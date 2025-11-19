<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
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
            'drivers.store' => $this->createRules(),
            'drivers.index' => $this->searchRules(),
            'drivers.update' => $this->updateRules(),
            default => []
        };
    }

    public function createRules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'extension_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:drivers'],
            'contact_number' => ['required', 'string', 'max:20'],
            'position' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'official_station' => ['required', 'string', 'max:255'],
        ];
    }

    public function searchRules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'string', 'in:first_name,last_name,email,contact_number'],
            'order' => ['nullable', 'string', 'in:asc,desc'],
        ];
    }

    public function updateRules(): array
    {
        return [
            'first_name' => ['sometimes', 'string', 'max:255'],
            'middle_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'extension_name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:drivers,email,' . $this->route('id')],
            'contact_number' => ['sometimes', 'string', 'max:20'],
            'position' => ['sometimes', 'string', 'max:255'],
            'designation' => ['sometimes', 'string', 'max:255'],
            'official_station' => ['sometimes', 'string', 'max:255'],
        ];
    }
}
