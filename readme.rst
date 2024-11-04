# Muhammed Ameen's Machine Test for GBS PLUS

## Overview

This project is a **User Management Application** developed for GBS PLUS using CodeIgniter 3 and MySQL. The application includes secure user handling and leverages AJAX for seamless interactions. Key security measures include XSS cleaning to mitigate potential cross-site scripting attacks, and CSRF protection to ensure secure form submissions. Additionally, email functionality for user notifications is tested using Ethereal Mail.

## Features

- **User Management Operations**: Allows for managing user data, including creating, viewing, updating, and deleting records.
- **AJAX Integration**: Provides a smooth and responsive user experience through asynchronous operations.
- **Email Testing with Ethereal Mail**: Sends email notifications to users using Ethereal Mail, a testing-only email service.
- **Security Measures**: Implements XSS cleaning and CSRF protection to secure the application.

## Setup Instructions

### 1. Base URL Configuration

Set the base URL in the `config.php` file to match your local environment. Open `application/config/config.php` and update the `$config['base_url']`:

```php
$config['base_url'] = 'http://localhost/gbs_ameen/';
```

### 2. Database Setup

The database schema is provided in the `database_example` folder. Follow these steps to set up the database:

1. Go to the `database_example` folder.
2. Import the SQL file into your MySQL database using phpMyAdmin or the MySQL command line.

### 3. Internet Connectivity

Ensure your development environment has internet access. This is essential for the application’s functionality, including AJAX operations, CSRF token updates, and email functionalities.

## Security Features

- **XSS Cleaning**: All user inputs are sanitized to prevent XSS attacks.
- **CSRF Protection**: Each form submission is protected with a CSRF token to guard against cross-site request forgery.

## Important Notes

- **Base URL**: Always check and update the base URL in `config.php` if you deploy the application on a different server or environment.
- **Database**: Ensure you import the database schema from the `database_example` folder to enable full functionality.
- **Ethereal Mail**: This service is used for testing email functionality. You may view sent emails by logging into Ethereal’s web interface.
- **Internet Access**: Ensure your environment is connected to the internet to enable AJAX operations and secure CSRF handling.

## Troubleshooting

If you encounter any issues:

- Verify the base URL configuration in `config.php`.
- Ensure the database schema has been correctly imported from the `database_example` folder.
- Check your internet connection for secure token updates and AJAX functionality.

For additional assistance, refer to the documentation or contact me directly.