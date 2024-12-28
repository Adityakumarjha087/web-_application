<?php
if (!isset($_GET['city'])) {
    echo json_encode(['error' => 'City parameter is missing']);
    exit;
}

$city = htmlspecialchars($_GET['city']);
$apiKey = '5aace2cb2fc8c9a78e73bd3034d56260'; // Replace with your OpenWeatherMap API key
$apiUrl = "http://api.openweathermap.org/data/2.5/weather?q={$city}&units=metric&appid={$apiKey}";

$response = file_get_contents($apiUrl);
if ($response === FALSE) {
    echo json_encode(['error' => 'Unable to fetch weather data']);
    exit;
}

$data = json_decode($response, true);

if (isset($data['cod']) && $data['cod'] != 200) {
    echo json_encode(['error' => $data['message']]);
    exit;
}

echo json_encode([
    'city' => $data['name'],
    'temperature' => $data['main']['temp'],
    'description' => ucfirst($data['weather'][0]['description']),
]);
?>
