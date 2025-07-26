# Deployment Checklist

This checklist ensures a secure and proper deployment of the FlyHub application.

## Pre-Deployment Checklist

### ✅ Environment Configuration
- [ ] Copy `env.example` to `.env`
- [ ] Generate application key: `php artisan key:generate`
- [ ] Configure all required environment variables
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Verify no sensitive data is committed to version control

### ✅ Database Setup
- [ ] Create production database
- [ ] Configure database credentials in `.env`
- [ ] Test database connection
- [ ] Run migrations: `php artisan migrate`
- [ ] Install Laravel Passport: `php artisan passport:install`
- [ ] Seed demo data (if needed): `php artisan db:seed`

### ✅ File Permissions
- [ ] Set proper file permissions:
  ```bash
  chmod -R 755 storage bootstrap/cache
  chown -R www-data:www-data storage bootstrap/cache
  ```
- [ ] Ensure storage directory is writable
- [ ] Verify log files are writable

### ✅ SSL/TLS Configuration
- [ ] Install SSL certificate
- [ ] Configure HTTPS redirect
- [ ] Set secure cookies
- [ ] Enable HSTS headers
- [ ] Test SSL configuration

### ✅ External Services
- [ ] Configure AWS S3 (if using file storage)
- [ ] Set up MercadoLivre integration (if needed)
- [ ] Configure email service
- [ ] Set up error tracking (Bugsnag, etc.)
- [ ] Configure payment processing (Stripe, etc.)

## Production Deployment Steps

### 1. Server Preparation
```bash
# Update system packages
sudo apt update && sudo apt upgrade -y

# Install required software
sudo apt install nginx mysql-server php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd php8.1-redis -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js and Yarn
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
sudo npm install -g yarn
```

### 2. Application Deployment
```bash
# Clone repository
git clone <repository-url> /var/www/flyhub
cd /var/www/flyhub

# Install dependencies
composer install --optimize-autoloader --no-dev
yarn install
yarn prod

# Set up environment
cp env.example .env
# Edit .env with production values

# Generate application key
php artisan key:generate

# Set up database
php artisan migrate
php artisan passport:install

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Web Server Configuration

#### Nginx Configuration
```nginx
server {
    listen 80;
    server_name your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com;
    
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    
    root /var/www/flyhub/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 4. Queue Worker Setup
```bash
# Create systemd service for queue workers
sudo nano /etc/systemd/system/flyhub-queue.service

[Unit]
Description=FlyHub Queue Worker
After=network.target

[Service]
Type=simple
User=www-data
Group=www-data
WorkingDirectory=/var/www/flyhub
ExecStart=/usr/bin/php artisan queue:work --sleep=3 --tries=3 --max-time=3600
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target

# Enable and start the service
sudo systemctl enable flyhub-queue
sudo systemctl start flyhub-queue
```

### 5. Monitoring Setup
```bash
# Set up log monitoring
sudo nano /etc/logrotate.d/flyhub

/var/www/flyhub/storage/logs/*.log {
    daily
    missingok
    rotate 52
    compress
    notifempty
    create 644 www-data www-data
}
```

## Post-Deployment Verification

### ✅ Application Health Checks
- [ ] Verify application loads without errors
- [ ] Test user registration and login
- [ ] Verify API endpoints are working
- [ ] Test file uploads (if applicable)
- [ ] Verify email sending functionality
- [ ] Test payment processing (if applicable)

### ✅ Security Verification
- [ ] Confirm HTTPS is working
- [ ] Test CSRF protection
- [ ] Verify input validation
- [ ] Check for exposed sensitive data
- [ ] Test rate limiting
- [ ] Verify proper error handling

### ✅ Performance Verification
- [ ] Monitor application response times
- [ ] Check database query performance
- [ ] Verify caching is working
- [ ] Monitor queue worker performance
- [ ] Test under load

### ✅ Backup Setup
- [ ] Configure automated database backups
- [ ] Set up file storage backups
- [ ] Test backup restoration
- [ ] Document backup procedures

## Maintenance Tasks

### Regular Maintenance
- [ ] Update Laravel and dependencies monthly
- [ ] Rotate API keys quarterly
- [ ] Review and update SSL certificates
- [ ] Monitor and clean up logs
- [ ] Review security configurations

### Monitoring
- [ ] Set up application monitoring
- [ ] Configure error alerting
- [ ] Monitor server resources
- [ ] Track application metrics
- [ ] Set up uptime monitoring

## Emergency Procedures

### Application Issues
1. Check application logs: `tail -f storage/logs/laravel.log`
2. Verify queue workers are running: `sudo systemctl status flyhub-queue`
3. Check database connectivity
4. Verify file permissions
5. Restart services if needed

### Security Incidents
1. Immediately rotate all API keys and passwords
2. Review logs for suspicious activity
3. Update security configurations
4. Notify affected users if necessary
5. Document the incident and response

## Support

For deployment assistance, contact the development team or create an issue in the repository. 