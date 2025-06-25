# Marketplace Project

A modern e-commerce marketplace platform built with Laravel, where users can browse, sell, and purchase digital products across various categories.

## Features

- **User Authentication & Authorization**
  - Secure login and registration system
  - Role-based access control (Admin and User roles)
  - User profile management

- **Product Management**
  - Create, edit, and delete products
  - Product categorization
  - Product search and filtering
  - Image upload functionality

- **Shopping Experience**
  - Shopping cart functionality
  - Secure checkout process
  - Order management
  - Order history

- **Admin Dashboard**
  - Product management
  - Category management
  - User management
  - Order tracking
  - Sales analytics

## Tech Stack

- **Backend**: Laravel 10
- **Frontend**: Blade Templates, TailwindCSS
- **Database**: MySQL
- **Build Tool**: Vite

## Requirements

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/maulana-tech/marketplace-project.git
   cd marketplace-project
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node.js dependencies:
   ```bash
   npm install
   ```

4. Setup environment file:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure your database in `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=marketplace
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Run database migrations and seeders:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. Build assets:
   ```bash
   npm run build
   ```

8. Start the development server:
   ```bash
   php artisan serve
   ```

The application will be available at `http://localhost:8000`

## Directory Structure

- `app/` - Contains the core code of your application
- `database/` - Contains database migrations and seeders
- `public/` - Contains publicly accessible files
- `resources/` - Contains views, raw assets, and translations
- `routes/` - Contains all route definitions
- `tests/` - Contains automated tests

## Testing

Run the automated tests using:
```bash
php artisan test
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
