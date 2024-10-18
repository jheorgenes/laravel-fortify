<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->middleware(['auth']); //Ao adicionar esse middleware, o fortify identifica se está autenticado e se não, redireciona para auth.login

Route::view('/contacts', 'contacts')->name('contacts');
