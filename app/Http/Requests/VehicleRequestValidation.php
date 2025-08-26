<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'vehicle-requests.index' => $this->searchRules(),
            'vehicle-requests.process' => $this->processRules(),
            default => []
        };
    }

    public function createRules() : array {
        return [
            'date_requested' => ['required', 'date'],
            'requesting_office' => ['required', 'string', 'max:255'],
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

    public function searchRules() : array {

        $sortableColumns = [
            'date_requested',
            'requesting_office',
            'purpose',
            'passengers',
            'requested_start',
            'requested_time',
            'requested_end',
            'destination',
            'requester_name',
            'requester_position',
            'requester_contact_number',
            'requester_email',
            'control_number',
            'status',
        ];

        return [
            'search' => ['nullable', Rule::enum(Status::class)],
            'query' => ['nullable', 'string', 'max:255'],
            'sort_by' => ['nullable', 'string', 'max:255', Rule::in($sortableColumns)],
            'sort_order' => ['nullable', 'string', 'max:255', Rule::in(['desc', 'asc'])],
        ];
    }

    public function processRules() : array {
        $isVehicleAvailable = (bool)request('is_vehicle_available');

        $vehicleAvailableRules =  $isVehicleAvailable ? [
            'vehicle_assignment_id' => ['required', 'exists:vehicle_assignments,id'],
        ] : [
        ];

        return [
            'is_vehicle_available' => ['required', 'boolean'],
            'signatories' => ['required', 'array'],
            'signatories.*.id' => ['required', 'exists:signatories,id'],
            'signatories.*.label' => ['required', 'string', 'max:255'],
            ...$vehicleAvailableRules
        ];
    }
}
