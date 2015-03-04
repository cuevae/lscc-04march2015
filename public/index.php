<?php

require_once "../vendor/autoload.php";

use Silex\Application;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

$app = new Application();

$app->get('/', function (Request $request, Application $app) {

    $question = $request->get('q');

    if (preg_match('/which of the following numbers is the largest/', $question) > 0) {
        $var     = explode(':', $question);
        $numbers = explode(',', $var[2]);
        return new Response(max($numbers));
    } elseif (preg_match_all('/[0-9a-z]+: what is (\d+) plus (\d+)/', $question, $matches) > 0) {
        array_shift($matches);
        $numbers = array_reduce($matches, function($result, $item){
            $result[] = intval($item[0]);
            return $result;
        }, array());
        return new Response(array_sum($numbers));
    }

});

$app->run();