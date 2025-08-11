# 📊 SurveyBoard – Online Survey Management System

SurveyBoard is a modern **online survey management platform** inspired by the simplicity and flexibility of Google Forms.  
Built using **HTML, CSS (Bootstrap), JavaScript, PHP, and MySQL**, it allows registered users to **create surveys, collect responses, and view results visually** in real time.

This system is designed for **educational projects, small businesses, feedback collection, event registrations**, and more.  
It offers a simple yet powerful way to create and share surveys with a **unique code system** so even non-registered participants can respond.

---

## 🚀 Current Features (Implemented)

### 🔐 User Authentication & Access
- **User Registration** – Users can sign up with essential details to start creating surveys.
- **User Login** – Secure authentication ensures that only registered users can access the dashboard.
- **Session Management** – Prevents unauthorized access and protects user accounts.

### 📝 Survey Creation & Management
- **Create Custom Surveys** – Add at least one question with four answer options.
- **Unique Survey Code Generation** – Each created survey automatically receives a unique code for public access.
- **Survey Management Dashboard** – View your created surveys, manage them, and access collected responses.

### 🗳 Public Survey Participation
- **Access via Unique Code** – Public users can open a survey without logging in by entering the provided code.
- **Simple and Fast Interface** – Minimal steps for participants to submit their answers.

### 📊 Response Collection & Analysis
- **Real-Time Response Capture** – As soon as a participant submits a response, it’s saved in the database.
- **Graphical Results View (Bar Graph)** – Clicking the **"View Results"** button shows collected survey results in **bar graph format** for easy analysis.
- **Data Accuracy** – MySQL constraints ensure that only valid and complete responses are stored.

### 🎨 UI & Design
- **Google Forms-Inspired Theme** – A clean and familiar interface.
- **Responsive Design** – Works seamlessly on desktops, tablets, and smartphones.
- **Dark Mode Toggle** – Users can switch between light and dark themes for better accessibility and comfort.

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
│   └── survey_webdev.sql         # Database schema & initial data
│
├── public/
│   ├── index.php                  # Landing page
│   ├── register.php               # User registration page
│   ├── login.php                  # User login page
│   ├── dashboard.php              # Admin/user dashboard
│   ├── create_survey.php          # Survey creation form
│   ├── view_survey.php            # Public survey participation page
│   ├── results.php                # Graphical results (bar graph)
│   └── assets/                    # CSS, JS, and image files
│
└── README.md                      # Project documentation
```

## ⚙ Installation & Setup (Using XAMPP)

1. **Install XAMPP**  
   Download and install [XAMPP](https://www.apachefriends.org/index.html).

2. **Start Apache & MySQL**  
   Open the XAMPP Control Panel and start both **Apache** and **MySQL** services.

3. **Clone the Repository**
   ```bash
   git clone https://github.com/sudhanwa755/surveyBoard.git

4. **Move the Project to htdocs**

Place the `surveyboard` folder inside:

```
C:\xampp\htdocs\
```

 5. **Import the Database**

  * Open **phpMyAdmin**.
  * Import the file `survey_webdev.sql` from the `sql/` folder.

 6.**Bonus tip**

  If xampp's sql sevices is stopping unexpectedly then search sevices on windows searchbar(on Windows 10/11) then search for MySQL80 and stop that servies then start your xampps's SQL service & BOOM you are good to Go...
  
 7. **Configure Database Connection**

  * Open `db.php` and set:

<!-- end list -->

```php
$host = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "survey_webdev";
```
 8. **Run the Project**

  * Open your browser and go to:

<!-- end list -->

```ruby
http://localhost/surveyboard/public/

```
📈 Future Scope

* **🖌 Customization of Forms** – Allow more personalization like themes, fonts, and custom layouts for surveys.
* **📂 Export Survey Data** – Generate downloadable Excel/CSV files containing survey results for offline analysis.
* **🎨 Further UI Enhancements** – Add animations, smoother transitions, and advanced styles for a more modern look.
* **👤 Guest Name Option for Records** –
    * Let guest participants optionally enter their name for admin records.
    * Admin can set this as mandatory or optional for each survey.
* **⚡ ReactJS Version** – Develop a single-page application version for better speed and a more modern user experience.
* **✨ Minor UI Tweaks** – Improve alignment, spacing, and consistency across all pages.

 🤝 Contributing
Contributions are welcome!
If you have suggestions or improvements, please fork the repository and submit a pull request.

💡 Author
Sudhanwa Kulkarni
* 📧 Email: [sudhanwalatur@gmail.com]
* 🌐 GitHub: [sudhanwa755](https://github.com/sudhanwa755)

