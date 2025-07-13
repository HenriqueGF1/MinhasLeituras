<?php

namespace App\Http\Requests\Usuario;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|min:2|max:40',
            'email' => 'required|email|unique:usuario,email',
            'password' => 'required|string|min:8',
            'data_nascimento' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (Carbon::parse($value)->diffInYears(Carbon::now()) < 18) {
                        $fail('Você deve ter pelo menos 18 anos.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.min' => 'O nome deve ter pelo menos 2 caracteres.',
            'nome.max' => 'O nome não pode ter mais que 40 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',

            'password.required' => 'A senha é obrigatória.',
            'password.string' => 'A senha deve ser um texto válido.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',

            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'Informe uma data de nascimento válida.',
        ];
    }

    public function attributes(): array
    {
        return [
            'data_nascimento' => 'data de nascimento',
            'password' => 'senha',
        ];
    }
}
