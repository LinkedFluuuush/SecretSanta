<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class IndexController extends Controller{
    public function showIndex(Request $request, Response $response, $args) {
        global $smarty;
        $smarty->assign("page", "index");
        
        $user = AppUser::findAppUserById(1);
        
        $smarty->assignByRef("user", $user);
        
        $response->getBody()->write($smarty->fetch('index.tpl'));
        
        return $response;
        
    }
}