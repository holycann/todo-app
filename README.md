# 📋 Todo App
## PHP MySQL

A simple and intuitive todo application built with PHP and MySQL to help you manage tasks and reminders efficiently.

![Project Logo](assets/images/logo/logo.png)

## ✨ Features

- ✅ Create, update, and delete tasks
- ⏰ Set reminders for tasks
- 📂 Organize tasks into categories
- 📅 View upcoming tasks and reminders

## 🚀 Setup

1. Clone the repository in your htdocs folder:
   ```bash
   git clone https://github.com/holycann/todo-app.git
   ```

2. Database Migration Commands:
   - Migration Up:
     ```bash
     php database/migration.php up
     ```
   - Migration Down:
     ```bash
     php database/migration.php down
     ```
   - Insert Dummy Data:
     ```bash
     php database/dummy.php
     ```

3. Configure database connection in `config/env.php`

4. Start Apache and MySQL servers using XAMPP

5. Access the application:
   - `http://localhost/todo-app`
   - Or `http://localhost/{your-folder-path}`

## 🛠️ Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- XAMPP or similar local server environment

## 📂 Project Structure

```
todo-app/
├── assets/           # Static assets (CSS, JS, images)
├── config/           # Configuration files
├── database/         # Database migrations
├── src/
│   ├── controllers/  # Request handling logic
│   ├── core/         # Core application components
│   ├── interface/    # Interfaces and contracts
│   ├── middleware/   # Request middleware
│   ├── models/       # Data models
│   ├── repositories/ # Data access layer
│   ├── routes/       # Application routing
│   ├── services/     # Business logic
│   └── views/        # HTML templates
└── index.php         # Application entry point
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

⭐ Don't forget to star the repository if you find it helpful! 🌟 