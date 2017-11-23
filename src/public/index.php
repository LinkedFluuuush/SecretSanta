<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Smarty as Smarty;

require '../vendor/autoload.php';
require('../smarty/Smarty.class.php');

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "localhost:3306";
$config['db']['user']   = "root";
$config['db']['pass']   = "root@123";
$config['db']['dbname'] = "";

$smarty = new Smarty();

$smarty->setTemplateDir('../smarty/templates');
$smarty->setCompileDir('../smarty/templates_c');
$smarty->setCacheDir('../smarty/cache');
$smarty->setConfigDir('../smarty/configs');

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('AppLogger');
    $file_handler = new \Monolog\Handler\StreamHandler("../logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$app->get('/', function (Request $request, Response $response) {
    global $smarty;
    
    $response->getBody()->write($smarty->fetch('index.tpl'));
    
    return $response;
});

$app->get('/hello/{name}', function (Request $request, Response $response) {
    global $smarty;
    $name = $request->getAttribute('name');
    
    $smarty->assign('name', $name);
    
    $response->getBody()->write($smarty->fetch('building.tpl'));
    
    $this->logger->addInfo("Something interesting happened");
    return $response;
});

$app->run();
