@extends('layouts.main_layout')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col">
            <p class="display-6 text-info">Esta página está acessível a usuários logados e não logados</p>
            <hr>
            @auth
                <p class="display-6 text-success">Este texto só vai ser apresentado a usuários logados</p>
            @endauth
            @guest <!-- Identifica que não há usuários logados -->
                <p class="display-6 text-warning">Este texto só vai ser apresentado a usuários visitantes</p>
            @endguest
                <p>OU DE OUTRA FORMA</p>
            @auth
                <p class="display-6 text-success">Este texto só vai ser apresentado a usuários logados</p>
            @else
                <p class="display-6 text-warning">Este texto só vai ser apresentado a usuários visitantes</p>
            @endauth
        </div>
    </div>
</div>
@endsection
