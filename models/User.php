<?php

namespace Models;

class User extends Database
{
    public function getUserById( int $getID )
    {
        return $this->getOne( 'user_pseudo', 'users', 'user_id', $getID );
    } 
    
    public function getRandomIdList( int $getID )
    {
        return $this->getAllWhere( 'user_random_id', 'users', 'event_id', $getID );
    }
    
    public function getUserWhere( int $event_id, string $order )
    {
        return $this->getAllInOrderWhere( 'user_id', 'users', 'event_id', $event_id, $order );
    }
    
    public function getUserWhereString( string $conditions )
    {
        return $this->getAllWhereString( 'user_id, pool_id', 'users', $conditions );
    }
    
    public function getUserByEventOrderedByTeam( int $event_id )
    {
        return $this->getAllInOrderWhere( 'user_id, team_id', 'users', 'event_id', $event_id, 'team_id ASC' );
    }
    
    public function getRandomUserList( string $conditions )
    {
        return $this->getRandomList( 'user_id, event_id', 'users', $conditions );
    }
    
    public function getRandomUserLimitedList( string $conditions, int $limit )
    {
        return $this->getRandomLimitedList( 'user_id, user_firstname, user_lastname, user_pseudo', 'users', $conditions, $limit );
    }
    
    public function getRandomUserForPool( string $conditions, int $limit )
    {
        return $this->getRandomLimitedList( 'user_id, pool_id', 'users', $conditions, $limit );
    }
    
    public function getCountOfUserByEvent( int $getID )
    {
        return $this->getCountOf( 'users', 'event_id', $getID );
    }
    
    public function getUserByTeam( int $team_id )
    {
        return $this->getAllWhere( '*', 'users', 'team_id', $team_id );
    }
    
    public function getUserByPool( int $pool_id )
    {
        return $this->getAllWhere( 'user_id, user_pseudo', 'users', 'pool_id', $pool_id );
    }
    
    public function getUserByEvent( int $uniq )
    {
        $joinsTables =
            [
                'users.event_id' => 'events.event_id'
            ];
        
        $colID = [ '.event_id' ];
        
        
        return $this->getElementsByJointsWithCondition( 'user_id, user_random_id, user_firstname, user_lastname, user_pseudo, team_id', 'events', $joinsTables, $colID, 'events.event_id', $uniq );
    }
    
    public function getUserByEventOrderedByRandomId( int $uniq )
    {
        return $this->getAllInOrderWhere( 'user_id, user_random_id, user_firstname, user_lastname, user_pseudo, team_id', 'users', 'event_id', $uniq, 'user_random_id ASC' );
    }
    
    public function getUserRank( int $event_id ) : array
    {
        return $this->getAllInOrderWhere( 'user_id, user_firstname, user_lastname, user_pseudo, user_total_points, user_victories, team_id', 'users', 'event_id', $event_id, 'user_victories DESC, user_total_points DESC' );
    }
    
    public function getUserRankByTeamRank( int $event_id )
    {
        $joinsTables = 
        [
            'teams.team_id' => 'users.team_id'
        ];
        
        $colID = [ '.team_id' ];
        
        return $this->getOrderedListOfJointsTables( 'user_id, users.team_id, users.event_id', 'users', $joinsTables, $colID, 'users.event_id', $event_id, "teams.team_victories DESC, teams.total_matchs_points DESC, users.user_victories DESC, users.user_total_points DESC" );
    }
    
    public function getPoints( int $user_id )
    {
        return $this->getOne( 'user_total_points', 'users', 'user_id', $user_id );
    }
    
    public function getVictories( int $user_id )
    {
        return $this->getOne( 'user_victories', 'users', 'user_id', $user_id );
    }
    
    
    public function insertUser( array $data )
    {
        return $this->addOne( "users", "user_random_id, user_firstname, user_lastname, user_pseudo, user_email, event_id", "?,?,?,?,?,?", $data );
    }
    
     public function updateUser( array $newData, int $getID )
    {
        $this->updateOne( 'users', $newData, 'user_id', $getID);
    }
    
    public function deleteUser( int $getID )
    {
        return $this->deleteOne( "users", "user_id", $getID);
    }
    
}    
 