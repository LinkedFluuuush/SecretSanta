<?php 
class AppUser extends Entity {

    protected $appUserId;
    protected $appUserName;
    protected $appUserFirstname;
    protected $appUserMail;
    
    public static function findAppUserById($id){
        $sql = "SELECT APP_USER_ID, APP_USER_NAME, APP_USER_FIRSTNAME, APP_USER_MAIL FROM APP_USER WHERE APP_USER_ID = :id";
        
        /** @var \Database $database */
        $database = Controller::$deps->db;
        
        $rowUser = $database->getAssoc($sql, array(
            ":id" => $id
        ));
        
        $appUser = new AppUser($rowUser);
        
        return $appUser;
    }
    
}