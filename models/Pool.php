<?php

namespace Models;

class Pool extends Database
{
    public function getPoolWhere( string $string ) : array
    {
       return $this->getAllWhereString( 'pool_id, pool_name, pool_turn', 'pools', $string ); 
    }
    
    public function getPoolByName( string $uniq ) : array
    {
        return $this->getOne( 'pool_id', 'pools', 'pool_name', $uniq );
    }
    
    public function addPool( array $data )
    {
        return $this->addOne( 'pools', 'event_id, pool_name, pool_turn', '?,?,?', $data);
    }
    
}