<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidatedRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'scan_id' => 'required|string',
            'session_id' => 'required|string',
            'operator_id' => 'required|string',
            'device_id' => 'required|string',
            'action' => 'required|string',
            'gps_lat' => 'nullable|integer',
            'gps_lng' => 'nullable|integer',
            'gps_accuracy' => 'nullable|integer',
            'device_timestamp' => 'nullable|date',
            'app_version' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'scan_id.required' => 'Scan ID is mandatory',
            'scan_id.string' => 'Scan ID is a required string',
            'session_id.required' => 'Session ID is mandatory',
            'session_id.string' => 'Session ID is a required string',
            'operator_id.required' => 'Operator ID is mandatory',
            'operator_id.string' => 'Operator ID is a required string',
            'device_id.required' => 'Device ID is mandatory',
            'device_id.string' => 'Device ID is a required string',
            'action.required' => 'Action is mandatory',
            'action.string' => 'Action is a required string',
            'gps_lat.integer' => 'Gps lat is a required numeric',
            'gps_lng.integer' => 'Gps lng is a required numeric',
            'gps_accuracy.integer' => 'Gps accuracy is a required numeric',
            'device_timestamp.date' => 'Device timestamp is a required date',
            'app_version.required' => 'App Version is mandatory',
            'app_version.string' => 'App Version is a required string'
        ];
    }

     protected function failedValidation($validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ])
        );
    }
}
