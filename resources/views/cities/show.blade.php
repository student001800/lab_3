@extends('layouts.app')
@section('title', $city->name . ' — Города Португалии')
@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div><p class="eyebrow mb-1">Подробная информация</p><h1>{{ $city->name }}</h1></div>
        <a href="{{ route('cities.index') }}" class="btn btn-outline-secondary">← К списку городов</a>
    </div>
    <section class="card detail-card"><div class="card-body p-4">
        @include('cities.partials.details', ['city' => $city])
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('cities.edit', $city) }}" class="btn btn-primary">Редактировать</a>
            <form action="{{ route('cities.destroy', $city) }}" method="POST" onsubmit="return confirm('Переместить город в удалённые записи?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger">Удалить</button>
            </form>
        </div>
    </div></section>
@endsection
