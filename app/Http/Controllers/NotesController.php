<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NotesCreateRequest;
use App\Interfaces\NotesRepositoryInterface;

class NotesController extends Controller {

    private NotesRepositoryInterface $repository;

    public function __construct(NotesRepositoryInterface $repository) {
        $this->repository = $repository;
    }
    
    public function index() {
        return redirect()->route('notes.show_creation');
    }

    public function showNoteCreation() {
        return view('notes.creation');
    }

    public function showNoteLinks() {
        $notes = $this->repository->getAllNotesWithPagination(5);

        return view('notes.links')->with('notes', $notes);
    }

    public function showNote($slug, Request $request) {
        $note = $this->repository->getNoteBySlug($slug);

        if ($note == null) {
            return view('notes.note')->with('error', 'Note does not exist');
        }

        if ($request->confirmed == 0) {
            return view('notes.note')->with('slug', $slug);
        }

        if ($note->readings_left < 1) {
            $this->repository->deleteNote($slug);
        }

        return view('notes.note')->with('note', $note);
    }

    public function confirmReading($slug) {
        $note = $this->repository->getNoteBySlug($slug);

        $note->readings_left -= 1;

        $this->repository->updateNote($slug, ['readings_left' => $note->readings_left]);

        return redirect()->route('notes.show_note', ['slug' => $slug, 'confirmed'=> 1]);
    }

    public function deleteNote($slug) {
        $this->repository->deleteNote($slug);

        return redirect()->route('notes.show_links');
    }

    public function createNote(NotesCreateRequest $request) {
        $details = $request->only([
            'text',
            'readings_left'
        ]);

        $this->repository->createNote($details);

        return redirect()->route('notes.show_links');
    }
}