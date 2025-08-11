
# 📊 SurveyBoard – Online Survey Management System

SurveyBoard is a modern **online survey management platform** inspired by the simplicity and flexibility of Google Forms.  
Built using **HTML, CSS (Bootstrap), JavaScript, PHP, and MySQL**, it allows registered users to **create surveys, collect responses, and view results visually** in real time.

This system is designed for **educational projects, small businesses, feedback collection, event registrations**, and more.  
It offers a simple yet powerful way to create and share surveys with a **unique code system** so even non-registered participants can respond.

---

## 🚀 Current Features (Implemented)

### 🔐 User Authentication & Access
- **User Registration** – Sign up with essential details to start creating surveys.
- **Secure Password Storage** – Passwords are **encrypted before being stored** in the database.
- **User Login** – Secure authentication ensures that only registered users can access their dashboard.
- **Session Management** – Prevents unauthorized access and protects user accounts.

### 📝 Survey Creation & Management
- **Create Custom Surveys** – Add at least one question with four answer options.
- **Unique Survey Code Generation** – Each created survey automatically receives a unique code for public access.
- **Survey Management Dashboard** – View your created surveys, manage them, and access collected responses.

### 📋 Dashboard Page Features
- **Recently Created Surveys** – Quickly access your latest surveys after logging in.
- **Response Counter** – Shows the total responses received for each survey in real time.
- **Copy Survey Code Button** – Instantly copy a generated unique code for easy sharing.
- **One-Click Delete Survey** – Remove any of your created surveys directly from the dashboard.
- **Logout Functionality** – End your session securely with a single click.

### 🗳 Public Survey Participation
- **Access via Unique Code** – Public users can open a survey without logging in by entering the provided code.
- **Simple and Fast Interface** – Minimal steps for participants to submit their answers.

### 📊 Response Collection & Analysis
- **Real-Time Response Capture** – Responses are saved to the database instantly after submission.
- **Graphical Results View (Bar Graph)** – View survey results in a clear, visual bar chart format.
- **Data Accuracy** – MySQL constraints ensure only valid and complete responses are stored.

### 🎨 UI & Design
- **Google Forms-Inspired Theme** – Clean, familiar, and easy to navigate.
- **Responsive Design** – Works seamlessly on desktops, tablets, and smartphones.
- **Dark Mode Toggle** – Switch between light and dark themes for comfort and accessibility.

---

## 🛡 Security Features
- **Password Encryption** – User passwords are stored securely using hashing techniques.
- **Session-Based Access Control** – Prevents unauthorized users from accessing private survey pages.
- **Owner-Only Survey Management** – Only the survey creator can view, edit, or delete their surveys.
- **Database Validation** – Ensures only authorized and valid data is processed.

---

## 🛠 Tech Stack
- **Frontend:** HTML5, CSS3 (Bootstrap 5), JavaScript  
- **Backend:** PHP 8+  
- **Database:** MySQL (via phpMyAdmin in XAMPP)  
- **Server Environment:** Apache (XAMPP for local development)  
- **Version Control:** Git & GitHub  

---

## 📂 Project Structure
```

surveyboard/
│
├── sql/
│   └── survey\_webdev.sql         # Database schema & initial data
│
├── public/
│   ├── index.php                  # Landing page
│   ├── register.php               # User registration page
│   ├── login.php                  # User login page
│   ├── dashboard.php              # Dashboard with survey management tools
│   ├── create\_survey.php          # Survey creation form
│   ├── view\_survey.php            # Public survey participation page
│   ├── results.php                # Graphical results (bar graph)
│   └── assets/                    # CSS, JS, and image files
│
└── README.md                      # Project documentation

````

---

## ⚙ Installation & Setup (Using XAMPP)
1. **Install XAMPP**  
   Download and install [XAMPP](https://www.apachefriends.org/index.html).

2. **Start Apache & MySQL**  
   Open the XAMPP Control Panel and start both **Apache** and **MySQL** services.

3. **Clone the Repository**
   ```bash
   git clone https://github.com/sudhanwa755/surveyBoard.git

4. **Move the Project to htdocs**

   ```
   C:\xampp\htdocs\
   ```

5. **Import the Database**

   * Open **phpMyAdmin**.
   * Create a new database named `survey_webdev`.
   * Import the file `survey_webdev.sql` from the `sql/` folder.

6. **Bonus Tip**
   If XAMPP's MySQL service stops unexpectedly:

   * Open **Services** in Windows.
   * Search for `MySQL80` and stop it.
   * Restart MySQL from XAMPP.

7. **Configure Database Connection**
   Open `db.php` and update:

   ```php
   $host = "localhost";
   $username = "root";
   $password = ""; // Your MySQL password
   $dbname = "survey_webdev";
   ```

8. **Run the Project**

   ```
   http://localhost/surveyboard/public/
   ```

---

## 📈 Future Scope

* 🖌 **Customization of Forms** – Themes, fonts, and custom layouts.
* 📂 **Export Survey Data** – Downloadable Excel/CSV survey results.
* 🎨 **Further UI Enhancements** – Animations, smooth transitions, and advanced styling.
* 👤 **Guest Name Option** – Optional/mandatory name field for guests.
* ⚡ **ReactJS Version** – Single-page application for faster interaction.
* ✨ **Minor UI Tweaks** – Alignment, spacing, and consistency improvements.

---

## 🤝 Contributing

Contributions are welcome!
Fork the repository, create a branch, and submit a pull request.

---

## 💡 Author

**Sudhanwa Kulkarni**
* 📧 Email: [sudhanwalatur@gmail.com](mailto:sudhanwalatur@gmail.com)
* 🌐 GitHub: [sudhanwa755](https://github.com/sudhanwa755)

