<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssistanceRequestValidation extends FormRequest
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
            'assistance-requests.store' => $this->createRules(),
            'assistance-requests.index' => $this->searchRules(),
            'assistance-requests.process' => $this->processRules(),
            default => []
        };
    }

    public function createRules(): array
    {
        return [
            'date_requested' => ['required', 'date'],
            'requesting_office' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string'],
            'request_type' => ['required', 'array'],
            'request_nature' => ['required', 'array'],
            'other_type' => ['nullable', 'string', 'max:255'],
            'other_nature' => ['nullable', 'string', 'max:255'],
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
            'details',
            'request_type',
            'request_nature',
            'other_type',
            'other_nature',
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
            'status' => ['required', Rule::in([Status::APPROVED->value, Status::DISAPPROVED->value])],
        ];
    }
}
