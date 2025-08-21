# Laravel Authentication

A Laravel 10+ project focused on authentication with email verification, password reset, and queued notifications. This serves as a foundation for future modules like product management.

---

## Features

* Auth (email/password)
* Signup & Login
* Password reset & email verification (queued)
* CSRF protection & validation

---

## Setup

1. **Clone repo & install dependencies**

```bash
git clone <repo-url>
cd <repo-folder>
composer install
npm install
npm run dev
```

2. **Environment**

```bash
cp .env.example .env
php artisan key:generate
```

* Set your DB credentials in `.env`
* Set `APP_URL=http://127.0.0.1:8000` for local dev
* Optional: toggle email verification

```env
EMAIL_VERIFICATION=true
```

3. **Migrate & Seed**

```bash
php artisan migrate --seed
```

4. **Queue setup** (for email verification & password reset)

```bash
php artisan queue:table
php artisan migrate
php artisan queue:work
```

> Local dev: you can use `QUEUE_CONNECTION=sync` in `.env` to skip queue.

5. **Serve app**

```bash
php artisan serve
```

---

## Notes

* Authentication system with email/password, signup, login, and password reset.
* Email sending uses queued notifications for performance.
* Verification emails are optional (toggle `EMAIL_VERIFICATION` in `.env`).
* CSRF protection and input validation included.
* Modular design for future extension (e.g., product module).
* Follows SOLID principles and separates concerns with services and FormRequests.
* Easy to extend and maintain; ready for production-level improvements.

---

## Next Steps / Improvements

* Add lazy loading and caching where needed.
* Add unit & feature tests.
* Add logging & error monitoring tools.
