<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignatoryRequest extends FormRequest
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
            'signatories.store' => $this->createRules(),
            'signatories.index' => $this->searchRules(),
            'signatories.update' => $this->updateRules(),
            default => []
        };
    }

    public function createRules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ];
    }

    public function searchRules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'string', 'in:full_name,position'],
            'order' => ['nullable', 'string', 'in:asc,desc'],
        ];
    }

    public function updateRules(): array
    {
        return [
            'full_name' => 'sometimes|required|string|max:255',
            'position' => 'sometimes|required|string|max:255',
        ];
    }
}
