CREATE DATABASE film_db;

GRANT ALL PRIVILEGES ON film_db.* TO film_db_user@localhost IDENTIFIED BY 'filmapi1213';

USE film_db;

CREATE TABLE films (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    genre VARCHAR(100),
    director VARCHAR(255),
    release_date DATE,
    duration INT,
    rating DECIMAL(2, 1),
    description TEXT,
    language VARCHAR(100),
    country VARCHAR(100),
    budget DECIMAL(15, 2),
    box_office DECIMAL(15, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(127) NOT NULL,
    username VARCHAR(126) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    api_key VARCHAR(32) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (username),
    UNIQUE (api_key)
);
