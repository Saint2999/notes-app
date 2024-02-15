<?php

namespace App\Repositories;

use App\Interfaces\NotesRepositoryInterface;
use App\Models\Note;
use Hashids\Hashids;

class NotesRepository implements NotesRepositoryInterface {

    private Hashids $hashids;

    public function __construct() {
        $this->hashids = new Hashids('notes-app', 9);
    }

    public function getAllNotes() {
        return Note::all();
    }

    public function getAllNotesWithPagination($pagination) {
        return Note::simplePaginate($pagination);
    }

    public function getNoteBySlug($slug) {
        return Note::find($this->hashids->decode($slug)[0]);
    }

    public function deleteNote($slug) {
        Note::destroy($this->hashids->decode($slug)[0]);
    }

    public function createNote(array $details) {
        $note = Note::create($details);

        $note->slug = $this->hashids->encode($note->id);

        $note->save();

        return $note;
    }

    public function updateNote($slug, array $details) {
        return Note::whereId($this->hashids->decode($slug)[0])->update($details);
    }
}