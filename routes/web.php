<?php

use App\Http\Controllers\Acchanndler;
use App\Http\Controllers\Usercontroller;
use Illuminate\Support\Facades\Route;



//check user logged (condition to redirect with super admin )
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $email = strtolower((string) auth()->user()->email);

    $elevatedEmails = [
        'yahya@gmail.com',
        'laadam@gmail.com',
        'ezzaytouni@gmail.com',
        'irfane@gmail.com',
        'bahloul@gmail.com',
        'mousalim@gmail.com',
    ];

    return in_array($email, $elevatedEmails, true)
        ? redirect()->route('dashboard')
        : redirect()->route('formation');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [Usercontroller::class, 'register'])->name('register');
    Route::get('/login', [Usercontroller::class, 'login'])->name('login');
    Route::post('/register/post', [Usercontroller::class, 'registerPost'])->name('register.post');
    Route::post('/login/post', [Usercontroller::class, 'loginPost'])->name('login.post');
});

// Protected routes (role sync)
Route::middleware(['auth', 'sync.role'])->group(function () {
    Route::post('/logout', [Usercontroller::class, 'logout'])->name('logout');
    Route::get('/language/{locale}', [Usercontroller::class, 'setLanguage'])->name('language');

    Route::get('/settings', [Acchanndler::class, 'settings'])
        ->name('settings');

    Route::get('/dashboard', [Usercontroller::class, 'dash'])
        ->middleware('permission:view dashboard')
        ->name('dashboard');

    Route::get('/addformation', [Usercontroller::class, 'formation'])
        ->middleware('permission:view formations|manage formations')
        ->name('formation');

    Route::post('/addformation/store', [Usercontroller::class, 'store'])
        ->middleware('permission:manage formations')
        ->name('formation.post');

    // innsert data formation    
    Route::post('/formations/store', [Usercontroller::class, 'store'])
        ->middleware('permission:manage formations')
        ->name('formations.store');

    Route::delete('/addformation/delete/{id}', [Usercontroller::class, 'destroy'])
        ->middleware('permission:manage formations')
        ->name('delete.post');

    // delte post    
    Route::delete('/formations/{id}', [Usercontroller::class, 'destroy'])
        ->middleware('permission:manage formations')
        ->name('formations.destroy');

    // route users    
    Route::get('/users', [Usercontroller::class, 'users'])
        ->middleware('permission:manage users')
        ->name('users.index');
  
    // role to teacher    
    Route::post('/users/assign-teacher', [Usercontroller::class, 'assignTeacherRole'])
        ->middleware('permission:manage users')
        ->name('users.assign-teacher');

    Route::view('/super-admin', 'super-admin')
        ->middleware('role:Super Admin')
        ->name('super-admin.index');

    // Update profile
    Route::put('/profile', [Acchanndler::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [Acchanndler::class, 'password'])->name('profile.password');
    Route::put('/profile/password', [Acchanndler::class, 'password'])->name('profile.password');
});
