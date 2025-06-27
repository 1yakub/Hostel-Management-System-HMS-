# Laravel Hostel Management System - Implementation Guide

## 1. Project Setup and Configuration

### 1.1 Initial Setup

```bash
# Create new Laravel project
composer create-project laravel/laravel hostel-management

# Install required packages
composer require laravel/breeze
php artisan breeze:install
npm install && npm run dev
```

### 1.2 Environment Configuration

-   Configure `.env` file with database settings
-   Set up mail configuration for notifications
-   Configure session and cache settings

## 2. Database Architecture

### 2.1 Database Migrations

```bash
php artisan make:migration create_rooms_table
php artisan make:migration create_guests_table
php artisan make:migration create_bookings_table
php artisan make:migration create_payments_table
php artisan make:migration create_services_table
```

### 2.2 Migration Definitions

#### create_rooms_table.php

```php
public function up()
{
    Schema::create('rooms', function (Blueprint $table) {
        $table->id();
        $table->string('room_number', 10)->unique();
        $table->integer('capacity');
        $table->decimal('price_per_night', 10, 2);
        $table->enum('status', ['available', 'occupied', 'maintenance']);
        $table->text('description')->nullable();
        $table->json('amenities')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}
```

#### create_guests_table.php

```php
public function up()
{
    Schema::create('guests', function (Blueprint $table) {
        $table->id();
        $table->string('name', 100);
        $table->string('email')->unique();
        $table->string('phone', 20);
        $table->string('id_number', 50);
        $table->text('address')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->string('emergency_contact')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}
```

#### create_bookings_table.php

```php
public function up()
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('guest_id')->constrained()->onDelete('cascade');
        $table->foreignId('room_id')->constrained()->onDelete('cascade');
        $table->datetime('check_in_date');
        $table->datetime('check_out_date');
        $table->enum('status', ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled']);
        $table->decimal('total_amount', 10, 2);
        $table->text('special_requests')->nullable();
        $table->integer('number_of_guests');
        $table->timestamps();
        $table->softDeletes();
    });
}
```

## 3. Models and Relationships

### 3.1 Base Models

```bash
php artisan make:model Room
php artisan make:model Guest
php artisan make:model Booking
php artisan make:model Payment
php artisan make:model Service
```

### 3.2 Model Implementations

#### Room.php

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'room_number',
        'capacity',
        'price_per_night',
        'status',
        'description',
        'amenities'
    ];

    protected $casts = [
        'amenities' => 'array'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable($checkIn, $checkOut)
    {
        return !$this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out_date', [$checkIn, $checkOut]);
            })->exists();
    }
}
```

#### Guest.php

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'id_number'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
```

#### Booking.php

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'guest_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'status',
        'total_amount'
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
```

## 4. Controllers and Business Logic

### 4.1 Resource Controllers

```bash
php artisan make:controller RoomController --resource
php artisan make:controller GuestController --resource
php artisan make:controller BookingController --resource
```

### 4.2 Service Classes

```php
namespace App\Services;

class BookingService
{
    public function calculateTotalAmount($room, $checkIn, $checkOut)
    {
        $nights = $checkIn->diffInDays($checkOut);
        return $room->price_per_night * $nights;
    }

    public function processBooking($data)
    {
        // Booking processing logic
    }
}
```

## 5. API Implementation

### 5.1 API Controllers

```bash
php artisan make:controller Api/RoomController --api
php artisan make:controller Api/BookingController --api
```

### 5.2 API Routes

```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('rooms', RoomController::class);
    Route::apiResource('bookings', BookingController::class);
});
```

## 6. Frontend Implementation

### 6.1 Views Structure

```
resources/views/
├── layouts/
│   └── app.blade.php
├── rooms/
│   ├── index.blade.php
│   ├── show.blade.php
│   └── form.blade.php
├── bookings/
│   ├── index.blade.php
│   └── create.blade.php
└── components/
    ├── room-card.blade.php
    └── booking-form.blade.php
```

### 6.2 Livewire Components

```bash
php artisan make:livewire RoomAvailability
php artisan make:livewire BookingCalendar
```

## 7. Testing

### 7.1 Feature Tests

```bash
php artisan make:test RoomBookingTest
php artisan make:test GuestRegistrationTest
```

### 7.2 Unit Tests

```bash
php artisan make:test BookingServiceTest --unit
```

## 8. Deployment

### 8.1 Production Setup

```bash
# Optimize application
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force
```

### 8.2 Server Requirements

-   PHP >= 8.1
-   MySQL >= 5.7
-   Composer
-   Node.js >= 14
-   SSL Certificate

## 9. Additional Features

### 9.1 Notifications

```php
php artisan make:notification BookingConfirmation
php artisan make:notification CheckInReminder
```

### 9.2 Reports Generation

```php
php artisan make:command GenerateOccupancyReport
php artisan make:command GenerateRevenueReport
```

## 10. Security Measures

-   CSRF protection
-   XSS prevention
-   SQL injection protection
-   Rate limiting
-   Input validation
-   Authentication & Authorization

## 11. Maintenance

### 11.1 Regular Tasks

```bash
# Database backup
php artisan backup:run

# Clean old records
php artisan housekeeping:clean-old-records

# Monitor system health
php artisan health:check
```

### 11.2 Performance Optimization

-   Database indexing
-   Query optimization
-   Cache implementation
-   Asset optimization
