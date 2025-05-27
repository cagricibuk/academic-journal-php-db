# Journal Management System

This project is a web-based **Journal Management System** developed as part of the Database Systems course using **PHP**, **MySQL (phpMyAdmin)**, and standard web technologies like **HTML**, **CSS**, and **JavaScript**..

The system provides functionality for managing academic journals, articles, and peer reviews. It supports multiple user roles (author, reviewer, editor), each with specific access and interfaces.

## 🌐 Live Features

- User authentication and role-based access
- Article submission and review system
- Volume and journal metadata management
- Relational database in BCNF with referential integrity
- Responsive web interface styled with CSS

---

## 🛠️ Technologies Used

- **PHP** – Backend scripting
- **MySQL** (phpMyAdmin via WAMP) – Relational database
- **HTML / CSS / JavaScript** – Front-end structure and styling
- **WAMP Server** – Local development environment

---

## 📁 Project Structure

```plaintext
/ (project root)
├── index.php             # Landing page
├── login.php             # Login form
├── loginProcess.php      # Login authentication
├── logout.php            # Logout logic
├── dbconnect.php         # Database connection script
├── authorHome.php        # Author dashboard
├── reviewerHome.php      # Reviewer dashboard
├── editor.php            # Editor interface
├── article.php           # Article detail page
├── journal2.php          # Journal & volume listing
├── volume.php            # Volume detail management
├── script.js             # JavaScript for interactivity
├── styles.css            # Application styles
```
---

## 🗃️ Database Design

The database was designed with normalization principles in mind:

- Initially evaluated for 2NF, 3NF, and BCNF
- Identified and resolved transitive and partial dependencies
- Final schema adheres to **BCNF** with foreign key constraints

### Example Tables:

- `article(id, volid, title, bodyText, correspAut, submissionDate, result)`
- `volume(id, name)`
- `person(email, name, isAuthor, isEditor, isReviewer)`
- `person_volume(email, vid)`

---

## 🔧 Setup Instructions

1. Install [WAMP](https://www.wampserver.com/) or use XAMPP if preferred.
2. Clone this repository or download the files.
3. Place the project folder inside `www` (WAMP) or `htdocs` (XAMPP).
4. Import the SQL database via **phpMyAdmin**.
5. Start all services (Apache, MySQL).
6. Navigate to `http://localhost/your-folder-name/index.php`.

---
