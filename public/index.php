<?php

require_once "../vendor/autoload.php";

use Silex\Application;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

$app = new Application();

$app->get('/', function(Request $request, Application $app){

    $question = $request->request->get('q');

    return new Response('Shez');
});

$app->run();