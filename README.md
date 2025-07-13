# Backend API - Employee Management System

This is the backend API for the CRUD App Employee Management System built using **Laravel**, **Sanctum** for authentication, and **Repository Pattern** to maintain clean and maintainable architecture.

---

## Features

- Authentication (Login, Logout) using Laravel Sanctum
- CRUD for Employee
- Division listing
- Filtering & search support on employee list
- Additional endpoints for `nilaiRT` and `nilaiST`
- Clean code architecture using:
  - Repository Pattern
  - Service Layer
  - Controllers

---

## API Routes

### Authentication

| Method | Endpoint      | Description     |
|--------|---------------|-----------------|
| POST   | `/api/login`  | User login      |
| POST   | `/api/logout` | User logout     |

### Division

| Method | Endpoint       | Description    |
|--------|----------------|----------------|
| GET    | `/api/divisions` | List all divisions |

### Employee

All employee routes are under `/api/employees` prefix.

| Method | Endpoint             | Description           |
|--------|----------------------|-----------------------|
| GET    | `/api/employees`     | List employees (with pagination, filtering) |
| GET    | `/api/employees/{id}`| Show employee detail  |
| POST   | `/api/employees`     | Create new employee   |
| PUT    | `/api/employees/{id}`| Update employee       |
| DELETE | `/api/employees/{id}`| Delete employee       |

### Nilai

| Method | Endpoint       | Description         |
|--------|----------------|---------------------|
| GET    | `/api/nilaiRT` | Retrieve Nilai RT   |
| GET    | `/api/nilaiST` | Retrieve Nilai ST   |