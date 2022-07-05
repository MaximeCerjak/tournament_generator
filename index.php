<?php
session_start();

spl_autoload_register( function( $class ){
    require_once lcfirst( str_replace( '\\', '/', $class ) ) . '.php';
});

if( array_key_exists( 'route', $_GET ) )
{ 
     switch( $_GET['route'] )
    {
        case "logIn" :
            $controller = new Controllers\FrontController();
            $controller->displayLogForm();
            break; 
        case "signIn" :
            $controller = new Controllers\FrontController();
            $controller->displaySignForm();
            break;
        case "connect" :
            $controller = new Controllers\AdminController();
            $controller->logIn();
            break;
        case "disconnect" :
            $controller = new Controllers\AdminController();
            $controller->disconnect();
            break;
        case "":
            $controller = new Controllers\FrontController();
            $controller->displayLogForm();
            
        //ROUTE ADMIN
        case "backSA" :
            $controller = new Controllers\FrontController();
            $controller->displayBackSA();
            break;//OK
        case "createEvent" :
            $controller = new Controllers\EventController();
            $controller->displayEventForm();
            break;//OK
        case "addEvent" :
            $controller = new Controllers\EventController();
            $controller->addEvent();
            break;//Routage... (error rapport)
        case 'eventsHistoric' :
            $controller = new Controllers\EventController();
            $controller->displayEventsBoard();
            break;//OK
        case 'editEvent' :
            $controller = new Controllers\EventController();
            $controller->displayEditEvent();
            break;//OK 
        case 'eventEdition' :
            $controller = new Controllers\EventController();
            $controller->editEvent();
            break;//Routage... (error rapport)
        case 'deleteEvent' :
            $controller = new Controllers\EventController();
            $controller->deleteEvent();
            break;//OK (error rapport)
        case 'scores' :
            $controller = new Controllers\BattleController();
            $controller->displayScores();
            break;//OK
        case "backAE" :
            $controller = new Controllers\FrontController();
            $controller->displayBackAE();
            break; 
            
        //ROUTE ADMIN TOURNOI
        case "players" :
            $controller = new Controllers\UserController();
            $controller->displayUsers();
            break;
        case "addPlayers" : 
            $controller = new Controllers\UserController();
            $controller->addPlayer();
            break;
        case "deletePlayer" :
            $controller = new Controllers\UserController();
            $controller->deleteUser();
        case "tournament" :
            $controller = new Controllers\TournamentController();
            $controller->displayTournamentForm();
            break;
        case "newTournament" : 
            $controller = new Controllers\TournamentController();
            $controller->addTournament();
            break;
        case "teamMatchs" :
            $controller = new Controllers\BattleController();
            $controller->displayTeamMatchs();
            break;
        case "individualMatchs" :
            $controller = new Controllers\BattleController();
            $controller->displayIndividualMatchs();
            break;    
        case "editScores" :
            $controller = new Controllers\BattleController();
            $controller->editScores();
            break;
        case "editIndividualScores" :
            $controller = new Controllers\BattleController();
            $controller->editIndividualScores();
            break;
        case "rank" :
            $controller = new Controllers\BattleController();
            $controller->displayRank();
            break;
        case "nextTeamTurn" :
            $controller = new Controllers\BattleController();
            $controller->generateNextTurn();
            break;
        case "nextIndividualTurn" :
            $controller = new Controllers\BattleController();
            $controller->generateSelectTurn();
            break;
        case 'returnMatch' :
            $controller = new Controllers\BattleController();
            $controller->generateReturnMatchs();
            break;
        case "generatePool" :
            $controller = new Controllers\BattleController();
            $controller->generatePool();
            break;
    }
}
else
{
    header( 'Location: index.php?route=logIn' );
    exit();
}