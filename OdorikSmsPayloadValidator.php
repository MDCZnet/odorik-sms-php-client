<?php
declare(strict_types=1);

/**
 * Class OdorikSmsPayloadValidator
 *
 * Validator for checking the correctness of data before sending SMS via Odorik API.
 */
class OdorikSmsPayloadValidator
{
    /**
     * Validates the recipient phone number.
     *
     * @param string $recipient
     * @return void
     */
    public static function checkRecipient(string $recipient): void
    {
        if (!preg_match('/^00\d{9,15}$/', $recipient)) {
            throw new InvalidArgumentException('Invalid recipient number format.');
        }
    }

    /**
     * Validates the message text.
     *
     * @param string $message
     * @throws InvalidArgumentException
     */ 
    public static function checkMessage(string $message): void
    {
        if (mb_strlen($message) === 0) {
            throw new InvalidArgumentException('Message must not be empty.');
        }
        if (mb_strlen($message) > 765) {
            throw new InvalidArgumentException('Message is too long (max 765 characters).');
        }
    }

    /**
     * Validates the sender against allowed senders.
     *
     * @param string $sender
     * @param array $allowedSenders
     * @throws InvalidArgumentException
     */
    public static function checkSender(string $sender, array $allowedSenders): void
    {
        if (trim($sender) === '') {
            return; // empty sender is allowed (optional parameter)
        }
        if (!in_array($sender, $allowedSenders, true)) {
            throw new InvalidArgumentException(
                "Sender '$sender' is not allowed. Allowed senders: " . implode(', ', $allowedSenders)
            );
        }
    }
}