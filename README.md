# 🎂 Cakes & Pastries — Laravel E-Commerce

A complete, production-ready e-commerce platform for **Cakes and Pastries** — built with Laravel 10, Filament 3 admin, Paystack payments, and Tailwind CSS.

---

## 🗂 Project Structure

```
cakes-pastries/
├── app/
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── ProductResource.php       ← Admin: manage products
│   │   │   ├── CategoryResource.php      ← Admin: manage categories
│   │   │   └── OrderResource.php         ← Admin: view & update orders
│   │   └── Widgets/
│   │       └── StatsOverview.php         ← Dashboard revenue/order stats
│   ├── Http/Controllers/
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php        ← Paystack integration here
│   │   └── Api/
│   │       ├── ProductController.php
│   │       └── OrderController.php
│   ├── Mail/
│   │   └── OrderConfirmation.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Category.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── Filament/AdminPanelProvider.php
├── database/
│   ├── migrations/                        ← 4 migrations
│   └── seeders/DatabaseSeeder.php         ← Sample products + admin user
├── resources/views/
│   ├── layouts/app.blade.php              ← Main layout
│   ├── home.blade.php
│   ├── products/
│   │   ├── index.blade.php               ← Search, filter, paginate
│   │   ├── show.blade.php
│   │   ├── _card.blade.php
│   │   └── _grid.blade.php               ← AJAX partial
│   ├── cart/index.blade.php
│   ├── checkout/
│   │   ├── index.blade.php
│   │   └── success.blade.php
│   └── emails/order-confirmation.blade.php
├── routes/
│   ├── web.php
│   └── api.php
└── config/paystack.php
```

---

## ⚡ Quick Setup

### 1. Install dependencies

```bash
composer install
npm install && npm run build   # if you add Vite/custom JS
```

### 2. Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
DB_DATABASE=cakes_pastries
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

PAYSTACK_PUBLIC_KEY=pk_live_xxxxxxxx
PAYSTACK_SECRET_KEY=sk_live_xxxxxxxx

MAIL_MAILER=smtp
MAIL_HOST=smtp.yourprovider.com
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=yourpassword
MAIL_FROM_ADDRESS=orders@cakesandpastries.com
```

### 3. Database & seed

```bash
php artisan migrate --force
php artisan db:seed
```

This creates:
- 3 categories: Cakes, Small Chops, Non-Alcoholic Drinks
- 9 sample products
- Admin user: `admin@cakesandpastries.com` / `password`

### 4. Storage link

```bash
php artisan storage:link
```

### 5. Run locally

```bash
php artisan serve
```

Visit:
- **Frontend** → http://localhost:8000
- **Admin** → http://localhost:8000/admin

---

## 💳 Paystack Setup

1. Create account at https://dashboard.paystack.com
2. Go to Settings → API Keys & Webhooks
3. Copy your **Public Key** and **Secret Key**
4. Paste them in `.env`

> **Test mode**: Use `pk_test_` / `sk_test_` keys during development.
> Test card: `4084 0840 8408 4081`, any future expiry, CVV `408`

---

## 🔐 Admin Dashboard

URL: `/admin`

Default login (change after first login!):
```
Email:    admin@cakesandpastries.com
Password: password
```

Admin can:
- ✅ Add / edit / delete products with image upload
- ✅ Manage categories
- ✅ View all orders with full details
- ✅ Update order status (Pending → Processing → Delivered)
- ✅ See revenue stats on dashboard

---

## 🌐 REST API

Base URL: `/api/v1`

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/v1/products` | List all available products |
| GET | `/api/v1/products/{id}` | Get single product |
| GET | `/api/v1/categories` | List categories |
| POST | `/api/v1/orders` | Place an order |
| GET | `/api/v1/orders/{id}` | Get order details |

### POST /api/v1/orders — Request body:
```json
{
  "customer_name": "Amaka Johnson",
  "phone": "08012345678",
  "email": "amaka@email.com",
  "address": "12 Baker Street, Lagos",
  "items": [
    { "product_id": 1, "quantity": 2 },
    { "product_id": 4, "quantity": 1 }
  ]
}
```

---

## 🚀 Production Deployment

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan storage:link
```

Set in `.env`:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

---

## 🔧 Optional Enhancements

- **Discount codes** → Add `coupons` table + apply in CheckoutController
- **Order tracking page** → Add `/orders/{id}/track` route
- **WhatsApp notifications** → Use Twilio or Africa's Talking API
- **Product image gallery** → Add `product_images` table
- **Inventory/stock count** → Add `stock_qty` column to products

---

## 📦 Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 10 |
| Admin Panel | Filament 3 |
| Frontend | Blade + Tailwind CSS (CDN) |
| Database | MySQL |
| Payments | Paystack |
| Email | Laravel Mail (SMTP) |
| API Auth | Laravel Sanctum (ready) |
| File Storage | Laravel Storage / S3-compatible |
