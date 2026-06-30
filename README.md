LASUMUC Web Portal

A bespoke web platform built for the Lagos State University Muslim Community (LASUMUC). This platform provides community engagement features, essential Islamic tools, and a robust donation tracking system.

🎨 Color Palette & Typography

The design system is heavily inspired by the official LASUMUC logo to ensure brand consistency.

Primary Colors

Navy Blue (#0B1B3D): Used for the primary navbar, footers, and prominent text. Representing stability and depth.

Forest Green (#006400): Used for primary action buttons, hover states, and key accents. Representing growth and Islamic tradition.

Accent Red (#E50000): Used sparingly for high-priority calls to action (like "Donate" buttons) or error notifications.

Typography

Primary Font (Quicksand): A clean, rounded sans-serif font used for all English text, headers, and UI elements to give a modern, friendly feel.

Arabic Font (Mirza): A legible, traditional serif font used specifically for rendering Quranic text and Islamic phrases.

🚀 Features

Daily Prayer Times: Dynamically fetched using the Aladhan API.

Al-Quran Integration: Read the full Quran with translations (powered by AlQuran Cloud API) using the elegant Mirza Arabic font.

Hijri Calendar: Keep track of Islamic dates and events.

Member Management: Secure user registration, login, and profile management.

Donations & Campaigns: Integrated with Paystack for seamless online donations towards general funds or specific community campaigns.

Admin Dashboard: Manage campaigns, view members, and track donation transactions.

Custom UI: Modern, glossy design using Tailwind CSS with custom alert notifications.

🛠️ Technology Stack

Frontend: HTML5, Tailwind CSS, JavaScript (jQuery, AJAX)

Backend: Vanilla PHP (No MVC framework for simplicity)

Database: MySQL

APIs & Integrations: Paystack (Payments), Aladhan API (Prayer Times), AlQuran Cloud API (Quran Text)

Fonts: Quicksand (Primary), Mirza (Arabic script)

⚙️ Installation & Setup

1. Generate File Structure

Run the provided setup_lasumuc.cmd (Windows) script in your desired project directory to automatically generate the folder hierarchy and empty files.

2. Database Configuration

Open phpMyAdmin or your preferred MySQL client.

Import the schema.sql file to create the lasumuc_db database and its tables (users, campaigns, donations).

The schema automatically creates a default admin account.

3. Connect the Application

Open includes/db.php and update the connection details if your local development environment differs from the defaults:

$host = 'localhost';
$user = 'root';
$pass = ''; // Add your MySQL password if applicable
$dbname = 'lasumuc_db';


4. API Configurations

Paystack: Update the Paystack public key in your frontend JavaScript (assets/js/main.js or donate.php) and your secret key in the backend (ajax/verify_payment.php).

🔐 Default Admin Access

Once the database is set up, you can log into the Admin Dashboard using:

Email: admin@lasumuslimcommunity.org

Password: admin123

(Note: Please ensure you change this password immediately in a production environment!)

📁 Project Structure Highlights

/includes/ - Contains the master header.php and footer.php templates.

/ajax/ - PHP scripts processing asynchronous requests (auth, payments) and returning JSON.

/admin/ - Secure directory requiring an admin session role to access.

/assets/ - Static files (CSS, JS, Images).

🤝 Contributing

For updates to the database, modify schema.sql. For layout changes, adjust includes/header.php or includes/footer.php. Frontend interactivity is managed inside assets/js/main.js.