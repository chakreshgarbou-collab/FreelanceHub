<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientProfileRequest extends FormRequest
{
    // Only logged-in users may submit this form
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    // Server-side validation: runs even if HTML5 checks are bypassed
    public function rules(): array
    {
        return [
            'industry'            => ['nullable', 'string', 'max:100'],
            'bio'                 => ['nullable', 'string', 'max:2000'],
            'current_job'         => ['nullable', 'string', 'max:100'],
            'address'             => ['nullable', 'string', 'max:255'],
            'availability_status' => ['required', 'boolean'],
        ];
    }
}
