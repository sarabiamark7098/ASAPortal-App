<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
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
            'vehicles.store' => $this->createRules(),
            'vehicles.index' => $this->searchRules(),
            'vehicles.update' => $this->updateRules(),
            default => []
        };
    }

    public function createRules(): array
    {
        return [
            'plate_number' => ['required', 'string', 'max:255', 'unique:vehicles'],
            'unit_type' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'purchase_year' => ['nullable', 'integer', 'min:1886', 'max:' . date('Y')],
            'model_year' => ['nullable', 'integer', 'min:1886', 'max:' . date('Y')],
            'engine_number' => ['nullable', 'string', 'max:255', 'unique:vehicles'],
            'chasis_number' => ['nullable', 'string', 'max:255', 'unique:vehicles'],
        ];
    }

    public function searchRules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'string', 'in:plate_number,unit_type,brand,model'],
            'order' => ['nullable', 'string', 'in:asc,desc'],
        ];
    }

    public function updateRules(): array
    {
        return [
            'plate_number' => ['required', 'string', 'max:255', 'unique:vehicles,plate_number,' . $this->route('id')],
            'unit_type' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'purchase_year' => ['nullable', 'integer', 'min:1886', 'max:' . date('Y')],
            'model_year' => ['nullable', 'integer', 'min:1886', 'max:' . date('Y')],
            'engine_number' => ['nullable', 'string', 'max:255', 'unique:vehicles,engine_number,' . $this->route('id')],
            'chasis_number' => ['nullable', 'string', 'max:255', 'unique:vehicles,chasis_number,' . $this->route('id')],
        ];

    }
}
