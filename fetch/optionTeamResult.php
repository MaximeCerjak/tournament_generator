<?php
require_once "../models/Database.php";
require_once "../models/User.php";

$userModel = new \Models\User();
$players = $userModel->getUserByEvent( $_GET['eventID'] );
$count = 0;

include '../views/optionTeamResult.phtml';