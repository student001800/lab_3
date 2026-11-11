@extends('layouts.app')
@section('title', 'Добавить город')
@section('content')
    <h1 class="mb-4">Добавить город</h1>
    <div class="form-card card"><div class="card-body p-4">
        <form action="{{ route('cities.store') }}" method="POST" enctype="multipart/form-data">
            @include('cities._form')
        </form>
    </div></div>
@endsection
