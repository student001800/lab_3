@extends('layouts.app')
@section('title', 'Редактировать ' . $city->name)
@section('content')
    <h1 class="mb-4">Редактировать: {{ $city->name }}</h1>
    <div class="form-card card"><div class="card-body p-4">
        <form action="{{ route('cities.update', $city) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('cities._form')
        </form>
    </div></div>
@endsection
