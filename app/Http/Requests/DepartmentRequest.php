<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $locales = config('app.available_locales' , ['en' , 'ar']);
        $rules = [];

        foreach($locales as $locale){
            $rules["name_{$locale}"] = 'nullable|string|min:2|max:255';
            $rules["description_{$locale}"] = 'nullable|string';

        }

        $rules["name_en"]= 'required_without:name_ar|string|min:2|max:255'; 
        $rules["name_ar"]= 'required_without:name_an|string|min:2|max:255'; 

        $rules['description'] = 'nullable|string';
        $rules['status'] = 'required|in:active,inactive';
        $rules['head_id'] = 'nullable|exists:employees,id';

        return $rules;
        
    }

    public function messages()
    {
        return [
            'name_en.required_without' => 'يجب إضافة الاسم باللغة الإنجليزية أو العربية على الأقل',
            'name_en.min' => 'الاسم بالإنجليزية يجب أن يكون على الأقل حرفين',
            'name_ar.required_without' => 'يجب إضافة الاسم باللغة العربية أو الإنجليزية على الأقل',
            'name_ar.min' => 'الاسم بالعربية يجب أن يكون على الأقل حرفين',
            'description_en.required' => 'الوصف بالإنجليزية مطلوب',
            'description_ar.required' => 'الوصف بالعربية مطلوب',
            'head_id.exists' => 'هذا الموظف غير موجود',
            'status.required' => 'حالة القسم مطلوبة',
            'status.in' => 'حالة القسم يجب أن تكون نشط أو غير نشط',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'name_en' => 'الاسم (EN)',
            'name_ar' => 'الاسم (AR)',
            'description_en' => 'الوصف (EN)',
            'description_ar' => 'الوصف (AR)',
            'head_id' => 'رئيس القسم',
            'status' => 'الحالة',
        ];
    }
}
