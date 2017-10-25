# Simple-Car-Monitoring
The App for create transportation request and monitor for its availability.
Using Laravel 5.5 LTS.

Installation:
1. Install Laragon on Windows, and open it after install
2. Run the web & MySQL server (for webserver, recommended using Nginx)
3. Copy this git link https://github.com/knightazura/Simple-Car-Monitoring.git
4. Click "Terimnal" button on Laragon window
5. Run this command on Terminal
```git clone https://github.com/knightazura/Simple-Car-Monitoring.git```
6. After all files downloaded, run this command
```composer install
npm install --save-dev
npm run production
php artisan cache:clear
php artisan key:generate
php artisan migrate
```
7. If there's no any errors, then you can run the App via Laragon by right click on any areas on Laragon's window, choose "www" and then click the application's folder name to opened it on browser.

###### Created & developed by: Muhammad Izzuddin al Fikri (muhammadizzuddinalfikri@gmail.com)
