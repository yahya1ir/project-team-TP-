# Formation Management System

A modern Laravel-based web application for managing formations (training programs) with role-based access control, multi-language support, and a responsive dashboard.

## 🚀 Features

- **Formation Management**: Create, read, update, and delete formations
- **User Authentication**: Secure login and registration system
- **Role-Based Access Control (RBAC)**: Permission-based authorization using Spatie Laravel-Permission
- **Multi-Language Support**: Internationalization (i18n) with English and French
- **Responsive Dashboard**: Modern UI with Vite-powered asset bundling
- **Database Migrations**: Organized schema management with seeders

## 📋 Requirements

- **PHP**: 8.1 or higher
- **Composer**: Latest version
- **Node.js**: 16+ (for Vite asset compilation)
- **npm** or **yarn**: Package manager for frontend dependencies
- **Database**: MySQL, PostgreSQL, SQLite, or SQL Server
- **Laravel**: 11.x

## 🛠️ Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd projet-vite-fait
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
npm install
# or
yarn install
```

### 4. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Then update your `.env` file with:
- Database credentials
- App URL and name
- Mail configuration (if needed)
- Other service credentials

### 5. Database Setup

```bash
php artisan migrate
php artisan db:seed
```

This will:
- Create all necessary tables
- Seed roles and permissions
- Create test users if seeders are configured

### 6. Configure Internationalization

The project includes multilingual support. See [I18N_SETUP_GUIDE.md](I18N_SETUP_GUIDE.md) for detailed i18n configuration.

## 🏃 Running the Application

### Development Mode

**Terminal 1 - Vite Dev Server** (for asset hot-reload):
```bash
npm run dev
```

**Terminal 2 - Laravel Server**:
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

### Production Build

```bash
npm run build
php artisan migrate --force
```

## 📁 Project Structure

```
├── app/                          # Application logic
│   ├── Console/                  # Artisan commands
│   ├── Exceptions/               # Exception handling
│   ├── Http/
│   │   ├── Controllers/          # Request handlers
│   │   ├── Kernel.php            # Middleware configuration
│   │   └── Middleware/           # HTTP middleware
│   ├── Models/                   # Eloquent models (Formation, User)
│   └── Providers/                # Service providers
├── config/                       # Configuration files
│   ├── app.php                   # Application config
│   ├── auth.php                  # Authentication config
│   ├── permission.php            # Permission/RBAC config
│   └── ...
├── database/
│   ├── factories/                # Model factories for testing
│   ├── migrations/               # Database schema migrations
│   └── seeders/                  # Database seeders
├── lang/                         # Internationalization files
│   ├── en/messages.php           # English translations
│   └── fr/messages.php           # French translations
├── public/                       # Public assets (served directly)
│   ├── Css/                      # Custom stylesheets
│   └── JS/                       # Custom JavaScript
├── resources/
│   ├── css/                      # Vite-processed styles
│   ├── js/                       # Vite-processed scripts
│   └── views/                    # Blade templates
├── routes/
│   ├── api.php                   # API routes
│   ├── web.php                   # Web routes
│   ├── channels.php              # Broadcasting channels
│   └── console.php               # Console commands
├── storage/                      # User uploads, logs, cache
├── tests/                        # PHPUnit test suite
├── vite.config.js                # Vite configuration
├── composer.json                 # PHP dependencies
├── package.json                  # Node dependencies
└── phpunit.xml                   # PHPUnit configuration
```

## 🔐 Authentication & Authorization

- **Default Authentication**: Uses Laravel's built-in authentication
- **Permission System**: Powered by [Spatie Laravel-Permission](https://spatie.be/docs/laravel-permission/v6/introduction)
- **API Authentication**: Sanctum for token-based API access

## 🌍 Internationalization (i18n)

- Supported languages: English (en), French (fr)
- Language files located in `lang/` directory
- Refer to [I18N_SETUP_GUIDE.md](I18N_SETUP_GUIDE.md) for switching languages and adding new locales

## 🧪 Testing

Run tests with PHPUnit:

```bash
php artisan test
```

For specific test suite:
```bash
php artisan test --filter=FormationTest
```

## 🚀 Deployment

1. Install production dependencies:
   ```bash
   composer install --optimize-autoloader --no-dev
   npm run build
   ```

2. Configure environment variables in `.env`

3. Run migrations:
   ```bash
   php artisan migrate --force
   ```

4. Set up a web server (Nginx/Apache) pointing to the `public/` directory

5. Enable HTTPS and configure CORS as needed


## 🤝 Contributing

1. Create a new branch for your feature: `git checkout -b feature/your-feature`
2. Commit your changes: `git commit -am 'Add new feature'`
3. Push to the branch: `git push origin feature/your-feature`
4. Submit a pull request


**Happy coding!  🎉**  --by irfane yahya
