<?php

require_once __DIR__ . '/../classes/ServerInfo.php';
require_once( __DIR__ . "/../classes/Lead.php");

const TOKEN = "ba67df6a-a17c-476f-8e95-bcdb75ed3958";
const URL = 'https://crm.belmar.pro/api/v1/addlead';



if(ServerInfo::checkMethodPost()){
    $lead = new Lead(URL, TOKEN);

    $lead->setFirstName($_POST['firstname']);
    $lead->setLastName($_POST['lastname']);
    $lead->setPhone($_POST['phone']);
    $lead->setEmail($_POST['email']);

    var_dump($lead->addLead());
}else{
    die();
}

