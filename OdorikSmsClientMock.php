<?php
declare(strict_types=1);

require_once __DIR__ . '/OdorikSmsClient.php';

/**
 * Mock class for OdorikSmsClient.
 * Simulates sending SMS and fetching allowed senders without real API calls.
 */
class OdorikSmsClientMock extends OdorikSmsClient
{
    /**
     * Simulates sending an SMS message.
     *
     * @param string $recipient
     * @param string $message
     * @param string|null $sender
     * @return string
     */
    public function sendSms(string $recipient, string $message, ?string $sender = null): string
    {
        // Simulated response
        return 'successfully_sent 100.00 (mock)';
    }

    /**
     * Simulates fetching allowed senders from the API.
     *
     * @return string[]
     */
    public function getAllowedSenders(): array
    {
        // Simulated allowed senders
        return [
            '00420724123123',
            'Odorik.cz',
            'SMSinfo',
            '5517'
        ];
    }
}