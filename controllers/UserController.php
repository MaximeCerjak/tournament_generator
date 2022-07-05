<?php

namespace Controllers;

class UserController
{
    public function displayUsers()
    {
        $userModel = new \Models\User();
        $eventModel = new \Models\Event();
        
        $event = $eventModel->getEvent( $_GET['eventID'] );
        
        $users = $userModel->getUserByEvent( $event['event_id'] );
        
        
        $view = "usersList.phtml";
        include_once "views/layout.phtml";
    }
    
    public function addPlayer()
    {
        $userModel = new \Models\User();
        
        if( isset( $_POST['firstname'] ) && !empty( $_POST['firstname'] )
        && isset( $_POST['lastname'] ) && !empty( $_POST['lastname'] )
        && isset( $_POST['pseudo'] ) && !empty( $_POST['pseudo'] )
        && isset( $_POST['email'] ) && !empty( $_POST['email'] ) 
        && isset( $_POST['eventId'] ) && !empty( $_POST['eventId'] ))
        {
            $time = time();
            $random_id = $time / rand(0, 1000 );
            $firstname = trim( $_POST['firstname'] );
            $lastname = trim( $_POST['lastname'] );
            $pseudo = trim( $_POST['pseudo'] );
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $event = $_POST['eventId'];
            
            
            $userModel->insertUser(
                [
                    $random_id,
                    $firstname,
                    $lastname,
                    $pseudo,
                    $email,
                    $event
                ]);
        }
        else
        {
            header ( 'Location:index.php?route=signIn&eventID='.$event.'&add=false' );
            echo "ERRORRRRRRR!!!!!!!!!!";
            exit(); 
        }
        
        header ( 'Location:index.php?route=signIn&eventID='.$event.'add=true' );
        exit();
    }
    
    public function deleteUser()
    {
        $userModel = new \Models\User();
        
        if( isset( $_GET['userID'] ))
        {
            $userModel->deleteUser( $_GET['userID'] );
        }
        else
        {
            header ( 'Location:index.php?route=players&eventID='.$_GET['eventID'].'deleted=false' );
            exit(); 
        }
        
        header ( 'Location:index.php?route=players&eventID='.$_GET['eventID'].'deleted=true' );
        exit();
    }
}