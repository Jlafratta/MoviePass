<?php namespace DAO;

use Models\Usuario as User; 
use Models\PerfilUsuario as PerfilUsuario; 
use Models\Rol as Rol; 
use DAO\Connection as Connection;
use \Exception as Exception;


class UserDAOPDO extends Helper {

    private $connection;  
    
   
    public function GetByEmail ($Email){
     
     try{

      $query =" select U.Email , 
      U.Password ,
      R.Description , 
      PU.FirstName ,
      PU.LastName ,
      PU.DNI 
      from Users as U 
      left join Profile_Users as PU 
      on PU.Id =U.Profile_UserId 
      left join Rol as R 
      on R.Id = U.RolId
      where U.Email= ". "'".$Email."' ;";
     
      
    $this-> connection=Connection::GetInstance();
    $resultSet=$this->connection->Execute($query);
    $user=new User();
    $user=null;
    foreach ($resultSet as $row)
    {                
         $rol =New Rol();
    $rol->setDescripcion($row["Description"]);

    $perfilUsuario=New PerfilUsuario();
    $perfilUsuario->setFirstName($row["FirstName"]);
    $perfilUsuario->setLastName($row["LastName"]);
    $perfilUsuario->setDni($row["DNI"]);
    
    $user=new User();
    
    $user->setEmail($row["Email"]);
    $user->setPassword($row["Password"]);
    $user->setPerfilUsuario($perfilUsuario);
    $user->setRol($rol);
    }
    
    return $user; 

     }
     catch(Exception $e)
      {
         throw $e;
      }
    }

    public function AddProfile($profileUser,$UserId)
    {
        try{


            $query ="INSERT INTO Profile_Users (UserId,FirstName,LastName,DNI) Values (:UserId, :FirstName, :LastName, :DNI);";
            $parameters["UserId"]=$UserId;
             $parameters["FirstName"] = $profileUser->getFirstName();
             $parameters["LastName"] = $profileUser->getLastName();
             $parameters["DNI"] =$profileUser->getDni();

             $this->connection = Connection::GetInstance();                
             $this->connection->ExecuteNonQuery($query, $parameters);
             
          }
          catch(Exception $EX){
              throw $EX;
   
          }
    }
    
    public function Add($User)
    {
       try{
         $query ="INSERT INTO Users (Email,Password,RolId,Profile_UserId) Values (:Email, :Password, :RolId, :Profile_UserId);";
          $parameters["Email"] = $User->getEmail();
          $parameters["Password"] = $User->getPassword();
          $parameters["RolId"] =2; // 2 PARA USER
          $parameters["Profile_UserId"] =$this->IdProfileInsert();

         
          $this->connection = Connection::GetInstance();                
          $this->connection->ExecuteNonQuery($query, $parameters);
       
          $this->AddProfile($User->getPerfilUsuario(),$this->IdProfileInsert());
         
          

          
       }
       catch(Exception $EX){
           throw $EX;

       }
    }


    public function IdProfileInsert()
    { try{

     $query="select AUTO_INCREMENT FROM information_schema.TABLES where TABLE_SCHEMA = "."'"."MoviePass"."'"." and TABLE_NAME= "."'"."Profile_Users"."'".";";
     $this-> connection=Connection::GetInstance();
    $result=$this->connection->Execute($query);
     
    foreach ($result as $row)
    {
        $Id=$row["AUTO_INCREMENT"];
    }
   
    return $Id;

    }
    catch (Exception $e)
    {
        throw $e;
    }

    }
   

}



?>