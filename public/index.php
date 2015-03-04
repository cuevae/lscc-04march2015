<?php

require_once "../vendor/autoload.php";

use Silex\Application;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

$app = new Application();

$app->get('/', function(Request $request, Application $app){

    $question = $request->get('q');
// ?q=49c14a70:%20which%20of%20the%20following%20numbers%20is%20the%20largest:%2052,%20812


    $var = explode(':', $question);
    $numbers = explode(',', $var[2]);

    return new Response(max($numbers));
});

$app->run();