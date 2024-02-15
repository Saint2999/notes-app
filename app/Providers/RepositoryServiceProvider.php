<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\NotesRepositoryInterface;
use App\Repositories\NotesRepository;

class RepositoryServiceProvider extends ServiceProvider {

    public function register(): void {
        $this->app->bind(NotesRepositoryInterface::class, NotesRepository::class);

    }

    public function boot(): void {
    
    }
}
