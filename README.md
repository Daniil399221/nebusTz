# 🏢 NebusTz API

## ✨ Возможности

- **🏗️ Управление зданиями** - работа с объектами недвижимости с геолокацией
- **📋 Виды деятельности** - иерархическая структура видов деятельности
- **📍 Геопоиск** - поиск организаций и зданий по радиусу
- **🔐 Безопасность** - API ключ аутентификация
- **📚 Swagger документация** - автоматическая генерация API документации
- **🧪 Тестирование** - полное покрытие тестами с Pest
- **🚀 Современный стек** - Laravel 10, PHP 8.3, современные пакеты

## 🏗️ Архитектура

Проект построен на Laravel 10

- **Models**: Organization, Building, Activity, User
- **Controllers**: RESTful контроллеры с валидацией
- **Services**: Бизнес-логика вынесена в сервисные классы
- **Resources**: API ресурсы для форматирования ответов
- **Middleware**: Кастомная аутентификация через API ключ
- **Testing**: Feature и Unit тесты с Pest

## 🚀 Быстрый старт

### Требования

- PHP 8.3+
- Laravel 10
- Composer
- PostgreSQL

### Установка

1. **Клонируйте репозиторий**
```bash
git clone <repository-url>
cd nebusTz/api
```

2. **Установите зависимости**
```bash
composer install
```

3. **Настройте окружение**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Запуск docker**
```bash
В корне nebuzTz
docker-compose up
```

4. **Настройте базу данных**
```bash
php artisan migrate
php artisan db:seed
```

## 📚 API Endpoints

### 🔐 Аутентификация
Все API endpoints защищены статическим API ключом через middleware `ApiStaticKey` - fa30-k4v9-5316-kEQ.
Можно поменять в .env

### 🏢 Организации

| Метод | Endpoint | Описание |
|-------|----------|----------|
| `GET` | `/api/organization/{id}` | Получить организацию по ID |
| `GET` | `/api/organization/search/name` | Поиск организаций по названию |
| `GET` | `/api/organization/radius` | Поиск организаций в радиусе |
| `GET` | `/api/organization/buildings/{id}/organizations` | Организации в здании |
| `GET` | `/api/organization/activity/{id}/organizations` | Организации по виду деятельности |
| `GET` | `/api/organization/activity/{id}/organizations-with-children` | Организации с дочерними видами деятельности |

### 🏗️ Здания

| Метод | Endpoint | Описание |
|-------|----------|----------|
| `GET` | `/api/buildings` | Список всех зданий |
| `GET` | `/api/buildings/{id}` | Получить здание по ID |
| `GET` | `/api/buildings/radius` | Поиск зданий в радиусе |

### 📋 Виды деятельности

| Метод | Endpoint | Описание |
|-------|----------|----------|
| `GET` | `/api/activity` | Список всех видов деятельности |
| `GET` | `/api/activity/{id}` | Получить вид деятельности по ID |

## 🗄️ Структура базы данных

### Organizations
- `id` - UUID первичный ключ
- `name` - Название организации
- `phone` - Телефон
- `building_id` - Связь с зданием
- `activity_id` - Связь с видом деятельности
- `slug` - URL-friendly название

### Buildings
- `id` - Первичный ключ
- `address` - Адрес здания
- `latitude` - Широта
- `longitude` - Долгота

### Activities
- `id` - Первичный ключ
- `name` - Название вида деятельности
- `parent_id` - Родительский вид деятельности
- `level` - Уровень в иерархии

## 🧪 Тестирование

Проект использует Pest для тестирования:

```bash
composer test:unit
```

## 📖 Документация API

Swagger документация автоматически генерируется:

```bash
# Генерация документации
php artisan l5-swagger:generate
```

Документация доступна по адресу: `http://localhost:92/api/documentation`

## 🛠️ Разработка

### Code Style
Проект использует Laravel Pint для форматирования кода:

```bash
composer lint
```

### Рефакторинг
Используется Rector для автоматического рефакторинга:

```bash
composer rector
```

## 📦 Используемые пакеты

### Основные
- **Laravel 10** - PHP фреймворк
- **Laravel Sanctum** - API аутентификация
- **L5-Swagger** - Swagger документация
- **Spatie Laravel Data** - Data Transfer Objects
- **Spatie Laravel Sluggable** - Автоматические slug'и

### Разработка
- **Pest** - Тестирование
- **Laravel Pint** - Code style
- **Rector** - Рефакторинг
- **Laravel Dusk** - Browser тестирование
- **Проект**: NebusTz API

