<?php

use App\Livewire\Dashboard\Category\Index as CategoryIndex;
use App\Livewire\Dashboard\Category\Save as CategorySave;
use App\Livewire\Dashboard\Post\Index as PostIndex;
use App\Livewire\Dashboard\Post\Save as PostSave;
use App\Livewire\Dashboard\Tag\Index as TagIndex;
use App\Livewire\Dashboard\Tag\Save as TagSave;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('dashboard')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Categories
    Route::prefix('category')->group(function () {
        Route::get('/', CategoryIndex::class)->name('d-category-index');
        Route::get('/create', CategorySave::class)->name('d-category-save');
        Route::get('/edit/{category}', CategorySave::class)->name('d-category-edit');
    });

    // Posts
    Route::prefix('post')->group(function () {
        Route::get('/', PostIndex::class)->name('d-post-index');
        Route::get('/create', PostSave::class)->name('d-post-save');
        Route::get('/edit/{post}', PostSave::class)->name('d-post-edit');
    });

    // Tags
    Route::prefix('tag')->group(function () {
        Route::get('/', TagIndex::class)->name('d-tag-index');
        Route::get('/create', TagSave::class)->name('d-tag-save');
        Route::get('/edit/{tag}', TagSave::class)->name('d-tag-edit');
    });
});
