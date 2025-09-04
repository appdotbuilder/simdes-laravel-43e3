<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLetterRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'resident';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'letter_type_id' => 'required|exists:letter_types,id',
            'purpose' => 'required|string|max:500',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'additional_data' => 'nullable|array',
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
            'letter_type_id.required' => 'Jenis surat harus dipilih.',
            'letter_type_id.exists' => 'Jenis surat tidak valid.',
            'purpose.required' => 'Tujuan pembuatan surat harus diisi.',
            'purpose.max' => 'Tujuan pembuatan surat maksimal 500 karakter.',
            'attachments.max' => 'Maksimal 5 lampiran yang dapat diunggah.',
            'attachments.*.mimes' => 'Lampiran harus berupa file JPG, JPEG, PNG, atau PDF.',
            'attachments.*.max' => 'Ukuran lampiran maksimal 2MB.',
        ];
    }
}