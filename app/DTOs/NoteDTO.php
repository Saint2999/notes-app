<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;
use WendellAdriel\ValidatedDTO\Casting\IntegerCast;

class NoteDTO extends ValidatedDTO
{
    public string $text;

    public int $readings_left;

    public ?string $slug;

    protected function rules(): array
    {
        return [
            'text' => 'required|string|max:2047',
            'readings_left' => 'required|integer|gte:0|lte:10',
            'slug' => 'string|min:9|max:9'        
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [
            'readings_left' => new IntegerCast(),
        ];
    }
}
