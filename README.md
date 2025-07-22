
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
    container_name: abud-App
    image: shinsenter/symfony:latest
    ports:
      - "8888:80"
    volumes:
      - ./myproject:/var/www/html
    depends_on:
      - mysql
    networks:
      - abud-net

  mysql:
    image: mysql:8.0
    container_name: abud-db
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: admin
      MYSQL_DATABASE: abud
      MYSQL_USER: admin
      MYSQL_PASSWORD: admin
    volumes:
      - mysql_data:/var/lib/mysql
    networks:
      - abud-net

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: abud-pma
    restart: always
    ports:
      - "8081:80"
    environment:
      PMA_HOST: mysql
      PMA_USER: admin
      PMA_PASSWORD: admin
      MYSQL_ROOT_PASSWORD: admin
    depends_on:
      - mysql
    networks:
      - abud-net

volumes:
  mysql_data:

networks:
  abud-net:
    driver: bridge
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
