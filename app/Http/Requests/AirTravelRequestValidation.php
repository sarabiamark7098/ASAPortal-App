<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AirTravelRequestValidation extends FormRequest
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
            'air-travel-requests.store' => $this->createRules(),
            'air-travel-requests.index' => $this->searchRules(),
            'air-travel-requests.update' => $this->updateRules(),
            default => []
        };
    }

    public function createRules(): array
    {
        return [
            'date_requested' => ['required', 'date'],
            'requesting_office' => ['required', 'string', 'max:255'],
            'fund_source' => ['required', 'string', 'max:255'],
            'trip_ticket_type' => ['required', 'boolean'],
            'requester_name' => ['required', 'string', 'max:255'],
            'requester_position' => ['required', 'string', 'max:255'],
            'requester_contact_number' => ['required', 'string', 'max:255'],
            'requester_email' => ['required', 'string', 'max:255'],
            'signatories' => ['required', 'array'],
            'signatories.*.id' => ['required', 'exists:signatories,id'],
            'signatories.*.label' => ['required', 'string', 'max:255'],

            'flights' => ['required', 'array'],
            'flights.*.destination_from' => ['required', 'string', 'max:255'],
            'flights.*.destination_to' => ['required', 'string', 'max:255'],
            'flights.*.trip_mode' => ['required', 'string', 'max:255'],
            'flights.*.departure_date' => ['required', 'date'],
            'flights.*.etd' => ['required', 'date_format:H:i:s'],
            'flights.*.eta' => ['required', 'date_format:H:i:s'],

            'passengers' => ['required', 'array'],
            'passengers.*.first_name' => ['required', 'string', 'max:255'],
            'passengers.*.last_name' => ['required', 'string', 'max:255'],
            'passengers.*.birth_date' => ['required', 'date'],
            'passengers.*.position' => ['required', 'string', 'max:255'],
            'passengers.*.email' => ['required', 'string', 'max:255'],
            'passengers.*.contact_number' => ['required', 'string', 'max:255'],
        ];
    }

    public function searchRules(): array
    {

        $sortableColumns = [
            'date_requested',
            'requesting_office',
            'fund_source',
            'trip_ticket_type',
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

    public function updateRules(): array
    {
        return [
            'status' => ['required', Rule::in([Status::APPROVED->value, Status::DISAPPROVED->value])],
        ];
    }
}
