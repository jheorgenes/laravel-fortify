@extends('layouts.main_layout')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5 card p-5">
            <form action="{{ route('password.update') }}" method="post">
                @csrf
                <p class="display-6 text-center">REDEFINIR SENHA</p>
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="mail" name="email" id="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password_confirmation">Confirmação da senha</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <div>
                        <a href="{{ route('login') }}">Página inicial</a>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-secondary px-5">DEFINIR SENHA</button>
                    </div>
                </div>
            </form>
            {{-- errors --}}
            @if ($errors->any())
                <div class="alert alert-danger mt-4">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
