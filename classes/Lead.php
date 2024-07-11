<?php

require_once __DIR__ . '/ServerInfo.php';

class Lead extends ServerInfo
{
    private string $firstName;
    private string $lastName;
    private string $phone;
    private string $email;
    private string $countryCode;
    private int  $box_id;
    private int $offer_id;
    private string $landingUrl;
    private string $ip;
    private string $password;
    private string $language;
    private string $apiUrl;
    private string $token;

    public function __construct(string $apiUrl, string $token)
    {
        $this->apiUrl = $apiUrl;
        $this->token = $token;
        $this->countryCode = 'GB';
        $this->box_id = 28;
        $this->offer_id = 5;
        $this->password = 'qwerty12';
        $this->language = 'en';
        $this->landingUrl = ServerInfo::getHost();
        $this->ip = ServerInfo::getAddr();
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function addLead() : string
    {
        $data = [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'phone' => $this->phone,
            'email' => $this->email,
            'countryCode' => $this->countryCode,
            'box_id' => $this->box_id,
            'offer_id' => $this->offer_id,
            'landingUrl' => $this->landingUrl,
            'ip' => $this->ip,
            'password' => $this->password,
            'language' => $this->language
        ];

        $options = [
            'http' => [
                'header' => "Content-Type: application/json\r\n" .
                    "token: {$this->token}\r\n",
                'method' => 'POST',
                'content' => json_encode($data),
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($this->apiUrl, false, $context);

        if($result === false){
            die("Помилка при надсиланні даних :(");
        }

        return $result;
    }
}