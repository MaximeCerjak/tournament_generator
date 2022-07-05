<?php

namespace Models;

class Event extends Database
{
 
    public function getEvents()
    {
        return $this->getAll( "event_name, event_company, event_id, event_start, event_end", "events" );
    }
    
    public function getEvent( $uniq )
    {
        return $this->getOne( "event_name, event_company, event_id, event_start, event_end, admin_id, is_on_tournament", "events", "event_id", $uniq );
    }
    
    public function getEventByAdmin( $uniq )
    {
        return $this->getOne( "event_name, event_company, event_id, event_start, event_end, admin_id, is_on_tournament", "events", "admin_id", $uniq );
    }
    
    public function insertEvent(array $data)
    {
        return $this->addOne("events", "admin_id, event_name, event_company, event_start, event_end", "?,?,?,?,?", $data );
    }
    
    public function editEvent(array $newData, $getID)
    {
        $this->updateOne( 'events', $newData, 'event_id', $getID);
    }
    
    public function deleteEvent( $getID )
    {
        return $this->deleteOne( "events", "event_id", $getID );
    }
    
}    