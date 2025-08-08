# Laravel Modular

## Overview

This project is a Laravel application designed to provide a robust framework for building web applications. It's used modular concept to build some module for your application need.

## Features

- Integration with Laravel 12 + Breeze.
- Custom command to auto build module.

## Requirements

- PHP ^8.2
- Composer
- Node.js and npm

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/ifthenuk/laravel-modular.git
   cd <project-name>
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node.js dependencies:
   ```bash
   npm install
   ```

4. Set up the environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

6. Start the development server:
   ```bash
   composer run dev
   ```
## Command for build module
For build module, i have build custom command so you don't need to create it manualy. Just try this command :

1. Create module
```bash
php artisan module:make {module_name} {--crud}
```
you can user option ``--crud`` to make crud module

2. Make migration file inside the module
```bash
php artisan module:make-migration {module_name} {migration_name}
```

3. Make seeder file inside the module
```bash
php artisan module:make-seeder {module_name} {seeder_name}
```

4. Run seeder file inside module
```bash
php artisan module:db-seed
```

5. Delete module
```bash
php artisan module:delete {module_name}
```

## License

This project is licensed under the MIT License.
