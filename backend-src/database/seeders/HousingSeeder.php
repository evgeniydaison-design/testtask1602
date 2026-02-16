<?php

namespace Database\Seeders;

use App\Models\Housing;
use Illuminate\Database\Seeder;

class HousingSeeder extends Seeder
{
    public function run(): void
    {
        $housings = [
            [
                'title' => 'Уютная квартира у моря в Сочи',
                'city' => 'sochi',
                'address' => 'Курортная, 12',
                'price' => 4500,
                'guests' => 4,
                'bedrooms' => 2,
                'beds' => 3,
                'baths' => 1,
                'image_url' => '/housignes/sochi1.jpeg',
                'description' => 'Современная квартира с видом на море в центре Сочи.',
                'amenities' => ['Wi-Fi', 'Кондиционер', 'Балкон', 'Парковка'],
            ],
            [
                'title' => 'Дом с бассейном в Геленджике',
                'city' => 'gelendzhik',
                'address' => 'Приморская, 45',
                'price' => 12000,
                'guests' => 8,
                'bedrooms' => 4,
                'beds' => 6,
                'baths' => 3,
                'image_url' => '/housignes/gelen.jpg',
                'description' => 'Просторный дом с частным бассейном и садом.',
                'amenities' => ['Бассейн', 'Wi-Fi', 'Кухня', 'Терраса', 'Парковка'],
            ],
            [
                'title' => 'Студия в Анапе для двоих',
                'city' => 'anapa',
                'address' => 'Пионерский пр., 20',
                'price' => 2800,
                'guests' => 2,
                'bedrooms' => 1,
                'beds' => 1,
                'baths' => 1,
                'image_url' => '/housignes/studia.jpg',
                'description' => 'Компактная студия в 5 минутах от пляжа.',
                'amenities' => ['Wi-Fi', 'Кондиционер', 'Кухня'],
            ],
            [
                'title' => 'Апартаменты с видом на горы в Адлере',
                'city' => 'adler',
                'address' => 'Демократическая, 8',
                'price' => 5500,
                'guests' => 4,
                'bedrooms' => 2,
                'beds' => 2,
                'baths' => 2,
                'image_url' => '/housignes/adler.jpg',
                'description' => 'Панорамный вид на горы и море.',
                'amenities' => ['Wi-Fi', 'Кондиционер', 'Балкон', 'Посудомоечная машина'],
            ],
            [
                'title' => 'Вилла на берегу в Сочи',
                'city' => 'sochi',
                'address' => 'Виноградная, 15',
                'price' => 25000,
                'guests' => 12,
                'bedrooms' => 6,
                'beds' => 8,
                'baths' => 4,
                'image_url' => '/housignes/sochi2.jpg',
                'description' => 'Роскошная вилла с прямым выходом к морю.',
                'amenities' => ['Бассейн', 'Джакузи', 'Wi-Fi', 'Парковка', 'Сад', 'Мангал'],
            ],
            [
                'title' => 'Квартира в центре Краснодара',
                'city' => 'krasnodar',
                'address' => 'Красная, 100',
                'price' => 3500,
                'guests' => 3,
                'bedrooms' => 1,
                'beds' => 2,
                'baths' => 1,
                'image_url' => '/housignes/kras.jpg',
                'description' => 'Удобная квартира в историческом центре города.',
                'amenities' => ['Wi-Fi', 'Кондиционер', 'Кухня', 'Стиральная машина'],
            ],
            [
                'title' => 'Коттедж в Геленджике',
                'city' => 'gelendzhik',
                'address' => 'Туристическая, 33',
                'price' => 15000,
                'guests' => 10,
                'bedrooms' => 5,
                'beds' => 7,
                'baths' => 3,
                'image_url' => '/housignes/gelen.jpg',
                'description' => 'Уютный коттедж для большой компании.',
                'amenities' => ['Бассейн', 'Wi-Fi', 'Мангал', 'Парковка', 'Терраса'],
            ],
            [
                'title' => 'Апартаменты у моря в Анапе',
                'city' => 'anapa',
                'address' => 'Набережная, 5',
                'price' => 6000,
                'guests' => 5,
                'bedrooms' => 2,
                'beds' => 3,
                'baths' => 2,
                'image_url' => '/housignes/anapa.jpg',
                'description' => 'Современные апартаменты с панорамными окнами.',
                'amenities' => ['Wi-Fi', 'Кондиционер', 'Балкон', 'Парковка'],
            ],
            [
                'title' => 'Домик у Олимпийского парка в Сочи',
                'city' => 'sochi',
                'address' => 'Олимпийская, 1',
                'price' => 8000,
                'guests' => 6,
                'bedrooms' => 3,
                'beds' => 4,
                'baths' => 2,
                'image_url' => '/housignes/sochi3.jpg',
                'description' => 'Удобное расположение рядом с достопримечательностями.',
                'amenities' => ['Wi-Fi', 'Кондиционер', 'Парковка', 'Терраса', 'Мангал'],
            ],
        ];

        foreach ($housings as $data) {
            Housing::create($data);
        }
    }
}
