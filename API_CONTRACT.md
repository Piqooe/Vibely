# MoSing — Backend API Contract

Base URL Lokal: `http://127.0.0.1:8000/api`
Header Wajib untuk Request JSON:
- `Accept: application/json`
- `Content-Type: application/json`
- `Authorization: Bearer <token>` 

---

## 1. Authentication (Laravel Sanctum)

### `POST /api/register`
Mendaftarkan pengguna baru dan mengembalikan token akses.
- **Body (JSON):**
  ```json
  {
    "name": "Alya Putri",
    "email": "alya@mosing.id",
    "password": "password123",
    "password_confirmation": "password123"
  }
  