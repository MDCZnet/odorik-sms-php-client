<?php
declare(strict_types=1);

// Example usage: send SMS via Odorik API client

require_once __DIR__ . '/../_config.php'; // set the correct path to your config file
require_once __DIR__ . '/OdorikSmsClient.php';
require_once __DIR__ . '/OdorikSmsPayloadValidator.php';

$recipient = ''; // recipient number in format 00..., e.g. 00420724000000
$sender = ''; // allowed sender number, e.g. 00420711000000
$message = ''; // message text (max 765 characters)
$client = new OdorikSmsClient(ODORIK_BASE_URL, ODORIK_USER, ODORIK_PASSWORD);

try {
    OdorikSmsPayloadValidator::checkRecipient($recipient);
    OdorikSmsPayloadValidator::checkMessage($message);

    if (trim($sender) !== '') {
        $response = $client->sendSms($recipient, $message, $sender);
        echo "✅ SMS sent successfully with sender ($sender): $response";
    } else {
        $response = $client->sendSms($recipient, $message);
        echo "✅ SMS sent successfully (no sender): $response";
    }
} catch (Exception $e) {
    echo "❌ Error sending SMS: " . $e->getMessage();
}