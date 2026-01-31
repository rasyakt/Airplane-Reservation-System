# Deployment Guide - Airplane Reservation System

## 🚀 Production Deployment Steps

### 1. Server Preparation

**Minimum Requirements:**

- Ubuntu 20.04+ / CentOS 8+
- PHP 8.2 or higher
- PostgreSQL 13+
- Nginx or Apache
- 512MB RAM minimum (1GB recommended)
- SSL Certificate

**Install Required Software:**

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.2 and extensions
sudo apt install php8.2 php8.2-fpm php8.2-pgsql php8.2-mbstring php8.2-xml php8.2-bcmath php8.2-curl php8.2-zip php8.2-gd -y

# Install PostgreSQL
sudo apt install postgresql postgresql-contrib -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js & NPM
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install nodejs -y

# Install Nginx
sudo apt install nginx -y
```

### 2. Database Setup

```bash
# Switch to postgres user
sudo -u postgres psql

# Create database and user
CREATE DATABASE airplane_production;
CREATE USER airplane_user WITH ENCRYPTED PASSWORD 'your_secure_password_here';
GRANT ALL PRIVILEGES ON DATABASE airplane_production TO airplane_user;
\q
```

### 3. Application Deployment

```bash
# Clone repository to /var/www
cd /var/www
sudo git clone https://github.com/your-repo/airplane.git
cd airplane

# Set permissions
sudo chown -R www-data:www-data /var/www/airplane
sudo chmod -R 755 /var/www/airplane/storage
sudo chmod -R 755 /var/www/airplane/bootstrap/cache

# Install dependencies
composer install --optimize-autoloader --no-dev
npm ci
npm run build

# Configure environment
cp .env.example .env
php artisan key:generate
```

### 4. Environment Configuration

Edit `.env`:

```env
APP_NAME="Airplane Reservation"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=airplane_production
DB_USERNAME=airplane_user
DB_PASSWORD=your_secure_password_here

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Run Migrations & Seeders

```bash
php artisan migrate --force
php artisan db:seed --force

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 6. Nginx Configuration

Create `/etc/nginx/sites-available/airplane`:

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;

    # Redirect to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/airplane/public;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Gzip Compression
    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
}
```

Enable site:

```bash
sudo ln -s /etc/nginx/sites-available/airplane /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 7. SSL Certificate (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal
sudo certbot renew --dry-run
```

### 8. Setup Cron Jobs

```bash
sudo crontab -e -u www-data
```

Add:

```cron
* * * * * cd /var/www/airplane && php artisan schedule:run >> /dev/null 2>&1
```

### 9. Process Manager (Supervisor - Optional for Queues)

```bash
sudo apt install supervisor -y
```

Create `/etc/supervisor/conf.d/airplane-worker.conf`:

```ini
[program:airplane-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/airplane/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/airplane-worker.log
stopwaitsecs=3600
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start airplane-worker:*
```

### 10. Monitoring & Logs

```bash
# View Laravel logs
tail -f /var/www/airplane/storage/logs/laravel.log

# View Nginx error logs
tail -f /var/nginx/error.log

# View Nginx access logs
tail -f /var/log/nginx/access.log
```

---

## 🔒Security Hardening

### 1. Firewall Configuration

```bash
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

### 2. Fail2Ban (Brute Force Protection)

```bash
sudo apt install fail2ban -y
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### 3. Database Security

```postgresql
# Limit connections
ALTER SYSTEM SET max_connections = 100;
SELECT pg_reload_conf();

# Enable SSL
ALTER SYSTEM SET ssl = on;
```

### 4. Regular Backups

```bash
# Database backup script
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
pg_dump -U airplane_user airplane_production > /backups/db_$DATE.sql
find /backups -name "db_*.sql" -mtime +7 -delete

# Add to cron
0 2 * * * /root/backup.sh
```

---

## 📊 Performance Optimization

### 1. OPcache (PHP)

Edit `/etc/php/8.2/fpm/php.ini`:

```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
```

### 2. PostgreSQL Tuning

Edit `/etc/postgresql/13/main/postgresql.conf`:

```ini
shared_buffers = 256MB
effective_cache_size = 1GB
maintenance_work_mem = 64MB
checkpoint_completion_target = 0.9
wal_buffers = 16MB
default_statistics_target = 100
random_page_cost = 1.1
```

### 3. Redis Cache (Optional)

```bash
sudo apt install redis-server -y

# Update .env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

---

## 🎯 Post-Deployment Checklist

- [ ] SSL certificate installed and auto-renewal configured
- [ ] Environment variables configured correctly
- [ ] Database migrations ran successfully
- [ ] Sample data seeded (optional)
- [ ] File permissions set correctly
- [ ] Cron jobs configured
- [ ] Firewall rules applied
- [ ] Backup system configured
- [ ] Monitoring setup
- [ ] Error logging working
- [ ] Email sending tested
- [ ] Admin account created and secured
- [ ] Domain DNS configured
- [ ] HTTPS working
- [ ] Performance tested

---

## 🆘 Troubleshooting

### 500 Internal Server Error

```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Database Connection Errors

```bash
# Test connection
php artisan tinker
>>> DB::connection()->getPdo();

# Check PostgreSQL status
sudo systemctl status postgresql
```

### Composer Issues

```bash
# Update dependencies
composer update --no-dev
composer dump-autoload
```

---

## 📞 Support

For deployment issues:

- Check logs first
- Ensure all requirements are met
- Verify environment configuration
- Contact support: support@yourdomain.com

**Deployment completed successfully!** 🎉
