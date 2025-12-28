<div class="row g-3">

    <div class="col-md-12">
        <x-form.input
            name="employee_id"
            label="{{ __('Employee name') }}"
            :value="$attendance->employee->name"
            disabled
        />
    </div>
    
    <div class="col-md-12">
        <x-form.input 
            name="department_id"
            label="{{ __('Department') }}"
            :value="$attendance->employee->department->name ?? 'N/A'"
            disabled
        />
    </div>

    <div class="col-md-12">
        <x-form.input
            type="date"
            name="date"
            label="{{ __('Date') }}"
            :value="old('date', isset($attendance) ? $attendance->date : '')"
        />
    </div>

    <div class="col-md-6">
        <x-form.input
            type="time"
            name="check_in"
            label="{{ __('Check In Time') }}"
            :value="old('check_in', isset($attendance) ? $attendance->check_in : '')"
        />  
    </div>

    <div class="col-md-6">
        <x-form.input
            type="time"
            name="check_out"
            label="{{ __('Check Out Time') }}"
            :value="old('check_out', isset($attendance) ? $attendance->check_out : '')"
        />
    </div>

</div>