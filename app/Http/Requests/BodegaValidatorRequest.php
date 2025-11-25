<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BodegaValidatorRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'referencia' => 'required|string|max:255|unique:bodega,referencia',
            'descripcion' => 'required|string|max:50',
            //'estado' => 'nullable|string|in:activo,inactivo',
        ];
    }

    public function messages(): array
    {
        return [
            'referencia.required' => 'La referencia es obligatoria',
            'descripcion.required' => 'La descripcion es obligatoria'
        ];
    }
}
