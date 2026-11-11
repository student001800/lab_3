# Лабораторная работа №3 — Города Португалии

Laravel 12, вариант «Города Португалии». Сборка стилей и скриптов — Vite.

## Скачал на другом компьютере

Один раз поставить три программы и проверить, что команды находятся:

1. PHP 8.3. В `php.ini` включить `curl`, `fileinfo`, `mbstring`, `openssl`, `pdo_sqlite`, `sqlite3`, `gd`, `zip`. Проверка: `php -v`.
2. Composer 2. Проверка: `composer -V`.
3. Node.js LTS вместе с npm. Проверка: `node -v` и `npm -v`.

`vendor`, `node_modules`, `.env` и файл базы в репозиторий не входят. Их создают команды ниже. PowerShell открыть в скачанной папке, там где лежат `artisan` и `composer.json`.

```powershell
composer install
npm install
Copy-Item .env.example .env
php artisan key:generate
if (-not (Test-Path database/database.sqlite)) { New-Item database/database.sqlite -ItemType File }
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

Дальше в браузере: **http://127.0.0.1:8000**

Эта ссылка откроет **http://127.0.0.1:8000/cities**. Остановить сервер: `Ctrl + C` в том же терминале.

Если зависимости уже стоят, а страница без стилей:

```powershell
npm run build
php artisan serve
```

`npm run dev` для обычного просмотра не нужен.

## Куда идти в браузере

| Адрес | Что это |
| --- | --- |
| http://127.0.0.1:8000/cities | Пять городов: Лиссабон, Порту, Синтра, Фару, Брага |
| http://127.0.0.1:8000/cities/create | Форма «Добавить город» |
| http://127.0.0.1:8000/cities/1 | Подробная страница первого города |
| http://127.0.0.1:8000/cities/1/edit | Редактирование |

На карточке «Подробнее» открывает модальное окно. «Редактировать» и «Удалить» работают с той же записи. Удаление мягкое: город пропадает из списка, в базе остаётся поле `deleted_at`.

## Где что лежит

Корень `Лр_3` — само приложение. Рядом, на уровень выше, лежит текст задания `WT. ЛР №3. Laravel QuickStart(1).docx`. Его в Git не класть.

| Куда смотреть | Зачем |
| --- | --- |
| `routes/web.php` | Все адреса. Ресурс `cities` даёт index, create, store, show, edit, update, destroy |
| `app/Http/Controllers/CityController.php` | CRUD, правила валидации, уменьшение картинки через GD |
| `app/Models/City.php` | Модель, soft delete, mutator даты `visited_on` |
| `database/migrations/2026_11_10_000000_create_cities_table.php` | Таблица `cities` |
| `database/seeders/CitySeeder.php` | Пять городов из ЛР №2 |
| `resources/views/layouts/app.blade.php` | Общая вёрстка и подключение Vite |
| `resources/views/cities/` | Список, форма, страница города. Создание и правка — один шаблон `_form.blade.php` |
| `resources/views/cities/partials/details.blade.php` | Подробности и для модалки, и для страницы show |
| `resources/sass/app.scss` | Свои стили поверх Bootstrap |
| `resources/js/app.js` | Bootstrap, jQuery, модалки |
| `resources/images/` | Исходные фото. Сидер копирует их в storage |
| `storage/app/public/cities/` | Файлы, которые отдаёт сайт |
| `public/storage` | Ссылка на эту папку, команда `php artisan storage:link` |
| `public/build/` | Готовые CSS и JS после `npm run build` |
| `vite.config.js` | Настройка Vite |
| `database/database.sqlite` | База. В Git не входит |
| `.env` | Ключ приложения и `DB_CONNECTION=sqlite`. В Git не входит |

Поле «Дата посещения» добавлено специально для mutator: в ЛР №2 дат у городов не было. У пяти исходных записей оно пустое, заполняется через форму.

## Как сдавать

Репозиторий инициализировать и пушить самому, из папки `Лр_3`. Не из `ARYUM`: там ещё лежит docx задания.

```powershell
git init
git branch -M main
git add .
git status
git commit -m "Laravel 12: города Португалии"
git remote add origin https://github.com/ВАШ-ЛОГИН/ВАШ-РЕПОЗИТОРИЙ.git
git push -u origin main
```

Перед `git add` в `git status` не должно быть `.env`, `vendor`, `node_modules` и `database/database.sqlite`. Они уже в `.gitignore`.

На проверке показать:

1. http://127.0.0.1:8000/cities — пять городов и картинки.
2. «Подробнее» — модалка, из неё отдельная страница.
3. «Добавить город» — пустая форма не сохраняется, заполненная появляется в списке.
4. «Редактировать» — та же форма, дата посещения на странице города в виде `дд.мм.гггг`.
5. Загрузка картинки — файл появляется в `storage/app/public/cities` и на карточке.
6. «Удалить» — город исчезает из списка.
7. `php artisan route:list` — имена `cities.index`, `cities.show` и остальные resource-маршруты.
8. `app/Models/City.php` — mutator `setVisitedOnAttribute` и `SoftDeletes`.
