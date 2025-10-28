<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EntryRequestValidation extends FormRequest
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
            'entry-requests.store' => $this->createRules(),
            'entry-requests.index' => $this->searchRules(),
            'entry-requests.update' => $this->updateRules(),
            default => []
        };
    }

    public function createRules(): array
    {
        return [
            'date_requested' => ['required', 'date'],
            'requesting_office' => ['required', 'string', 'max:255'],
            'requested_date' => ['required', 'date'],
            'requester_name' => ['required', 'string', 'max:255'],
            'requester_position' => ['required', 'string', 'max:255'],
            'requester_contact_number' => ['required', 'string', 'max:255'],
            'requester_email' => ['required', 'string', 'max:255'],

            'signatories' => ['required', 'array'],
            'signatories.*.id' => ['required', 'exists:signatories,id'],
            'signatories.*.label' => ['required', 'string', 'max:255'],

            'guests' => ['required', 'array'],
            'guests'.'*'.'full_name' => ['required', 'string', 'max:255'],
            'guests'.'*'.'purpose' => ['required', 'string'],
        ];
    }

    public function searchRules(): array
    {

        $sortableColumns = [
            'date_requested',
            'requesting_office',
            'requested_date',
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
