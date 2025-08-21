<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|unique:users|alpha_dash:ascii|regex:/^[a-zA-Z]+/i',
            'email' => 'required|email|unique:users|ends_with:@gmail.com,@yahoo.com',
            'phone' => 'required|numeric|digits:11|unique:users',
            // If you prefer stricter rule, uncomment Password class usage
            // 'password' => ['bail', 'required', 'confirmed',
            //     Password::min(8)
            //         ->letters()
            //         ->mixedCase()
            //         ->numbers()
            //         ->symbols()
            //         ->uncompromised() ]
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
            'terms' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'username.regex' => 'Username cannot start with a number',
            'email.ends_with' => 'Only Gmail & Yahoo emails are allowed',
        ];
    }

    public function validatedData(): array
    {
        $data = $this->validated();
        unset($data['terms'], $data['password_confirmation']);
        return $data;
    }
}
