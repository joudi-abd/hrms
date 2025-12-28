<div class="row g-3">
    <div class="col-md-12">
        <x-form.input
            label="Name"
            name="name"
            type="text"
            placeholder="Enter leave type name"
            :value="old('name', isset($leave_type) ? $leave_type->name : '')"
        />
    </div>
    <div class="col-md-6">
        <x-form.input
            label="Days Allowed Per Year"
            name="max_days_per_year"
            type="number"
            placeholder="Enter number days allowed on this leave type per year"
            :value="old('max_days_per_year', isset($leave_type) ? $leave_type->max_days_per_year : '')"
        />
    </div>
    <div class="col-md-6">
        <x-form.select
            label="Is Paid"
            name="is_paid"
            :options="['1' => 'Paid', '0' => 'Unpaid']"
            placeholder="Select if leave is paid or unpaid"
            :selected="old('is_paid', isset($leave_type) ? $leave_type->is_paid : '')"
        />
    </div>
    <div class="col-md-12">
        <x-form.textarea
            label="Description"
            name="description"
            placeholder="Enter description"
            :value="old('description', isset($leave_type) ? $leave_type->description : '')"
        />
    </div>
</div>