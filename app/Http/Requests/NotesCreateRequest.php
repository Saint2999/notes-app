<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotesCreateRequest extends FormRequest {
    
    public function rules(): array {
        return [
            'text' => 'required|string|max:2047',
            'readings_left' => 'required|numeric|gte:1|lte:10'
        ];
    }
}