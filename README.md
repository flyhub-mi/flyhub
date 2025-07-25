# FlyHub MarketPlaces Integration

A multi-channel e-commerce integration platform built with Laravel.

> 🇧🇷 **Leia em Português**: [README.pt-BR.md](README.pt-BR.md)
> **📸 Screenshots**: [SCREENS.md](SCREENS.md)

## Features

- Multi-tenant architecture
- Integration with multiple e-commerce platforms:
  - MercadoLivre
  - WooCommerce
  - Magento/Magento2
  - Bling
  - TotalExpress
  - Sisplan
  - Vendure
- Product synchronization
- Order management
- Inventory tracking
- API-first design

## Documentation

- **📸 Screenshots**: [SCREENS.md](SCREENS.md) - Visual overview of the application interface
- **🔒 Security**: [SECURITY.md](SECURITY.md) - Security guidelines and best practices
- **🚀 Deployment**: [DEPLOYMENT.md](DEPLOYMENT.md) - Deployment instructions
- **🇧🇷 Portuguese**: [README.pt-BR.md](README.pt-BR.md) - Portuguese documentation

## Quick Start

Want to get up and running quickly? Here's the minimal setup:

```bash
# 1. Clone and setup
git clone <repository-url>
cd flyhub-app
composer install
yarn install

# 2. Configure environment
cp .env.example .env
# Edit .env with your database credentials

# 3. Setup database and seed demo data
php artisan migrate
php artisan db:seed
php artisan passport:install

# 4. Start the application
php artisan serve
yarn dev

# 5. Login with demo credentials
# Visit: http://localhost:8000/login
# Email: admin@demo.com
# Password: password123
```

## Requirements

- PHP 8.1+
- MySQL 8.0+
- Node.js 14+
- Composer
- Yarn

## Installation

### 1. Clone the repository
```bash
git clone <repository-url>
cd flyhub-app
```

### 2. Install PHP dependencies
```bash
composer install
```

### 3. Install Node.js dependencies
```bash
yarn install
```

### 4. Environment setup
```bash
cp env.example .env
```

Update the `.env` file with your credentials. **Important**: Never commit your `.env` file to version control!

```env
# Required: Generate application key
APP_KEY=                    # Run: php artisan key:generate

# Database Configuration
DB_PASSWORD=your_password

# AWS Configuration (if using S3)
AWS_ACCESS_KEY_ID=your_aws_key
AWS_SECRET_ACCESS_KEY=your_aws_secret

# MercadoLivre Integration (if using)
MELI_CLIENT_ID=your_meli_client_id
MELI_CLIENT_SECRET_KEY=your_meli_secret

# Other services as needed...
```

**⚠️ Security Note**: See [SECURITY.md](SECURITY.md) for detailed security configuration guidelines.

### 5. Generate application key
```bash
php artisan key:generate
```

### 6. Setup database
```bash
# Create database and user (run as MySQL root)
mysql -u root -p < database/setup.sql

# Run migrations
php artisan migrate

# Seed initial data
php artisan db:seed
```

### 7. Install Laravel Passport
```bash
php artisan passport:install
```

### 8. Build frontend assets
```bash
yarn dev
```

## Demo Data

After running the seeders, the following demo data will be available for testing:

### Demo Tenants

The application comes with 3 demo tenants for testing multi-tenant functionality:

#### 1. Demo Store
- **ID**: `demo-store`
- **Domain**: `demo-store.localhost`
- **Company**: Demo E-commerce Store LTDA
- **Location**: São Paulo, SP
- **Contact**: contact@demo-store.com

#### 2. Test Shop
- **ID**: `test-shop`
- **Domain**: `test-shop.localhost`
- **Company**: Test Shop Comércio Eletrônico LTDA
- **Location**: Rio de Janeiro, RJ
- **Contact**: info@test-shop.com

#### 3. Sample Mart
- **ID**: `sample-mart`
- **Domain**: `sample-mart.localhost`
- **Company**: Sample Mart Distribuidora LTDA
- **Location**: Belo Horizonte, MG
- **Contact**: sales@sample-mart.com

### Demo Users

The application includes 4 demo users with different roles:

| User | Email | Role | Password |
|------|-------|------|----------|
| Admin User | admin@demo.com | admin | password123 |
| Manager User | manager@demo.com | manager | password123 |
| Demo User | user@demo.com | user | password123 |
| Support User | support@demo.com | support | password123 |

### Testing with Demo Data

You can use these credentials to test different aspects of the application:

```bash
# Test admin functionality
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "admin@demo.com", "password": "password123"}'

# Test tenant-specific operations
php artisan tenants:run --tenants=demo-store queue:work
php artisan tenants:run --tenants=test-shop sync --argument="type=receive" --argument="resource=products"
```

## Usage

### Start Development Server
```bash
# Start Laravel development server
php artisan serve

# Start frontend watcher (in another terminal)
yarn watch
```

### Authentication & Login

You can log in using any of the demo users:

```bash
# Web interface
# Visit: http://localhost:8000/login
# Use any demo user credentials from the table above

# API authentication
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "admin@demo.com", "password": "password123"}'
```

### Multi-Tenant Operations

The application supports multi-tenant operations. You can work with different tenants:

```bash
# Run queue worker for a specific tenant
php artisan tenants:run queue:work --tenants=demo-store

# Run queue worker for multiple tenants
php artisan tenants:run queue:work --tenants=demo-store,test-shop

# Run queue worker for all tenants
php artisan tenants:run queue:work --all-tenants
```

### Sync Resources

Sync data with external e-commerce platforms:

```bash
# Sync all resources for a tenant
php artisan tenants:run sync --tenants=demo-store

# Sync specific resource type
php artisan tenants:run sync --tenants=demo-store --argument="type=receive" --argument="resource=products"

# Sync categories for multiple tenants
php artisan tenants:run sync --tenants=demo-store,test-shop --argument="type=receive" --argument="resource=categories"

# Sync orders for all tenants
php artisan tenants:run sync --all-tenants --argument="type=receive" --argument="resource=orders"
```

### Channel Integration

Test different e-commerce platform integrations:

```bash
# Test MercadoLivre integration
php artisan tenants:run --tenants=demo-store channel:test --channel=mercadolivre

# Test WooCommerce integration  
php artisan tenants:run --tenants=test-shop channel:test --channel=woocommerce

# Test Magento2 integration
php artisan tenants:run --tenants=sample-mart channel:test --channel=magento2
```

## Testing

### Run Tests
```bash
# Run all tests
php artisan test

# Run tests with coverage
php artisan test --coverage

# Run specific test suite
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature
```

### Testing with Demo Data

The application includes comprehensive demo data for testing:

```bash
# Test multi-tenant functionality
php artisan tenants:run --tenants=demo-store,test-shop,sample-mart test

# Test specific tenant operations
php artisan tenants:run --tenants=demo-store queue:work --once
php artisan tenants:run --tenants=test-shop sync --argument="type=receive" --argument="resource=products"

# Test API endpoints with demo users
curl -X GET http://localhost:8000/api/v1/users \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json"
```

### Database Testing
Make sure you have a separate test database configured in your `.env.testing` file.

### Demo Data for Testing

Use the following demo credentials for testing:

**Users:**
- Admin: `admin@demo.com` / `password123`
- Manager: `manager@demo.com` / `password123`
- User: `user@demo.com` / `password123`
- Support: `support@demo.com` / `password123`

**Tenants:**
- `demo-store`
- `test-shop`
- `sample-mart`

## Deployment

### Production Build
```bash
# Build production assets
yarn prod

# Optimize for production
php artisan optimize
composer install --optimize-autoloader --no-dev
```

### Serverless Deployment
```bash
# Deploy to AWS Lambda
yarn sls-deploy
```

## Configuration

### Channel Configuration
Each e-commerce channel requires specific configuration. See the `config/` directory for available options.

### Attribute Mapping
Customize attribute mappings for different platforms in their respective config files:
- `config/magento2.php` - Magento2 attribute mappings
- Other platform configs as needed

## Troubleshooting

### Database Connection Issues
1. Ensure MySQL service is running
2. Verify database credentials in `.env`
3. Check if database exists: `mysql -u root -p -e "SHOW DATABASES;"`
4. Run database setup script: `mysql -u root -p < database/setup.sql`

### Route Issues
If you encounter controller not found errors:
1. Clear route cache: `php artisan route:clear`
2. Clear config cache: `php artisan config:clear`
3. Regenerate autoload: `composer dump-autoload`

### Windows Port Issues
If you encounter port conflicts on Windows:
```powershell
# View reserved ports
netsh int ip show excludedportrange protocol=tcp

# Reset port reservation (run as administrator)
net stop winnat
net start winnat
```

## API Documentation

API documentation is available at `/api/documentation` when the application is running.

## Security

### Reporting Security Issues

If you discover a security vulnerability within FlyHub, please send an email to the development team. All security vulnerabilities will be promptly addressed.

### Security Configuration

- **Environment Variables**: Never commit `.env` files containing sensitive data
- **API Keys**: Rotate all API keys regularly and use environment variables
- **Database**: Use strong passwords and enable SSL in production
- **File Storage**: Configure proper S3 bucket permissions and encryption

For detailed security guidelines, see [SECURITY.md](SECURITY.md).

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Submit a pull request

### Security Guidelines for Contributors

- Never commit sensitive data or API keys
- Use environment variables for all configuration
- Follow Laravel security best practices
- Test your changes thoroughly

## License

MIT License. [LICENSE](LICENSE)
