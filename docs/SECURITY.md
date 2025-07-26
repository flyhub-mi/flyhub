# Security Configuration

This document outlines the security considerations and configuration requirements for the FlyHub application.

## Environment Variables

The following environment variables contain sensitive information and should be properly configured:

### Required Environment Variables

```bash
# Application
APP_KEY=                    # Laravel application key (generate with: php artisan key:generate)

# Database
DB_PASSWORD=                # Database password

# Laravel Passport
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=  # OAuth client secret

# AWS Services
AWS_ACCESS_KEY_ID=          # AWS access key
AWS_SECRET_ACCESS_KEY=      # AWS secret key
AWS_BUCKET=                 # S3 bucket name
AWS_CDN_BUCKET=             # CDN bucket name

# MercadoLivre Integration
MELI_CLIENT_ID=             # MercadoLivre application ID
MELI_CLIENT_SECRET_KEY=     # MercadoLivre application secret

# Error Tracking
BUGSNAG_API_KEY=            # Bugsnag API key for error tracking

# Payment Processing
STRIPE_KEY=                 # Stripe publishable key
STRIPE_SECRET=              # Stripe secret key

# Email Configuration
MAIL_USERNAME=              # SMTP username
MAIL_PASSWORD=              # SMTP password
MAIL_FROM_ADDRESS=          # From email address
```

## Security Best Practices

### 1. Environment Configuration
- Never commit `.env` files to version control
- Use different environment files for different environments (`.env.local`, `.env.production`, etc.)
- Use strong, unique passwords for all services
- Rotate API keys regularly

### 2. Database Security
- Use strong database passwords
- Limit database access to application servers only
- Enable SSL/TLS for database connections in production
- Regularly backup your database

### 3. API Security
- Use HTTPS in production
- Implement rate limiting
- Validate all input data
- Use Laravel's built-in CSRF protection

### 4. File Storage
- Configure proper S3 bucket permissions
- Use IAM roles instead of access keys when possible
- Enable S3 bucket encryption
- Set up proper CORS policies

### 5. Application Security
- Keep Laravel and all dependencies updated
- Use strong session configuration
- Implement proper authentication and authorization
- Enable security headers

## Production Deployment

### Environment Setup
1. Copy `env.example` to `.env`
2. Generate application key: `php artisan key:generate`
3. Configure all required environment variables
4. Set `APP_ENV=production` and `APP_DEBUG=false`

### Database Setup
1. Create production database
2. Run migrations: `php artisan migrate`
3. Install Passport: `php artisan passport:install`
4. Seed demo data (if needed): `php artisan db:seed`

### File Permissions
```bash
# Set proper file permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### SSL/TLS Configuration
- Configure SSL certificates
- Redirect HTTP to HTTPS
- Set secure cookies
- Enable HSTS headers

## Monitoring and Logging

### Error Tracking
- Configure Bugsnag or similar error tracking service
- Set up proper logging levels
- Monitor application logs regularly

### Security Monitoring
- Monitor failed login attempts
- Track API usage and rate limits
- Set up alerts for suspicious activity
- Regular security audits

## Compliance

### Data Protection
- Implement proper data encryption
- Follow GDPR requirements if applicable
- Regular data backups
- Data retention policies

### PCI Compliance (if handling payments)
- Use PCI-compliant payment processors
- Don't store credit card data
- Implement proper payment security measures

## Emergency Procedures

### Security Breach Response
1. Immediately rotate all API keys and passwords
2. Review and analyze logs for suspicious activity
3. Update security configurations
4. Notify affected users if necessary
5. Document the incident and response

### Backup and Recovery
1. Regular automated backups
2. Test backup restoration procedures
3. Document recovery procedures
4. Maintain disaster recovery plan

## Contact

For security-related issues, please contact the development team or create a private issue in the repository. 
