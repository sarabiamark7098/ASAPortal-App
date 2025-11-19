<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JanitorialRequestValidation extends FormRequest
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
            'janitorial-requests.store' => $this->createRules(),
            'janitorial-requests.index' => $this->searchRules(),
            'janitorial-requests.process' => $this->processRules(),
            'janitorial-requests.update' => $this->updateRules(),
            default => []
        };
    }

    public function createRules(): array
    {
        return [
            'date_requested' => ['required', 'date'],
            'requesting_office' => ['required', 'string', 'max:255'],
            'purpose' => ['required', 'string'],
            'count_utility' => ['required', 'integer'],
            'requested_date' => ['nullable', 'date'],
            'requested_time' => ['nullable', 'date_format:H:i:s'],
            'location' => ['nullable', 'string'],
            'fund_source' => ['nullable', 'string', 'max:255'],
            'office_head' => ['nullable', 'string', 'max:255'],
            'requester_name' => ['required', 'string', 'max:255'],
            'requester_position' => ['required', 'string', 'max:255'],
            'requester_contact_number' => ['required', 'string', 'max:255'],
            'requester_email' => ['required', 'string', 'max:255'],
        ];
    }

    public function searchRules(): array
    {

        $sortableColumns = [
            'date_requested',
            'requesting_office',
            'purpose',
            'count_utility',
            'requested_date',
            'requested_time',
            'location',
            'fund_source',
            'office_head',
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
            'janitors' => ['required', 'array'],
            'janitors.*.full_name' => ['required', 'string', 'max:255'],
        ];
    }

    public function updateRules(): array
    {
        return [
            'status' => ['required', Rule::in([Status::APPROVED->value, Status::DISAPPROVED->value])],
        ];
    }
}
