# Всё лето

Каталог жилья для отпуска. Nuxt 3 на фронте, Laravel на бэке.

## Как запустить

Нужны PHP 8.2+, Composer и Node.js 20+.

**Backend:**
```bash
composer create-project laravel/laravel backend
Copy-Item -Path "backend-src\*" -Destination "backend\" -Recurse -Force
cd backend
copy .env.example .env
php artisan key:generate
type nul > database\database.sqlite или New-Item -Path database\database.sqlite -ItemType File -Force
php artisan migrate --seed
php artisan serve
```

API: http://127.0.0.1:8000/api

**Frontend:**
```bash
cd frontend
npm install
npm run dev
```

Сайт: http://localhost:3000

Если фронт не видит API — в `frontend/.env` добавь:
```
NUXT_PUBLIC_API_BASE=http://127.0.0.1:8000/api
```

## API

`GET /api/housings` — список жилья с пагинацией.

Параметры: `city`, `min_price`, `max_price`, `guests`, `sort` (price_asc | price_desc | newest), `page`.

## Структура

- `backend-src/` — исходники Laravel (копируются в backend после create-project)
- `frontend/` — Nuxt приложение
