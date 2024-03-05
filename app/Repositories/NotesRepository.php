<?php

namespace App\Repositories;

use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

class NotesRepository 
{
    public function getAllNotes(): Collection
    {
        return Note::all();
    }

    public function getNoteById($id): ?Note
    {
        return Note::findOrFail($id);
    }

    public function createNote(array $details): Note
    {
        return Note::create($details);
    }
}