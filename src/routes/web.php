<?php

use App\Models\Ticket;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\EventController;

use App\Http\Controllers\PlaceController;
use App\Http\Controllers\TicketController;




Route::get('/', function () {
    return view('landing');
});

Route::middleware('permission:see-panel')->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', function () {
        // Verificar si el usuario tiene el rol 'root'
        $isRoot = auth()->user()->hasRole('root'); // Verifica si el usuario tiene el rol root
        $userArea = auth()->user()->area; // Obtener el área del usuario
    
        // Si el usuario es root, obtiene todos los tickets, si no, obtiene solo los tickets de su área
        $tickets = $isRoot ? Ticket::all() : Ticket::where('area', $userArea)->get();
    
        // Pasar los tickets a la vista dashboard
        return view('dashboard', compact('tickets'));
    })->name('dashboard');
    


    Route::get('/pull-events', [EventController::class, 'pullEvents'])->name('pull-events');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('places', PlaceController::class);
    Route::resource('logs', LogController::class);
    Route::resource('tickets', TicketController::class);
    Route::put('/tickets/{ticket}/resolve', [TicketController::class, 'resolveTicket'])->name('tickets.resolve');
    Route::post('/tickets/{ticket}/reopen', [TicketController::class, 'reopen'])->name('tickets.reopen');

});



Route::resource('assets', AssetController::class)->middleware('auth');
Route::post('/tickets/{ticket}/assign-area', [TicketController::class, 'assignToArea'])->name('tickets.assignArea');


