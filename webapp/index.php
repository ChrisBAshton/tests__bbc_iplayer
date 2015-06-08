<?php
date_default_timezone_set('Europe/London');

require_once __DIR__ . '/autoload.php';
$f3 = \Base::instance();
$f3->config('f3_config.ini');

$routes = array(
    'GET  /' => 'AZGetter->index',

    'GET /letters' => function () {
        header ('Location: /');
    },

    'GET /letters/@letter' => 'AZGetter->letter',

    'GET /letters/@letter/@pageNumber' => 'AZGetter->letterAndPage'
);

foreach($routes as $request => $handler) {
    $f3->route($request, $handler);
}

$f3->run();