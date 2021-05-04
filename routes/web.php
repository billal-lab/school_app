<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    if(Auth()->user()){
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function(){

    Route::get('/login',[App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login_index');
    Route::post('/login',[App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

    Route::get('/register',[App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register_index');
    Route::post('/register',[App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');

});

Route::middleware('auth')->group(function(){

    Route::get('/planning', [App\Http\Controllers\PlanningController::class, 'index'])->name('planning_index');
    
    Route::middleware('admin_enseignant')->group(function(){
        Route::get('/planning/create', [App\Http\Controllers\PlanningController::class, 'create_show'])->name('planning_create_show');
        Route::post('/planning/create', [App\Http\Controllers\PlanningController::class, 'create'])->name('planning_create');
        Route::get('/planning/edit', [App\Http\Controllers\PlanningController::class, 'edit_show'])->name('planning_edit_show');
        Route::post('/planning/edit', [App\Http\Controllers\PlanningController::class, 'edit'])->name('planning_edit');
        Route::post('/planning/delete', [App\Http\Controllers\PlanningController::class, 'delete'])->name('planning_delete');
    });

    Route::post('/logout',[App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/users/edit/profil', [App\Http\Controllers\UserController::class, 'edit_profil_show'])->name('edit_profil_show');
    Route::get('/users/edit/password', [App\Http\Controllers\UserController::class, 'edit_password_show'])->name('edit_password_show');

    Route::post('/users/edit/profil', [App\Http\Controllers\UserController::class, 'edit_profil'])->name('edit_profil');
    Route::post('/users/edit/password', [App\Http\Controllers\UserController::class, 'edit_password'])->name('edit_password');

    Route::middleware('admin')->group(function () {
        
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users_index');
        Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create_show'])->name('users_create_show');
        Route::post('/users/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('users_delete');
        Route::post('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users_create');

        Route::get('/formations', [App\Http\Controllers\FormationController::class, 'index'])->name('formations_index');
        Route::get('/formations/create', [App\Http\Controllers\FormationController::class, 'create_show'])->name('formations_create_show');
        Route::post('/formations/create', [App\Http\Controllers\FormationController::class, 'create'])->name('formations_create');
        Route::get('/formations/edit', [App\Http\Controllers\FormationController::class, 'edit_show'])->name('formations_edit_show');
        Route::post('/formations/edit', [App\Http\Controllers\FormationController::class, 'edit'])->name('formations_edit');
        Route::post('/formations/delete', [App\Http\Controllers\FormationController::class, 'delete'])->name('formations_delete');

        Route::get('/cours', [App\Http\Controllers\CourController::class, 'index'])->name('cours_index');
        Route::get('/cours/create', [App\Http\Controllers\CourController::class, 'create_show'])->name('cours_create_show');
        Route::post('/cours/create', [App\Http\Controllers\CourController::class, 'create'])->name('cours_create');
        Route::get('/cours/edit', [App\Http\Controllers\CourController::class, 'edit_show'])->name('cours_edit_show');
        Route::post('/cours/edit', [App\Http\Controllers\CourController::class, 'edit'])->name('cours_edit');
        Route::post('/cours/delete', [App\Http\Controllers\CourController::class, 'delete'])->name('cours_delete');

    });

    Route::middleware('etudiant')->group(function(){
        Route::get('/coursUser', [App\Http\Controllers\CourUserController::class, 'index'])->name('cours_users_index');
        Route::post('/coursUser/register', [App\Http\Controllers\CourUserController::class, 'register'])->name('cours_users_register');
        Route::post('/coursUser/unregister', [App\Http\Controllers\CourUserController::class, 'unregister'])->name('cours_users_unregister');
        Route::get('/coursUser/registred', [App\Http\Controllers\CourUserController::class, 'index_registred'])->name('cours_users_index_registred');
    });

    Route::middleware('enseignant')->group(function(){
        Route::get('/coursEnseignant', [App\Http\Controllers\CourUserController::class, 'index_responsable_cours'])->name('cours_enseignant_index');    
    });

});
