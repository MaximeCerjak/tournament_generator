<?php

namespace Models;

class Admin extends Database
{
    public function getAdminById( $uniq ) : array
    {
        return $this->getOne( "admin_id, admin_name", "admins", "admin_id", $uniq );
    }
    
    public function getAdminByName( $name ) : array
    {
        return $this->getOne( "admin_id, admin_name, admin_password, admin_role", "admins", "admin_name", $name );
    }
    
    public function insertAdmin( array $data) 
    {
        return $this->addOne( "admins", "admin_name, admin_password", "?,?", $data );
    }
    
    public function editAdmin(array $newData, $getID) : void 
    {
        $this->updateOne( 'admins', $newData, 'admin_id', $getID);
    }
}