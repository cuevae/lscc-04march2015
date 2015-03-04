<?php

require_once "../vendor/autoload.php";

use Silex\Application;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

$app = new Application();

function isSqr($number)
{
    $res = sqrt($number);
    return strpos($res, '.') === false;
}

function isCube($number)
{
    $res = pow($number, 1 / 3);
    return strpos($res, '.') === false;
}

$app->get('/', function (Request $request, Application $app) {

    $question = $request->get('q');

    if (preg_match('/which of the following numbers is the largest/', $question) > 0) {
        $var     = explode(':', $question);
        $numbers = explode(',', $var[2]);
        return new Response(max($numbers));
    } elseif (preg_match_all('/[0-9a-z]+: what is (\d+) plus (\d+)/', $question, $matches) > 0) {
        array_shift($matches);
        $numbers = array_reduce($matches, function ($result, $item) {
            $result[] = intval($item[0]);
            return $result;
        }, array());
        return new Response(array_sum($numbers));
    } elseif (preg_match_all('/[0-9a-z]+: what is (\d+) multiplied by (\d+)/', $question, $matches) > 0) {
        array_shift($matches);
        $number = array_reduce($matches, function ($result, $item) {
            $result *= intval($item[0]);
            return $result;
        }, 1);
        return new Response($number);
    } elseif (preg_match_all('/[0-9a-z]+: what currency did Spain use before the Euro/', $question) > 0) {
        return new Response('Peseta');
    } elseif (preg_match_all('/[0-9a-z]+: who is the Prime Minister of Great Britain/', $question) > 0) {
        //62.172.95.210 - - [04/Mar/2015:14:30:49 -0600] "GET /?q=448627b0: who is the Prime Minister of Great Britain HTTP/1.1" 200 161 "-" "-"
        return new Response('David Cameron');
    } elseif (preg_match_all('/[0-9a-z]+: which city is the Eiffel tower in/', $question) > 0) {
        return new Response('Paris');
    } else {
        $var     = explode(':', $question);
        $numbers = explode(',', $var[2]);

        $flag = 0;
        foreach ($numbers as $number) {
            if (isSqr($number)
                && isCube($number)
            ) {
                $flag = 1;
                return new Response($number);
            }
        }

        if (!$flag) {
            return new Response();
        }
    }

});

$app->run();