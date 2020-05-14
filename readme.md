## About Scheduling

This system is a shift scheduling system designed for the emergency room of Mackay Memorial Hospital. The Genetic Algorithm used in this system can consider the constraints of shift arrangement and doctors' requirements at the same time.

The system was developed with the php framework of Laravel. To know more about this framework, visit the website (https://laravel.com/)

## Introduction to Scheduling

Each user should login with their own email address and password through the login page.
![Imgur](https://i.imgur.com/I2qigOi.png "Login Page")

After login to the system, users can view the announcements issued by directors in announcement page, they can click "more" button to know the detail.
![Imgur](https://i.imgur.com/NZkWNvz.png "Announcement Page")

If the user's identity is a director, then the user can issue new announcements by clicking the botton at the top of announcements.
![Imgur](https://i.imgur.com/sGPvJtA.png "Announcement Page_Director")

In this page, users can arrange and submit their shift arrangement, they can decide time(daytime / night), location, subject etc.
![Imgur](https://i.imgur.com/GQOtCUt.png "Shift Arrangement")

After the users submit their arrangement, the scheduling algorithm starts finding the solution for them. When a solution is obtained, the system display the result.
![Imgur](https://i.imgur.com/NKrH0Up.png "Arrangement result")

If a user would like to change their shifts, he / she can submit their requests.
![Imgur](https://i.imgur.com/P2j64dx.png "Change shift")