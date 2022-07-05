<?php

namespace Controllers;

class TournamentController
{
    
    public function displayTournamentForm()
    {
        $userModel = new \Models\User();
        $users = $userModel->getCountOfUserByEvent( $_GET['eventID'] );
        
        $players = $userModel->getUserByEvent( $_GET['eventID'] );
        
        $view = "tournamentForm.phtml";
        include_once "views/layout.phtml";
    }
    
    
    public function addTournament()
    {
        $userModel = new \Models\User();
        $teamModel = new \Models\Team();
        $eventModel = new \Models\Event();
        $battleModel = new \Models\Battle();
        $tournamentModel = new \Models\Tournament();
        
        if( isset( $_COOKIE[ 'config' ] ) && isset( $_COOKIE['eventId'] ) )
        {
            $event_id = $_COOKIE['eventId'];
            
            $users = $userModel->getUserByEventOrderedByRandomId( $event_id );
        
            $config = json_decode( $_COOKIE['config'], true);
            
            if( $config[0]['Equipe'] == true )
            {
                
                $players = $config[0]['Joueurs total'];
                $teams = $config[1]["Nombre d'équipes"];
                $plrs_for_teams = $config[1]['Joueurs par équipe'];
                $total_matchs = $config[1]['Total matchs'];
                $first_turn = $config[1]['Tour 1'];
                $sec_turn = $config[1]['Tour 2'];
                $third_turn = $config[1]['Tour 3'];
                $fourth_turn = $config[1]['Tour 4'];
                $sleeves = $first_turn;
                $teams_config = [];
                $count = 0;
                
                $data_tournament = [ $event_id, 1, 0 ];
                $tournamentModel->addTournament($data_tournament);
                
                $conditions = 'event_id = '.$event_id.' AND team_id IS NULL';
                
                
                //On créé un tableau contenant le nombre d'équipe choisi dans le formulaire en les identifiant avec le nom d'équipe qui s'incrémente
                for( $i = 1; $i <= $teams; $i++ )
                {
                   ${'team_'.$i}['name'] = 'team_'.$i;
                   
                   $teams_config[($i)-1] = ${'team_'.$i};
                }
                
                //On créé les équipes en base de donnée pour chaque element du tableau teams_config
                for( $t = 0; $t < $teams; $t++ )
                {
                    $teamModel->addTeam([
                                        $event_id,
                                        $teams_config[$t]['name']
                                        ]);
                }
                
                
                //On récupère l'id de la team à chaque itération
                //On récupère une liste alétoire limité par le nombre de joueurs par équipe 
                //On distribue aléatoirement les joueurs dans chaque équipe en faisant un update de team_id
                foreach( $teams_config as $team )
                {
                    $bdd_team = $teamModel->getTeamByName( $team['name'] );
                    
                    $newData = [ 'team_id' => $bdd_team['team_id'] ];
                    
                    $users_for_team = $userModel->getRandomUserLimitedList( $conditions, $plrs_for_teams );
                    
                    foreach( $users_for_team as $user )
                    {
                        $userModel->updateUser( $newData, $user['user_id'] );
                    }
                    
                }
                
                //On récupère à nouveau la liste des joueurs pour accéder à team_id
                $users_on = $userModel->getUserByEventOrderedByTeam( $event_id );
                
                //On créé un tableau contenant deux tableaux contenant autant de joueurs qu'il y aura de matchs par manche
                $plrs_tab = $battleModel->generatePlrsTab( $users_on, $players );
                
                // On créé le tableau associant le player1 au player2 pour chaque duel
                
                $players_1 = $plrs_tab[0];
                $players_2 = $plrs_tab[1];
                
                $battle = $battleModel->generateTurnMatch( $sleeves, $players_1, $players_2 );
               
                $battleModel->generateMatchs( $battle, $event_id, 1 );

                $new_data = [ 'is_on_tournament' => 1 ];
                $eventModel->editEvent( $new_data, $event_id );
                
                
                $view = "test.phtml";
                include_once "views/layout.phtml";
                
            }
            elseif( $config[0]['Individuel'] == true )
            {
                $players = $config[0]['Joueurs total'];
                $pools = $config[0]['Poule'];
                $total_select_match = $config[2]['Matchs de selection'];
                $first_turn_select = $config[2]['Tour 1'];
                $sec_turn_select = $config[2]['Tour 2'];
                $third_turn_select = $config[2]['Tour 3'];
                $fourth_turn_select = $config[2]['Tour 4'];
                $fifth_turn_select = $config[2]['Tour 5'];
                $sixth_turn_select = $config[2]['Tour 6'];
                
                
                $data_tournament = [ $event_id, 0, 1 ];
                $tournamentModel->addTournament($data_tournament);
                
                if( $pools == true && $config[4]['Tours de selection final'] == true )
                {
                    $plrs_for_pool = $config[3]['Joueurs par poule'];
                    $total_pool_match = $config[3]['Matchs de poule'];
                    $pool_number = $config[3]['Nombre de poules de selection'];
                    $first_final_turn = $config[4]['Tour 1'];
                    $sec_final_turn = $config[4]['Tour 2'];
                    $third_final_turn = $config[4]['Tour 3'];
                    $fourth_final_turn = $config[4]['Tour 4'];
                    $fifth_final_turn = $config[4]['Tour 5'];
                    $sixth_final_turn = $config[4]['Tour 6'];
                }
                
                if( $config[5]['Poule finale'] == true )
                {
                    $total_final_match = $config[5]['Matchs de poule final'];
                    $final_players = $config[5]['Joueurs par poule'];
                }
                
                
                if( $players % 2 == 0 )
                {
                    $conditions = "event_id =".$event_id;
                    $users = $userModel->getRandomUserList( $conditions );
                    
                    $plrs_tab = $battleModel->generatePlrsTab( $users, $players );
                    $battle_tab = [];
                    
                    for( $i = 0; $i < count($plrs_tab[0]); $i++ )
                    {
                        $battle_tab[ $plrs_tab[0][$i]['user_id'] ] = $plrs_tab[1][$i]['user_id']; 
                    }
                    
                    $battleModel->generateMatchs( $battle_tab, $event_id, 1 );
                    
                    $new_data = [ 'is_on_tournament' => 1 ];
                    $eventModel->editEvent( $new_data, $event_id );
                    
                    $view = "test.phtml";
                    include_once "views/layout.phtml";
                }
                else
                {
                    
                }
            }
            else
            {
               echo 'Erreur'; 
            }
        }
    }
}