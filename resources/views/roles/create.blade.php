@extends('layouts.admin')

@section('title', 'Add New Role')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Add New Role</h4>
    <a href="{{ route('roles.index') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Back</a>
</div>

<div class="card">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="form-label">Role Name *</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="e.g. Manager">
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                <h6 class="mb-0">Assign Permissions</h6>
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllPermissions()">Select All</button>
            </div>
            
            @php
                // Group permissions by the second word (e.g., 'view patients' -> 'patients')
                $groupedPermissions = [];
                foreach($permissions as $permission) {
                    $parts = explode(' ', $permission->name);
                    $module = isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : 'other';
                    $groupedPermissions[$module][] = $permission;
                }
            @endphp

            <div class="row">
            @foreach($groupedPermissions as $module => $modulePermissions)
                @php
                    $moduleIcons = [
                        'dashboard' => 'fa-gauge-high',
                        'patients' => 'fa-users',
                        'doctors' => 'fa-user-doctor',
                        'appointments' => 'fa-calendar-check',
                        'consultations' => 'fa-stethoscope',
                        'tests' => 'fa-microscope',
                        'lab orders' => 'fa-vial',
                        'lab results' => 'fa-file-medical',
                        'billing' => 'fa-file-invoice-dollar',
                        'accounts' => 'fa-scale-balanced',
                        'reports' => 'fa-chart-line',
                        'staff' => 'fa-user-tie',
                        'payroll' => 'fa-money-check-dollar',
                        'settings' => 'fa-gear',
                        'roles' => 'fa-shield-halved',
                        'prescriptions' => 'fa-prescription',
                        'radiology' => 'fa-x-ray',
                        'ipd' => 'fa-hospital-user',
                        'wards' => 'fa-door-open',
                        'beds' => 'fa-bed',
                        'emergency' => 'fa-truck-medical',
                        'nursing' => 'fa-user-nurse',
                        'ot' => 'fa-syringe',
                        'pharmacy' => 'fa-prescription-bottle-medical',
                        'inventory' => 'fa-boxes-stacked',
                        'blood bank' => 'fa-droplet',
                        'ambulance' => 'fa-truck-medical',
                        'certificates' => 'fa-certificate',
                    ];
                    $modIcon = $moduleIcons[strtolower($module)] ?? 'fa-layer-group';
                @endphp
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #142D4E 0%, #0d1e34 100%) !important; color: #ffffff !important; border-bottom: 0; padding: 0.85rem 1.15rem;">
                            <h6 class="mb-0 text-uppercase fw-bold text-white d-flex align-items-center" style="color: #ffffff !important; font-size: 0.88rem; letter-spacing: 0.5px;">
                                <i class="fa-solid {{ $modIcon }} me-2" style="color: #ffffff !important; font-size: 0.95rem;"></i>
                                <span style="color: #ffffff !important; font-weight: 700;">{{ $module }}</span>
                            </h6>
                            <div class="form-check form-switch m-0">
                                <input class="form-check-input module-select-all" type="checkbox" onclick="toggleModule(this, '{{ str_replace(' ', '_', $module) }}')">
                            </div>
                        </div>
                        <div class="card-body bg-light module-body-{{ str_replace(' ', '_', $module) }}">
                            @foreach($modulePermissions as $permission)
                            @php 
                                $action = strtolower(explode(' ', $permission->name)[0]);
                                $badgeColor = match($action) {
                                    'view' => 'info',
                                    'create' => 'success',
                                    'edit' => 'warning',
                                    'delete' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                <div>
                                    <span class="badge bg-{{ $badgeColor }} bg-opacity-25 text-{{ $badgeColor }} me-2" style="width: 60px;">{{ ucfirst($action) }}</span>
                                    <label class="form-check-label text-secondary small" for="perm_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary px-4 rounded-pill shadow"><i class="fa-solid fa-save me-1"></i> Save Role</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModule(checkbox, moduleName) {
        const checkboxes = document.querySelectorAll('.module-body-' + moduleName + ' .permission-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = checkbox.checked;
        });
    }

    function selectAllPermissions() {
        const allCheckboxes = document.querySelectorAll('.permission-checkbox, .module-select-all');
        const isChecked = allCheckboxes[0] ? !allCheckboxes[0].checked : true;
        allCheckboxes.forEach(cb => {
            cb.checked = isChecked;
        });
    }
</script>
@endsection
