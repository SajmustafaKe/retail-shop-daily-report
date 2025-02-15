CREATE DATABASE retail_shop;

USE retail_shop;

-- Table for sales
CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    branch VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL
);

-- Table for bank balances
CREATE TABLE bank_balances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    balance DECIMAL(10, 2) NOT NULL
);

-- Table for accounts payable
CREATE TABLE accounts_payable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL
);

-- Table for accounts receivable
CREATE TABLE accounts_receivable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL
);

-- Table for posted cheques
CREATE TABLE posted_cheques (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('released', 'received') NOT NULL,
    date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL
);

-- Table for matters arising
CREATE TABLE matters_arising (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    description TEXT NOT NULL
);