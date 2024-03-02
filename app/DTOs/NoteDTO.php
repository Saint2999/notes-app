<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class NoteDTO extends ValidatedDTO
{
    public string $text;

    public int $readings_left;

    public string $slug;

    protected function rules(): array
    {
        return [
            'text' => 'required|string|max:2047',
            'readings_left' => 'required|numeric|gte:1|lte:10',
            'slug' => 'required|string|min:9|max:9',
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }
}
