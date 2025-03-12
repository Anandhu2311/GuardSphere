<?php
require __DIR__ . '/vendor/autoload.php'; // Load Composer autoload

use Dotenv\Dotenv;
use Google\Client;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Initialize Google Client
$client = new Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri('re'); // Replace with your actual redirect URI
$client->addScope('email');
$client->addScope('profile');

// Generate the authentication URL
$url = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Google Login Example</title>
</head>

<body>

    <a href="<?= htmlspecialchars($url) ?>">Sign in with Google</a>

</body>

</html>