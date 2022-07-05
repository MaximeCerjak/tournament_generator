<?php

namespace Models;

class Team extends Database
{
    public function getTeamByName( string $uniq ) : array
    {
        return $this->getOne( 'team_id', 'teams', 'team_name', $uniq );
    }
    
    public function getTeamVictories( int $teamID ) : array
    {
        return $this->getOne( 'team_victories', 'teams', 'team_id', $teamID );
    }
    
    public function getTeamPoints( int $teamID ) : array
    {
        return $this->getOne( 'total_matchs_points', 'teams', 'team_id', $teamID );
    }
    
    public function getTeamRank( int $event_id ) : array
    {
        return $this->getAllInOrderWhere( 'team_id, team_name, team_victories, total_matchs_points', 'teams', 'event_id', $event_id, 'team_victories DESC, total_matchs_points DESC' );
    }
    
    public function addTeam( array $data )
    {
        return $this->addOne( 'teams', 'event_id, team_name', '?,?', $data);
    }
    
    public function updateScore( array $newData, int $teamID )
    {
        return $this->updateOne( 'teams', $newData, 'team_id', $teamID );
    }
}