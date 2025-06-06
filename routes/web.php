<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\IndexController;
use App\Models\User;
use App\Events\TestEvent;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Message routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
});


// Corrected dashboard route to use controller only
Route::get('/dashboard', [IndexController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.view');
// Route::post('/chat/{id}/send', [ChatController::class, 'send'])->name('chat.send');
Route::post('/chat/{id}', [ChatController::class, 'send'])->name('chat.send');


Route::get('/send-test-event', function () {
    event(new TestEvent('Hello from Laravel Reverb'));
    return 'Event dispatched!';
});

require __DIR__.'/auth.php';