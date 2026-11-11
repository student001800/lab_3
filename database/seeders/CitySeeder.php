<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            [
                'name' => 'Лиссабон', 'slug' => 'lisbon', 'category' => 'Столица',
                'short_description' => 'Столица Португалии, известная своими холмами и старинными трамваями.',
                'description' => 'Лиссабон — крупнейший город и столица Португалии. Расположен на семи холмах на берегу реки Тежу. Район Алфама известен своими традициями. Население: около 500 тысяч человек. Климат средиземноморский.',
                'landmark' => 'Район Алфама', 'population' => 500000, 'image' => 'lisbon.jpg',
            ],
            [
                'name' => 'Порту', 'slug' => 'porto', 'category' => 'Культурный центр',
                'short_description' => 'Второй по величине город, знаменитый мостом Луиша I и портвейном.',
                'description' => 'Порту — второй по величине город Португалии. Знаменит мостом Луиша I и производством портвейна. Исторический центр включен в список Всемирного наследия ЮНЕСКО.',
                'landmark' => 'Мост Луиша I', 'population' => null, 'image' => 'porto.jpg',
            ],
            [
                'name' => 'Синтра', 'slug' => 'sintra', 'category' => 'Дворцовый комплекс',
                'short_description' => 'Живописный город с романтическими дворцами Пена и Кинта да Регалейра.',
                'description' => 'Синтра — город в 25 км от Лиссабона, знаменитый своими дворцом Пена и Кинта да Регалейра. Включен в список Всемирного наследия ЮНЕСКО с 1995 года.',
                'landmark' => 'Дворец Пена', 'population' => null, 'image' => 'sintra.jpg',
            ],
            [
                'name' => 'Фару', 'slug' => 'faro', 'category' => 'Курорт',
                'short_description' => 'Главный город региона Алгарве с потрясающими пляжами южного побережья.',
                'description' => 'Фару — главный город региона Алгарве на юге страны. Известен потрясающими пляжами, лагуной Риа Формоза и свежими морепродуктами.',
                'landmark' => 'Лагуна Риа Формоза', 'population' => null, 'image' => 'faro.jpg',
            ],
            [
                'name' => 'Брага', 'slug' => 'braga', 'category' => 'Религиозный центр',
                'short_description' => 'Один из старейших городов страны, известный как «португальский Рим».',
                'description' => 'Брага — один из старейших городов Португалии, известный как Bom Jesus do Monte. В городе более 30 церквей и соборов. Молодежная столица Европы 2012 года.',
                'landmark' => 'Bom Jesus do Monte', 'population' => null, 'image' => 'braga.jpg',
            ],
        ];

        foreach ($cities as $data) {
            $source = resource_path('images/' . $data['image']);
            $target = 'cities/' . $data['image'];

            if (is_file($source)) {
                Storage::disk('public')->put($target, file_get_contents($source));
            }

            City::updateOrCreate(
                ['name' => $data['name']],
                [
                    'category' => $data['category'],
                    'short_description' => $data['short_description'],
                    'description' => $data['description'],
                    'landmark' => $data['landmark'],
                    'population' => $data['population'],
                    'image_path' => is_file($source) ? $target : null,
                ]
            );
        }
    }
}
