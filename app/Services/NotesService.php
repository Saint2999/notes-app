<?php

namespace App\Services;

use App\Repositories\NotesRepository;
use App\DTOs\NoteDTO;
use Exception;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NotesService
{
    private NotesRepository $repository;

    private Hashids $hashids;

    public function __construct(NotesRepository $repository) 
    {
        $this->repository = $repository;
        $this->hashids = new Hashids('notes-app', 9);
    }

    public function getAllNotes(): array
    {
        $noteDTOs = array_map(array(NoteDTO::class, 'fromModel'), $this->repository->getAllNotes()->all());
        
        return $noteDTOs;
    }

    public function getNote(string $slug): NoteDTO
    {
        $note = $this->repository->getNoteById($this->hashids->decode($slug)[0]);

        $noteDTO = NoteDTO::fromModel($note);

        return $noteDTO;
    }

    public function confirmReading(string $slug): void
    {
        $note = $this->repository->getNoteById($this->hashids->decode($slug)[0]);
        
        $note->readings_left -= 1;

        $saved = $note->save();

        if (!$saved) {
            $message = 'Failed to confirm reading for Note-' . $note->slug;
            
            throw new Exception($message);
        }

        if ($note->readings_left >= 1) {
            return;
        }

        $deleted = $note->delete();

        if (!isset($deleted) || !$deleted) {
            $message = 'Failed to delete Note-' . $note->slug;

            throw new Exception($message);
        }
    }

    public function createNote(NoteDTO $noteDTO): NoteDTO
    {
        $note = $this->repository->createNote([
            'text' => $noteDTO->text,
            'readings_left' => $noteDTO->readings_left
        ]);

        $note->slug = $this->hashids->encode($note->id);
        
        $saved = $note->save();

        if (!$saved) {
            $message = 'Failed to save Note-' . $note->slug;

            throw new Exception($message);
        }

        $noteDTO = NoteDTO::fromModel($note);

        return $noteDTO;
    }

    public function deleteNote(string $slug): void
    {
        $note = $this->repository->getNoteById($this->hashids->decode($slug)[0]);
        
        $deleted = $note->delete();

        if (!isset($deleted) || !$deleted) {
            $message = 'Failed to delete Note-' . $note->slug;

            throw new Exception($message);
        }
    }
}
