# 🧩 Task Management System

A robust **Task Management System** built with **Laravel 12** (backend) and **Vue.js 3** (frontend).  
This system allows users to efficiently manage tasks through an intuitive interface, complete with authentication, role-based access control, RESTful API integration, and performance optimization.

---

## 🚀 Features

- **CRUD Operations:** Create, Read, Update, and Delete tasks.
- **Task Filtering:** View tasks based on their status (Incomplete / Complete).
- **User Authentication:** Each user can manage only their own tasks.
- **Role Management:** Admin and User roles with one-to-one relationships.
- **Access Control List (ACL):**
  - All logged-in users can view all tasks.
  - Regular users can modify only their own tasks.
  - Admins can view and modify all tasks.
- **Custom Middleware:** Logs every request and measures response time.
- **Queue & Jobs:** Sends background email notifications when a task is created or completed.
- **RESTful API:** Fully featured API endpoints for external integration.
- **Caching & Optimization:** Speeds up database queries and task retrieval.
- **Modern Frontend:** Built with Vue.js 3 for a dynamic and responsive UI.
- **Security:** Includes CSRF protection, input validation, and secure authentication.

---

## ⚙️ Installation & Setup

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/your-username/task-management-system.git
cd task-management-system
```

### 2️⃣ Install Dependencies
```bash
composer install
npm install && npm run build
```

### 3️⃣ Environment Setup
Copy the example environment file and configure it:
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` to match your database and mail configuration.

### 4️⃣ Database Migration & Seeding
Run migrations and seed the database:
```bash
php artisan migrate --seed
```
This will create tables and insert initial **roles** and **users** data.

### 5️⃣ Start the Queue Worker
To enable background email notifications:
```bash
php artisan queue:work
```

### 6️⃣ Run the Application
Start the local development servers:
```bash
php artisan serve
npm run dev
```

---

## 🧪 Testing

Run automated PHPUnit tests for CRUD operations, validation, and middleware:
```bash
php artisan test
```

---

## 📡 API Documentation

| Method | Endpoint | Description | Authentication |
|--------|-----------|--------------|----------------|
| GET | `/api/tasks` | Retrieve all tasks | Required |
| GET | `/api/tasks/{id}` | Retrieve a single task | Required |
| POST | `/api/tasks` | Create a new task | Required |
| PUT | `/api/tasks/{id}` | Update an existing task | Required |
| DELETE | `/api/tasks/{id}` | Delete a task | Required |

All routes are protected via **Laravel Sanctum** authentication.

# Task Management System API Documentation

This API provides endpoints to manage Task Management System functionalities such as role-based users, tasks, and users.
You can find the full API documentation on Postman here:

[![Run in Postman](https://run.pstmn.io/button.svg)](https://documenter.getpostman.com/view/9268269/2sB3QQHT8h)

---

## 🧠 Scalability Notes

As the application grows, consider the following strategies to maintain performance and scalability:

- **Database Optimization:** Add proper indexing and use query caching to reduce load.
- **Horizontal Scaling:** Deploy multiple application instances behind a load balancer.
- **Queue Management:** Use Redis or RabbitMQ for handling background jobs efficiently.
- **Caching Layer:** Leverage Laravel Cache and CDN for static asset delivery.
- **Database Sharding:** For very large datasets, consider partitioning or read replicas.

---

## 🧰 Technologies Used

- **Backend:** Laravel 11 (PHP 8+)
- **Frontend:** Vue.js 3 with Composition API
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **Queue Driver:** Database / Redis
- **UI Library:** Element Plus (optional)
- **Caching:** Laravel Cache / Redis

---

## 📂 Project Structure

```
Task-Management-System/
├── app/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── js/
│   ├── css/
│   └── views/
├── routes/
│   ├── api.php
│   └── web.php
└── tests/
```

---

## 🧑‍💻 Author

**Developed by:** Nur Alam  
**Position:** Assistant Manager, ICT – Kallol Group of Companies  
**GitHub:** [github.com/nuralamict](https://github.com/nuralamict)  
**Email:** nuralamict@gmail.com  

---

## 🧾 License

This project is licensed under the **MIT License** — feel free to use, modify, and distribute.

---

## 📬 Submission Guideline

**Submit via:**  
✅ GitHub or Bitbucket repository link  

**Include:**
- `README.md` (this file)  
- Migration and Seeder files  
- Queue and Testing setup commands  
- API documentation  
