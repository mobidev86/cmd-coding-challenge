

## Installation and Setup

### Prerequisites

Before installing this Laravel application, ensure you have the following installed on your system:

-   **PHP 8.2 or higher** with required extensions (BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML)
-   **Composer** (PHP dependency manager)
-   **Node.js** (version 18 or higher) and **npm**
-   **SQLite** (default database) or **MySQL/PostgreSQL** (optional)

### Quick Setup

The easiest way to get started is using the automated setup script:

```bash
# Clone the repository
git clone <repository-url>
cd <project-directory>

# Run the automated setup
composer setup
```

This will automatically:

-   Install PHP dependencies
-   Copy `.env.example` to `.env`
-   Generate application key
-   Run database migrations
-   Install Node.js dependencies
-   Build frontend assets

### Manual Setup

If you prefer to set up the project manually:

1. **Install PHP dependencies:**

    ```bash
    composer install
    ```

2. **Set up environment configuration:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3. **Configure your environment variables in `.env`:**

    - Update `APP_NAME`, `APP_URL` as needed
    - Configure database settings (SQLite is used by default)
    - Set up mail configuration for email features
    - Configure other services as required

4. **Set up the database:**

    ```bash
    # For SQLite (default)
    touch database/database.sqlite

    # Run migrations
    php artisan migrate
    ```

5. **Install and build frontend assets:**
    ```bash
    npm install
    npm run build
    ```

### Development Environment

For development, you can use the convenient development script that starts all necessary services:

```bash
composer dev
```

This will concurrently run:

-   Laravel development server (`php artisan serve`)
-   Queue worker (`php artisan queue:listen`)
-   Log viewer (`php artisan pail`)
-   Vite development server (`npm run dev`)

Alternatively, you can run services individually:

```bash
# Start the Laravel server
php artisan serve

# In separate terminals:
npm run dev              # Frontend development server
php artisan queue:work   # Queue worker (for background jobs)
```

### Email Configuration

To enable email functionality, update your `.env` file with proper mail settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Testing

Run the test suite:

```bash
composer test
# or
php artisan test
```

### Admin Panel Access

This application includes Filament admin panel. After setup, you can create an admin user:

```bash
php artisan make:filament-user
```

Then access the admin panel at `/admin`.

## Important Note

**Note:** All the features mentioned in the provided document are completed from a code perspective. However, some features need few tweaks including email sending for various events.
