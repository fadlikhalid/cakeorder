<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Cake Order Management System

A Laravel-based web application for managing cake orders, designed for bakeries and cake shops to track orders and handle customer information efficiently.

## Features

### Order Management
- **Create Orders**
  - Customer information capture
  - Cake type and size selection
  - Delivery/pickup date and time scheduling
  - Special instructions handling
  - Price management

- **Order Tracking**
  - Status management (Preparing → Prepared → Delivered)
  - Order filtering by date range and status
  - Sortable order list
  - Printable order details

- **Dashboard Views**
  - Today's orders summary
  - Tomorrow's orders preview
  - Status-based organization (Preparing/Prepared/Delivered)
  - Monthly order statistics

### Business Settings
- Configurable business hours
- Closed days management (e.g., Mondays)
- Business contact information
- Address details

## Technical Stack

### Backend
- Laravel 10.x
- PHP 8.x
- MySQL Database

### Frontend
- Bootstrap 4.5.2
- Font Awesome 5.15.4
- jQuery 3.5.1
- Custom CSS

## Installation

1. Clone the repository
\`\`\`
git clone [repository-url]
\`\`\`

2. Install dependencies
\`\`\`
composer install
\`\`\`

3. Configure environment
\`\`\`
cp .env.example .env
php artisan key:generate
\`\`\`

4. Update \`.env\` with your database credentials and business settings
\`\`\`
DB_DATABASE=laravel_order
DB_USERNAME=your_username
DB_PASSWORD=your_password

APP_TIMEZONE=Asia/Kuala_Lumpur
\`\`\`

5. Run migrations
\`\`\`
php artisan migrate
\`\`\`

## Known Limitations

1. **Mobile Responsiveness**
   - Table scrolling issues on mobile devices
   - Limited touch interaction optimization
   - Layout constraints on smaller screens

2. **Authentication**
   - No user authentication system
   - No role-based access control

3. **Business Logic**
   - Limited validation for business hours
   - Basic order status workflow

## Future Improvements

1. **High Priority**
   - Implement mobile-responsive tables
   - Add user authentication
   - Enhance form validation

2. **Features to Add**
   - Calendar view for orders
   - Email notifications
   - Customer database
   - Order statistics and reporting
   - Multi-user support with roles

## Environment Requirements

- PHP >= 8.1
- MySQL >= 5.7
- Composer
- Node.js & NPM (for asset compilation)

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
