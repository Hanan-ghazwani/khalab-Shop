-- قاعدة بيانات مشروع نبات 🌱
CREATE DATABASE IF NOT EXISTS project;
USE project;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    useremail VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL
);