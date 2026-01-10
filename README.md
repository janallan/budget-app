# Budget App

A modern budget management application built with Laravel and Flux UI.

## Features

- Track income and expenses
- Categorize transactions
- View spending analytics
- Budget planning and monitoring
- Responsive design

## Requirements

- PHP 8.1+
- Laravel 10+
- Node.js 16+
- Composer

## Installation

```bash
# Clone repository
git clone <repository-url>
cd budget

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Build assets
npm run build

# Start development server
php artisan serve
```

## Usage

1. Register an account
2. Add income and expense transactions
3. Organize transactions by category
4. Review budget reports and analytics

## Technology Stack

- **Backend**: Laravel
- **UI Framework**: Flux UI
- **Database**: MySQL/PostgreSQL

## Contributing

Submit pull requests to improve the app.

## License

MIT License
