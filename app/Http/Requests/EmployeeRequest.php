<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
        $id = $this->route('employee') ? $this->route('employee')->id : null;
        $roles = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'department_id' => 'required|exists:departments,id',
            'employee_id' => 'required|string|unique:employees,employee_id,' . $id,
            'job_title' => 'string|max:255',
            'salary' => 'numeric',
            'status' => 'in:active,inactive,on_leave',
            'role_id' => 'array',
            'role_id.*' => 'exists:roles,id',
        ];
        if ($this->isMethod('post')) {
            $roles['password'] = 'required|string|min:8';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $roles['password'] = 'sometimes|nullable|string|min:8';
        }
        return $roles;

    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'department_id.required' => 'The department field is required.',
            'department_id.exists' => 'The selected department is invalid.',
            'employee_id.required' => 'The employee ID field is required.',
            'employee_id.unique' => 'The employee ID has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
        ];
    }

    public function attributes(): array
    {
        return [
            'department_id' => 'department',
            'employee_id' => 'employee ID',
        ];
    }
}
