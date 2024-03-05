<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;

Route::get('/notes', [NotesController::class, 'getNoteLinks'])->name('notes.get_links');
Route::get('/notes/{slug}', [NotesController::class, 'getNote'])->name('notes.get_note');

Route::patch('/notes/{slug}', [NotesController::class, 'confirmReading'])->name('notes.confirm_reading');

Route::post('/notes/create', [NotesController::class, 'createNote'])->name('notes.create_note');

Route::delete('/notes/{slug}', [NotesController::class, 'deleteNote'])->name('notes.delete_note');