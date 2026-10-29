<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFreelancerProfileRequest extends FormRequest
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
            'professional_title'  => ['required', 'string', 'max:100'],
            'bio'                 => ['nullable', 'string', 'max:2000'],
            'skills'              => ['nullable', 'string', 'max:255'],
            'location'            => ['nullable', 'string', 'max:100'],
            'hourly_rate'         => ['required', 'numeric', 'min:0', 'max:100000'],
            'availability_status' => ['required', 'boolean'],
        ];
    }
}