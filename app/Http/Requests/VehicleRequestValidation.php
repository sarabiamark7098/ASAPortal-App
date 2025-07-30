<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequestValidation extends FormRequest
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
        $routeName = $this->route()->getName();

        return match ($routeName) {
            'vehicle-requests.store' => $this->createRules(),
            default => []
        };
    }

    public function createRules() : array {
        return [
            'date_requested' => ['required', 'date'],
            'requesting_office' => ['required', 'string'],
            'purpose' => ['required', 'string'],
            'passengers' => ['required', 'string'],
            'requested_start' => ['required', 'date'],
            'requested_time' => ['required', 'date_format:H:i:s'],
            'requested_end' => ['required', 'date'],
            'destination' => ['required', 'string', 'max:255'],
            'requester_name' => ['required', 'string', 'max:255'],
            'requester_position' => ['required', 'string', 'max:255'],
            'requester_contact_number' => ['required', 'string', 'max:255'],
            'requester_email' => ['required', 'string', 'max:255'],
        ];
    }
}
