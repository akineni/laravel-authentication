<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        $key = filter_var($this->input('email'), FILTER_VALIDATE_EMAIL);

        return [
            'email'    => $key ? 'required|email' : 'required',
            'password' => 'required',
            'remember-me' => 'nullable|boolean',
        ];
    }

    public function credentials(): array
    {
        $data = $this->only('email', 'password');
        if (!filter_var($this->input('email'), FILTER_VALIDATE_EMAIL)) {
            $data['username'] = $data['email'];
            unset($data['email']);
        }
        return $data;
    }
}
