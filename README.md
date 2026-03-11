# Warehouse Inventory Management System

A full-stack warehouse inventory management web application built with **PHP, MySQL, and Bootstrap**.  
The system allows managing IT products stored in warehouse sections and shelves, placing stock orders, and browsing available inventory.

---

## Features

### Authentication System
- User registration
- Login / logout
- Session authentication
- Forgot password

### Product Management
- Add new products
- Upload product images
- Track product quantity
- Assign products to warehouse locations

### Warehouse System
- Section tracking
- Shelf tracking
- Location-based inventory

### Product Browsing
- Search products
- Filter by warehouse location
- Sort by name or quantity
- Pagination

### Stock Orders
- Order new stock
- Automatic quantity update
- Order history tracking

---

## Project Structure
```
magacin/
│
├── assets/                # images and static resources
├── uploads/               # uploaded product images
│
├── about_us.php           # about warehouse page
├── browse_products.php    # product browsing with filters
├── contact_info.php       # contact page
├── db.php                 # database connection
├── index.php              # homepage
├── login.php              # user login
├── logout.php             # user logout
├── navbar.php             # navigation bar
├── order_history.php      # order history
├── register.php           # user registration
│
└── magacin.sql            # database dump
```

---

## Technology Stack

- PHP
- MySQL / MariaDB
- Bootstrap
- HTML
- CSS

---

## Database

Database name: `magacin`

Main tables:

- `korisnici`
- `products`
- `lokacija`
- `naracki`

---

## How to Run the Project

1. Install **XAMPP**

2. Move project folder to:
```
xampp/htdocs/
```

3. Import database using **phpMyAdmin**:
```
magacin.sql
```

4. Update database connection in:
```
db.php
```

5. Start **Apache** and **MySQL**

6. Open in browser:
```
http://localhost/magacin
```

---

## Author

Computer Engineering student focused on:

- backend development
- database systems
- full-stack web applications
