<?php
declare(strict_types=1);

// Example usage: fetch allowed senders from Odorik API

require_once __DIR__ . '/../_config.php'; // set the correct path to your config file
require_once __DIR__ . '/OdorikSmsClient.php';

$client = new OdorikSmsClient(ODORIK_BASE_URL, ODORIK_USER, ODORIK_PASSWORD);

try {
    $allowedSenders = $client->getAllowedSenders();
    echo "Allowed senders: " . implode(', ', $allowedSenders) . PHP_EOL;
} catch (Exception $e) {
    echo "Error fetching allowed senders: " . $e->getMessage() . PHP_EOL;
}