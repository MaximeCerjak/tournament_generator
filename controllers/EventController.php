<?php

namespace Controllers;

class EventController
{

    public function displayEventForm()
    {
        $view = "createEvent.phtml";
        include_once "views/layout.phtml";
    }
    
    public function displayEventsBoard()
    {
        $eventModel = new \Models\Event();
        $events = $eventModel->getEvents();
        
        $view = "eventsHistoric.phtml";
        include_once "views/layout.phtml";
    }
   
   public function displayEditEvent()
   {
       $eventModel = new \Models\Event();
       $event = $eventModel->getEvent( $_GET['eventID'] );
       $adminModel = new \Models\Admin();
       $admin = $adminModel->getAdminById( $event['admin_id'] );
       
       $view = "createEvent.phtml";
       include_once "views/layout.phtml";
   }
   
   public function addEvent()
   {
       $eventModel = new \Models\Event();
       $adminModel = new \Models\Admin();
       
       
        if( isset( $_POST['event-name'] ) && !empty( $_POST['event-name'] ) 
        && isset( $_POST['company-name'] ) && !empty( $_POST['company-name'] )
        && isset( $_POST['event-start'] ) && !empty( $_POST['event-start'] ) 
        && isset( $_POST['event-end'] ) && !empty( $_POST['event-end'] )
        && isset( $_POST['admin-name'] ) && !empty( $_POST['admin-name'] )
        && isset( $_POST['password']) && !empty( $_POST['password'] ) ) 
        {
            $admin_name = trim( $_POST['admin-name'] );
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $event_name = trim( $_POST['event-name'] );
            $event_company = trim( $_POST['company-name'] );
            $event_start = date( "Y-m-d H:i:s", strtotime( $_POST['event-start'] ) );
            $event_end = date( "Y-m-d H:i:s", strtotime( $_POST['event-end'] ) );
            
            
            
        $adminModel->insertAdmin(
            [
                $admin_name,
                $password
            ]);
            
        $admin = $adminModel->getAdminByName( $admin_name );    
            
        $eventModel->insertEvent(
            [
                $admin['admin_id'],
                $event_name,
                $event_company,
                $event_start,
                $event_end
            ]);

        }
        else
        {
            header ( 'Location:index.php?route=eventsHistoric&add=false' );
            echo "ERRORRRRRRR!!!!!!!!!!";
            exit(); 
        }
        
        header ( 'Location:index.php?route=eventsHistoric&add=true' );
        exit();
        
    }
    
   
   
   public function editEvent()
   {
       $eventModel = new \Models\Event();
       $adminModel = new \Models\Admin();
       
       if (isset($_FILES['event-logo']) && $_FILES['event-logo']['error'] == 0)
        {
            
            if ( $_FILES['event-logo']['size'] <= 1000000 )
            {
                
                $fileInfo = pathinfo($_FILES['event-logo']['name']);
                $extension = $fileInfo['extension'];
                $allowedExtensions = ['jpg', 'png'];
                if ( in_array( $extension, $allowedExtensions )) 
                {
                    $tmp_name = $_FILES['event-logo']['tmp_name'];
                    $name = basename($_FILES['event-logo']['name']);
                    $filter_name = str_replace(' ', '-', $name);
                    $chemin = 'public/images/company_logo/';
                    move_uploaded_file($tmp_name, $chemin.$filter_name);
                }
                else
                {
                    header ( 'Location: index.php?route=eventsHistoric&error=file-extension' );
                    exit();
                }
            } 
            else
            {
                header ( 'Location: index.php?route=eventsHistoric&error=file-size' );
                exit();
            }
        }
        else
        {
            var_dump($_FILES['event-logo']);
        }
        
        $event_logo = $chemin.$filter_name;
       
        if( isset( $_POST['event-name'] ) && !empty( $_POST['event-name'] ) 
        && isset( $_POST['company-name'] ) && !empty( $_POST['company-name'] )
        && isset( $_POST['event-start'] ) && !empty( $_POST['event-start'] ) 
        && isset( $_POST['event-end'] ) && !empty( $_POST['event-end'] )
        && isset( $_POST['admin-name'] ) && !empty( $_POST['admin-name'] )) 
        {
            $admin_name = trim( $_POST['admin-name'] );
            $event_name = trim( $_POST['event-name'] );
            $event_company = trim( $_POST['company-name'] );
            $event_start = date( "Y-m-d H:i:s", strtotime( $_POST['event-start'] ) );
            $event_end = date( "Y-m-d H:i:s", strtotime( $_POST['event-end'] ) );
            
            
        $newDataEvent = 
            [
                "event_name" => $event_name,
                "event_company" => $event_company,
                "event_logo" => $event_logo,
                "event_start" => $event_start,
                "event_end" => $event_end
            ];
        
        $eventModel->editEvent( $newDataEvent, $_GET['eventID'] );    
        
        $newDataAdmin = 
            [
              "admin_name" => $admin_name  
            ];
        
        $adminModel->editAdmin( $newDataAdmin, $_GET['adminID'] );
        var_dump($event_logo);
        
            
        }
        
        echo "ERRORRRRRRR!!!!!!!!!!";
    }
    
    public function deleteEvent()
    {
        $eventModel = new \Models\Event();
        
        if( isset( $_GET['eventID'] ))
        {
            $eventModel->deleteEvent( $_GET['eventID'] );
        }
        else
        {
            header ( 'Location:index.php?route=eventsHistoric&deleted=false' );
            exit(); 
        }
        
        header ( 'Location:index.php?route=eventsHistoric&deleted=true' );
        exit();
    }
}    