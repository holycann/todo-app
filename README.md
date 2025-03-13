# Todo App

![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange)

A simple and intuitive todo application built with PHP and MySQL to help you manage tasks and reminders efficiently.

## ✨ Features

- ✅ Create, update, and delete tasks
- ⏰ Set reminders for tasks
- 📂 Organize tasks into categories
- 📅 View upcoming tasks and reminders

## 🚀 Setup

1. Clone the repository on your htdocs folder:
   ```bash
   git clone https://github.com/holycann/todo-app.git
   ```
2. Migrate database schema with command.
   For Migration Up

   ```php
   php database/migration.php up
   ```

   For Migration Down

   ```php
   php database/migration.php down
   ```

3. Configure the database connection in `config/env.php`.
4. Start the Apache and MySQL servers using XAMPP.
5. Access the application at `http://localhost/todo-app`.

## 🛠️ Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- XAMPP or similar local server environment

## 📄 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
