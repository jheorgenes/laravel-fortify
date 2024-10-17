<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    echo "Hello fortify";
})->middleware(['auth']); //Ao adicionar esse middleware, o fortify identifica se está autenticado e se não, redireciona para auth.login
