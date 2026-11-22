<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', [\App\Http\Controllers\Frontend\HomeController::class, 'index']);

Route::get('/about', [\App\Http\Controllers\Frontend\HomeController::class, 'about'])->name('frontend.about');

Route::get('/contact', [\App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('frontend.contact');
Route::post('/contact', [\App\Http\Controllers\Frontend\ContactController::class, 'store'])->name('frontend.contact.store');

// Frontend Services
Route::get('/services', [\App\Http\Controllers\Frontend\ServiceController::class, 'index'])->name('frontend.services.index');
Route::get('/services/{slug}', [\App\Http\Controllers\Frontend\ServiceController::class, 'show'])->name('frontend.services.show');

Route::get('/departments', [\App\Http\Controllers\Frontend\DepartmentController::class, 'index']);
Route::get('/departments/{slug}', [\App\Http\Controllers\Frontend\DepartmentController::class, 'show']);

Route::get('/tests', [\App\Http\Controllers\Frontend\TestController::class, 'index']);
Route::get('/tests/{id}', [\App\Http\Controllers\Frontend\TestController::class, 'show'])->whereNumber('id');

Route::get('/packages', [\App\Http\Controllers\Frontend\PackageController::class, 'index']);
Route::get('/packages/{id}', [\App\Http\Controllers\Frontend\PackageController::class, 'show']);

Route::get('/doctors', [\App\Http\Controllers\Frontend\DoctorController::class, 'index']);
Route::get('/doctors/{id}', [\App\Http\Controllers\Frontend\DoctorController::class, 'show'])->whereNumber('id');

Route::get('/appointment', [\App\Http\Controllers\Frontend\AppointmentController::class, 'index'])->name('frontend.appointment');
Route::post('/appointment', [\App\Http\Controllers\Frontend\AppointmentController::class, 'store'])->name('frontend.appointment.store');
Route::get('/appointment/confirmation/{id}', [\App\Http\Controllers\Frontend\AppointmentController::class, 'confirmation'])->name('frontend.appointment.confirmation');

// API routes for appointment form
Route::get('/api/doctors-by-department', [\App\Http\Controllers\Frontend\AppointmentController::class, 'getDoctorsByDepartment']);
Route::get('/api/tests-by-department', [\App\Http\Controllers\Frontend\AppointmentController::class, 'getTestsByDepartment']);
Route::get('/api/doctor-slots', [\App\Http\Controllers\Frontend\AppointmentController::class, 'getAvailableSlots']);

Route::get('/home-collection', [\App\Http\Controllers\Frontend\HomeCollectionController::class, 'index'])->name('frontend.home-collection');
Route::post('/home-collection', [\App\Http\Controllers\Frontend\HomeCollectionController::class, 'store'])->name('frontend.home-collection.store');

Route::get('/pricing', [\App\Http\Controllers\Frontend\PricingController::class, 'index'])->name('frontend.pricing');

Route::get('/reports', [\App\Http\Controllers\Frontend\ReportController::class, 'index']);
Route::post('/reports/search', [\App\Http\Controllers\Frontend\ReportController::class, 'search'])->name('frontend.reports.search');
Route::get('/reports/search', function () {
    return redirect('/reports');
});
Route::get('/reports/{id}/download', [\App\Http\Controllers\Frontend\ReportController::class, 'download'])->name('frontend.reports.download');

Route::get('/blog', [\App\Http\Controllers\Frontend\BlogController::class, 'index'])->name('frontend.blog.index');
Route::get('/blog/{blog}', [\App\Http\Controllers\Frontend\BlogController::class, 'show'])->whereNumber('blog')->name('frontend.blog.show');

Route::get('/faq', [\App\Http\Controllers\Frontend\FaqController::class, 'index'])->name('frontend.faq');

Route::get('/branches', [\App\Http\Controllers\Frontend\BranchController::class, 'index'])->name('frontend.branches');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('patients', \App\Http\Controllers\PatientController::class);
    Route::resource('admin-doctors', \App\Http\Controllers\DoctorController::class)->names('doctors')->parameters(['admin-doctors' => 'doctor']);
    // Appointments & OPD Queue
    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class);
    Route::patch('appointments/{appointment}/status', [\App\Http\Controllers\AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
    Route::get('appointments-queue', [\App\Http\Controllers\AppointmentController::class, 'queue'])->name('appointments.queue');

    // Emergency Department (ER & Triage)
    Route::resource('emergency', \App\Http\Controllers\EmergencyController::class);
    Route::post('emergency/{emergency}/transfer-ipd', [\App\Http\Controllers\EmergencyController::class, 'transferToIpd'])->name('emergency.transfer-ipd');
    Route::post('emergency/{emergency}/transfer-to-ipd', [\App\Http\Controllers\EmergencyController::class, 'transferToIpd'])->name('emergency.transferToIpd');

    // Clinical Vitals Recording
    Route::post('vitals', [\App\Http\Controllers\VitalController::class, 'store'])->name('vitals.store');

    // Wards, Cabins & Beds Management
    Route::resource('wards', \App\Http\Controllers\WardController::class);
    Route::get('beds/matrix', [\App\Http\Controllers\BedController::class, 'matrix']);
    Route::get('beds-matrix', [\App\Http\Controllers\BedController::class, 'matrix'])->name('beds.matrix');
    Route::patch('beds/{bed}/status', [\App\Http\Controllers\BedController::class, 'updateStatus'])->name('beds.updateStatus');
    Route::resource('beds', \App\Http\Controllers\BedController::class);

    // IPD Admissions, Transfers & Discharges
    Route::resource('admissions', \App\Http\Controllers\AdmissionController::class);
    Route::post('admissions/{admission}/transfer-bed', [\App\Http\Controllers\AdmissionController::class, 'transferBed'])->name('admissions.transfer-bed');
    Route::post('admissions/{admission}/transfer-bed-alt', [\App\Http\Controllers\AdmissionController::class, 'transferBed'])->name('admissions.transferBed');
    Route::post('admissions/{admission}/daily-charge', [\App\Http\Controllers\AdmissionController::class, 'addDailyCharge'])->name('admissions.daily-charge');
    Route::post('admissions/{admission}/daily-charge-alt', [\App\Http\Controllers\AdmissionController::class, 'addDailyCharge'])->name('admissions.addDailyCharge');
    Route::post('admissions/{admission}/discharge', [\App\Http\Controllers\AdmissionController::class, 'discharge'])->name('admissions.discharge');

    // Nursing Station, MAR & Shift Roster
    Route::get('nursing', [\App\Http\Controllers\NursingController::class, 'index'])->name('nursing.index');
    Route::get('nursing/mar', [\App\Http\Controllers\NursingController::class, 'mar'])->name('nursing.mar');
    Route::post('nursing/medication', [\App\Http\Controllers\NursingController::class, 'storeMedication'])->name('nursing.storeMedication');
    Route::post('nursing/medication/{chart}/administer', [\App\Http\Controllers\NursingController::class, 'administerMedication'])->name('nursing.administer');
    Route::post('nursing/notes', [\App\Http\Controllers\NursingController::class, 'storeNote'])->name('nursing.storeNote');
    Route::get('nursing/roster', [\App\Http\Controllers\NursingController::class, 'roster'])->name('nursing.roster');
    Route::post('nursing/roster', [\App\Http\Controllers\NursingController::class, 'storeRoster'])->name('nursing.storeRoster');
    Route::post('nursing/store-roster', [\App\Http\Controllers\NursingController::class, 'storeRoster'])->name('nursing.store-roster');

    // Operation Theatre (OT) & Surgeries
    Route::resource('ot', \App\Http\Controllers\OtController::class);
    Route::put('ot/{ot}/notes', [\App\Http\Controllers\OtController::class, 'updateNotes'])->name('ot.update-notes');
    Route::put('ot/{ot}/update-notes', [\App\Http\Controllers\OtController::class, 'updateNotes'])->name('ot.updateNotes');
    Route::post('ot/{ot}/staff', [\App\Http\Controllers\OtController::class, 'addStaff'])->name('ot.add-staff');
    Route::post('ot/{ot}/add-staff', [\App\Http\Controllers\OtController::class, 'addStaff'])->name('ot.addStaff');

    // Hospital Pharmacy POS & Inventory
    Route::get('pharmacy', [\App\Http\Controllers\PharmacyController::class, 'index'])->name('pharmacy.index');
    Route::get('pharmacy/medicines', [\App\Http\Controllers\PharmacyController::class, 'medicines'])->name('pharmacy.medicines');
    Route::post('pharmacy/medicines', [\App\Http\Controllers\PharmacyController::class, 'storeMedicine'])->name('pharmacy.storeMedicine');
    Route::post('pharmacy/store-medicine', [\App\Http\Controllers\PharmacyController::class, 'storeMedicine'])->name('pharmacy.medicines.store');
    Route::get('pharmacy/batches', [\App\Http\Controllers\PharmacyController::class, 'batches'])->name('pharmacy.batches');
    Route::post('pharmacy/batches', [\App\Http\Controllers\PharmacyController::class, 'storeBatch'])->name('pharmacy.storeBatch');
    Route::post('pharmacy/store-batch', [\App\Http\Controllers\PharmacyController::class, 'storeBatch'])->name('pharmacy.batches.store');
    Route::get('pharmacy/pos', [\App\Http\Controllers\PharmacyController::class, 'pos'])->name('pharmacy.pos');
    Route::post('pharmacy/pos/checkout', [\App\Http\Controllers\PharmacyController::class, 'checkout'])->name('pharmacy.pos.checkout');
    Route::post('pharmacy/store-sale', [\App\Http\Controllers\PharmacyController::class, 'storeSale'])->name('pharmacy.storeSale');
    Route::get('pharmacy/sales/{sale}/print', [\App\Http\Controllers\PharmacyController::class, 'printSale'])->name('pharmacy.print');

    // Laboratory Pathology Samples
    Route::get('samples', [\App\Http\Controllers\SampleController::class, 'index'])->name('samples.index');
    Route::post('samples/{sample}/collect', [\App\Http\Controllers\SampleController::class, 'collect'])->name('samples.collect');
    Route::post('samples/{sample}/receive', [\App\Http\Controllers\SampleController::class, 'receive'])->name('samples.receive');
    Route::post('samples/{sample}/reject', [\App\Http\Controllers\SampleController::class, 'reject'])->name('samples.reject');

    // Digital Radiology & Imaging
    Route::resource('radiology', \App\Http\Controllers\RadiologyController::class);
    Route::get('radiology/{order}/report', [\App\Http\Controllers\RadiologyController::class, 'report'])->name('radiology.report');
    Route::get('radiology/{order}/report-form', [\App\Http\Controllers\RadiologyController::class, 'report'])->name('radiology.report-form');
    Route::post('radiology/{order}/report', [\App\Http\Controllers\RadiologyController::class, 'storeReport'])->name('radiology.storeReport');
    Route::post('radiology/{order}/save-report', [\App\Http\Controllers\RadiologyController::class, 'storeReport'])->name('radiology.save-report');
    Route::get('radiology/{order}/print', [\App\Http\Controllers\RadiologyController::class, 'print'])->name('radiology.print');
    Route::get('radiology/{order}/print-report', [\App\Http\Controllers\RadiologyController::class, 'print'])->name('radiology.print-report');

    // Doctor Portal routes
    Route::get('doctor/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('doctor.dashboard');
    Route::get('doctor/appointments', [\App\Http\Controllers\AppointmentController::class, 'index'])->name('doctor.appointments');
    Route::get('doctor/consultations', [\App\Http\Controllers\ConsultationController::class, 'index'])->name('doctor.consultations');
    Route::get('doctor/patients', [\App\Http\Controllers\PatientController::class, 'index'])->name('doctor.patients');

    // Hospital Expenses
    Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);

    // Blood Bank & Donors
    Route::get('blood-bank', [\App\Http\Controllers\BloodBankController::class, 'index'])->name('blood-bank.index');
    Route::post('blood-bank/donors', [\App\Http\Controllers\BloodBankController::class, 'storeDonor'])->name('blood-bank.store-donor');
    Route::post('blood-bank/bags', [\App\Http\Controllers\BloodBankController::class, 'storeBag'])->name('blood-bank.store-bag');
    Route::post('blood-bank/bags/{bag}/issue', [\App\Http\Controllers\BloodBankController::class, 'issueBag'])->name('blood-bank.issue-bag');

    // Ambulance Fleet & Dispatch
    Route::get('ambulance', [\App\Http\Controllers\AmbulanceController::class, 'index'])->name('ambulance.index');
    Route::post('ambulance/vehicles', [\App\Http\Controllers\AmbulanceController::class, 'storeVehicle'])->name('ambulance.store-vehicle');
    Route::patch('ambulance/vehicles/{vehicle}/status', [\App\Http\Controllers\AmbulanceController::class, 'updateVehicleStatus'])->name('ambulance.update-vehicle-status');
    Route::post('ambulance/requests', [\App\Http\Controllers\AmbulanceController::class, 'storeRequest'])->name('ambulance.store-request');
    Route::patch('ambulance/requests/{ambulanceRequest}/status', [\App\Http\Controllers\AmbulanceController::class, 'updateRequestStatus'])->name('ambulance.update-request-status');

    // HR & Staff Payroll
    Route::get('payroll', [\App\Http\Controllers\PayrollController::class, 'index'])->name('payroll.index');
    Route::post('payroll/attendance', [\App\Http\Controllers\PayrollController::class, 'markAttendance'])->name('payroll.mark-attendance');
    Route::post('payroll/salary', [\App\Http\Controllers\PayrollController::class, 'storeSalary'])->name('payroll.store-salary');
    Route::get('payroll/payslip/{salaryPayment}', [\App\Http\Controllers\PayrollController::class, 'payslip'])->name('payroll.payslip');

    // Vital Records & Medical Certificates
    Route::get('certificates', [\App\Http\Controllers\CertificateController::class, 'index'])->name('certificates.index');
    Route::post('certificates/birth', [\App\Http\Controllers\CertificateController::class, 'storeBirth'])->name('certificates.store-birth');
    Route::post('certificates/death', [\App\Http\Controllers\CertificateController::class, 'storeDeath'])->name('certificates.store-death');
    Route::post('certificates/medical', [\App\Http\Controllers\CertificateController::class, 'storeMedical'])->name('certificates.store-medical');
    Route::get('certificates/birth/{record}/print', [\App\Http\Controllers\CertificateController::class, 'printBirth'])->name('certificates.print-birth');
    Route::get('certificates/death/{record}/print', [\App\Http\Controllers\CertificateController::class, 'printDeath'])->name('certificates.print-death');
    Route::get('certificates/medical/{certificate}/print', [\App\Http\Controllers\CertificateController::class, 'printMedical'])->name('certificates.print-medical');
    Route::resource('admin-tests', \App\Http\Controllers\TestController::class)->names('tests')->parameters(['admin-tests' => 'test']);
    Route::resource('invoices', \App\Http\Controllers\InvoiceController::class);
    Route::resource('diagnostic-orders', \App\Http\Controllers\DiagnosticOrderController::class);
    Route::patch('diagnostic-orders/{order}/status', [\App\Http\Controllers\DiagnosticOrderController::class, 'updateStatus'])->name('diagnostic-orders.updateStatus');

    // Consultations & Prescriptions
    Route::resource('consultations', \App\Http\Controllers\ConsultationController::class);
    Route::patch('consultations/{visit}/status', [\App\Http\Controllers\ConsultationController::class, 'updateStatus'])->name('consultations.updateStatus');
    Route::get('visits/{visit}/prescription', [\App\Http\Controllers\PrescriptionController::class, 'form'])->name('prescriptions.form');
    Route::post('visits/{visit}/prescription', [\App\Http\Controllers\PrescriptionController::class, 'save'])->name('prescriptions.save');

    Route::resource('test-results', \App\Http\Controllers\TestResultController::class);
    Route::resource('testimonials', \App\Http\Controllers\TestimonialController::class)->except(['show']);
    Route::resource('admin-packages', \App\Http\Controllers\PackageController::class)->except(['show']);
    Route::resource('faqs', \App\Http\Controllers\FaqController::class)->except(['show']);
    Route::get('/home-collection-page', [\App\Http\Controllers\HomeCollectionPageController::class, 'index'])->name('home-collection-page.index');
    Route::put('/home-collection-page', [\App\Http\Controllers\HomeCollectionPageController::class, 'update'])->name('home-collection-page.update');
    Route::get('/home-collection-requests', [\App\Http\Controllers\HomeCollectionRequestController::class, 'index'])->name('home-collection-requests.index');
    Route::get('/home-collection-requests/{home_collection_request}', [\App\Http\Controllers\HomeCollectionRequestController::class, 'show'])->name('home-collection-requests.show');
    Route::patch('/home-collection-requests/{home_collection_request}/status', [\App\Http\Controllers\HomeCollectionRequestController::class, 'updateStatus'])->name('home-collection-requests.status');
    Route::get('/pricing-page', [\App\Http\Controllers\PricingPageController::class, 'index'])->name('pricing-page.index');
    Route::put('/pricing-page', [\App\Http\Controllers\PricingPageController::class, 'update'])->name('pricing-page.update');
    Route::get('/footer-settings', [\App\Http\Controllers\FooterSettingController::class, 'index'])->name('footer-settings.index');
    Route::put('/footer-settings', [\App\Http\Controllers\FooterSettingController::class, 'update'])->name('footer-settings.update');
    Route::get('/contact-page', [\App\Http\Controllers\ContactPageController::class, 'index'])->name('contact-page.index');
    Route::put('/contact-page', [\App\Http\Controllers\ContactPageController::class, 'update'])->name('contact-page.update');
    Route::get('/contact-messages', [\App\Http\Controllers\ContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::get('/contact-messages/{contact_message}', [\App\Http\Controllers\ContactMessageController::class, 'show'])->name('contact-messages.show');
    Route::delete('/contact-messages/{contact_message}', [\App\Http\Controllers\ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
    Route::resource('blogs', \App\Http\Controllers\BlogController::class)->except(['show']);
    Route::resource('admin-branches', \App\Http\Controllers\BranchController::class)->names('branches')->parameters(['admin-branches' => 'branch'])->except(['show', 'create', 'edit']);

    // Accounts
    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');

    // Staff & Roles
    Route::resource('staff', \App\Http\Controllers\StaffController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/account', [ReportController::class, 'account'])->name('account');
        Route::get('/patient', [ReportController::class, 'patient'])->name('patient');
        Route::get('/doctor', [ReportController::class, 'doctor'])->name('doctor');
        Route::get('/lab-order', [ReportController::class, 'labOrder'])->name('labOrder');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');

    // Frontend CMS
    Route::get('/cms', [\App\Http\Controllers\FrontendCMSController::class, 'index'])->name('cms.index');
    Route::put('/cms/hero', [\App\Http\Controllers\FrontendCMSController::class, 'updateHero'])->name('cms.hero.update');
    Route::put('/cms/stats', [\App\Http\Controllers\FrontendCMSController::class, 'updateStats'])->name('cms.stats.update');
    Route::put('/cms/quick-actions', [\App\Http\Controllers\FrontendCMSController::class, 'updateQuickActions'])->name('cms.quick_actions.update');
    Route::put('/cms/about', [\App\Http\Controllers\FrontendCMSController::class, 'updateAbout'])->name('cms.about.update');
    Route::put('/cms/why-choose', [\App\Http\Controllers\FrontendCMSController::class, 'updateWhyChoose'])->name('cms.why_choose.update');
    Route::put('/cms/how-it-works', [\App\Http\Controllers\FrontendCMSController::class, 'updateHowItWorks'])->name('cms.how_it_works.update');
    Route::get('/about-page', [\App\Http\Controllers\AboutPageController::class, 'index'])->name('about-page.index');
    Route::put('/about-page', [\App\Http\Controllers\AboutPageController::class, 'update'])->name('about-page.update');
});

require __DIR__.'/auth.php';

// ================================================================
// UTILITY ARTISAN ROUTES (Cache Clear & Storage Link)
// ================================================================
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return '<div style="font-family:sans-serif; padding:40px; text-align:center;">
                <h2 style="color:#15803d;">✅ Application Cache Cleared Successfully!</h2>
                <p style="color:#64748b;">Cache, Config, Route, and View caches have been cleared.</p>
                <a href="' . url('/') . '" style="display:inline-block; margin-top:15px; padding:10px 20px; background:#2563eb; color:#fff; text-decoration:none; border-radius:8px;">Back to Home</a>
            </div>';
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return '<div style="font-family:sans-serif; padding:40px; text-align:center;">
                <h2 style="color:#15803d;">✅ Storage Link Created Successfully!</h2>
                <p style="color:#64748b;">The [public/storage] directory has been linked to [storage/app/public].</p>
                <a href="' . url('/') . '" style="display:inline-block; margin-top:15px; padding:10px 20px; background:#2563eb; color:#fff; text-decoration:none; border-radius:8px;">Back to Home</a>
            </div>';
});
