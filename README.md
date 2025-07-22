
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

## 🐳 Getting Started with Docker

### 1. Clone the repository

```bash
git clone https://github.com/YOUR_USERNAME/time-tracking-app.git
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

- Symfony 6
- API Platform
- MySQL
- LexikJWTAuthenticationBundle
- Bootstrap 5
- Docker & Docker Compose

---

## 📬 Contact

Developed by **Abdulrhman Alshalal**  
📧 Email: [your-email@example.com]  
🌍 Location: Austria

---

## ✅ License

This project is open-sourced under the MIT license.
