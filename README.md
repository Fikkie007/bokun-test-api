# PHP Bokun API Client

---

## 🚀 Requirements

* PHP 7.4+
* [Composer](https://getcomposer.org/)
* Bokun API credentials: `ACCESS_KEY`, `SECRET_KEY`, `APP_URL`

---

## 🛠️ Installation

```bash
git clone https://your.repo/php-bokun-client.git
cd php-bokun-client
composer install
cp .env.example .env
```

Edit `.env` and add your Bokun crede    ntials.

---

## ⚙️ Project Structure

```
my-php-app/
├── public/
│   └── products
│       └── product_list              # Web entry point
├── src/
│   ├── Clients/
│   │   └── BokunClient.php    # Core API client
├── bootstrap.php              # Loads .env, Composer autoload
├── .env.example               # Example environment file
├── composer.json
└── README.md
```

---

## 🔧 Usage

### 1. Set up environment

```env
ACCESS_KEY=your_key_here
SECRET_KEY=your_secret
APP_URL=https://api.bokuntest.com
```

### 2. Fetch product listings

```bash
php list_products.php
```

This runs a GET request to `/product-list.json/list?lang=EN` and outputs the HTTP status and response body.

---

## 📖 API Client

`BokunClient` handles:

* HMAC-SHA1 signing with `X-Bokun-Date`, `X-Bokun-AccessKey`, and `X-Bokun-Signature` headers
* URL building, error detection, and JSON decoding

---

## 🧪 Debugging

* Use `dd()` to **dump** variables and stop execution
* Use `dump()` to **print** and continue

---