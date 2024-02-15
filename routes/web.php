<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;

Route::get('/', [NotesController::class, 'index']);

Route::get('/creation', [NotesController::class, 'showNoteCreation'])->name('notes.show_creation');
Route::get('/notes', [NotesController::class, 'showNoteLinks'])->name('notes.show_links');
Route::get('/note/{slug}', [NotesController::class, 'showNote'])->name('notes.show_note');

Route::patch('/note/{slug}', [NotesController::class, 'confirmReading'])->name('notes.confirm_reading');

Route::post('/create-note', [NotesController::class, 'createNote'])->name('notes.create_note');

Route::delete('/delete-note/{slug}', [NotesController::class, 'deleteNote'])->name('notes.delete_note');