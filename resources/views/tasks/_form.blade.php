<div class="row mt-3">
    <div class="col-md-12">
        <x-form.input
            name="title"
            label="Task Title"
            :value="old('title', isset($task) ? $task->title : '')"
            placeholder="Enter task title"
        />
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <x-form.textarea
            name="description"
            label="Task Description"
            :value="old('description', isset($task) ? $task->description : '')"
            placeholder="Enter task description"
        />
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <x-form.select
            name="department_id"
            label="Department"
            :options="$departments->pluck('name', 'id')"
            :selected="old('department_id', isset($task) ? $task->department_id : '')"
            placeholder="Select Department"
        />
    </div>
    <div class="col-md-6">
        <x-form.select
            name="assigned_to"
            label="Assign To"
            :options="$employees->pluck('name', 'id')"
            :selected="old('assigned_to', isset($task) ? $task->assigned_to : '')"
            placeholder="Select Employee"
        />
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-6">
        <x-form.select
            name="priority"
            label="Priority"
            :options="['low' => 'Low', 'medium' => 'Medium', 'high' => 'High']"
            :selected="old('priority', isset($task) ? $task->priority : '')"
            placeholder="Select Priority"
        />
    </div>
    <div class="col-md-6">
        <x-form.select
            name="status"
            label="Status"
            :options="['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed']"
            :selected="old('status', isset($task) ? $task->status : '')"
            placeholder="Select Status"
        />
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-4">
        <x-form.input
            name="start_date"
            label="Start Date"
            type="date"
            :value="old('start_date', isset($task) ? $task->start_date : '')"
        />
    </div>
    <div class="col-md-4">
        <x-form.input
            name="due_date"
            label="Due Date"
            type="date"
            :value="old('due_date', isset($task) ? $task->due_date : '')"
        />
    </div>
    <div class="col-md-4">
        <x-form.input
            name="created_by"
            label="Created By"
            type="text"
            :value="isset($task) ? $task->creator->name : auth()->user()->name"
            disabled
        />
    </div>
</div>