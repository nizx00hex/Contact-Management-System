# PHP Contact CRUD API

A simple PHP CRUD model for managing contact messages using PDO and MySQL.

## Features

* Create contact messages
* Read all contacts
* Read single contact
* Update contact details
* Delete contacts
* PDO prepared statements
* Basic input sanitization
* MySQL database support

---

# Project Structure

```bash
project/
│
├── assets/
│   └── css/
|        └── style.css
│
├── config/
│   └── Database.php
│
├── core/
│   └── init.php
│
├── models/
│   └── Contact.php
│
├── sql/
│   └── database.sql
│
├── models/
│   ├── create.php
│   ├── read.php
│   ├── read_one.php
│   ├── update.php
│   └── delete.php
│
└── README.md
```

---

# Database Setup

## Create Database

```sql
CREATE DATABASE contact_system;
```

## Use Database

```sql
USE contact_system;
```

## Create Table

```sql
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

# PDO Database Connection Example

```php
<?php

class Database {

    private $host = 'localhost';
    private $db_name = 'contact_system';
    private $username = '<username>';
    private $password = '<password>';

    public $conn;

    public function connect() {

        $this->conn = null;

        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
```

---

# CRUD Methods

## Create Contact

```php
$contact->name = "John";
$contact->email = "john@example.com";
$contact->subject = "Hello";
$contact->message = "Test message";

$contact->create();
```

---

## Read All Contacts

```php
$result = $contact->read();
print_r($result);
```

---

## Read Single Contact

```php
$contact->id = 1;

$result = $contact->readOne();
print_r($result);
```

---

## Update Contact

```php
$contact->id = 1;
$contact->name = "Updated Name";
$contact->email = "updated@example.com";
$contact->subject = "Updated Subject";
$contact->message = "Updated Message";
$contact->status = "resolved";

$contact->update();
```

---

## Delete Contact

```php
$contact->id = 1;

$contact->delete();
```

---

# Security Notes

This project uses:

* PDO prepared statements
* Basic input sanitization using:

  * `htmlspecialchars()`
  * `strip_tags()`

## Important

The `update()` method currently does not sanitize user input.
You should sanitize inputs before updating data.

Example:

```php
$this->name = htmlspecialchars(strip_tags($this->name));
```

---

# Technologies Used

* PHP
* MySQL
* PDO
* REST API concepts

---

# Future Improvements

* JWT Authentication
* Validation system
* Pagination
* Search functionality
* API rate limiting
* Better error handling

---

# License

This project is open-source and free to use.
