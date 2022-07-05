<?php

namespace Models;

abstract class Database
{
    private static $_dbConnect;
    
    //Connexion à la base de donnée
    private static function setDb()
    {
        try 
        {
            self::$_dbConnect = new \PDO( 'mysql:host=db.3wa.io;dbname=maximecerjak_smile;charset=utf8', 'maximecerjak', 'b207833bfd1522b6a914bfada6472ae8' );
            self::$_dbConnect->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING );
        } 
        catch(Exception $message)
        {
            echo "Problême de connexion";
        }
    }
 
    protected function getDb()
    {
        
        if( self::$_dbConnect == null )
        {
            self::setDb();
        }
        
        return self::$_dbConnect;
    }
    
    
    
    
////////     CRUD
////////   Requêtes factorisées


    //SELECT
    //Recuperation d'une partie ou de l'ensemble des données d'une table
    protected function getAll( string $columns, string $table ) : array
    {
        $query = $this->getDb()->prepare( "SELECT $columns FROM $table" );
        $query->execute();
        return $query->fetchAll();
    }
    
    protected function getAllWhere( string $columns, string $table, string $condition, int $uniq ) : array
    {
        $query = $this->getDb()->prepare( "SELECT $columns FROM $table WHERE $condition = $uniq" );
        $query->execute();
        return $query->fetchAll();
    }
    
    protected function getAllWhereString( string $columns, string $table, string $string ) : array
    {
        $query = $this->getDb()->prepare( "SELECT $columns FROM $table WHERE $string" );
        $query->execute();
        return $query->fetchAll();
    }
    
    
    //SELECT
    //Récupération d'une liste ordonée avec condition
    protected function getAllInOrderWhere( string $columns, string $table, string $condition, int $uniq, string $order ) : array
    {
        $query = $this->getDb()->prepare( "SELECT $columns FROM $table WHERE $condition = ? ORDER BY $order" );
        $query->execute([$uniq]);
        return $query->fetchAll(); 
    }

    
    //SELECT
    //Recuperation d'une partie ou de l'ensemble des données d'une ligne dans une table (identifiant unique à fournir)
    protected function getOne( string $columns, string $table, string $condition, string $uniq) : array|bool
    {
        $query = $this->getDb()->prepare( "SELECT $columns FROM $table WHERE $condition = ?" );
        $query->execute( [ $uniq ] );
        return $query->fetch(); 
    }
    
    
    //SELECT
    //Recuperation de données par correspondance LIKE (utile pour les requete AJAX)
    protected function getBySearch( string $select, string $table, string $columns, string $condition ) : array
    {
        $query = $this->getDb()->prepare( "SELECT $select FROM $table WHERE $columns LIKE ?");
        $query->execute( [ $condition ] );
        return $query->fetchAll();
    }
    
    //COUNT-SELECT
    //Récupération du nombre d'entrée
    protected function getCountOf( string $table, string $column, string $condition ) : array
    {
        $query = $this->getDb()->prepare( "SELECT COUNT(*) FROM $table WHERE $column = ?" );
        $query->execute( [ $condition ] );
        return $query->fetch();
    }
    
    //RANDOM-SELECT-LIST
    //Récupère une liste d'un certain nombre de ligne défini dans un ordre aléatoire
    protected function getRandomLimitedList( string $columns, string $table, string $conditions, int $limit )
    {
        $query = $this->getDb()->prepare( "SELECT $columns FROM $table WHERE $conditions ORDER BY RAND() LIMIT $limit" );
        $query->execute();
        return $query->fetchAll();
    }
    
    protected function getRandomList( string $columns, string $table, string $conditions )
    {
        $query = $this->getDb()->prepare( "SELECT $columns FROM $table WHERE $conditions ORDER BY RAND()" );
        $query->execute();
        return $query->fetchAll();
    }
    
    
    //SELECT
    //Recuperation d'une partie ou l'ensemble des données d'un élément composant plusieurs tables jointes (identifiant unique à fournir)
    //(A modifier avec explode pour la creation des lignes INNER JOIN l.80)
    protected function getElementByJointsWithCondition( string $columns, string $srcTable, array $joinsTables = [], array $colID = [], string $condition, string $uniq) : array
    {                                                                
        $str = '';                                    
        
        foreach( $joinsTables as $joinTable => $join )    
        {    
            $table = str_replace( $colID, '', $joinTable);
            $str .= "INNER JOIN $table ON $joinTable = $join ";
        }                                           
                                                               
        
        $query = $this->getDb()->prepare("SELECT $columns
                                          FROM $srcTable
                                          $str
                                          WHERE $condition = ?" );
        $query->execute( [ $uniq ] );
        return $query->fetch();
    }
    
    
    //SELECT
    //Recuperation d'une partie ou l'ensemble des données de tables jointes (identifiant unique à fournir)
    //(A modifier avec explode pour la creation des lignes INNER JOIN l.80)
    protected function getElementsByJointsWithCondition( string $columns, string $srcTable, array $joinsTables = [], array $colID = [], string $condition, string $uniq) : array
    {                                                                
        $str = '';                                    
        
        foreach( $joinsTables as $joinTable => $join )    
        {    
            $table = str_replace( $colID, '', $joinTable);
            $str .= "INNER JOIN $table ON $joinTable = $join ";
        }                                           
                                                               
        
        $query = $this->getDb()->prepare("SELECT $columns
                                          FROM $srcTable
                                          $str
                                          WHERE $condition = ?" );
        $query->execute( [ $uniq ] );
        return $query->fetchAll();
    }
    
    
     //SELECT
    //Recuperation d'une partie ou l'ensemble des données de tables jointes sans conditions
    protected function getElementsByJoints( string $columns, string $srcTable, array $joinsTables = [], array $colID = []) : array
    {                                                                
        $str = '';                                    
        
        foreach( $joinsTables as $joinTable => $join )    
        {    
            $table = str_replace( $colID, '', $joinTable);
            $str .= "INNER JOIN $table ON $joinTable = $join ";
        }                                           
                                                               
        
        $query = $this->getDb()->prepare("SELECT $columns
                                          FROM $srcTable
                                          $str" );
        $query->execute();
        return $query->fetchAll();
    }
    
    
    //SELECT
    //Recuperation des trois derniers éléments ajouté à une table avec des données de tables jointes
    protected function getElementsByJointsLimited( string $columns, string $srcTable, array $joinsTables = [], array $colID = [], $order) : array
    {                                                                
        $str = '';                                    
        
        foreach( $joinsTables as $joinTable => $join )    
        {    
            $table = str_replace( $colID, '', $joinTable);
            $str .= "INNER JOIN $table ON $joinTable = $join ";
        }                                           
                                                               
        
        $query = $this->getDb()->prepare("SELECT $columns
                                          FROM $srcTable
                                          $str
                                          ORDER BY $order DESC
                                          LIMIT 3" );
        $query->execute();
        return $query->fetchAll();
    }
    
    
    //SELECT
    //Récupération d'une liste ordonée selon des conditions de plusieurs table
    protected function getOrderedListOfJointsTables( string $columns, string $srcTable, array $joinsTables = [], array $colID = [], string $condition, int $uniq, string $order) : array
    {
        $str = '';                                    
        
        foreach( $joinsTables as $joinTable => $join )    
        {    
            $table = str_replace( $colID, '', $joinTable);
            $str .= "INNER JOIN $table ON $joinTable = $join ";
        }  
        
        $query = $this->getDb()->prepare("SELECT $columns
                                          FROM $srcTable
                                          $str
                                          WHERE $condition = ?
                                          ORDER BY $order" );
        $query->execute( [ $uniq ] );
        return $query->fetchAll();
    }
    
    //INSERT
    //Ajout d'une ligne dans une table
    //Requête pour formulaire
    protected function addOne( string $table, string $columns, string $values, array $data ) : void
    {
       $query = $this->getDb()->prepare( "INSERT INTO $table ( $columns ) VALUES ( $values )" );
       $query->execute( $data );
    }
    
    
    //UPDATE
    //Modification d'une ligne dans une table (identifiant unique à fournir)
    protected function updateOne( string $table, array $newData, string $condition, string $uniq) : void
    {
       $sets = '';
        
        foreach( $newData as $key => $value )
        {
            $sets .= "$key = :$key,";
        }
       
        $sets = substr( $sets, 0, -1 );
       
        
        $query = $this->getDb()->prepare( " UPDATE $table SET $sets WHERE $condition = :$condition" );
        
        foreach( $newData as $key => $value )
        {
            $query->bindValue( ":$key", $value );
        }
       
        
        $query->bindValue( ":$condition", $uniq );
        $query->execute();
    }
    
    
    
    //DELETE
    //Suppression d'un element (identifiant unique à fournir)
    protected function deleteOne( string $table, string $condition, string $uniq ) : void
    {
       $query = $this->getDb()->prepare( "DELETE FROM $table WHERE $condition = ?" );
       $query->execute( [ $uniq ] );
    }
                                         
    
    //DELETE
    //Tentative de suppression par jointure (à voir avec le build de la bdd)
    protected function deleteChildJoin( string $srcTable, array $joinsTables = [], array $colID = [], string $condition, string $uniq) : void
    {
        $deleteStr = 'DELETE ';
        $innerStr = '';
        
         foreach( $joinsTables as $joinTable => $join )    
        {    
            $table = str_replace( $colID, '', $joinTable);
            $deleteStr .= $table . ', ';
            $innerStr .= "INNER JOIN $table ON $joinTable = $join ";
        } 
        
        $deleteStr = substr( $deleteStr, 0, -2 );
        
        $query = $this->getDb()->prepare("DELETE $deleteStr
                                            FROM $srcTable 
                                            $innerStr
                                            WHERE $condition = ?");
        $query->execute( [ $uniq ] );                                    
    }
    
}