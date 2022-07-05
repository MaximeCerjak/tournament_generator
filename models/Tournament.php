<?php

namespace Models;

class Tournament extends Database
{
    public function getConfig( int $event_id )
    {
        return $this->getOne( 'tournament_id, team_tournament, individual_tournament, pool_on, final_on', 'tournaments', 'event_id', $event_id );
    }
    
    public function addTournament( array $data )
    {
        return $this->addOne( 'tournaments', 'event_id, team_tournament, individual_tournament', '?,?,?', $data );
    }
    
}