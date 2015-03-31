<?php

/**
 *
 * Error Handler
 * Permet d'attraper les erreurs,
 * de les logger et de les formater
 *
 */
$app->error(function(\Exception $e, $code) use ($app) {
    $message = "Une erreur inconnue est survenue";

    if ($e->getMessage() != null) {
        $message = $e->getMessage();
    }

    return new Symfony\Component\HttpFoundation\Response(
        json_encode([
            'message'    => $message,
            'code'       => $code
        ], JSON_PRETTY_PRINT),
        $code,
        ['Content-type' => 'application/json']
    );
});
