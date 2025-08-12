<?php
declare(strict_types=1);

/**
 * Class OdorikSmsClient
 *
 * Minimalistic client for sending SMS via Odorik API.
 * 
 * @author Martin Dittrich <https://MDCZ.net>
 * @version 1.0.0
 */
class OdorikSmsClient
{
    private string $baseUrl;
    private string $user;
    private string $password;

    /**
     * OdorikSmsClient constructor.
     *
     * @param string $baseUrl Base URL of the API
     * @param string $user Odorik API user (ID or line number)
     * @param string $password Odorik API password
     */
    public function __construct(string $baseUrl, string $user, string $password)
    {
        $this->baseUrl = $baseUrl;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Send SMS via Odorik API.
     *
     * @param string $recipient Phone number in international format (e.g. 00420789123456)
     * @param string $message Message text (max 765 characters)
     * @param string|null $sender Optional sender (e.g. 'Odorik.cz')
     * @return string API response (plain-text)
     * @throws Exception On request error
     */
    public function sendSms(string $recipient, string $message, ?string $sender = null): string
    {
        if ($sender !== null) {
            $allowedSenders = $this->getAllowedSenders();
            if (!in_array($sender, $allowedSenders, true)) {
                throw new InvalidArgumentException("Sender '$sender' is not allowed. Allowed senders: " . implode(', ', $allowedSenders));
            }
        }

        $url = $this->baseUrl . '/sms';
        $data = [
            'user' => $this->user,
            'password' => $this->password,
            'recipient' => $recipient,
            'message' => $message,
        ];
        if ($sender !== null) {
            $data['sender'] = $sender;
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception("API error: HTTP $httpCode, response: $response");
        }

        return $response;
    }

    /**
     * Get allowed senders from Odorik API.
     *
     * @return string[] Array of allowed sender values
     * @throws Exception On request error
     */
    public function getAllowedSenders(): array
    {
        $url = $this->baseUrl . '/sms/allowed_sender';
        $data = [
            'user' => $this->user,
            'password' => $this->password,
        ];

        $ch = curl_init($url . '?' . http_build_query($data));
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception("API error: HTTP $httpCode, response: $response");
        }

        // Response is plain-text, comma separated
        return array_map('trim', explode(',', $response));
    }
}