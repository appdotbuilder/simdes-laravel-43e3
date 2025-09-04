<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLetterRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,reviewing,approved,rejected,completed',
            'admin_notes' => 'nullable|string|max:1000',
            'final_letter' => 'nullable|file|mimes:pdf|max:5120',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status tidak valid.',
            'admin_notes.max' => 'Catatan admin maksimal 1000 karakter.',
            'final_letter.mimes' => 'Surat final harus berupa file PDF.',
            'final_letter.max' => 'Ukuran surat final maksimal 5MB.',
        ];
    }
}