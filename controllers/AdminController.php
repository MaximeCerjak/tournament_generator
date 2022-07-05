<?php

namespace Controllers;

class AdminController
{
     public function logIn()
    {
        $adminModel = new \Models\Admin();
        
        if( isset( $_POST['idAdmin'] ) && isset( $_POST['password'] ) )
        {
            $idAdmin = $_POST['idAdmin'];
            $admin = $adminModel->getAdminByName( $idAdmin );
            
            if( $admin )
            {

                if( password_verify( $_POST['password'], $admin['admin_password'] ) )
                {
                    if( $admin['admin_role'] == 2 )
                    {
                        $_SESSION['admin'] = $admin;
                        
                        header('location:index.php?route=backAE&connect=true&adminID='.$admin['admin_id']);
                        exit;
                        
                    } 
                    elseif ( $admin['admin_role'] == 1 )
                    {
                        
                        $_SESSION['superAdmin'] = $admin;
                        header('location:index.php?route=backSA&connect=true');
                        exit;
                        
                    }
                }
                else 
                {
                    var_dump( $admin );
                    header('location:index.php?route=logIn&passError=true');
                    exit;
                }
            }
            else 
            {
                var_dump( $admin );
                header('location:index.php?route=logIn&sessionError=true');
                exit;
            }
        }
        else 
        {
            var_dump( $admin );
            header('location:index.php?route=logIn&idError=true');
            exit;
        }
    }
        
    
    public function disconnect()
    {
        session_destroy();
        
        header('location:index.php?route=logIn');
        exit;
    }
}