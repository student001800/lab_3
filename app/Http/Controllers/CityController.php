<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CityController extends Controller
{
    public function index(): View
    {
        $cities = City::query()->orderBy('id')->get();

        return view('cities.index', compact('cities'));
    }

    public function create(): View
    {
        return view('cities.create', ['city' => new City()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);
        unset($validated['image']);
        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->storeResizedImage($request);
        }

        try {
            City::create($validated);
        } catch (\Throwable $exception) {
            if (!empty($validated['image_path'])) {
                Storage::disk('public')->delete($validated['image_path']);
            }
            throw $exception;
        }

        return redirect()->route('cities.index')->with('success', 'Город успешно добавлен.');
    }

    public function show(City $city): View
    {
        return view('cities.show', compact('city'));
    }

    public function edit(City $city): View
    {
        return view('cities.edit', compact('city'));
    }

    public function update(Request $request, City $city): RedirectResponse
    {
        $validated = $this->validatedData($request);
        unset($validated['image']);

        $newPath = null;
        if ($request->hasFile('image')) {
            $newPath = $this->storeResizedImage($request);
            $validated['image_path'] = $newPath;
        }

        $originalUpdatedAt = $city->getOriginal('updated_at');
        $previousImage = $city->getOriginal('image_path');
        $city->fill($validated);

        $payload = ['updated_at' => now()];
        foreach (array_keys($validated) as $key) {
            $payload[$key] = $city->getAttributes()[$key] ?? null;
        }

        $saved = City::query()
            ->whereKey($city->getKey())
            ->where('updated_at', $originalUpdatedAt)
            ->update($payload);

        if ($saved === 0) {
            if ($newPath) {
                Storage::disk('public')->delete($newPath);
            }

            return redirect()
                ->route('cities.edit', $city)
                ->withInput()
                ->withErrors(['name' => 'Город уже изменили. Обновите страницу и повторите сохранение.']);
        }

        if ($newPath && $previousImage && $previousImage !== $newPath) {
            Storage::disk('public')->delete($previousImage);
        }

        return redirect()->route('cities.show', $city)->with('success', 'Данные города обновлены.');
    }

    public function destroy(City $city): RedirectResponse
    {
        // Soft delete intentionally keeps the image file, so the record can be restored later.
        $city->delete();

        return redirect()->route('cities.index')->with('success', 'Город перемещён в удалённые записи.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:120'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'max:5000'],
            'landmark' => ['nullable', 'string', 'max:255'],
            'population' => ['nullable', 'integer', 'min:0'],
            'visited_on' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
    }

    /**
     * Resize an uploaded image to fit within 1200x800 while preserving aspect ratio.
     * Uses PHP GD (extension=gd), avoiding an unnecessary third-party image library.
     */
    private function storeResizedImage(Request $request): string
    {
        $file = $request->file('image');
        $binary = file_get_contents($file->getRealPath());
        $source = $binary === false ? false : @imagecreatefromstring($binary);
        if (!$source) {
            throw ValidationException::withMessages([
                'image' => 'Не удалось прочитать загруженное изображение.',
            ]);
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $scale = min(1, 1200 / max(1, $width), 800 / max(1, $height));
        $newWidth = max(1, (int) round($width * $scale));
        $newHeight = max(1, (int) round($height * $scale));
        $canvas = imagecreatetruecolor($newWidth, $newHeight);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);
        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        ob_start();
        $written = imagejpeg($canvas, null, 85);
        $contents = ob_get_clean();
        imagedestroy($source);
        imagedestroy($canvas);

        if (!$written || $contents === false || $contents === '') {
            throw ValidationException::withMessages([
                'image' => 'Не удалось сохранить изображение.',
            ]);
        }

        $path = 'cities/' . Str::uuid() . '.jpg';
        Storage::disk('public')->put($path, $contents);

        return $path;
    }
}
