# Survey Board Documentation

## Overview
The Survey Board project is a web-based application that allows users to create, participate in, and manage surveys. It provides a user-friendly interface for both survey creators and respondents.

## Project Structure
The project consists of the following files and directories:

- **index.html**: Main entry point for users.
- **register.html**: Registration form for new users.
- **take_survey.html**: Survey participation page.
- **thank_you.html**: Confirmation page after survey submission.
- **dashboard.php**: User dashboard displaying surveys and responses.
- **create_form.html**: Page for creating new surveys.
- **view_submitted_surveys.php**: Displays submitted surveys and responses.
- **php/**: Contains PHP scripts for backend functionality.
  - **db.php**: Database connection and configuration.
  - **login.php**: User login management.
  - **logout.php**: User logout functionality.
  - **register.php**: User registration processing.
  - **create_survey.php**: Survey creation processing.
  - **view_survey.php**: Display specific survey details.
  - **submit_response.php**: Process user survey responses.
  - **results.php**: Generate and display survey results.
- **sql/**: Contains SQL scripts for database setup.
  - **survey_system_webdev.sql**: Database schema and initial data.
- **css/**: Contains styles for the application.
  - **style.css**: CSS styles for layout and appearance.
- **js/**: Contains JavaScript files for client-side functionality.
  - **validate.js**: Form validation scripts.
- **images/**: Contains image assets.
  - **logo.png**: Logo for the survey board.

## Features
- User registration and login functionality.
- Ability to create and manage surveys.
- Participation in surveys with real-time response submission.
- Dashboard for users to view their surveys and responses.
- Display of survey results with statistics.

## Setup Instructions
1. Clone the repository to your local machine.
2. Import the SQL script located in the `sql/` directory into your database management system to set up the database.
3. Configure the database connection in `php/db.php` with your database credentials.
4. Open `index.html` in your web browser to access the application.

## Usage Guidelines
- Users must register to create an account before accessing survey creation features.
- Surveys can be created with various question types and options.
- Users can take surveys and view their submitted responses in the dashboard.

## Contributing
Contributions to the Survey Board project are welcome. Please submit a pull request or open an issue for any enhancements or bug fixes.