<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>🌦️ Weather </title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 2rem;
      color: #fff;
    }

    .container {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      padding: 2rem 2.5rem;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.4);
      width: 100%;
      max-width: 600px;
    }

    h1 {
      text-align: center;
      margin-bottom: 1rem;
      font-size: 2.5rem;
      color: #ffffff;
      text-shadow: 0 0 10px #000;
    }

    form {
      display: flex;
      gap: 10px;
      margin-bottom: 1.5rem;
    }

    input[type="text"] {
      flex: 1;
      padding: 0.8rem 1rem;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      outline: none;
      background: #ffffffdd;
      color: #000;
    }

    button,
    .location-btn {
      padding: 0.8rem 1.5rem;
      border: none;
      border-radius: 10px;
      background-color: #00c9ff;
      color: #000;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s ease;
    }

    button:hover,
    .location-btn:hover {
      background-color: #92fe9d;
    }

    .error {
      color: #ff4c4c;
      text-align: center;
      margin-bottom: 1rem;
      font-weight: bold;
    }

    .weather-box {
      background-color: rgba(255, 255, 255, 0.15);
      padding: 1rem;
      border-radius: 12px;
      margin-bottom: 1.5rem;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
      animation: fadeIn 0.4s ease-in-out;
    }

    .weather-box h2 {
      margin-bottom: 0.5rem;
      color: #fff;
    }

    .weather-box p {
      font-size: 1.1rem;
    }

    ul {
      list-style-type: none;
      padding: 0;
    }

    ul li {
      margin-bottom: 0.4rem;
      background: rgba(255, 255, 255, 0.1);
      padding: 0.5rem 1rem;
      border-radius: 8px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    ul li form {
      margin: 0;
    }

    h3 {
      margin: 1rem 0 0.6rem;
    }

    .location-btn {
      display: block;
      margin: 1rem auto 1.5rem;
    }

    #locationWeather {
      display: none;
    }

    @media (max-width: 500px) {
      .container {
        padding: 1.5rem 1.2rem;
      }

      h1 {
        font-size: 2rem;
      }

      input[type="text"], button {
        font-size: 0.9rem;
      }

      .location-btn {
        font-size: 0.9rem;
        padding: 0.6rem 1.2rem;
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>🌤️ Weather ProMax</h1>

    <!-- Search Form -->
    <form action="<?= site_url('weather/getWeather') ?>" method="post">
      <input type="text" name="city" placeholder="Enter City Name" required>
      <button type="submit">Search</button>
    </form>

    <!-- Error Message -->
    <?php if ($error): ?>
      <p class="error"><?= esc($error) ?></p>
    <?php endif; ?>

    <!-- Weather Data -->
    <?php if ($data): ?>
      <div class="weather-box">
        <h2>📍 Weather in <?= esc($data['name']) ?></h2>
        <p>🌡️ Temperature: <?= esc($data['main']['temp']) ?> °C</p>
        <p>🌥️ Weather: <?= esc($data['weather'][0]['description']) ?></p>
        <p>💧 Humidity: <?= esc($data['main']['humidity']) ?>%</p>
        <p>🌬️ Wind: <?= esc($data['wind']['speed']) ?> m/s</p>
        <?php if (!empty($data['aqi'])): ?>
          <p>📊 AQI: <?= esc($data['aqi']) ?></p>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <!-- Location Weather Button -->
    <button class="location-btn" onclick="getLocationWeather()">📍 Get My Location Weather</button>

    <!-- Location Weather Display -->
    <div id="locationWeather" class="weather-box"></div>

    <!-- Search History -->
    <h3>🕓 Last 5 Searches</h3>
    <ul>
      <?php foreach ($history as $item): ?>
        <li>
          <span>📍 <?= esc($item['city_name']) ?> — <?= esc($item['searched_at']) ?></span>
          <form class="delete-form" method="post">
  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= esc($item['id']) ?>">
  <button type="submit">🗑️</button>
</form>

        </li>
      <?php endforeach; ?>
    </ul>
  </div>
            <!-- Toast container -->
<div id="toast" style="
  position: fixed;
  top: 20px;
  right: 20px;
  background: #333;
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  display: none;
  z-index: 9999;
"></div>

<script>
  function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.innerText = message;
    toast.style.background = type === 'success' ? '#28a745' : '#dc3545';
    toast.style.display = 'block';

    setTimeout(() => {
      toast.style.display = 'none';
    }, 3000);
  }

  document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(this);

      fetch("<?= site_url('weather/deleteHistory') ?>", {
        method: "POST",
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          this.closest('li').remove(); // remove the row from table
          showToast(data.message, 'success');
        } else {
          showToast(data.message, 'error');
        }
      })
      .catch(() => {
        showToast('Something went wrong', 'error');
      });
    });
  });
</script>

  <script>
    function getLocationWeather() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(success, error);
      } else {
        alert("Geolocation is not supported by this browser.");
      }

      function success(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        const apiKey = 'ed64d126c3069b8154e2a6e6a80ad3fb'; // Replace with your OpenWeatherMap API key

        const url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&units=metric&appid=${apiKey}`;

        fetch(url)
          .then(response => response.json())
          .then(data => {
            const weatherBox = document.getElementById('locationWeather');
            weatherBox.style.display = 'block';
            weatherBox.innerHTML = `
              <h2>📍 Weather in ${data.name}</h2>
              <p>🌡️ Temperature: ${data.main.temp} °C</p>
              <p>🌥️ Weather: ${data.weather[0].description}</p>
              <p>💧 Humidity: ${data.main.humidity}%</p>
              <p>🌬️ Wind: ${data.wind.speed} m/s</p>
            `;
          })
          .catch(() => {
            alert('Failed to fetch weather data.');
          });
      }

      function error(err) {
        alert("Error fetching location: " + err.message);
      }
    }
  </script>

</body>
</html>
