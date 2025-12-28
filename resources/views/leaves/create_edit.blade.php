{{-- Create / Edit Leave Request Modal --}}
<div class="modal fade" id="createEditModal" tabindex="-1" aria-labelledby="createEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="createEditForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="modalTitle">{{ __('New Leave Request') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger w-100">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="leave_type_id" class="form-label">{{ __('Leave Type') }}</label>
                        <select name="leave_type_id" id="leave_type_id" class="form-select" >
                            <option value="" selected disabled>{{ __('Select Leave Type') }}</option>
                            @foreach($leaveTypes as $type)
                                <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}">
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label">{{ __('Reason') }}</label>
                        <textarea name="reason" id="reason" rows="3" class="form-control">{{ old('reason') }}</textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary" id="modalSubmit">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('scripts')
<script>
    const createEditModal = document.getElementById('createEditModal');
    createEditModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const form = createEditModal.querySelector('#createEditForm');

        const action = button.getAttribute('data-action');
        form.action = action;

        const method = button.getAttribute('data-method') || 'POST';
        if(method.toUpperCase() === 'PUT') {
            if(!form.querySelector('input[name="_method"]')) {
                const inputMethod = document.createElement('input');
                inputMethod.type = 'hidden';
                inputMethod.name = '_method';
                inputMethod.value = 'PUT';
                form.appendChild(inputMethod);
            } else {
                form.querySelector('input[name="_method"]').value = 'PUT';
            }
            createEditModal.querySelector('#modalTitle').textContent = '{{ __("Edit Leave Request") }}';
        } else {
            const methodInput = form.querySelector('input[name="_method"]');
            if(methodInput) methodInput.remove();
            createEditModal.querySelector('#modalTitle').textContent = '{{ __("New Leave Request") }}';
        }

        createEditModal.querySelector('#leave_type_id').value = button.getAttribute('data-leave_type') || '';
        createEditModal.querySelector('#start_date').value = button.getAttribute('data-start_date') || '';
        createEditModal.querySelector('#end_date').value = button.getAttribute('data-end_date') || '';
        createEditModal.querySelector('#reason').value = button.getAttribute('data-reason') || '';
    });
</script>
@endpush