<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'referencia' => 'required|string|max:255|' . Rule::unique('bodega', 'referencia')->ignore(optional($this->route('bodega'))->id),
            'descripcion' => 'required|string|max:50',
            //'estado' => 'nullable|string|in:activo,inactivo',
        ];
    }

    public function messages(): array
    {
        return [
            'referencia.required' => 'La referencia es obligatoria',
            'referencia.unique' => 'Ya existe una bodega con esta referencia.',
            'descripcion.required' => 'La descripcion es obligatoria',
        ];
    }
}
