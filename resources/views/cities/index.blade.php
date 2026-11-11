@extends('layouts.app')

@section('title', 'Города Португалии')

@section('content')
    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
        <div>
            <p class="eyebrow mb-1">Portugal · PT</p>
            <h1 class="mb-0">Крупнейшие города Португалии</h1>
        </div>
        <a href="{{ route('cities.create') }}" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Добавить город</a>
    </div>

    <div class="row g-4 justify-content-center" id="cities">
        @forelse($cities as $city)
            <div class="col-12 col-sm-6 col-lg-4">
                <article class="card h-100 city-card">
                    @if($city->image_url)
                        <img src="{{ $city->image_url }}" class="card-img-top city-card-image" alt="{{ $city->name }}">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-primary align-self-start mb-2">{{ $city->category }}</span>
                        <h2 class="h5 card-title">{{ $city->name }}</h2>
                        <p class="card-text flex-grow-1">{{ $city->short_description }}</p>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#cityModal{{ $city->id }}">Подробнее</button>
                            <a href="{{ route('cities.edit', $city) }}" class="btn btn-outline-secondary btn-sm">Редактировать</a>
                            <form action="{{ route('cities.destroy', $city) }}" method="POST" onsubmit="return confirm('Переместить город в удалённые записи?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit">Удалить</button>
                            </form>
                        </div>
                    </div>
                </article>

                <div class="modal fade" id="cityModal{{ $city->id }}" tabindex="-1" aria-labelledby="cityModalLabel{{ $city->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title fs-5" id="cityModalLabel{{ $city->id }}">{{ $city->name }}</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                            </div>
                            <div class="modal-body">@include('cities.partials.details', ['city' => $city])</div>
                            <div class="modal-footer">
                                <a href="{{ route('cities.show', $city) }}" class="btn btn-primary">Открыть отдельную страницу</a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Города пока не добавлены.</div></div>
        @endforelse
    </div>
@endsection
