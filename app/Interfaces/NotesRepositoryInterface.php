<?php

namespace App\Interfaces;

interface NotesRepositoryInterface {

    public function getAllNotes();
   
    public function getAllNotesWithPagination($pagination);
    
    public function getNoteBySlug($slug);

    public function deleteNote($slug);
    
    public function createNote(array $details);
   
    public function updateNote($slug, array $details);
}