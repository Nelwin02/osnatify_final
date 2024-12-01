
<?php
$apiKey = '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';
$url = 'https://api.openai.com/v1/chat/completions';

function callOpenAI($prompt) {
    global $apiKey, $url;

    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'user', 'content' => $prompt]
        ],
        'max_tokens' => 150,
    ];

    $options = [
        'http' => [
            'header' => [
                "Content-Type: application/json",
                "Authorization: Bearer $apiKey"
            ],
            'method' => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);
    
    if ($response === FALSE) {
        return ['error' => 'API request failed.'];
    }

    return json_decode($response, true);
}

// Fetch provinces
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getProvinces') {
    $prompt = "List all provinces in the Philippines, ordered alphabetically and separated by commas.";
    $response = callOpenAI($prompt);

    if (isset($response['choices'][0]['message']['content'])) {
        $provinces = array_map('trim', explode(',', $response['choices'][0]['message']['content']));
        echo json_encode($provinces);
    } else {
        echo json_encode(['error' => 'Unable to fetch provinces.']);
    }
    exit;
}

// Fetch cities based on province
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['province'])) {
    $province = htmlspecialchars(trim($_POST['province'])); // Validate input
    $prompt = "Provide a list separated by commas of cities in the province of $province with their corresponding zip codes in this format: City Name (Zip Code)";
    $response = callOpenAI($prompt);

    if (isset($response['choices'][0]['message']['content'])) {
        $cities = array_map('trim', explode(',', $response['choices'][0]['message']['content']));
        $citiesArray = [];

        foreach ($cities as $cityWithZip) {
            list($cityName, $zipCode) = explode('(', str_replace(')', '', $cityWithZip));
            $citiesArray[] = [
                'name' => trim($cityName),
                'zipcode' => trim($zipCode)
            ];
        }

        echo json_encode($citiesArray);
    } else {
        echo json_encode(['error' => 'Unable to fetch cities.']);
    }
    exit;
}

// Fetch barangays based on city
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['city'])) {
    $city = htmlspecialchars(trim($_POST['city'])); // Validate input
    $prompt = "List all barangays in the city of $city, ordered alphabetically and separated by commas.";
    $response = callOpenAI($prompt);

    if (isset($response['choices'][0]['message']['content'])) {
        $barangays = array_map('trim', explode(',', $response['choices'][0]['message']['content']));
        echo json_encode($barangays);
    } else {
        echo json_encode(['error' => 'Unable to fetch barangays.']);
    }
    exit;
}
?>
