<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'auth.register' => $this->registerRules(),
            'auth.login' => $this->loginRules(),
            default => []
        };
    }

    public function registerRules() : array {
        return [
            'username' => ['required_without:email','nullable','string','unique:users,username'],
            'email' => ['required_without:username','nullable','email','unique:users,email'],
            'password' => ['required','string','min:8'],
            'first_ame' => ['required','string','max:255'],
            'middle_name' => ['string','max:255','nullable'],
            'last_name' => ['required','string','max:255'],
            'extension_name' => ['string','max:255','nullable'],
            'position' => ['required','string','max:255','nullable'],
            'birth_date' => ['required','date','nullable'],
            'office' => ['exists:offices,id','nullable'],
            'division' => ['exists:offices,id','nullable'],
            'contact_number' => ['required','string','max:15','nullable'],
        ];
    }

    public function loginRules() : array {
        return [
            'login' => ['required','string'],
            'password' => ['required', 'string'],
        ];
    }
}
