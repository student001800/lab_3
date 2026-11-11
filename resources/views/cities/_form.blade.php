@csrf
<div class="mb-3">
    <label for="name" class="form-label">Название города *</label>
    <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $city->name) }}" required maxlength="120">
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="category" class="form-label">Категория *</label>
    <input id="category" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $city->category) }}" required maxlength="120">
    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="short_description" class="form-label">Краткое описание *</label>
    <textarea id="short_description" name="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="2" maxlength="500" required>{{ old('short_description', $city->short_description) }}</textarea>
    @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="description" class="form-label">Подробное описание *</label>
    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="5" maxlength="5000" required>{{ old('description', $city->description) }}</textarea>
    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="landmark" class="form-label">Главная достопримечательность</label>
        <input id="landmark" name="landmark" class="form-control @error('landmark') is-invalid @enderror" value="{{ old('landmark', $city->landmark) }}" maxlength="255">
        @error('landmark')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="population" class="form-label">Население (человек)</label>
        <input id="population" type="number" min="0" name="population" class="form-control @error('population') is-invalid @enderror" value="{{ old('population', $city->population) }}">
        @error('population')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="mb-3">
    <label for="visited_on" class="form-label">Дата посещения (необязательно)</label>
    <input id="visited_on" type="date" name="visited_on" class="form-control @error('visited_on') is-invalid @enderror" value="{{ old('visited_on', $city->visited_on?->format('Y-m-d')) }}">
    <div class="form-text">Дополнительное поле для демонстрации преобразования даты в Eloquent-модели.</div>
    @error('visited_on')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-4">
    <label for="image" class="form-label">Изображение города</label>
    <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp" class="form-control @error('image') is-invalid @enderror">
    <div class="form-text">JPG, PNG или WebP, максимум 4 МБ. Изображение будет уменьшено с сохранением пропорций.</div>
    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
    @if($city->image_url)
        <img src="{{ $city->image_url }}" class="current-image mt-3" alt="Текущее изображение">
    @endif
</div>
<button class="btn btn-primary" type="submit">Сохранить</button>
<a href="{{ route('cities.index') }}" class="btn btn-outline-secondary ms-2">Отмена</a>
