<div class="row g-3 align-items-start">
    @if($city->image_url)
        <div class="col-12 col-md-5">
            <img src="{{ $city->image_url }}" class="img-fluid rounded city-detail-image" alt="{{ $city->name }}">
        </div>
    @endif
    <div class="col">
        <p><strong>Категория:</strong> {{ $city->category }}</p>
        @if($city->landmark)
            <p><strong>Интересный объект:</strong>
                <span tabindex="0" data-bs-toggle="popover" data-bs-title="Достопримечательность" data-bs-content="{{ $city->landmark }}">{{ $city->landmark }}</span>
            </p>
        @endif
        <p>{{ $city->description }}</p>
        @if($city->population)<p><strong>Население:</strong> {{ number_format($city->population, 0, ',', ' ') }} человек</p>@endif
        @if($city->visited_on)<p><strong>Дата посещения:</strong> {{ $city->visited_on->format('d.m.Y') }}</p>@endif
    </div>
</div>
