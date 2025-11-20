# Supplier Management System

A modern web-based supplier management system with CRUD operations, status tracking, and PDF reporting.

## Requirements

- XAMPP (Apache + MySQL + PHP 7.4+)
- Web browser (Chrome, Firefox, Edge)

## Installation

1. **Start XAMPP**
   - Open XAMPP Control Panel
   - Start Apache and MySQL services

2. **Setup FPDF Library**
   - Download FPDF from [http://www.fpdf.org/](http://www.fpdf.org/)
   - Extract and copy `fpdf.php` and `font` folder to `libs/fpdf/`

3. **Access Application**
   - Open browser: `http://localhost/mid-final/`
   - Database auto-creates on first run
   - Login: `admin` / `admin123`

## Features

- **CRUD Operations** - Create, Read, Update, Delete suppliers
- **Status Tracking** - Active, Inactive, Suspended with color-coded badges
- **Advanced Filtering** - Search and filter by status
- **PDF Reports** - Generate printable supplier lists
- **AJAX Interface** - Seamless updates without page reloads
- **Responsive Design** - Works on desktop and mobile
- **Auto-Provisioning** - Database and tables created automatically

## Tech Stack

- **Backend**: PHP + MySQL with PDO
- **Frontend**: jQuery + AJAX
- **Styling**: Custom CSS with modern UI
- **PDF**: FPDF Library
- **Icons**: Font Awesome 6.0

## Project Structure

```
mid-final/
├── api/                  # Backend endpoints
├── assets/              # CSS, JavaScript
├── config/              # Database configuration
├── database/            # SQL schema
├── libs/fpdf/          # PDF library
├── reports/            # PDF generation
├── dashboard.php       # Main application
├── login.php          # Authentication
└── index.php          # Entry point
```

## Database Schema

**suppliers** - company_name, contact_person, email, phone, address, status, created_at  
**users** - username, password, full_name, created_at

## Developer

**Mark Angelo L. Mingala**  
3A-WMAD

## License

Educational Project - 2025
