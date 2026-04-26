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
            'gps_lat' => 'nullable|numeric|between:-90,90',
            'gps_lng' => 'nullable|numeric|between:-180,180',
            'gps_accuracy' => 'nullable|numeric',
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
            'gps_lat.numeric' => 'Gps lat is a required numeric',
            'gps_lng.numeric' => 'Gps lng is a required numeric',
            'gps_accuracy.numeric' => 'Gps accuracy is a required numeric',
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
