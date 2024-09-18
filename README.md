# Digital Diaries

## Project Overview

"**Digital Diaries**" is a platform where users can share their personal moments with others.
The project consists of two main parts:

- A web application, for users to create and interact with posts.
- An admin's user management system, for managing user information, 
assigning moderator roles and overseeing database statistics.

This project combines the functionality of user-generated content with an administrative interface for moderation and management.
This is my **third semester project**.

## Features

- **Web Application**:
  - Users can create, edit, and delete their posts;
  - Moderators can edit and delete categories and posts;
  - Special "*hot*" posts feature that highlights selected posts on the front page;
  - User authentication with signup, login, and logout functionalities.

- **Admin's User Management System**:
  - Manage user information and assign or remove moderator roles;
  - View and analyze database statistics;
  - Identify the most popular category, which can help adjust the website's design to enhance its visual appeal based on user preferences;
  - Edit and update basic user details, directly through the system.

## Technologies Used

- **PHP**: For the web app's backend;
- **HTML5 & CSS3**: For structuring and styling the web apps's frontend;
- **MySQL**: For managing the project's database, storing it's information;
- **C# WinForms**: For creating the admin's user management system.

## How to Use

The functionalities of "Digital Diaries" are designed to be intuitive.
Users can easily navigate the web app to create, edit, and interact with posts, 
while the admin's user management system offers straightforward tools for managing the content. 
If you explore the platform, you should be able to figure out its features with ease.

## Setup and Installation

1. Clone this repository:
   `git clone https://github.com/A-Kederys/Digital-Diaries.git`
2. Web Application Setup:
   - Make sure you have a local server environment installed (I used XAMPP);
   - Move the project files into the `htdocs` folder (if using XAMPP), or the appropriate web directory for your server;
   - Move the database folder `kursinis_heterogenine` into the mysql data folder (mine is located in `C:\xampp\mysql\data`).
3. Admin's User Management System:
   - Open the C# WinForms project in Visual Studio;
   - Ensure that the MySQL.Data package is installed for database connectivity;
   - if necessary, update the database connection string in the C# project to match your local MySQL setup.
4. Run the Project:
   - For the web application, start your local server and navigate to `http://localhost/almanR`;
   - For the admin's user management system, run the WinForms application through Visual Studio.
