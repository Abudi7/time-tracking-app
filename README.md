
# ⏱️ Time Tracking API with Symfony & JWT

This is a simple **Time Tracking** application built with **Symfony**, **API Platform**, and **JWT Authentication**, with a **Bootstrap-based frontend**.

## 🚀 Features

- ✅ User registration and login via JWT
- 🕒 Start and stop time tracking with duration calculation
- 📅 View all tracked work sessions with date, day name, and user email
- 🔐 Secure API endpoints using JWT
- 🐳 Dockerized setup for easy deployment

---

## 📂 Project Structure

```
.
├── src/                # Symfony source code
├── public/             # Frontend HTML (time tracking page)
├── templates/          # Twig templates
├── docker/             # Docker setup
├── .env                # Environment variables
├── docker-compose.yml  # Docker services
└── README.md
```

---

## 🐳 Docker Setup

### docker-compose.yml

```yaml
version: '3.8'

services:
  symfony:
    image: shinsenter/symfony:php8.4
    container_name: symfony-app
    ports:
      - "8080:80"
    volumes:
      - ./:/var/www/html/new_web_App
    environment:
      - APP_ENV=dev
    depends_on:
      - db

  db:
    image: mysql:8.0
    container_name: mysql-db
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: symfony_db
      MYSQL_USER: symfony
      MYSQL_PASSWORD: symfony
    volumes:
      - db_data:/var/lib/mysql
    ports:
      - "3306:3306"

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: phpmyadmin
    restart: always
    depends_on:
      - db
    ports:
      - "8081:80"
    environment:
      PMA_HOST: db
      MYSQL_ROOT_PASSWORD: root

volumes:
  db_data:
```
## 🐳 Getting Started with Docker

### 1. Clone the repository

```bash
git clone https://github.com/Abudi7/time-tracking-app.git
cd time-tracking-app
```

### 2. Start Docker containers

```bash
docker-compose up -d
```

### 3. Install dependencies

```bash
docker exec -it app composer install
```

### 4. Create the database

```bash
docker exec -it app php bin/console doctrine:database:create
docker exec -it app php bin/console doctrine:migrations:migrate
```

---

## 🧪 API Endpoints

| Method | Endpoint             | Description              |
|--------|----------------------|--------------------------|
| POST   | `/api/register`      | Register a new user      |
| POST   | `/api/login`         | Get JWT token            |
| POST   | `/api/time/start`    | Start time tracking      |
| POST   | `/api/time/stop`     | Stop time tracking       |
| GET    | `/api/times`         | List all tracked records |

> All secured endpoints require `Authorization: Bearer {token}`

---

## 🌐 Frontend

Simple `index.html` interface with:

- Start / Stop buttons
- Feedback messages
- Table with all records (date, duration, day name, user email)

Edit your `index.html` to include:
```javascript
localStorage.setItem("token", "YOUR_JWT_TOKEN");
```

---

## 🛠 Tech Stack

- Symfony 7.3
- API Platform
- MySQL
- LexikJWTAuthenticationBundle
- Bootstrap 5
- Docker & Docker Compose

---

## 📬 Contact

Developed by **Abdulrhman Alshalal**  
📧 Email: [casper.king14@gmail.com]  
🌍 Location: Austria

---

## ✅ License

This project is open-sourced under the MIT license.
