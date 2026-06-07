# Muhammad Ilham Hakiki — Laravel Portfolio

A clean, minimalist, recruiter-friendly single-page portfolio website built with:

- **Laravel 12** — backend framework
- **Blade** — templating engine
- **Livewire 3** — reactive components (contact form)
- **Filament 3** — admin panel / CMS for managing projects
- **Tailwind CSS v4** — utility-first styling

---

## 📁 Project Structure

```
portfolio/
├── app/
│   ├── Filament/
│   │   └── Resources/
│   │       └── ProjectResource.php         # Filament CMS for projects
│   ├── Livewire/
│   │   └── ContactForm.php                 # Reactive contact form
│   └── Models/
│       └── Project.php                     # Eloquent model
│
├── database/
│   └── migrations/
│       └── xxxx_create_projects_table.php
│
├── resources/
│   ├── css/
│   │   └── app.css                         # Tailwind + custom tokens
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php               # Main layout
│       ├── components/
│       │   ├── nav.blade.php
│       │   ├── hero.blade.php
│       │   ├── about.blade.php
│       │   ├── tech-stack.blade.php
│       │   ├── projects.blade.php
│       │   ├── experience.blade.php
│       │   ├── contact.blade.php
│       │   └── footer.blade.php
│       ├── livewire/
│       │   └── contact-form.blade.php
│       └── welcome.blade.php               # Single-page entry
│
└── routes/
    └── web.php
```

---

## 🚀 Setup

### 1. Clone & install

```bash
git clone https://github.com/yourusername/portfolio.git
cd portfolio
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### 2. Database

```bash
# Edit .env — set DB_DATABASE, DB_USERNAME, DB_PASSWORD
php artisan migrate
php artisan db:seed  # optional: seed sample projects
```

### 3. Storage link

```bash
php artisan storage:link
```

### 4. Filament admin

```bash
php artisan make:filament-user
# Set email + password for admin access
```

Visit `/admin` to manage your portfolio projects through the Filament CMS.

### 5. Build & serve

```bash
npm run dev       # development (Vite HMR)
npm run build     # production build
php artisan serve # visit http://localhost:8000
```

---

## 🎨 Design Tokens

All design variables are defined in `resources/css/app.css` under `@theme`:

| Token                    | Value      | Usage                |
|--------------------------|------------|----------------------|
| `--color-accent`         | `#e8401c`  | Primary accent/CTAs  |
| `--color-accent-soft`    | `#fff0ed`  | Soft accent bg       |
| `--color-surface`        | `#fafaf9`  | Card backgrounds     |
| `--color-text-secondary` | `#6b6b65`  | Body text            |
| `--font-serif`           | Instrument Serif | Headings      |
| `--font-sans`            | DM Sans    | Body, UI text        |

---

## 🧩 Livewire Contact Form

The contact form is a Livewire component with real-time validation.

**Blade usage:**
```blade
<livewire:contact-form />
```

**Configure mail recipient in `.env`:**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=yourpassword
MAIL_FROM_ADDRESS="noreply@ilhamhakiki.dev"
PORTFOLIO_MAIL_RECIPIENT=ilhamhakiki@example.com
```

---

## 📊 Filament CMS

The Filament admin panel provides a full CMS for portfolio projects:

- Create, edit, reorder projects with drag-and-drop
- Upload screenshots
- Manage tech stack tags
- Toggle featured status
- Filter by status and type

---

## 📦 Key Dependencies

```json
{
  "require": {
    "php": "^8.2",
    "laravel/framework": "^12.0",
    "livewire/livewire": "^3.0",
    "filament/filament": "^3.0"
  },
  "require-dev": {
    "laravel/vite-plugin": "^1.0"
  }
}
```

```json
{
  "devDependencies": {
    "@tailwindcss/vite": "^4.0",
    "tailwindcss": "^4.0",
    "vite": "^6.0"
  }
}
```

---

## 📄 License

MIT — feel free to fork and customize for your own portfolio.

---

Built with ❤️ by Muhammad Ilham Hakiki
