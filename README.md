# Project-SQL-Security

## Overview
This project demonstrates common security vulnerabilities in SQL databases, focusing primarily on SQL injection attacks and their prevention. The goal is to build a secure web application that showcases the importance of SQL security and how to protect against common threats.

## Features
- **User Authentication**: Secure login system with hashed passwords and role-based access control (RBAC).
- **SQL Injection Demonstration**: Vulnerabilities are intentionally introduced to demonstrate how SQL injection attacks can occur and be exploited.
- **SQL Injection Prevention**: Techniques like prepared statements, input sanitization, and parameterized queries are used to protect the system.
- **Admin Panel**: Allows an admin to manage users and view logs of critical activities.
- **Two-Step Verification for Admins**: Admin users are required to verify their identity using a two-factor authentication (2FA) mechanism.
- **CSRF Protection**: The system is secured against cross-site request forgery (CSRF) attacks.
- **Logging**: Critical user activities are logged for auditing purposes.

## Technologies Used
- **Backend**: PHP, MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Security Measures**:
  - Password hashing using `password_hash()`.
  - Input validation and sanitization.
  - SQL injection prevention via prepared statements.
  - Role-based access control (RBAC).
  - CSRF protection.
  - Two-step verification for admin users.

## Setup Instructions
To run this project locally, follow these steps:

1. Clone the repository:
   ```bash
   git clone https://github.com/PhamMinhKha0710/Project-SQL-Security.git
