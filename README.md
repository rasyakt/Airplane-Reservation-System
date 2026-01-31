# Airplane Reservation System

Production-ready airplane booking system built with Laravel 12, PostgreSQL, and Tailwind CSS.

## 🚀 Features

### Public Booking Interface

- ✈️ **Flight Search** - Search flights by origin, destination, and date
- 💺 **Seat Selection** - Interactive seat selection with travel class grouping
- 👤 **Client Registration** - Secure passenger information collection
- ✅ **Booking Confirmation** - Detailed confirmation with unique codes
- 🔒 **Anti-Double Booking** - Database-level constraints + pessimistic locking

### Admin Panel

- 🛫 **Airport Management** - CRUD operations with IATA code validation
- ✈️ **Aircraft Management** - Manage aircraft models and manufacturers
- 📅 **Schedule Management** - Define flight routes and times
- 🎫 **Flight Management** - Monitor and update flight statuses
- 🔐 **Authentication** - Laravel Breeze with secure login

## 📋 Requirements

- PHP 8.2+
- PostgreSQL 13+
- Composer
- Node.js & NPM

## 🛠️ Installation

```bash
# Clone repository
git clone <your-repo-url>
cd Airplane

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Configure database in .env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=airplane
DB_USERNAME=root
DB_PASSWORD=

# Create database (via pgAdmin or command line)
# Then run migrations
php artisan migrate:fresh --seed

# Build assets
npm run build

# Start server
php artisan serve
```

## 🎯 Default Login

**Admin Account:**

- Email: `admin@airplane.com`
- Password: Set during first login

## 📊 Database Schema

### Core Tables

- **countries** - IATA country codes
- **airports** - Airport information with IATA codes
- **aircraft_manufacturers** - Boeing, Airbus, etc.
- **aircraft** - Aircraft models
- **travel_classes** - Economy, Business, First Class
- **flight_statuses** - Scheduled, Delayed, Cancelled, etc.

### Operational Tables

- **schedules** - Flight routes and times
- **flights** - Specific flight instances
- **aircraft_instances** - Individual aircraft units
- **aircraft_seats** - Seat configurations

### Booking Tables

- **clients** - Passenger information
- **flight_seat_prices** - Dynamic pricing per flight
- **bookings** - Confirmed reservations

## 🔐 Security Features

- ✅ CSRF Protection
- ✅ SQL Injection Prevention (Eloquent ORM)
- ✅ XSS Protection (Blade templating)
- ✅ Password Hashing (Bcrypt)
- ✅ Email Validation
- ✅ Unique Constraints
- ✅ Database Transactions

## 🎨 UI/UX Features

- 🌙 Dark Mode Theme
- 📱 Fully Responsive Design
- 🎭 Professional Gradient Buttons
- ⚡ Real-time Form Validation
- 💬 Flash Messages
- 🔄 Loading States
- 📄 Pagination

## 📝 API Endpoints

### Public Routes

```
GET  /                          - Homepage with search
GET  /flights/search            - Search results
GET  /flights/{flight}          - Flight details & seat selection
POST /clients                   - Register client
POST /bookings/confirm          - Confirm booking
GET  /bookings/confirmation/{code} - Confirmation page
```

### Admin Routes (Auth Required)

```
GET  /admin/airports            - List airports
GET  /admin/aircraft            - List aircraft
GET  /admin/schedules           - List schedules
GET  /admin/flights             - List flights
```

## 🚀 Deployment

### Production Checklist

1. **Environment Configuration**

```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

2. **Optimize Performance**

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

3. **Database**

```bash
php artisan migrate --force
php artisan db:seed --force
```

4. **Security**

- Set strong `APP_KEY`
- Configure HTTPS
- Set up database backups
- Enable rate limiting
- Configure CORS if needed

5. **Server Requirements**

- PHP-FPM with Nginx/Apache
- PostgreSQL server
- SSL certificate
- Min 512MB RAM

### Recommended Hosting

- **VPS**: DigitalOcean, Linode, AWS EC2
- **Shared**: Laravel Forge, Ploi
- **Platform**: Laravel Cloud, Heroku

## 📈 Performance

- Database indexing on foreign keys
- Eager loading relationships
- Query optimization
- Asset minification
- Gzip compression

## 🧪 Testing

```bash
# Run tests
php artisan test

# Code quality
./vendor/bin/phpstan analyse

# Code style
./vendor/bin/pint
```

## 📦 Tech Stack

- **Backend**: Laravel 12
- **Database**: PostgreSQL
- **Frontend**: Blade + Tailwind CSS
- **Build**: Vite
- **Authentication**: Laravel Breeze
- **ORM**: Eloquent

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

This project is open-source software licensed under the MIT license.

## 👨‍💻 Support

For issues and questions:

- Create an issue on GitHub
- Contact: your-email@example.com

## 🎉 Acknowledgments

- Laravel Framework
- Tailwind CSS
- PostgreSQL Community

---

**Built with ❤️ for the aviation industry**
