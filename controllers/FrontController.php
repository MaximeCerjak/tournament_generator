<?php

namespace Controllers;

class FrontController
{
    public function displayLogForm()
    {
        $view = 'formLog.phtml';
        include_once 'views/layout.phtml';
    }
    
    public function displaySignForm()
    {
        $eventModel = new \Models\Event();
        $event = $eventModel->getEvent( $_GET['eventID']);
        
        
        $view = 'formSign.phtml';
        include_once 'views/layout.phtml';
    }
    
    public function displayBackSA()
    {
        $view = 'backSuperAdmin.phtml';
        include_once 'views/layout.phtml';
    }
    
    public function displayBackAE()
    {
        $adminModel = new \Models\Admin();
        $eventModel = new \Models\Event();
        $tournamentModel = new \Models\Tournament();
        
        
        $admin = $adminModel->getAdminById( $_GET['adminID'] );
        $event = $eventModel->getEventByAdmin( $_GET['adminID'] );
        
        $tournament = $tournamentModel->getConfig( $event['event_id'] );
        if( $tournament == false )
        {
            $tournament = [];
        }
        
            
        $view = 'backAdminEvent.phtml';
        include_once 'views/layout.phtml';
    }
}    