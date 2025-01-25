# README.txt

## Project Title: Secure User Registration System

### Description
This project implements a secure registration system designed on the basic of Cyber Security Principles in order
 to protect user through advanced security measures, including password hashing, email encryption, CAPTCHA for bot prevention, and multi-factor authentication (MFA).

### Contents
- **/frontend**: Contains HTML, CSS, and JavaScript files for the user interface.
- **/backend**: Includes PHP files handling server-side logic.
- **/database**: SQL file for database structure and initial data.
- **/libraries**: External libraries (PHPMailer, bcrypt) used for security features.

### Technologies Used
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Security Libraries**: BCRYPT, AES-128 CBC, reCAPTCHA v3

### Installation Instructions
1. Place the project folder in the `htdocs` directory (XAMPP) .
2. Create a MySQL database and import the provided SQL file.
3. Update the database connection settings in `config.php`.
4. Start your local server and access the application at `http://localhost/userregistration`.

### Features
- Password and security answer hashing using BCRYPT
- AES-128 CBC email encryption
- CAPTCHA and HoneyPot for bot prevention
- Multi-factor authentication via Email OTP and security questions
- Password Feedback and Stength
- Requirement of Unique Email and Username 

### Testing
The system has been tested against common threats like brute-force attack, bot infiltration and MFA check. 

### Author
- [Praveen Sapkota]

### License
This project is licensed under the MIT License.
