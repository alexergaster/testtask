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
    private string $token;

    public function __construct(string $token)
    {
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
        $result = file_get_contents("https://crm.belmar.pro/api/v1/addlead", false, $context);

        if($result === false){
            die("Помилка при надсиланні даних :(");
        }

        return $result;
    }
    public function getStatuses($date_from, $date_to, $page = 0, $limit = 100) {
        $data = array(
            'date_from' => $date_from . " 00:00:00",
            'date_to' => $date_to . " 23:59:59",
            'page' => $page,
            'limit' => $limit
        );

        $result = $this->postData($data);
        $response = json_decode($result, true);

        if ($response && isset($response['status']) && $response['status'] === true) {
            return $response['data'];
        } else {
            return array();
        }
    }

    private function postData($data): false|string
    {
        $options = array(
            'http' => array(
                'header' => "Content-Type: application/json\r\n" .
                    "token: {$this->token}\r\n",
                'method' => 'POST',
                'content' => json_encode($data),
            ),
        );
        $context = stream_context_create($options);
        return file_get_contents("https://crm.belmar.pro/api/v1/getstatuses", false, $context);
    }

    public function printLead($leads): string
    {
        $str = '';
        foreach ($leads as $lead){
           $str .= "<tr>" . "<td class='p-2'>{$lead['id']}</td>" . "<td class='p-2'>{$lead['email']}</td>" .
            "<td class='p-2'>{$lead['status']}</td>" . "<td class='p-2'>{$lead['ftd']}</td>". "</tr>";
        }

      return $str;
    }
}