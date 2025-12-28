<div class="row g-3">
    <div class="col-md-6">
        <x-form.input 
        name="first_name"
        label="{{ __('First Name') }}"
        placeholder="{{ ('Enter First Name') }}"
        :value="old('first_name', optional($employee->profile)->first_name)"
        />
    </div>
    <div class="col-md-6">
        <x-form.input 
        name="last_name"
        label="{{ __('Last Name') }}"
        placeholder="{{ ('Enter Last Name') }}"
        :value="old('last_name', optional($employee->profile)->last_name)"
        />
    </div>
    <div class="col-md-6">
        <x-form.input 
        name="phone"
        type="number"
        label="{{ __('Phone') }}"
        placeholder="{{ ('Enter Phone') }}"
        :value="old('phone', optional($employee->profile)->phone)"
        />
    </div>
    <div class="col-md-6">
        <x-form.input 
        name="address"
        placeholder="{{ __('Enter Address') }}"
        label="{{ __('Address') }}"
        :value="old('address', optional($employee->profile)->address)"
        />
    </div>
    <div class="col-md-4">
        <x-form.select 
        name="gender"
        lable="{{ __('Gender') }}"
        placeholder="{{ __('Select Gender') }}"
        :options="['male' => __('Male') , 'female' => __('Female')]"
        :selected="old('gender' , optional($employee->profile)->gender )"
        />
    </div>
    <div class="col-md-4">
        <x-form.select 
        name="marital_status"
        lable="{{ __('Marital Status') }}"
        placeholder="{{ __('Select Status') }}"
        :options="['single' => 'Single', 'married' => 'Married', 'divorced' => 'Divorced', 'widowed' => 'Widowed' ]"
        :selected="old('marital_status' , optional($employee->profile)->marital_status )"
        />
    </div>
    <div class="col-md-4">
        <x-form.input 
        name="birth_date"
        type="date"
        lable="{{ __('Birth Date') }}"
        placeholder=""
        :value="old('birth_date', optional($employee->profile)->birth_date)"
        />
    </div>
</div>