# 🌦️ Mausam App - Weather App using CodeIgniter 4 & OpenWeather API

**Mausam App** is a clean and simple weather web application built using **CodeIgniter 4**, which allows users to get real-time weather information of any city using the **OpenWeatherMap API**.

---

## 🔥 Features

- 🔍 Search current weather by city name
- 🌐 Real-time data from OpenWeatherMap API
- 🌡️ Weather details: temperature, humidity, condition, wind speed, etc.
- 🎯 Fully responsive UI using Bootstrap
- 💾 API key handled securely via `.env`
- ⚙️ Clean MVC structure (CI4)
- ⚠️ Error handling for invalid city searches or failed requests

---

## 🧰 Technologies Used

- ✅ PHP (CodeIgniter 4)
- ✅ OpenWeatherMap API
- ✅ HTML, CSS, 
- ✅ JavaScript (optional for AJAX)
- ✅ JSON (for API responses)

---

## 📦 Setup Instructions

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/vikashsharma4141/Masuam-app.git
cd Masuam-app
2️⃣ Install Dependencies
bash
Copy
Edit
composer install
3️⃣ Configure Environment
Create a copy of the env file:

bash
Copy
Edit
cp env .env
Then set your base URL and OpenWeather API key:

env
Copy
Edit
app.baseURL = 'http://localhost:8080/'
weather.apiKey = your_openweather_api_key_here
4️⃣ Run the App
bash
Copy
Edit
php spark serve
Visit in your browser:
📍 http://localhost:8080

🛠 How It Works
The user enters a city name

Controller sends request to https://api.openweathermap.org/data/2.5/weather

Data is retrieved, processed, and displayed in a styled view

If an invalid city is entered, a proper error message is shown

🌍 OpenWeather API Info
[Website: https://openweathermap.org/api]https://api.openweathermap.org/data/2.5/weather?q={city name}&appid={API key}&units=metric


Make sure to sign up and get your API Key in controller 

Example endpoint used:

bash
Copy
Edit
https://api.openweathermap.org/data/2.5/weather?q={city name}&appid={API key}&units=metric
📁 Folder Structure
pgsql
Copy
Edit
app/
 ├── Controllers/
 │    └── Weather.php
 ├── Models/
 │    └── WeatherModel.php
 ├── Views/
 │    └── weather/
 └── Config/
      └── Routes.php
public/
 └── assets/
.env
composer.json


👨‍💻 Developed By
Vikash Sharma
📍 Frontend + PHP Developer
🔗 LinkedIn
