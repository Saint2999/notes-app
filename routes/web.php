<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;

Route::get('/', [NotesController::class, 'index']);

Route::get('/creation', [NotesController::class, 'showNoteCreation'])->name('notes.show_creation');
Route::get('/notes', [NotesController::class, 'showNoteLinks'])->name('notes.show_links');
Route::get('/notes/{slug}', [NotesController::class, 'showNote'])->name('notes.show_note');