# cat-manager
# 🐱 api-project

Welcome to **api-project**, a fun and interactive website built for **cat lovers**! Whether you're here to admire cute kitties, learn about cat breeds, or enjoy random cat facts, this is the purr-fect place for you.

## 📌 Project Description

This website is dedicated to showcasing everything about cats. It fetches data from public APIs to display cat images, facts, and other feline content in a user-friendly interface.

## 🔧 Technologies Used

- **HTML** – Structure of the website  
- **CSS** – Styling and layout  
- **JavaScript** – Dynamic content and API interactions  
- **PHP** – Server-side logic and backend handling

## 🚀 Getting Started

### Prerequisites

Make sure you have the following installed:

- A web server (e.g., XAMPP, WAMP, or Apache)
- PHP 7.x or higher
- Internet connection (to access external cat APIs)

Direction:
- place the files here on the htdocs from XAMPP
- put this sql command
- :
CREATE DATABASE cat_app;
USE cat_app;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255)
);

CREATE TABLE cats (
  id INT AUTO_INCREMENT PRIMARY KEY,
  breed VARCHAR(255),
  image_url TEXT,
  fact TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
- and run the web using hhtps://localhost/cat-manager/
  

### Installation

1. Clone this repository:
   ```bash
   https://github.com/greg161616/cat-manager/
