# Law Office Management System

A comprehensive web-based platform designed to streamline legal operations for law firms. This system was developed as part of a final-year university project for Savjani & Co. Lawyers in Malawi.

## 📌 Project Overview

The Law Office Management System (also known as the Online Legal Consultation System - OLCS) improves legal service delivery through:

- Online appointment scheduling
- Secure video consultations
- Case progress tracking
- Digital document management
- Online payment integration (Mobile Money & Bank Transfer)
- Automated SMS/email notifications
- Multi-role access for Clients, Lawyers, and Admins

## 🎯 Features

- **Client Portal**
  - Register/login
  - Book consultations
  - View case progress
  - Upload/download documents
  - Make secure payments

- **Lawyer Portal**
  - View assigned cases
  - Conduct video consultations
  - Update case milestones
  - Receive client notifications

- **Admin Dashboard**
  - Manage users (clients & lawyers)
  - Schedule/assign appointments
  - View system activity & reports
  - Upload/manage services
  - View feedback & documents

## 🏗️ System Architecture

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP (Object-Oriented)
- **Database**: MySQL
- **Authentication**: Role-based login (Client, Lawyer, Admin)
- **Video Chat**: Embedded 3rd-party video call API
- **Notifications**: Email + SMS reminders

## 💻 Installation Guide

1. **Clone the repository**

   ```bash
   git clone https://github.com/your-username/law-office-management.git
   cd law-office-management

2. **Create the database**

Import the provided law_office_db.sql file into MySQL.

3. **Configure the database**

Edit /config/db.php to match your DB credentials:


define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'law_office_db');
Set up Email (PHPMailer)

Edit SMTP settings in send_mail.php.

Start the server

Use XAMPP or any local server.

Open http://localhost/law-office-management in your browser.

##  User Credentials
**username: admin1**
**password: admin123** 