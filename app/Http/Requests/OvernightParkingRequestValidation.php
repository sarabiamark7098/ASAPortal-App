<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OvernightParkingRequestValidation extends FormRequest
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
            'overnight-parking-requests.store' => $this->createRules(),
            'overnight-parking-requests.index' => $this->searchRules(),
            'overnight-parking-requests.process' => $this->processRules(),
            'overnight-parking-requests.update' => $this->updateRules(),
            default => []
        };
    }

    public function createRules(): array
    {
        return [
            'date_requested' => ['required', 'date'],
            'justification' => ['required', 'string'],
            'plate_number' => ['required', 'nullable', 'string', 'max:255'],
            'model' => ['required', 'nullable', 'string', 'max:255'],
            'office' => ['required', 'nullable', 'string', 'max:255'],
            'requested_start' => ['required', 'nullable', 'date'],
            'requested_end' => ['required', 'nullable', 'date'],
            'requested_time' => ['required', 'nullable', 'date_format:H:i:s'],
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
            'justification',
            'plate_number',
            'model',
            'requested_start',
            'requested_end',
            'requested_time',
            'office',
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
