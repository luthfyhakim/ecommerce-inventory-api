# E-Commerce Inventory API

Laravel RESTful API for e-commerce inventory management with JWT authentication.

## Features

-   JWT Authentication
-   Product Management (CRUD)
-   Category Management
-   Stock Management
-   Inventory Value Calculation
-   Product Search & Filtering
-   Repository Pattern Implementation
-   Request Validation
-   Error Handling

## Installation

1. Clone the repository

```bash
git clone https://github.com/luthfyhakim/ecommerce-inventory-api.git
cd ecommerce-inventory-api
```

2. Install dependencies

```bash
composer install && composer require tymon/jwt-auth
```

3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

4. JWT Setup

```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

5. Database setup

```bash
php artisan migrate
php artisan db:seed
```

6. Start the server

```bash
php artisan serve
```

## API Endpoints

### Authentication

-   POST `/api/v1/register` - Register new user
-   POST `/api/v1/login` - Login user
-   POST `/api/v1/logout` - Logout user
-   GET `/api/v1/me` - Get current user

### Products

-   GET `/api/v1/products` - Get all products
-   GET `/api/v1/products/{id}` - Get product by ID
-   POST `/api/v1/products` - Create new product
-   PUT `/api/v1/products/{id}` - Update product
-   DELETE `/api/v1/products/{id}` - Delete product
-   GET `/api/v1/products/search` - Search products
-   POST `/api/v1/products/update-stock` - Update product stock

### Categories

-   GET `/api/v1/categories` - Get all categories
-   GET `/api/v1/categories/{id}` - Get category by ID
-   POST `/api/v1/categories` - Create new category
-   PUT `/api/v1/categories/{id}` - Update category
-   DELETE `/api/v1/categories/{id}` - Delete category

### Inventory

-   GET `/api/v1/inventory/value` - Get total inventory value

## Usage Examples

### Register User

```bash
curl -X POST http://localhost:8000/api/v1/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Admin User",
    "email": "admin@example.com",
    "password": "password123"
  }'
```

### Login

```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password123"
  }'
```

### Create Category

```bash
curl -X POST http://localhost:8000/api/v1/categories \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN" \
  -d '{
    "name": "Electronics"
  }'
```

### Create Product

```bash
curl -X POST http://localhost:8000/api/v1/products \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN" \
  -d '{
    "name": "Laptop Dell",
    "price": 12000000.00,
    "stock_quantity": 15,
    "category_id": 1
  }'
```

### Search Products

```bash
curl -X GET "http://localhost:8000/api/v1/products/search?name=laptop&category_id=1" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN"
```

### Update Stock

```bash
curl -X POST http://localhost:8000/api/v1/products/update-stock \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN" \
  -d '{
    "product_id": 1,
    "quantity": 20
  }'
```

### Get Inventory Value

```bash
curl -X GET http://localhost:8000/api/v1/inventory/value \
  -H "Authorization: Bearer YOUR_JWT_TOKEN"
```

## API Response Format

### Success Response

```json
{
    "success": true,
    "message": "Operation successful",
    "data": {
        // response data
    }
}
```

### Error Response

```json
{
    "success": false,
    "message": "Error message",
    "error": "Detailed error information"
}
```

## Validation Rules

### Product Validation

-   `name`: required, string, max 255 characters
-   `price`: required, numeric, minimum 0
-   `stock_quantity`: required, integer, minimum 0
-   `category_id`: required, must exist in categories table

### Category Validation

-   `name`: required, string, max 255 characters, unique

## Project Architecture

This project follows the Repository Pattern architecture:

-   **Controllers**: Handle HTTP requests responses and business logic
-   **Repositories**: Handle data access layer
-   **Models**: Represent database entities
-   **Requests**: Handle input validation
-   **Middleware**: Handle authentication and authorization

## Security Features

-   JWT Authentication
-   Input validation
-   SQL injection prevention (Eloquent ORM)
-   Password hashing
-   Token-based authentication

## License

This project is licensed under the MIT License.
