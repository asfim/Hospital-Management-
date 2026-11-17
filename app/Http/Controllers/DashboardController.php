<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Staff;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\DiagnosticOrder;
use App\Models\Admission;
use App\Models\Bed;
use App\Models\Ward;
use App\Models\EmergencyCase;
use App\Models\PharmacySale;
use App\Models\Expense;
use App\Models\Surgery;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user && $user->hasRole('Doctor')) {
            $doctor = Doctor::where('user_id', $user->id)->first();
            
            if ($doctor) {
                $data = [
                    'doctor' => $doctor,
                    'total_appointments' => Appointment::where('doctor_id', $doctor->id)->count(),
                    'today_appointments_count' => Appointment::where('doctor_id', $doctor->id)->whereDate('date', today())->count(),
                    'active_ipd_patients' => Admission::where('doctor_id', $doctor->id)->where('status', 'admitted')->count(),
                    'upcoming_surgeries' => Surgery::where('lead_surgeon_id', $doctor->id)->where('status', 'scheduled')->count(),
                    'upcoming_appointments' => Appointment::with('patient')
                                                ->where('doctor_id', $doctor->id)
                                                ->whereIn('status', ['Scheduled', 'Confirmed', 'Pending', 'Waiting'])
                                                ->whereDate('date', '>=', today())
                                                ->orderBy('date')
                                                ->orderBy('time')
                                                ->take(5)
                                                ->get(),
                    'today_appointments' => Appointment::with('patient')
                                                ->where('doctor_id', $doctor->id)
                                                ->whereDate('date', today())
                                                ->orderBy('time')
                                                ->get(),
                ];

                return view('doctor.dashboard', $data);
            }
        }

        return view('admin.dashboard', $this->getAdminData());
    }

    private function getAdminData()
    {
        $today = Carbon::today();

        // 1. Bed Statistics
        $totalBeds = Bed::count();
        $occupiedBeds = Bed::where('status', 'occupied')->count();
        $availableBeds = Bed::where('status', 'available')->count();
        $maintenanceBeds = Bed::whereIn('status', ['cleaning', 'maintenance'])->count();
        $bedOccupancyRate = $totalBeds > 0 ? round(($occupiedBeds / $totalBeds) * 100, 1) : 0;

        // 2. IPD Statistics
        $activeAdmissions = Admission::where('status', 'admitted')->count();
        $todayAdmissions = Admission::whereDate('admission_date', $today)->count();
        $todayDischarges = Admission::whereDate('discharge_date', $today)->count();

        // 3. OPD & Appointments
        $totalAppointments = Appointment::count();
        $todayAppointments = Appointment::whereDate('date', $today)->count();
        $waitingAppointments = Appointment::whereDate('date', $today)->whereIn('status', ['Waiting', 'Scheduled', 'Pending'])->count();

        // 4. Emergency
        $todayEmergency = EmergencyCase::whereDate('arrival_time', $today)->count();
        $activeEmergency = EmergencyCase::whereIn('status', ['triaged', 'under_treatment'])->count();

        // 5. Surgeries
        $todaySurgeries = Surgery::whereDate('scheduled_start', $today)->count();

        // 6. Pharmacy & Laboratory
        $todayPharmacySales = PharmacySale::whereDate('created_at', $today)->sum('total');
        $totalLabOrders = DiagnosticOrder::count();
        $pendingLabOrders = DiagnosticOrder::whereIn('order_status', ['Pending', 'Sample Pending', 'Processing'])->count();

        // 7. Financials
        $todayInvoicePaid = Invoice::whereDate('created_at', $today)->sum('paid');
        $todayRevenue = $todayInvoicePaid + $todayPharmacySales;
        $totalRevenue = Invoice::sum('paid') + PharmacySale::sum('paid');
        $todayExpenses = Expense::whereDate('date', $today)->sum('amount');
        $monthlyRevenue = Invoice::whereMonth('created_at', $today->month)->whereYear('created_at', $today->year)->sum('paid')
                        + PharmacySale::whereMonth('created_at', $today->month)->whereYear('created_at', $today->year)->sum('paid');

        // 8. Recent Activities
        $recentAdmissions = Admission::with(['patient', 'doctor', 'ward', 'bed'])
            ->latest()
            ->take(6)
            ->get();

        $recentEmergency = EmergencyCase::with(['patient', 'doctor'])
            ->latest('arrival_time')
            ->take(5)
            ->get();

        $recentAppointments = Appointment::with(['patient', 'doctor'])
            ->latest()
            ->take(5)
            ->get();

        $recentPatients = Patient::latest()->take(5)->get();

        // 9. Ward Occupancy
        $wards = Ward::withCount([
            'beds as total_beds_count',
            'beds as occupied_beds_count' => function ($q) {
                $q->where('status', 'occupied');
            },
            'beds as available_beds_count' => function ($q) {
                $q->where('status', 'available');
            }
        ])->get();

        // 10. Last 7 Days Revenue Trend
        $chartDates = [];
        $chartRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = Carbon::today()->subDays($i);
            $chartDates[] = $d->format('D, M d');
            $invDay = Invoice::whereDate('created_at', $d)->sum('paid');
            $phmDay = PharmacySale::whereDate('created_at', $d)->sum('paid');
            $chartRevenue[] = (float) ($invDay + $phmDay);
        }

        return [
            // Counts
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::count(),
            'total_staff' => Staff::count(),
            'total_appointments' => $totalAppointments,
            'today_appointments' => $todayAppointments,
            'waiting_appointments' => $waitingAppointments,
            
            // IPD & Beds
            'total_beds' => $totalBeds,
            'occupied_beds' => $occupiedBeds,
            'available_beds' => $availableBeds,
            'maintenance_beds' => $maintenanceBeds,
            'bed_occupancy_rate' => $bedOccupancyRate,
            'active_admissions' => $activeAdmissions,
            'today_admissions' => $todayAdmissions,
            'today_discharges' => $todayDischarges,

            // Emergency & OT
            'today_emergency' => $todayEmergency,
            'active_emergency' => $activeEmergency,
            'today_surgeries' => $todaySurgeries,

            // Pharmacy & Lab
            'today_pharmacy_sales' => $todayPharmacySales,
            'total_lab_orders' => $totalLabOrders,
            'pending_lab_orders' => $pendingLabOrders,

            // Financials
            'today_revenue' => $todayRevenue,
            'total_revenue' => $totalRevenue,
            'today_expenses' => $todayExpenses,
            'monthly_revenue' => $monthlyRevenue,

            // Lists & Wards
            'recent_admissions' => $recentAdmissions,
            'recent_emergency' => $recentEmergency,
            'recent_appointments' => $recentAppointments,
            'recent_patients' => $recentPatients,
            'wards' => $wards,

            // Chart
            'chart_dates' => json_encode($chartDates),
            'chart_revenue' => json_encode($chartRevenue),
        ];
    }
}
