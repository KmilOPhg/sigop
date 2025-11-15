<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialValidatorRequest extends FormRequest
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
        return [
            'nombre_material' => 'required|string|max:255',
            'unidad_medida' => 'required|string|max:255',
            'estado' => 'required|string|in:activo,inactivo',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre_material.required' => 'El nombre del material es obligatorio.',
            'nombre_material.string' => 'El nombre del material debe ser una cadena de texto.',
            'nombre_material.max' => 'El nombre del material no debe exceder los 255 caracteres.',
            'unidad_medida.required' => 'La unidad de medida es obligatoria.',
            'unidad_medida.string' => 'La unidad de medida debe ser una cadena de texto.',
            'unidad_medida.max' => 'La unidad de medida no debe exceder los 255 caracteres.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser "activo" o "inactivo".',
        ];
    }
}
