<div class="row">
    <ul class="nav nav-tabs" id="languageTabs" role="tablist">
        @foreach(config('app.available_locales', ['en', 'ar']) as $index => $locale)
            <li class="nav-item">
                <a class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                   id="{{ $locale }}-tab" 
                   data-bs-toggle="tab" 
                   href="#{{ $locale }}" 
                   role="tab">
                    {{ strtoupper($locale) }}
                </a>
            </li>
        @endforeach
    </ul>
    <div class="tab-content mt-3" id="languageTabsContent">
        @foreach(config('app.available_locales', ['en', 'ar']) as $index => $locale)
            <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                id="{{ $locale }}" 
                role="tabpanel">
                <div class="col-md-12">
                    <x-form.input
                    name="name_{{ $locale }}"
                    label="{{ __('Name') }} ({{ strtoupper($locale) }})"
                    :value="old('name', isset($department) ? $department->name : '')"
                    placeholder="{{ __('Enter department name') }}"
                    />
                </div>
                <div class="col-md-12">
                    <x-form.textarea
                    name="description_{{ $locale }}"
                    label="{{ __('Description') }} ({{ strtoupper($locale) }})"
                    :value="old('description', isset($department) ? $department->description : '')"
                    placeholder="{{ __('Enter department description') }}"
                    />
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-md-12">
        <x-form.select
        name="status"
        label="{{ __('Status') }}"
        :options="['active' => __('Active'), 'inactive' => __('Inactive')]"
        :selected="old('status', isset($department) ? $department->status : 'active')"
        />
    </div>
</div>

@push('scripts')
    <script>
        // Optional: Auto-fill first language to others if needed
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Translation form loaded');
        });
    </script>
@endpush