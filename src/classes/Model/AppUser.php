<?php
/**
 * @method int      getAppUserId()
 * @method void     setAppUserId(integer $id)
 * @method String      getAppUserName()
 * @method void     setAppUserName(String $name)
 * @method String      getAppUserFirstname()
 * @method void     setAppUserFirstname(String $firstname)
 * @method String      getAppUserMail()
 * @method void     setAppUserMail(String $mail)
 * @method String      getAppUserPasswd()
 * @method void     setAppUserPasswd(String $passwd)
 * @author linke
 *
 */
class AppUser extends Entity {

    protected $appUserId;
    protected $appUserName;
    protected $appUserFirstname;
    protected $appUserMail;
    protected $appUserPasswd;
    
    public function save(){
        $sql = "INSERT INTO APP_USER (APP_USER_ID, APP_USER_NAME, APP_USER_FIRSTNAME, APP_USER_MAIL, APP_USER_PASSWD) 
            VALUES(:id, :name, :firstname, :mail, :passwd) ON DUPLICATE KEY UPDATE
                APP_USER_NAME = :name
                APP_USER_FIRSTNAME = :firstname
                APP_USER_MAIL = :mail
                APP_USER_PASSWD = :passwd";
        
        /** @var \Database $database */
        $database = Controller::$deps->db;
        
        $database->execute($sql, array(
            ":id"           => $this->getAppUserId(),
            ":name"         => $this->getAppUserName(),
            ":firstname"    => $this->getAppUserFirstname(),
            ":mail"         => $this->getAppUserMail(),
            ":passwd"       => $this->getAppUserPasswd()
        ));
    }
    
    public static function findAppUserById($id){
        $sql = "SELECT APP_USER_ID, APP_USER_NAME, APP_USER_FIRSTNAME, APP_USER_MAIL, APP_USER_PASSWD FROM APP_USER WHERE APP_USER_ID = :id";
        
        /** @var \Database $database */
        $database = Controller::$deps->db;
        
        $rowUser = $database->getAssoc($sql, array(
            ":id" => $id
        ));
        
        $appUser = new AppUser($rowUser);
        
        return $appUser;
    }
    
    public static function findAppUserByMail($mail){
        $sql = "SELECT APP_USER_ID, APP_USER_NAME, APP_USER_FIRSTNAME, APP_USER_MAIL, APP_USER_PASSWD FROM APP_USER WHERE APP_USER_MAIL = :mail";
        
        /** @var \Database $database */
        $database = Controller::$deps->db;
        
        $rowUser = $database->getAssoc($sql, array(
            ":mail" => $mail
        ));
        
        $appUser = new AppUser($rowUser);
        
        return $appUser;
    }
}