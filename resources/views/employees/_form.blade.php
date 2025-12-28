<div class="row g-3">
    <div class="col-md-6">
        <x-form.input name="employee_id" label="{{ __('Employee ID') }}" :value="old('employee_id', isset($employee) ? $employee->employee_id : 'EMP-')" />
    </div>
    <div class="col-md-6">
        <x-form.input name="name" label="{{ __('Name') }}" :value="old('name', isset($employee) ? $employee->name : '')" placeholder="{{ __('Enter name') }}" />
    </div>
    <div class="col-md-6">
        <x-form.input type="email" name="email" label="{{ __('Email') }}" :value="old('email', isset($employee) ? $employee->email : '')" placeholder="{{ __('Enter email address') }}" />
    </div>
    <div class="col-md-6">
        <x-form.input type="password" name="password" label="{{ __('Password') }}" placeholder="{{ __('Enter temporary password') }}" />
    </div>
    <div class="col-md-6">
        <x-form.select name="department_id" label="{{ __('Department') }}" placeholder="{{ __('Choose Department') }}" :options="$departments->pluck('name', 'id')->toArray()" :selected="old('department_id', isset($employee) ? $employee->department_id : '')" />
    </div>
    <div class="col-md-6">
        <x-form.select name="job_title" label="{{ __('Job Title') }}" placeholder="{{ __('Choose Job Title') }}" :options="['Manager' => 'Manager', 'Developer' => 'Developer', 'Designer' => 'Designer', 'QA' => 'QA', 'HR' => 'HR']" :selected="old('job_title', isset($employee) ? $employee->job_title : '')" />
    </div>
    <div class="col-md-4">
        <x-form.input type="number" name="salary" label="{{ __('Salary') }}" :value="old('salary', isset($employee) ? $employee->salary : '')" placeholder="{{ __('Enter salary amount') }}" />
    </div>
    <div class="col-md-4">
        <x-form.input type="date" name="hire_date" label="{{ __('Date of Joining') }}" :value="old('hire_date', isset($employee) ? $employee->hire_date : '')" placeholder="{{ __('Select date of joining') }}" />
    </div>
    <div class="col-md-4">
        <x-form.select name="status" label="{{ __('Status') }}" placeholder="{{ __('Choose status') }}" :options="['active' => __('Active'), 'inactive' => __('Inactive'), 'on_leave' => __('On Leave')]" :selected="old('status', isset($employee) ? $employee->status : '')" />
    </div>
    <div class="col-md-12">
        <label class="form-label">{{ __('Roles') }}</label>
        <div class="border rounded p-3" style="max-height:200px; overflow:auto;">
            @foreach($roles as $role)
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="role_id[]" value="{{ $role->id }}" id="role_{{ $role->id }}" {{ (isset($employee) && $employee->roles->contains($role->id)) || (is_array(old('role_id')) && in_array($role->id, old('role_id'))) ? 'checked' : '' }}>
                    <label class="form-check-label" for="role_{{ $role->id }}">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>