# Supplier Management System

## Setup Instructions

1.  **Start XAMPP**:
    *   Open XAMPP Control Panel.
    *   Start **Apache** and **MySQL** services.

2.  **Auto-Provisioning** (NEW):
    *   The database will be **automatically created** when you first access the application.
    *   Sample data will also be inserted automatically.
    *   No manual database setup required!

3.  **FPDF Library** (Required for PDF Reports):
    *   Download FPDF from [http://www.fpdf.org/](http://www.fpdf.org/).
    *   Extract the contents.
    *   Copy `fpdf.php` and the `font` folder into `libs/fpdf/`.

4.  **Run the Application**:
    *   Open your browser and go to `http://localhost/mid-final/`.
    *   The system will automatically set up the database on first load.

## Features

*   **Auto-Provisioning**: Database and tables are created automatically on first run.
*   **CRUD Operations**: Create, Read, Update, and Delete suppliers.
*   **AJAX**: Seamless updates without page reloads.
*   **Search**: Real-time filtering of suppliers.
*   **PDF Report**: Generate a printable list of suppliers.
*   **Responsive Design**: Works on desktop and mobile.
*   **Sample Data**: Includes 3 sample suppliers to get you started.

## Folder Structure

*   `api/`: PHP scripts for handling AJAX requests.
*   `assets/`: CSS and JavaScript files.
*   `config/`: Database connection and auto-provisioning configuration.
*   `database/`: SQL schema script (optional - auto-provisioning handles this).
*   `libs/`: External libraries (FPDF).
*   `reports/`: PHP script for generating PDF reports.
