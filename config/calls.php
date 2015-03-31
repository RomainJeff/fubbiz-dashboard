<?php

$app->after(function (Symfony\Component\HttpFoundation\Request $request, Symfony\Component\HttpFoundation\Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
});
