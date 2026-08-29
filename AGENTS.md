# Repository Guidelines

## Project Structure & Module Organization

This is a Laravel 12 LMS application with Filament admin screens. Core PHP code lives in `app/`: models in `app/Models`, controllers in `app/Http/Controllers`, services in `app/Services`, console commands in `app/Console/Commands`, and Filament resources/widgets/pages in `app/Filament`. Routes are defined in `routes/web.php` and `routes/console.php`. Blade templates are in `resources/views`, with frontend assets in `resources/css` and `resources/js`. Migrations, factories, and seeders are under `database/`. Tests are split into `tests/Feature` and `tests/Unit`. Public assets are under `public/`.

## Build, Test, and Development Commands

- `composer install` installs PHP dependencies.
- `composer run dev` starts the local Laravel server.
- `php artisan migrate --seed` applies migrations and seeders for local data.
- `composer test` clears config and runs the Laravel test suite.
- `./vendor/bin/pint` formats PHP code with Laravel Pint.

## Coding Style & Naming Conventions

Follow Laravel defaults and PSR-4 autoloading. Use 4-space indentation for PHP, strict namespaces matching paths, and descriptive class names such as `CourseGraphService`, `LessonController`, or `CreateCourse`. Keep Filament resource code grouped by resource under `app/Filament/Resources/<PluralName>/` with `Pages`, `Schemas`, and `Tables` subdirectories. Prefer service classes for recommendation, graph, pacing, and scoring logic instead of placing domain algorithms in controllers.

## Testing Guidelines

PHPUnit is configured in `phpunit.xml`; tests use SQLite in memory and array-backed cache/session/mail drivers. Add unit tests for isolated services and algorithms in `tests/Unit`, and feature tests for routes, controllers, enrollment flows, and Filament behavior in `tests/Feature`. Name tests after the behavior under test, for example `RecommendationServiceTest` or `EnrollmentFlowTest`, and run `composer test` before submitting changes.

## Commit & Pull Request Guidelines

Recent history uses short, lowercase commit messages such as `database` and `first commit`; keep commits concise but more descriptive when possible, for example `add course recommendation tests`. Pull requests should include a summary, testing performed, migration or seeder impacts, and screenshots for UI changes in Blade or Filament pages. Link related issues when available and call out any required `.env` or database setup changes.

## Security & Configuration Tips

Do not commit `.env`, generated secrets, or local database dumps. Keep credentials in environment variables and use Laravel config files under `config/` for defaults only. Review migrations and seeders carefully before changing production-facing data shapes.
