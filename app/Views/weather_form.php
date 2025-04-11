<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🌤 Weather Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(to top, #0f2027, #203a43, #2c5364);
            min-height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
            transition: background 0.4s ease;
        }

        body.light-mode {
            background: linear-gradient(to top, #fefcea, #f1da36);
            color: #222;
        }

        .clouds {
            position: absolute;
            top: 0;
            left: 0;
            width: 200%;
            height: 100%;
            background: url('https://cdn.pixabay.com/photo/2016/08/18/01/40/clouds-1594662_960_720.png') repeat-x;
            animation: moveClouds 60s linear infinite;
            opacity: 0.4;
            z-index: 0;
        }

        @keyframes moveClouds {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .lightning {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            background: radial-gradient(circle, rgba(255,255,0,0.4) 0%, rgba(255,255,0,0) 70%);
            opacity: 0;
            z-index: 1;
        }

        @keyframes flash {
            0% { opacity: 0; }
            20% { opacity: 1; }
            50% { opacity: 0.6; }
            100% { opacity: 0; }
        }

        .container {
            position: relative;
            z-index: 2;
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 40px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
            text-align: center;
        }

        .container.light-mode {
            background: rgba(255, 255, 255, 0.4);
            color: #222;
        }

        h1 {
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 2.5rem;
        }

        form input, form button {
            padding: 12px 16px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            margin: 10px;
        }

        input[type="text"] {
            width: 60%;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        button {
            background: #00c6ff;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #0072ff;
        }

        .weather-box {
            margin-top: 20px;
            font-size: 1.2rem;
        }

        .error {
            color: #ff4e4e;
        }

        .mode-toggle {
            position: absolute;
            top: 20px;
            right: 30px;
            z-index: 999;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            transition: all 0.3s;
        }

        .mode-toggle:hover {
            background: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body>

    <!-- Moving Clouds -->
    <div class="clouds"></div>

    <!-- Random Lightning -->
    <div class="lightning"></div>

    <!-- Light/Dark Toggle -->
    <div class="mode-toggle" onclick="toggleMode()">🌗 Toggle Mode</div>

    <!-- Main Weather Glass Container -->
    <div class="container" id="mainContainer">
        <h1>🌩 Weather App</h1>

        <!-- Search Form -->
        <form action="<?= site_url('weather/getWeather') ?>" method="post">
            <input type="text" name="city" placeholder="Enter City Name" required>
            <button type="submit">Search</button>
        </form>

        <!-- Error Message -->
        <?php if (isset($error) && $error): ?>
            <p class="error"><?= esc($error) ?></p>
        <?php endif; ?>

        <!-- Weather Data -->
        <?php if (isset($data)): ?>
            <div class="weather-box">
                <h2>🌍 <?= esc($data['name']) ?></h2>
                <p>🌡 Temp: <?= esc($data['main']['temp']) ?> °C</p>
                <p>☁️ Weather: <?= esc($data['weather'][0]['description']) ?></p>
                <p>💧 Humidity: <?= esc($data['main']['humidity']) ?>%</p>
                <p>🌬 Wind: <?= esc($data['wind']['speed']) ?> m/s</p>
                <?php if (isset($data['aqi'])): ?>
                    <p>🧪 AQI: <?= esc($data['aqi']) ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Scripts -->
    <script>
        const lightning = document.querySelector('.lightning');
        const body = document.body;
        const container = document.getElementById('mainContainer');

        function randomFlash() {
            const interval = Math.random() * 5000 + 3000;
            setTimeout(() => {
                lightning.style.animation = 'flash 0.8s ease-in-out';
                lightning.addEventListener('animationend', () => {
                    lightning.style.animation = '';
                }, { once: true });
                randomFlash();
            }, interval);
        }

        function toggleMode() {
            body.classList.toggle('light-mode');
            container.classList.toggle('light-mode');
        }

        randomFlash();
    </script>
</body>
</html>
