<?php

namespace Controllers;

class BattleController
{

    public function displayTeamMatchs()
    {
        $battleModel = new \Models\Battle();
        $eventModel = new \Models\Event();
        
        $event = $eventModel->getEvent( $_GET['eventID'] );
        
        
        $matchs_first = $battleModel->getMatchsByTurn( $_GET['eventID'], 1 );
        $matchs_sec = $battleModel->getMatchsByTurn( $_GET['eventID'], 2 );
        $matchs_third = $battleModel->getMatchsByTurn( $_GET['eventID'], 3 );
        $matchs_fourth = $battleModel->getMatchsByTurn( $_GET['eventID'], 4 );
        
        $turns = [
                  $matchs_first,
                  $matchs_sec,
                  $matchs_third,
                  $matchs_fourth
                 ];
        
        
        $resultat_first_turn = $battleModel->turnEnd( $matchs_first );
        $resultat_sec_turn = $battleModel->turnEnd( $matchs_sec );
        $resultat_third_turn = $battleModel->turnEnd( $matchs_third );
        $resultat_fourth_turn = $battleModel->turnEnd( $matchs_fourth );
        
        if( $resultat_sec_turn == true )
        {
            $resultat_first_turn = false;
        }
        elseif( $resultat_third_turn == true )
        {
            $resultat_sec_turn = false;
        }
        elseif( $resultat_fourth_turn == true )
        {
            $resultat_third_turn = false;
        }
        
        
        $userModel = new \Models\User();
        $users = $userModel->getUserByEvent( $_GET['eventID'] );
        
        $view = "teamMatchs.phtml";
        include_once "views/layout.phtml";    
    }
    
    public function displayIndividualMatchs()
    {
        $battleModel = new \Models\Battle();
        $eventModel = new \Models\Event();
        $userModel = new \Models\User();
        $tournamentModel = new \Models\Tournament();
        $turn_result;
        
        $tournament = $tournamentModel->getConfig( $_GET['eventID'] );
        
        $event = $eventModel->getEvent( $_GET['eventID'] );
    
        $users = $userModel->getUserByEvent( $_GET['eventID'] );
        
        
        $first_pool_turn = $battleModel->getMatchsByPoolTurn( $_GET['eventID'], 1 );
        $sec_pool_turn = $battleModel->getMatchsByPoolTurn( $_GET['eventID'], 2 );
        $third_pool_turn = $battleModel->getMatchsByPoolTurn( $_GET['eventID'], 3 );
        $fourth_pool_turn = $battleModel->getMatchsByPoolTurn( $_GET['eventID'], 4 );
        
        $pool_turns = [
                        $first_pool_turn,
                        $sec_pool_turn,
                        $third_pool_turn,
                        $fourth_pool_turn
                      ];
        
        
        $matchs_first = $battleModel->getMatchsByTurn( $_GET['eventID'], 1 );
        $first_exaequo = $battleModel->getMatchWhere( 'match_exaequo = 1 AND match_sleeve = 1 AND event_id ='.$_GET['eventID'] );
        $first_return = $battleModel->getMatchsByTurn( $_GET['eventID'], -1 );
        $first_end = false;
        foreach( $first_return as $match )
        {
            if( $match['score_player_1'] != NULL && $match['score_player_2'] != NULL )
            {
                $first_end = true;
            }
            else
            {
                $first_end = false;
                break;
            }
        }
        
        
        $matchs_sec = $battleModel->getMatchsByTurn( $_GET['eventID'], 2 );
        $sec_exaequo = $battleModel->getMatchWhere( 'match_exaequo = 1 AND match_sleeve = 2 AND event_id ='.$_GET['eventID'] );
        $sec_return = $battleModel->getMatchsByTurn( $_GET['eventID'], -2 );
        $sec_end = false;
        foreach( $sec_return as $match )
        {
            if( $match['score_player_1'] != NULL && $match['score_player_2'] != NULL )
            {
                $sec_end = true;
            }
            else
            {
                $sec_end = false;
                break;
            }
        }
        
        
        $matchs_third = $battleModel->getMatchsByTurn( $_GET['eventID'], 3 );
        $third_exaequo = $battleModel->getMatchWhere( 'match_exaequo = 1 AND match_sleeve = 3 AND event_id ='.$_GET['eventID'] );
        $third_return = $battleModel->getMatchsByTurn( $_GET['eventID'], -3 );
        $third_end = false;
        foreach( $third_return as $match )
        {
            if( $match['score_player_1'] != NULL && $match['score_player_2'] != NULL )
            {
                $third_end = true;
            }
            else
            {
                $third_end = false;
                break;
            }
        }
        
        
        $matchs_fourth = $battleModel->getMatchsByTurn( $_GET['eventID'], 4 );
        $fourth_exaequo = $battleModel->getMatchWhere( 'match_exaequo = 1 AND match_sleeve = 4 AND event_id ='.$_GET['eventID'] );
        $fourth_return = $battleModel->getMatchsByTurn( $_GET['eventID'], -4 );
        $fourth_end = false;
        foreach( $fourth_return as $match )
        {
            if( $match['score_player_1'] != NULL && $match['score_player_2'] != NULL )
            {
                $fourth_end = true;
            }
            else
            {
                $fourth_end = false;
                break;
            }
        }
        
        
        $matchs_fifth = $battleModel->getMatchsByTurn( $_GET['eventID'], 5 );
        $fifth_exaequo = $battleModel->getMatchWhere( 'match_exaequo = 1 AND match_sleeve = 5 AND event_id ='.$_GET['eventID'] );
        $fifth_return = $battleModel->getMatchsByTurn( $_GET['eventID'], -5 );
        $fifth_end = false;
        foreach( $fifth_return as $match )
        {
            if( $match['score_player_1'] != NULL && $match['score_player_2'] != NULL )
            {
                $fifth_end = true;
            }
            else
            {
                $fifth_end = false;
                break;
            }
        }
        
        
        $matchs_sixth = $battleModel->getMatchsByTurn( $_GET['eventID'], 6 );
        $sixth_exaequo = $battleModel->getMatchWhere( 'match_exaequo = 1 AND match_sleeve = 6 AND event_id ='.$_GET['eventID'] );
        $sixth_return = $battleModel->getMatchsByTurn( $_GET['eventID'], -6 );
        $sixth_end = false;
        foreach( $sixth_return as $match )
        {
            if( $match['score_player_1'] != NULL && $match['score_player_2'] != NULL )
            {
                $sixth_end = true;
            }
            else
            {
                $sixth_end = false;
                break;
            }
        }
        
        
        if( !empty( $sec_exaequo ) || $first_end == true )
        {
            $first_exaequo = [];
        }
        elseif( !empty( $third_exaequo ) || $sec_end == true )
        {
            $sec_exaequo = [];
        }
        elseif( !empty( $fourth_exaequo ) || $third_end == true )
        {
            $third_exaequo = [];
        }
        elseif( !empty( $fifth_exaequo ) || $fourth_end == true )
        {
            $fourth_exaequo = [];
        }
        elseif( !empty( $sixth_exaequo ) || $fifth_end == true )
        {
            $fifth_exaequo = [];
        }
        elseif( $sixth_end == true )
        {
            $sixth_exaequo = [];
        }
                   
        $turns = [
                    $matchs_first,
                    $matchs_sec,
                    $matchs_third,
                    $matchs_fourth,
                    $matchs_fifth,
                    $matchs_sixth
                ];
                
        $return_turn = [
                        $first_return,
                        $sec_return,
                        $third_return,
                        $fourth_return,
                        $fifth_return,
                        $sixth_return
                    ];
                     
        
        $resultat_first_turn = $battleModel->turnEnd( $matchs_first );
        $resultat_sec_turn = $battleModel->turnEnd( $matchs_sec );
        $resultat_third_turn = $battleModel->turnEnd( $matchs_third );
        $resultat_fourth_turn = $battleModel->turnEnd( $matchs_fourth );
        $resultat_fifth_turn = $battleModel->turnEnd( $matchs_fifth );
        $resultat_sixth_turn = $battleModel->turnEnd( $matchs_sixth );
        
        if( $resultat_first_turn == true )
        {
            $turn_result = 1;
            $winners = $userModel->getUserWhere( $_GET['eventID'], 'user_victories DESC, user_total_points DESC LIMIT '.count($matchs_first) );
        }
        elseif( $resultat_sec_turn == true )
        {
            $resultat_first_turn = false;
            $turn_result = 2;
            $winners = $userModel->getUserWhere( $_GET['eventID'], 'user_victories DESC, user_total_points DESC LIMIT '.count($matchs_sec) );
        }
        elseif( $resultat_third_turn == true )
        {
            $resultat_sec_turn = false;
            $turn_result = 3;
            $winners = $userModel->getUserWhere( $_GET['eventID'], 'user_victories DESC, user_total_points DESC LIMIT '.count($matchs_third) );
        }
        elseif( $resultat_fourth_turn == true )
        {
            $resultat_third_turn = false;
            $turn_result = 4;
            $winners = $userModel->getUserWhere( $_GET['eventID'], 'user_victories DESC, user_total_points DESC LIMIT '.count($matchs_fourth) );
        }
        elseif( $resultat_fifth_turn == true )
        {
            $resultat_fourth_turn = false;
            $turn_result = 5;
            $winners = $userModel->getUserWhere( $_GET['eventID'], 'user_victories DESC, user_total_points DESC LIMIT '.count($matchs_fifth) );
        }
        elseif( $resultat_sixth_turn == true )
        {
            $resultat_fifth_turn = false;
            $turn_result = 6;
            $winners = $userModel->getUserWhere( $_GET['eventID'], 'user_victories DESC, user_total_points DESC LIMIT '.count($matchs_sixth) );
        }
        
        
        $view = "individualMatchs.phtml";
        include_once "views/layout.phtml";    
    }
    
    
    public function displayScores()
    {
        $battleModel = new \Models\Battle();
        $matchs = $battleModel->getMatchs( $_GET['eventID'] );
        
        $userModel = new \Models\User();
        $users = $userModel->getUserByEvent( $_GET['eventID'] );
        
        
        $view = "scores.phtml";
        include_once "views/layout.phtml";
    }
    
    public function displayRank()
    {
        $teamModel = new \Models\Team();
        $teams_rank = $teamModel->getTeamRank( $_GET['eventID'] );
        
        $userModel = new \Models\User();
        $users_rank = $userModel->getUserRank( $_GET['eventID'] );
        
        $view = "rank.phtml";
        include_once "views/layout.phtml";    
    }
    
    public function editScores()
    {
        $battleModel = new \Models\Battle();
        $teamModel = new \Models\Team();
        $userModel = new \Models\User();
        
        
        if( isset( $_GET['matchID'] ) && isset( $_POST['score-player-1'] ) && !empty( $_POST['score-player-1'] )
        && isset( $_POST['score-player-2'] ) && !empty( $_POST['score-player-2'] )
        && isset( $_POST['team-1'] ) && !empty( $_POST['team-1'] ) 
        && isset( $_POST['team-2'] ) && !empty( $_POST['team-2'] ) 
        && isset( $_POST['user-id-1'] ) && !empty( $_POST['user-id-1'] )
        && isset( $_POST['user-id-2'] ) && !empty( $_POST['user-id-2'] ) )
        {
            //RECUPERATION ET MANIPULATION DES DONNEES TEAM
            $team_victories_1 = $teamModel->getTeamVictories( $_POST['team-1'] );
            $total_points_team_1 = $teamModel->getTeamPoints( $_POST['team-1'] );
            $points_team_1 = $total_points_team_1['total_matchs_points'] + $_POST['score-player-1'];
            
            $team_victories_2 = $teamModel->getTeamVictories( $_POST['team-2'] );
            $total_points_team_2 = $teamModel->getTeamPoints( $_POST['team-2'] );
            $points_team_2 = $total_points_team_2['total_matchs_points'] + $_POST['score-player-2'];
            
            
            //RECUPERATION ET MANIPULATION DES DONNEES USERS
            $user_1_victories = $userModel->getVictories( $_POST['user-id-1'] );// getPoint et getVictories
            $user_1_victories = $user_1_victories['user_victories'];
            $user_1_points = $userModel->getPoints( $_POST['user-id-1'] );
            $user_1_total_points = $user_1_points['user_total_points'] + $_POST['score-player-1'];
            
            $user_2_victories = $userModel->getVictories( $_POST['user-id-2'] );
            $user_2_points = $userModel->getPoints( $_POST['user-id-2'] );
            $user_2_victories = $user_2_victories['user_victories'];
            $user_2_total_points = $user_2_points['user_total_points'] + $_POST['score-player-1'];
            
            if( $_POST['score-player-1'] == $_POST['score-player-2'] )
            {
            
                $newData = [ 
                            'score_player_1' => $_POST['score-player-1'], 
                            'score_player_2' => $_POST['score-player-2'], 
                            'match_exaequo' => 1 
                           ]; 
                           
                           
                $team_victories_1['team_victories']++;
                $team_victories_2['team_victories']++;           
                
                $newData_team_1 = [ 
                                    'total_matchs_points' => $points_team_1,
                                    'team_victories' => $team_victories_1['team_victories'] 
                                  ]; 
                $newData_team_2 = [ 
                                    'total_matchs_points' => $points_team_2,
                                    'team_victories' => $team_victories_2['team_victories'] 
                                  ]; 
                
                $teamModel->updateScore( $newData_team_1, $_POST['team-1'] );
                $teamModel->updateScore( $newData_team_2, $_POST['team-2'] );
                
                
                $user_1_victories++;
                $user_2_victories++;
                
                $newData_user_1 = [
                                    'user_victories' => $user_1_victories,
                                    'user_total_points' => $user_1_total_points
                                  ];
                                  
                $newData_user_2 = [
                                    'user_victories' => $user_2_victories,
                                    'user_total_points' => $user_2_total_points
                                  ];
                                  
                $userModel->updateUser( $newData_user_1, $_POST['user-id-1'] ); 
                $userModel->updateUser( $newData_user_2, $_POST['user-id-2'] ); 
                
            }
            elseif(  $_POST['score-player-1'] > $_POST['score-player-2'] )
            {
                
                $newData = [ 
                            'score_player_1' => $_POST['score-player-1'], 
                            'score_player_2' => $_POST['score-player-2'], 
                            'match_winner' => 1, 
                            'match_looser' => 2
                            ];
                            
                            
                $team_victories_1['team_victories'] += 3;            
                            
                $newData_team_1 = [ 
                                    'total_matchs_points' => $points_team_1,
                                    'team_victories' => $team_victories_1['team_victories'] 
                                  ];
                
                $newData_team_2 = [ 
                                    'total_matchs_points' => $points_team_2
                                  ];                   
                
                $teamModel->updateScore( $newData_team_1, $_POST['team-1'] );
                $teamModel->updateScore( $newData_team_2, $_POST['team-2'] );
                
                
                
                $user_1_victories += 3;
                
                
                $newData_user_1 = [
                                    'user_victories' => $user_1_victories,
                                    'user_total_points' => $user_1_total_points
                                  ];
                                  
                $newData_user_2 = [
                                    'user_total_points' => $user_2_total_points
                                  ];
                                  
                $userModel->updateUser( $newData_user_1, $_POST['user-id-1'] ); 
                $userModel->updateUser( $newData_user_2, $_POST['user-id-2'] );
                
            }
            else
            {
                
                $newData = [ 
                            'score_player_1' => $_POST['score-player-1'], 
                            'score_player_2' => $_POST['score-player-2'], 
                            'match_winner' => 2, 
                            'match_looser' => 1
                           ];
                         
                           
                $team_victories_2['team_victories'] += 3;           
                            
                $newData_team_1 = [ 
                                    'total_matchs_points' => $points_team_1
                                  ]; 
                                  
                $newData_team_2 = [ 
                                    'total_matchs_points' => $points_team_2,
                                    'team_victories' => $team_victories_2['team_victories'] 
                                  ]; 
                
                $teamModel->updateScore( $newData_team_1, $_POST['team-1'] );
                $teamModel->updateScore( $newData_team_2, $_POST['team-2'] );
                
                
                
                $user_2_victories += 3;
                
                $newData_user_1 = [
                                    'user_total_points' => $user_1_total_points
                                  ];
                                  
                $newData_user_2 = [
                                    'user_victories' => $user_2_victories,
                                    'user_total_points' => $user_2_total_points
                                  ]; 
                                  
                $userModel->updateUser( $newData_user_1, $_POST['user-id-1'] ); 
                $userModel->updateUser( $newData_user_2, $_POST['user-id-2'] ); 
                
            }
            
            $battleModel->updateScore( $newData, $_GET['matchID'] );
            
        }
        
        header ( 'Location:index.php?route=matchs&matchID='.$_GET['matchID'].'&eventID='.$_GET['eventID'] );
        exit();
    }
    
    
    public function editIndividualScores()
    {
        
        $userModel = new \Models\User();
        $battleModel = new \Models\Battle();
        
        if( isset( $_GET['matchID'] ) && isset( $_POST['score-player-1'] ) && !empty( $_POST['score-player-1'] )
        && isset( $_POST['score-player-2'] ) && !empty( $_POST['score-player-2'] )
        && isset( $_POST['user-id-1'] ) && !empty( $_POST['user-id-1'] )
        && isset( $_POST['user-id-2'] ) && !empty( $_POST['user-id-2'] ) )
        {
            
            //RECUPERATION ET MANIPULATION DES DONNEES USERS
            $user_1_victories = $userModel->getVictories( $_POST['user-id-1'] );// getPoint et getVictories
            $user_1_victories = $user_1_victories['user_victories'];
            $user_1_points = $userModel->getPoints( $_POST['user-id-1'] );
            $user_1_points = $user_1_points['user_total_points'] + $_POST['score-player-1'];
            
            $user_2_victories = $userModel->getVictories( $_POST['user-id-2'] );
            $user_2_victories = $user_2_victories['user_victories'];
            $user_2_points = $userModel->getPoints( $_POST['user-id-2'] );
            $user_2_points = $user_2_points['user_total_points'] + $_POST['score-player-1']; 
            
            
            if( $_POST['score-player-1'] == $_POST['score-player-2'] )
            {
            
                $newData = [ 
                            'score_player_1' => $_POST['score-player-1'], 
                            'score_player_2' => $_POST['score-player-2'], 
                            'match_exaequo' => 1 
                           ]; 
                           
                
                $user_1_victories++;
                $user_2_victories++;
                
                $newData_user_1 = [
                                    'user_victories' => $user_1_victories,
                                    'user_total_points' => $user_1_points
                                  ];
                                  
                $newData_user_2 = [
                                    'user_victories' => $user_2_victories,
                                    'user_total_points' => $user_2_points
                                  ];
                                  
                $userModel->updateUser( $newData_user_1, $_POST['user-id-1'] ); 
                $userModel->updateUser( $newData_user_2, $_POST['user-id-2'] ); 
                
            }
            elseif(  $_POST['score-player-1'] > $_POST['score-player-2'] )
            {
                
                $newData = [ 
                            'score_player_1' => $_POST['score-player-1'], 
                            'score_player_2' => $_POST['score-player-2'], 
                            'match_winner' => 1, 
                            'match_looser' => 2
                            ];
                            
                            

                $user_1_victories += 3;
                
                
                $newData_user_1 = [
                                    'user_victories' => $user_1_victories,
                                    'user_total_points' => $user_1_points
                                  ];
                                  
                $newData_user_2 = [
                                    'user_total_points' => $user_2_points
                                  ];
                                  
                $userModel->updateUser( $newData_user_1, $_POST['user-id-1'] ); 
                $userModel->updateUser( $newData_user_2, $_POST['user-id-2'] );
                
            }
            else
            {
                
                $newData = [ 
                            'score_player_1' => $_POST['score-player-1'], 
                            'score_player_2' => $_POST['score-player-2'], 
                            'match_winner' => 2, 
                            'match_looser' => 1
                           ];
                         
                           
                $user_2_victories += 3;
                
                $newData_user_1 = [
                                    'user_total_points' => $user_1_points
                                  ];
                                  
                $newData_user_2 = [
                                    'user_victories' => $user_2_victories,
                                    'user_total_points' => $user_2_points
                                  ]; 
                                  
                $userModel->updateUser( $newData_user_1, $_POST['user-id-1'] ); 
                $userModel->updateUser( $newData_user_2, $_POST['user-id-2'] ); 
                
            }
            
            $battleModel->updateScore( $newData, $_GET['matchID'] );
            
        }
        
        header ( 'Location:index.php?route=individualMatchs&matchID='.$_GET['matchID'].'&eventID='.$_GET['eventID'] );
        exit();
        
    }
    
    
    public function generateNextTurn()
    {
        $userModel = new \Models\User();
        $battleModel = new \Models\Battle();
        
        $users_ranked = $userModel->getUserRankByTeamRank( $_GET['eventID'] );
        
       
            $event_id = $_GET['eventID'];
        
            $players = count( $users_ranked );
            $sleeves = $players / 2;
        
            //On créé un tableau contenant deux tableaux contenant autant de joueurs qu'il y aura de matchs par manche
            $plrs_tab = $battleModel->generatePlrsTab( $users_ranked, $players );
            
            // On créé le tableau associant le player1 au player2 pour chaque duel
            
            $players_1 = $plrs_tab[0];
            $players_2 = $plrs_tab[1];
            
            $battle = $battleModel->generateTurnMatch( $sleeves, $players_1, $players_2 );
           
            $battleModel->generateMatchs( $battle, $event_id, $_GET['turn'] );
        
        header ( 'Location:index.php?route=teamMatchs&eventID='.$_GET['eventID'] );
        exit();
    }
    
    public function generateReturnMatchs()
    {
        $battleModel = new \Models\Battle();
        $return_matchs = [];
        
        $exaequo = $battleModel->getMatchWhere( 'event_id = '.$_GET['eventID'].' AND match_sleeve = '.$_GET['turn'].' AND match_exaequo = 1' );
        
        
        foreach( $exaequo as $match )
        {
            $return_matchs[ $match['player_1_user_id']] = $match['player_2_user_id'];
        }
        
        $battleModel->generateMatchs( $return_matchs, $_GET['eventID'], '-'.$_GET['turn'] );
        
        header ( 'Location:index.php?route=individualMatchs&eventID='.$_GET['eventID'].'&return-turn='.$_GET['turn'] );
        exit();
    }
    
    
    public function generateSelectTurn()
    {
        $userModel = new \Models\User();
        $battleModel = new \Models\Battle();
        
        
        $plrs_tab = $battleModel->generatePlrsTab( $users, $players );
        $battle_tab = [];
            
        for( $i = 0; $i < count($plrs_tab[0]); $i++ )
        {
            $battle_tab[ $plrs_tab[0][$i]['user_id'] ] = $plrs_tab[1][$i]['user_id']; 
        }
            
        $battleModel->generateMatchs( $battle_tab, $_GET['eventID'], $_GET['turn'] );
        
        header ( 'Location:index.php?route=individualMatchs&eventID='.$_GET['eventID'] );
        exit();
       
    }
    
    public function generatePool()
    {
        $poolModel = new \Models\Pool();
        $userModel = new \Models\User();
        $battleModel = new \Models\Battle();
        $tournamentModel = new \Models\Tournament();
        
        $tournament = $tournamentModel->getConfig( $_GET['eventID'] );
        
        $battles;
        
        if( isset( $_GET['players'] ) )
        {
            $players = $_GET['players'];
            
            if( $players <= 13 )
            {
                $is_final = 1;
                
                $users = $userModel->getUserWhere( $_GET['eventID'], 'user_victories DESC, user_total_points DESC LIMIT '.$players );
                
    
                for( $i = 0; $i < count($users); $i++ )
                {
                    for( $j = $i+1; $j < count($users); $j++ )
                    {
                        $battles[] = [ $users[$i]['user_id'] => $users[$j]['user_id'] ];
                    }
                }
                
                
                $battleModel->generatePoolMatchs( $battles, $_GET['eventID'], $_GET['pool_turn'], $is_final );
                
                header ( 'Location:index.php?route=individualMatchs&eventID='.$_GET['eventID'] );
                exit();
                
            }
            else
            {
                $first_number = [ 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113, 127, 131, 137, 139, 149, 151, 157, 163, 167, 173, 179, 181, 191, 193, 197 ];
                
                if( in_array( $players, $first_number ) )
                {
                    
                }
                else
                {
                    $event_id = $_GET['eventID'];
                    $users = $userModel->getUserWhere( $_GET['eventID'], 'user_victories DESC, user_total_points DESC LIMIT '.$players );
                    
                    $config = json_decode( $_COOKIE['config'], true);
                    
                    $pools = $config[3]['Nombre de poules de selection'];
                    $players_for_pool = $config[3]['Joueurs par poule'];
                    $total_pool_match = $config[3]['Matchs de poule'];
                    $pool_match = $total_pool_match / $pools;
                    $pools_config = [];
                    
                    if( $config[3]['Matchs de poule'] == $config[4]['Matchs de selection final'])
                    {
                        $turn = 1;
                    }
                    
                    $conditions = ' event_id = '.$event_id.' AND user_victories > 1 AND pool_id IS NULL';
                    
                    //On créé un tableau contenant le nombre de poule choisi dans le formulaire en les identifiant avec le nom de poule qui s'incrémente
                    for( $i = 1; $i <= $pools; $i++ )
                    {
                       ${'pool_'.$i}['name'] = 'pool_'.$i;
                       
                       $pools_config[($i)-1] = ${'pool_'.$i};
                    }
                    
                    //On créé les poules en base de donnée pour chaque element du tableau pools_config
                    for( $p = 0; $p < $pools; $p++ )
                    {
                        $poolModel->addPool([
                                            $event_id,
                                            $pools_config[$p]['name'],
                                            $turn
                                            ]);
                    }
                    
                    
                    //On récupère l'id de la pool à chaque itération
                    //On récupère une liste alétoire limité par le nombre de joueurs par équipe 
                    //On distribue aléatoirement les joueurs dans chaque équipe en faisant un update de pool_id
                    foreach( $pools_config as $pool )
                    {
                        $bdd_pool = $poolModel->getPoolByName( $pool['name'] );
                        
                        $newData = [ 'pool_id' => $bdd_pool['pool_id'] ];
                        
                        $users_for_pool = $userModel->getRandomUserForPool( $conditions, $players_for_pool );
                        
                        foreach( $users_for_pool as $user )
                        {
                            $userModel->updateUser( $newData, $user['user_id'] );
                        }
                    }
                    
                    //On récupère les poules pour générer les matchs
                    $pools_on = $poolModel->getPoolWhere( 'event_id = '.$event_id.' AND pool_turn = '.$turn );
                    $end_pool = [];
                    
                    foreach( $pools_on as $pool )
                    {
                        $end_pool[] = $userModel->getUserByPool( $pool['pool_id'] );
                    }
                    
                    foreach( $end_pool as $pool )
                    {
                        for( $i = 0; $i < count($pool); $i++ )
                        {
                            for( $j = $i+1; $j < count($pool); $j++ )
                            {
                                $battles[] = [ $users[$i]['user_id'] => $users[$j]['user_id'] ];
                            }
                        }
                    }
                    
                    var_dump($end_pool);
                    var_dump($battles);
                
                }
            }
        }
        
    }
 
}    
