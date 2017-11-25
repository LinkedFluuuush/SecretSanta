<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Smarty as Smarty;

session_start();

require '../vendor/autoload.php';
require('../smarty/Smarty.class.php');

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


$smarty = new Smarty();

$smarty->setTemplateDir('./templates');
$smarty->setCompileDir('../smarty/templates_c');
$smarty->setCacheDir('../smarty/cache');
$smarty->setConfigDir('../smarty/configs');

$smarty->assign("current_page", $_SERVER['REQUEST_URI']);

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('AppLogger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    return Database::getInstance();
};

$container['conf'] = function ($c) {
    /** @var Config $config */
    $config = new Config("../config/dbConfig.ini");
    $config->addIni("../config/security.ini");
    return $config;
};

$container['IndexController'] = function ($container) {
    return new IndexController($container);
};


$app->get('/', IndexController::class.':showIndex');

$app->post('/login', UserController::class.':doLogin');

$app->get('/login', UserController::class.':showLogin');

$app->get('/logout', UserController::class.':doLogout');

$app->get('/hello/{name}', function (Request $request, Response $response) {
    global $smarty;
    $smarty->assign("page", "hello");
    
    $name = $request->getAttribute('name');
    
    $smarty->assign('name', $name);
    
    $response->getBody()->write($smarty->fetch('building.tpl'));
    
    $this->logger->addInfo("Something interesting happened");
    return $response;
});

$app->run();
