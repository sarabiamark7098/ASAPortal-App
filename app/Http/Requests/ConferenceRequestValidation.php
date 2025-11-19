<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConferenceRequestValidation extends FormRequest
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
            'conference-requests.store' => $this->createRules(),
            'conference-requests.index' => $this->searchRules(),
            'conference-requests.process' => $this->processRules(),
            'conference-requests.update' => $this->updateRules(),
            default => []
        };
    }

    public function createRules(): array
    {
        return [
            'date_requested' => ['required', 'date'],
            'requesting_office' => ['required', 'string', 'max:255'],
            'purpose' => ['required', 'string'],
            'requested_start' => ['required', 'date'],
            'requested_time_start' => ['required', 'date_format:H:i:s'],
            'requested_end' => ['required', 'date'],
            'requested_time_end' => ['required', 'date_format:H:i:s'],
            'conference_room' => ['required', 'string', 'max:255'],
            'number_of_persons' => ['required', 'integer'],
            'focal' => ['required', 'string', 'max:255'],
            'requester_name' => ['required', 'string', 'max:255'],
            'requester_position' => ['required', 'string', 'max:255'],
            'requester_contact_number' => ['required', 'string', 'max:255'],
            'requester_email' => ['required', 'string', 'max:255'],

            'files' => ['required', 'array'],
            'files.*.label' => ['required', 'string', 'max:255'],
            'files.*.file' => ['required'],
        ];
    }

    public function searchRules(): array
    {

        $sortableColumns = [
            'date_requested',
            'requesting_office',
            'purpose',
            'requested_start',
            'requested_time_start',
            'requested_end',
            'requested_time_end',
            'conference_room',
            'number_of_persons',
            'focal',
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

    public function processRules(): array
    {
        return [
            'is_conference_available' => ['required', 'boolean'],
            'signatories' => ['required', 'array'],
            'signatories.*.id' => ['required', 'exists:signatories,id'],
            'signatories.*.label' => ['required', 'string', 'max:255'],
        ];
    }

    public function updateRules(): array
    {
        return [
            'status' => ['required', Rule::in([Status::APPROVED->value, Status::DISAPPROVED->value])],
        ];
    }
}
