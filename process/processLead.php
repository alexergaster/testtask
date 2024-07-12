<?php

require_once __DIR__ . '/../classes/ServerInfo.php';
require_once __DIR__ . "/../classes/Lead.php";

const TOKEN = "ba67df6a-a17c-476f-8e95-bcdb75ed3958";

if(!ServerInfo::isPostMethod()) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Неправильний метод запиту'
    ]);
}

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($data)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Відсутні необхідні дані'
    ]);
}

switch ($data["action"]){
    case "createLead":
        $lead = new Lead(TOKEN);

        $lead->setFirstName($data['firstName']);
        $lead->setLastName($data['lastName']);
        $lead->setPhone($data['phone']);
        $lead->setEmail($data['email']);

        $response = $lead->addLead();

        $result = json_decode($response, true);

        echo json_encode([
            'status' => $result["status"],
            'message' => $result["error"] ?? "Користувач успішно створився",
        ]);
        break;
    case "printLead":
        $lead = new Lead(TOKEN);

        $date_from = $data['dateFrom'];
        $date_to = $data['dateTo'];

        $leads = $lead->getStatuses($date_from, $date_to);

        echo json_encode([
            'status' => 'true',
            'message' => 'Дані успішно отримані',
            'data' => $lead->printLead($leads)
        ]);
        break;
}


