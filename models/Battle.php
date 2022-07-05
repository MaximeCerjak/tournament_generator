<?php

namespace Models;

class Battle extends Database
{
    public function getMatchs( int $uniq )
    {
        $joinsTables =
            [
                'events.event_id' => 'matchs.event_id'
            ];
        
        $colID = [ '.event_id' ];
        
    
        return $this->getElementsByJointsWithCondition( 'event_name, match_id, match_sleeve, match_pool_sleeve, match_final, player_1_user_id, player_2_user_id, score_player_1, score_player_2, match_winner, match_looser, match_exaequo', 'matchs', $joinsTables, $colID, 'matchs.event_id', $uniq );
    }
    
    public function getMatchsByTurn( int $event_id, int $turn )
    {
        $str = 'event_id = '.$event_id.' AND match_sleeve = '.$turn;
        
        return $this->getAllWhereString( 'match_id, match_sleeve, match_pool_sleeve, match_final, player_1_user_id, player_2_user_id, score_player_1, score_player_2, match_winner, match_looser, match_exaequo', 'matchs', $str );
    }
    
    public function getMatchsByPoolTurn( int $event_id, int $pool_turn )
    {
        $str = 'event_id = '.$event_id.' AND match_pool_sleeve = '.$pool_turn;
        
        return $this->getAllWhereString( 'match_id, match_sleeve, match_pool_sleeve, match_final, player_1_user_id, player_2_user_id, score_player_1, score_player_2, match_winner, match_looser, match_exaequo', 'matchs', $str );
    }
    
    public function getMatchWhere( string $string )
    {
        return $this->getAllWhereString( 'match_id, match_sleeve, match_pool_sleeve, match_final, player_1_user_id, player_2_user_id', 'matchs', $string );
    }
    
    
    public function insertMatch( array $data )
    {
        return $this->addOne( 'matchs', 'event_id, match_sleeve, player_1_user_id, player_2_user_id', '?,?,?,?',  $data );
    }
    
    public function insertPoolMatch( array $data )
    {
        return $this->addOne( 'matchs', 'event_id, match_pool_sleeve, match_final, player_1_user_id, player_2_user_id', '?,?,?,?,?',  $data );
    }
    
    public function updateScore( array $newData, int $matchID )
    {
        return $this->updateOne( 'matchs', $newData, 'match_id', $matchID );
    }
    
    
    public function turnEnd( array $match_list )
    {
        $count = 0;
        $resultat;
        
        foreach( $match_list as $match )
        {
            if( $match['match_winner'] != NULL && $match['match_looser'] != NULL )
            {
                $count++;
            }
            elseif( $match['match_exaequo'] == 1 )
            {
                $count++;
            }
        }
        if( $count == count($match_list) )
        {
            $resultat = true;
        }
        else
        {
            $resultat = false;
        }
        
        return $resultat;
        
    }
    
    
     public function generatePlrsTab( array $users, int $players_nbr )
    {
        $plrs_1 = [];
        $plrs_2 = [];
        
        for( $i = 0; $i < $players_nbr; $i++ )
        {
             if( $i % 2 == 0 )
             {
                 $plrs_1[] = $users[$i];
             }
             else
             {
                 $plrs_2[] = $users[$i];
             }
        }
        
      return array($plrs_1, $plrs_2);  
      
    }
    
    
   public function generateTurnMatch( int $matchs, array $tab_1, array $tab_2 )
    {
        $battle = [];
        
            for( $i = 0; $i < $matchs; $i++)
            {
                if( count($tab_1) == 0 )
                {
                    break;    
                }
                else
                {
                    if( $tab_1[0]['team_id'] == $tab_2[0]['team_id'] )
                    {
                        foreach( $tab_2 as $tab )
                        {
                            if( $tab_1[0]['team_id'] != $tab['team_id'] )
                            {
                                $battle[$tab_1[0]['user_id']] = $tab['user_id'];
                                array_shift( $tab_1 );
                                array_shift( $tab );
                            }
                            else
                            {
                                continue;
                            }
                        }
                    }
                    else
                    {
                        $battle[$tab_1[0]['user_id']] = $tab_2[0]['user_id'];
                        array_shift( $tab_1 );
                        array_shift( $tab_2 );        
                    }
                }    
            }
            
        return $battle;
    }
    
    
    public function generateMatchs( array $sleeve_matchs, int $event, int $turn )
    {
        
        
        foreach( $sleeve_matchs as $key => $value )
            {
                $player_1_id = $key;
                $player_2_id = $value;
               
               
                $this->insertMatch([
                                    $event,
                                    $turn,
                                    $player_1_id,
                                    $player_2_id
                                    ]);
            }
    }
    
    public function generatePoolMatchs( array $sleeve_matchs, int $event, int $pool_turn, int $is_final )
    {
        
        foreach( $sleeve_matchs as $match )
        {
            foreach( $match as $key => $value )
            {
                $player_1_id = $key;
                $player_2_id = $value;
               
               
                $this->insertMatch([
                                    $event,
                                    $pool_turn,
                                    $is_final,
                                    $player_1_id,
                                    $player_2_id
                                    ]);   
            }
        }
    }
    
}    
 