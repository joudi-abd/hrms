<?php

namespace App\Http\Requests;

use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class LeaveRequestRequest extends FormRequest
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
        return [
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|before_or_equal:end_date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:1000',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $employeeId = auth()->user()->id;
            $leaveTypeId = $this->leave_type_id;

            $year = Carbon::parse($this->start_date)->year;

            $usedDays = LeaveRequest::where('employee_id', $employeeId)
                ->where('leave_type_id', $leaveTypeId)
                ->where('status', 'approved')
                ->whereYear('start_date', $year)
                ->sum('total_days');

            $leaveType = \App\Models\LeaveType::find($leaveTypeId);

            $requestedDays = Carbon::parse($this->start_date)
                ->diffInDays(Carbon::parse($this->end_date)) + 1;

            if (($usedDays + $requestedDays) > $leaveType->max_days_per_year) {
                $validator->errors()->add(
                    'leave_type_id',
                    __('You have exceeded the allowed annual leave limit.')
                );
            }
        });
    }
}
