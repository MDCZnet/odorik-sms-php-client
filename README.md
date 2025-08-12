# Odorik SMS API Client

Minimalistic PHP client for sending SMS via Odorik API.

## Requirements

- PHP 7.4 or newer
- cURL extension

## Installation and Configuration

1. Clone the repository
2. Sign in or register at https://www.odorik.cz/registrace.html
3. Obtain your API credentials from your account settings
4. Create a config file

    ```php
    <?php
    define('ODORIK_API_BASE_URL', 'https://www.odorik.cz/api/v1');
    define('ODORIK_USER', 'your_odorik_user_id');
    define('ODORIK_PASSWORD', 'your_odorik_api_password');
    ```

## Usage

### Example: Send SMS

```php
require_once 'OdorikSmsClient.php';
require_once 'config.php';

$client = new OdorikSmsClient(ODORIK_API_BASE_URL, ODORIK_USER, ODORIK_PASSWORD);
$response = $client->sendSms('00420724000000', 'Test message');
echo $response;
```

### Example: Fetch allowed senders

```php
require_once 'OdorikSmsClient.php';
require_once 'config.php';

$client = new OdorikSmsClient(ODORIK_API_BASE_URL, ODORIK_USER, ODORIK_PASSWORD);
$allowedSenders = $client->getAllowedSenders();
print_r($allowedSenders);
```

### Example: Send SMS with allowed sender

```php
require_once 'OdorikSmsClient.php';
require_once '_config.php';

$client = new OdorikSmsClient(ODORIK_API_BASE_URL, ODORIK_USER, ODORIK_PASSWORD);
$sender = '00420711000000'; // allowed sender number
$response = $client->sendSms('00420724000000', 'Test message', $sender);
echo $response;
```

## Testing

You can use the provided mock class and test scripts for safe testing without sending real SMS.  
See `odorik-send-sms-test.php` for positive and negative test cases.

## Odorik API Documentation

[Official Odorik SMS API documentation](https://www.odorik.cz/w/api:sms)

## Author

Martin Dittrich <https://MDCZ.net>