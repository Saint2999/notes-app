<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiSuccessResponse;
use App\Services\NotesService;
use App\DTOs\NoteDTO;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class NotesController extends Controller 
{
    private NotesService $service;

    public function __construct(NotesService $service) 
    {
        $this->service = $service;
    }
    
    public function index() 
    {
        return redirect()->route('notes.show_creation');
    }

    public function showNoteCreation()
    {
        return view('notes.creation');
    }

    public function showNoteLinks() 
    {
        return view('notes.links');
    }

    public function showNote(string $slug) 
    {
        return view('notes.note')->with('slug', $slug);
    }

    public function getNoteLinks()
    {
        $notes = $this->service->getAllNotes();

        return new ApiSuccessResponse(
            $notes,
            ['self' => url()->current()]
        );
    }

    public function getNote(string $slug, Request $request) 
    {
        $note = $this->service->getNote($slug);

        return new ApiSuccessResponse(
            $note,
            ['self' => url()->current()]
        );
    }

    public function confirmReading(string $slug) 
    {
        $this->service->confirmReading($slug);

        return new ApiSuccessResponse(
            [],
            [],
            Response::HTTP_NO_CONTENT
        );
    }

    public function createNote(Request $request) 
    {
        $noteDTO = NoteDTO::fromRequest($request);

        $noteDTO = $this->service->createNote($noteDTO);

        return new ApiSuccessResponse(
            $noteDTO,
            ['self' => url()->current()],
            Response::HTTP_CREATED
        );
    }
    
    public function deleteNote(string $slug) 
    {
        $this->service->deleteNote($slug);

        return new ApiSuccessResponse(
            [],
            [],
            Response::HTTP_NO_CONTENT
        );
    }
}