<?php
declare(strict_types=1);

// Example test: OdorikSmsClientMock and payload validation (positive and negative cases)

require_once __DIR__ . '/../_config.php'; // set the correct path to your config file
require_once __DIR__ . '/OdorikSmsClientMock.php';
require_once __DIR__ . '/OdorikSmsPayloadValidator.php';

echo "=== POSITIVE TEST - send sms ===" . PHP_EOL;
$recipient = '00420724000000';
$message = 'Test message';
$client = new OdorikSmsClientMock(ODORIK_BASE_URL, ODORIK_USER, ODORIK_PASSWORD);

try {
    OdorikSmsPayloadValidator::checkRecipient($recipient);
    OdorikSmsPayloadValidator::checkMessage($message);

    $response = $client->sendSms($recipient, $message);
    echo "✅ SMS sent successfully: $response" . PHP_EOL . PHP_EOL;
} catch (Exception $e) {
    echo "❌ Error sending SMS: " . $e->getMessage() . PHP_EOL . PHP_EOL;
} 

echo "=== POSITIVE TEST - allowed senders ===" . PHP_EOL;
try {
    if (method_exists($client, 'getAllowedSenders')) {
        $allowedSenders = $client->getAllowedSenders();
        echo "✅ Get allowed senders successfull: " . implode(', ', $allowedSenders) . PHP_EOL . PHP_EOL;
    } else {
        echo "❌ getAllowedSenders() method not implemented in mock client." . PHP_EOL . PHP_EOL;
    }
} catch (Exception $e) {
    echo "❌ Error getting allowed senders: " . $e->getMessage() . PHP_EOL . PHP_EOL;
}

echo "=== POSITIVE TEST – send sms with allowed sender ===" . PHP_EOL;
$recipient = '00420724000000';
$message = 'Test message';
$allowedSenders = $client->getAllowedSenders();
$sender = $allowedSenders[0]; // use the first allowed sender

try {
    OdorikSmsPayloadValidator::checkRecipient($recipient);
    OdorikSmsPayloadValidator::checkMessage($message);

    $response = $client->sendSms($recipient, $message, $sender);
    echo "✅ SMS sent successfully with allowed sender ($sender): $response" . PHP_EOL . PHP_EOL;
} catch (Exception $e) {
    echo "❌ Error sending SMS with allowed sender: " . $e->getMessage() . PHP_EOL . PHP_EOL;
}

echo "=== NEGATIVE TEST – invalid number ===" . PHP_EOL;
$recipient = '12345';
$message = 'Test message';

try {
    OdorikSmsPayloadValidator::checkRecipient($recipient);
    OdorikSmsPayloadValidator::checkMessage($message);

    $response = $client->sendSms($recipient, $message);
    echo "❌ Error: SMS should not have been sent!" . PHP_EOL . PHP_EOL;
} catch (Exception $e) {
    echo "✅ Negative test passed, error caught: " . $e->getMessage() . PHP_EOL . PHP_EOL;
}

echo "=== NEGATIVE TEST – number does not start with 00 ===" . PHP_EOL;
$recipient = '420724000000';
$message = 'Test message';

try {
    OdorikSmsPayloadValidator::checkRecipient($recipient);
    OdorikSmsPayloadValidator::checkMessage($message);

    $response = $client->sendSms($recipient, $message);
    echo "❌ Error: SMS should not have been sent!" . PHP_EOL . PHP_EOL;
} catch (Exception $e) {
    echo "✅ Negative test passed, error caught: " . $e->getMessage() . PHP_EOL . PHP_EOL;
}

echo "=== NEGATIVE TEST – empty message ===" . PHP_EOL;
$recipient = '00420724000000';
$message = '';

try {
    OdorikSmsPayloadValidator::checkRecipient($recipient);
    OdorikSmsPayloadValidator::checkMessage($message);

    $response = $client->sendSms($recipient, $message);
    echo "❌ Error: SMS should not have been sent!" . PHP_EOL . PHP_EOL;
} catch (Exception $e) {
    echo "✅ Negative test passed, error caught: " . $e->getMessage() . PHP_EOL . PHP_EOL;
}