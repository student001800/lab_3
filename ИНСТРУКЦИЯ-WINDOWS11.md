# Запуск ЛР №3 на Windows 11 Pro — пошагово

## 0. Что установить один раз

1. PHP 8.3 x64. В `php.ini` включить `curl`, `fileinfo`, `mbstring`, `openssl`, `pdo_sqlite`, `sqlite3`, `gd`, `zip`; проверить `php -v` и `php -m`.
2. Composer 2 — при установке указать `C:\\php\\php.exe`.
3. Node.js LTS (вместе с npm).
4. Git for Windows.
5. Visual Studio Code.

После изменения PATH закрывайте и заново открывайте PowerShell/VS Code.

## 1. Распаковать проект

Распакуйте ZIP, например, в `C:\\WebProjects\\Laravel-LR3-Portugal`. Не помещайте проект в `C:\\Program Files` или папку OneDrive.

Откройте VS Code → File → Open Folder → выберите `C:\\WebProjects\\Laravel-LR3-Portugal`.

В VS Code откройте Terminal → New Terminal. Проверьте, что текущая папка — корень проекта, где лежат `artisan`, `composer.json` и `package.json`.

## 2. Установить PHP-зависимости

```powershell
composer install
```

Команда создаст `vendor`. При первом запуске она также может создать `composer.lock`.

## 3. Установить JavaScript-зависимости

```powershell
npm install
```

Команда создаст `node_modules` и `package-lock.json`.

## 4. Создать файл окружения и ключ

```powershell
if (-not (Test-Path .env)) { Copy-Item .env.example .env }
php artisan key:generate
php artisan config:clear
```

В `.env` уже предусмотрено SQLite-подключение. Не публикуйте `.env` в GitHub.

## 5. Подготовить базу и изображения

```powershell
if (-not (Test-Path database/database.sqlite)) { New-Item database/database.sqlite -ItemType File }
php artisan migrate --seed
php artisan storage:link
```

Миграции создадут таблицу `cities`; сидер добавит пять городов Португалии и скопирует их изображения в `storage/app/public/cities`.

Если `storage:link` на Windows сообщает об ошибке создания символической ссылки, включите Windows Developer Mode либо откройте PowerShell от имени администратора и повторите команду. Не создавайте вручную папку `public/storage` до выполнения команды.

## 6. Собрать CSS и JavaScript

```powershell
npm run build
```

Это Vite: SCSS и JavaScript из `resources` собираются в `public/build`. Страницы подключают их директивой `@vite`.

Пока правите стили или скрипты, в отдельном терминале можно оставить `npm run dev`.

## 7. Запустить приложение

Откройте отдельный терминал в корне проекта и выполните:

```powershell
php artisan serve
```

Откройте в браузере `http://127.0.0.1:8000`.

Пока терминал с `artisan serve` открыт, сервер работает. Остановить его можно `Ctrl + C`.

## 8. Проверить функциональность

- На главной странице должны отображаться Лиссабон, Порту, Синтра, Фару и Брага.
- Кнопка «Подробнее» открывает Bootstrap Modal; внутри есть ссылка на отдельную страницу `show`.
- «Добавить город» открывает форму создания.
- На странице города можно редактировать запись.
- Удаление выполняет Soft Delete: запись исчезает из обычного списка, но остаётся в базе с заполненным `deleted_at`.
- При загрузке нового изображения файл сохраняется в `storage/app/public/cities` и уменьшается до 1200×800 без искажения пропорций.
- Для проверки миграций: `php artisan migrate:status`.
- Для проверки маршрутов: `php artisan route:list`.
- После правок стилей снова выполните `npm run build`, если не запущен `npm run dev`.

## 9. Проверить Eloquent через Tinker

```powershell
php artisan tinker
```

В появившейся интерактивной консоли:

```php
use App\\Models\\City;

City::create([
    'name' => 'Коимбра',
    'category' => 'Университетский город',
    'short_description' => 'Тестовая запись.',
    'description' => 'Создана через Laravel Tinker для проверки модели.',
]);
```

Проверить список можно командой `App\\Models\\City::all();`, выйти — `exit`.

## 10. Git и GitHub — несколько коммитов, push и pull

Сначала создайте на GitHub пустой репозиторий (не добавляйте README, `.gitignore` или License). В терминале проекта:

```powershell
git init
git branch -M main
git config user.name "Ваше имя"
git config user.email "Email, указанный в GitHub"
```

Сделайте несколько осмысленных коммитов, добавляя разные части проекта:

```powershell
git add .editorconfig .gitattributes .gitignore .env.example artisan bootstrap config public/index.php routes composer.json composer.lock
git commit -m "Initialize Laravel 12 project"

git add database
git add app/Models app/Providers
git commit -m "Add city migration, seeder and Eloquent model"

git add app/Http/Controllers routes resources/views
git commit -m "Implement city CRUD and Blade views"

git add package.json package-lock.json vite.config.js resources/js resources/sass resources/images
git commit -m "Configure Bootstrap, jQuery and Vite"

git add README.md ИНСТРУКЦИЯ-WINDOWS11.md
git commit -m "Add setup guide and CRUD tests"
```

Если какая-либо команда `git add` сообщает, что путь не найден, проверьте имя файла/папки и продолжайте. Перед отправкой проверьте историю:

```powershell
git log --oneline
git status
```

Подключите свой удалённый GitHub-репозиторий (замените адрес на свой):

```powershell
git remote add origin https://github.com/ВАШ-ЛОГИН/ИМЯ-РЕПОЗИТОРИЯ.git
git push -u origin main
```

`push` отправляет локальные коммиты на GitHub. Для демонстрации `pull` откройте GitHub в браузере, создайте там отдельный файл, например `github-note.txt`, и сохраните его коммитом. Затем в PowerShell:

```powershell
git pull origin main
```

Теперь файл, созданный на GitHub, появится и в локальной папке. Это наглядно показывает обратное направление синхронизации. После демонстрации файл можно удалить отдельным коммитом.

**Важно:** push выполняется только после авторизации в вашем GitHub. Не отправляйте `.env`, `vendor`, `node_modules` и локальную SQLite-базу.

## Частые ошибки

- `php is not recognized` — PHP не добавлен в PATH; перезапустите терминал.
- `could not find driver` — включите `extension=pdo_sqlite` и `extension=sqlite3` в `php.ini`.
- `GD extension is required` или ошибка обработки изображения — включите `extension=gd`.
- `No application encryption key` — выполните `php artisan key:generate`.
- `Vite manifest not found` — выполните `npm install`, затем `npm run build`.
- `Table cities not found` — выполните `php artisan migrate --seed`.
- Изображения не открываются — проверьте `php artisan storage:link`.

## Почему поле даты необязательное

В исходной ЛР №2 у городов не было дат. Для выполнения требования ЛР №3 о date mutator добавлено необязательное поле `visited_on` («Дата посещения»). Сидер не выдумывает даты для пяти исходных городов. В модели есть mutator, который нормализует введённую дату к формату `YYYY-MM-DD`.
