<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class UserController extends Controller{
    public function doLogin(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();

        $request->getAttribute('redirect');

        if(isset($_SESSION['user'])){
            Controller::$logger->addWarning("User tried to connect while already connected");
            return $response->withRedirect($data['redirect'], 302);
        } else {
            $user = AppUser::findAppUserByMail($data['mail']);
            
            if(!$user){
                return $response->withRedirect('/login?error=incorrectLoginOrPassword', 302);
            } else {
                if(password_verify($data['password'], $user->getAppUserPasswd())){
                    $options = array(
                        "cost" => Controller::$conf->getConfig("password", "cost")
                    );
                    
                    if (password_needs_rehash($user->getAppUserPasswd(), PASSWORD_DEFAULT, $options)) {
                        $newPasswd = password_hash($user->getAppUserPasswd(), PASSWORD_DEFAULT, $options);
                        $user->setAppUserPasswd($newPasswd);
                        $user->save();
                    }
                    
                    $_SESSION['user'] = $user->getAppUserId();
                    return $response->withRedirect($data['redirect'], 302);
                } else {
                    return $response->withRedirect('/login?error=incorrectLoginOrPassword', 302);
                }
            }
        }
    }
    
    public function doLogout(Request $request, Response $response, $args) {
        unset($_SESSION['user']);
        return $response->withRedirect('/', 302);
    }
    
    public function showLogin(Request $request, Response $response, $args) {
        if(isset($_SESSION['user'])){
            return $response->withRedirect('/', 302);
        }
        
        global $smarty;
        $smarty->assign("page", "login");
        
        $queryParams = $request->getQueryParams();
        if(isset($queryParams['error'])){
            $smarty->assign("error", $queryParams['error']);
        }
        
        $response->getBody()->write($smarty->fetch("login.tpl"));
        
        return $response;
    }
}