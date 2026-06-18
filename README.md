# SpecWise — AI-Powered Product Comparison Platform

SpecWise is a production-grade product comparison platform built with Laravel, Livewire, and Tailwind CSS. It aggregates data across multiple categories (Smartphones, Laptops, Headphones, etc.) and uses **DeepSeek AI** (V3/R1) to generate side-by-side comparison verdicts, feature highlights, and customer review summaries.

---

## 🚀 Key Features

* **AI Search & Intent Parsing:** Natural language queries parsed dynamically to match categories, budgets, and feature metrics.
* **Side-by-Side Comparison Matrix:** Interactive specs comparisons with dynamic "AI Verdict" and smart choice indicators.
* **Review Sentiment Synthesis:** Dynamically generated list of Key Pros & Cons extracted from customer feedback via DeepSeek API.
* **Price Tracking & Alerts:** Monitor retail prices across multiple stores (Amazon, Best Buy, Walmart) and set alert thresholds.
* **Responsive, Premium UI:** Clean light-mode design utilizing glassmorphism elements, responsive layouts, and smooth animations.

---

## 🛠️ Tech Stack

* **Framework:** Laravel 12 (PHP 8.2+)
* **Frontend:** Blade Templates + Livewire + Tailwind CSS
* **Database:** PostgreSQL (Supabase / local pgsql)
* **AI Engine:** DeepSeek V3 API (`deepseek-chat`)
* **Package Ecosystem:**
  - `livewire/livewire` — Reactive interface components
  - `laravel/breeze` — Secure user authentication
  - `artesaos/seotools` — Native SEO metadata & JSON-LD management
  - `spatie/laravel-responsecache` — High-speed full-page caching

---

## 💻 Local Setup & Installation

### 1. Clone & Install Dependencies
```bash
git clone https://github.com/Orrddy/specwise.git
cd specwise
composer install
npm install && npm run build
```

### 2. Configure Environment Variables
Copy the `.env.example` file to `.env`:
```bash
cp .env.example .env
```
Update database credentials and your DeepSeek API key:
```env
DB_CONNECTION=pgsql
DB_HOST=db.dvyyjmzqxxemfzgpqnlk.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=YOUR_SUPABASE_DB_PASSWORD

DEEPSEEK_API_KEY=your_deepseek_api_key_here
DEEPSEEK_MODEL=deepseek-chat
DEEPSEEK_BASE_URL=https://api.deepseek.com
```

### 3. Setup Application Key & Migrate
```bash
php artisan key:generate
php artisan migrate --seed
```

### 4. Run Locally
```bash
php artisan serve
```
Open `http://localhost:8000` in your browser.

---

## 🛡️ License

Open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
