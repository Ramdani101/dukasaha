# Dukasaha (dukasaha)

A lightweight anonymous messaging / confession platform built with Laravel.
Guests can send anonymous confessions to a user (by username) and continue conversations via a guest token; recipients (users) can reply and manage messages from a dashboard.

---

## Table of contents

-   [Features](#features)
-   [Requirements](#requirements)
-   [Quick start](#quick-start)
-   [Environment & Configuration](#environment--configuration)
-   [Database & Migrations](#database--migrations)
-   [Running the app](#running-the-app)
-   [Testing](#testing)
-   [Routes & Controllers (overview)](#routes--controllers-overview)
-   [Key flows & implementation notes](#key-flows--implementation-notes)
-   [Factories & Tests](#factories--tests)
-   [Contributing](#contributing)
-   [License](#license)

---

## Features ✅

-   Public confession form per user (URL: `/u/{username}`)
-   Guests send message anonymously and receive a **guest token** to return and chat
-   Owner dashboard / inbox for authenticated users
-   Two-way chat between guest & owner (stored conversations)
-   Secure authentication, registration, and password reset flows
-   Simple test suite with feature tests using Pest

---

## Requirements ⚙️

-   PHP 8.1+ (project uses modern Laravel dependencies)
-   Composer
-   A database supported by Laravel (MySQL, SQLite, Postgres)
-   Optional: Redis / queue driver for async/notifications

---

## Quick start (local)

1. Clone the repo

```bash
git clone <repo-url> dukasaha
cd dukasaha
```

2. Install dependencies

```bash
composer install
```

3. Copy env and generate key

```bash
cp .env.example .env
php artisan key:generate
```

4. Set up DB in `.env` (DB_CONNECTION, DB_DATABASE etc.)

5. Run migrations

```bash
php artisan migrate
```

6. Serve app locally

```bash
php artisan serve
# Visit http://127.0.0.1:8000
```

---

## Environment & Configuration 🔑

Important variables (add to `.env`):

-   APP_URL (e.g. `http://127.0.0.1:8000`)
-   DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
-   MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD
-   RECAPTCHA_SITE_KEY and RECAPTCHA_SECRET_KEY (used in login form verification)
-   QUEUE_CONNECTION (use `sync` for local dev)

Quick copy & setup (platform-specific):

-   Windows (PowerShell or CMD):

```powershell
copy .env.example .env
php artisan key:generate
```

-   macOS / Linux:

```bash
cp .env.example .env
php artisan key:generate
```

Minimal `.env` values you should set for local development:

```
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dukasaha
DB_USERNAME=root
DB_PASSWORD=
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io   # or your SMTP provider
MAIL_PORT=2525
MAIL_USERNAME=<mailuser>
MAIL_PASSWORD=<mailpass>
RECAPTCHA_SITE_KEY=
RECAPTCHA_SECRET_KEY=
QUEUE_CONNECTION=sync
```

Notes & tips:

-   Keep `.env` out of version control (Laravel's `.gitignore` already ignores it). Instead, keep `.env.example` updated with non-secret defaults so contributors know which variables to set.
-   For local email testing use Mailtrap (or `log` mailer) so password reset emails don't go to real users.
-   The login flow integrates Google reCAPTCHA; tests skip verification (see `AuthController`) so test runs are not blocked by missing keys.
-   For quick local testing you can use SQLite by setting `DB_CONNECTION=sqlite` and `DB_DATABASE` to a file path (or `:memory:` for in-memory testing).
-   If you use a CI system (GitHub Actions, GitLab CI), inject the required environment variables there rather than committing them.

Password reset uses Laravel's built-in `Password` broker (tokens stored in `password_reset_tokens`).

---

## Database & migrations 📦

Main tables:

-   `users` — Laravel default (registration, login)
-   `confessions` — stores the original anonymous message, `guest_token` and `ip_address`
-   `chats` — threaded chat messages within a confession (`sender_type` = `guest`|`user` and `is_read` boolean)
-   `sessions`, `password_reset_tokens` (Laravel/extended stuff)

Helpful commands:

-   `php artisan migrate` — migrate DB
-   `php artisan migrate:fresh --seed` — reset and seed

---

## Running the app 🧪

-   Local server: `php artisan serve`
-   Queue workers (if you add notification events): `php artisan queue:work`

---

## Testing 🧩

This project uses Pest (and supports PHPUnit compatibility).

-   Run the entire test suite:

```bash
vendor/bin/pest
# or
php artisan test
```

-   Run a single test file or filter tests:

```bash
vendor/bin/pest tests/Feature/ConfessionFlowTest.php
vendor/bin/pest --filter logged_in_user_can_reply_to_confession_and_owner_reply_is_marked_read
```

Notes about tests:

-   CSRF middleware is disabled in tests where appropriate (see tests `setUp()`)
-   `AuthController` is configured to skip reCAPTCHA during unit tests to simplify testing flows

---

## Routes & Controllers (overview) 🔀

Major routes (see `routes/web.php`):

-   Public

    -   `GET /` — Landing (PageController@index)
    -   `GET /u/{username}` — Confession form (ConfessionController@create)
    -   `POST /confess` — Submit confession (ConfessionController@store)
    -   `GET /reply/{token}` — Guest chat view (ChatController@guestAccess)
    -   `POST /chat/guest/{token}` — Guest reply (ChatController@guestReply)

-   Authenticated

    -   `GET /messages` — Inbox (ConfessionController@index)
    -   `GET /chat/{id}` — Owner chat view (ChatController@show)
    -   `POST /chat/{id}` — Owner reply (ChatController@store)
    -   Profile and settings (ProfileController)

-   Auth
    -   Registration, login, logout (AuthController)
    -   Password reset (ForgotPasswordController)

Controller highlights:

-   `ConfessionController` — handles creating confessions and listing inbox messages
-   `ChatController` — shows conversation, handles guest & owner replies, marks confessions as read
-   `AuthController` — registration & login (includes reCAPTCHA verification)
-   `ProfileController` — update username and delete account

---

## Key flows & implementation notes 💡

-   Guest flow:

    -   Guest submits to `/confess` with `username_target` and `message` → Confession created with `guest_token` (64 chars) and `ip_address` stored
    -   They are redirected to `/reply/{token}` where they can view and reply

-   Owner flow:

    -   Authenticated owner views their inbox (`/messages`) and opens a conversation. When the owner opens a chat, the confession is marked `is_read = true`.
    -   Owner replies are saved with `sender_type = 'user'` and default `is_read = true` for the content owner posts.

-   Security:
    -   Users cannot access others' confessions; controllers abort with `403` for unauthorized access
    -   Use `Rule::unique()->ignore($user->id)` for username updates so the user can keep their existing username

---

## Factories & tests ⚙️

-   Factories added:
    -   `database/factories/ConfessionFactory.php`
    -   `database/factories/ChatFactory.php`
-   Use factories in tests to create realistic data quickly: `Confession::factory()->create()`.

---

## Contributing 🤝

-   Please open PRs and include tests for new features or bug fixes.
-   Consider adding event-driven notifications (e.g., `ConfessionCreated`) so recipients can be notified via email or real-time channels (Pusher, Laravel Echo).

---

## Trouble shooting & contact

If you want a clarification or want me to expand sections (routes, controllers, testing, CI), attach the file or say which area to expand and I'll update the README accordingly.

---

## License

MIT — check `LICENSE` file if included.

---

Thank you for building Dukasaha — let me know which parts you want expanded or converted into developer docs or a CONTRIBUTING guide. 👋
