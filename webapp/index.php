<?php
date_default_timezone_set('Europe/London');

require_once __DIR__ . '/autoload.php';
$f3 = \Base::instance();
$f3->config('f3_config.ini');

$routes = array(
    'GET  /' => function ($f3, $params) {
        $f3->set('content','index.html');
        echo View::instance()->render('layout.html');
    },

    'GET /letters' => function () {
        header ('Location: /');
    },

    'GET /letters/@letter' => function ($f3, $params) {
        $letter = $params['letter'];
        displayLetterListing($params['letter']);
    },

    'GET /letters/@letter/@pageNumber' => function ($f3, $params) {
        $letter = $params['letter'];
        $pageNumber = (int) $params['pageNumber'];
        if ($pageNumber < 2) {
            header('Location: /letters/' . $letter);
        }
        displayLetterListing($letter, $pageNumber);
    }
);

function displayLetterListing($letter, $pageNumber = 1) {
    global $f3;

    $jsonUrl = 'https://ibl.api.bbci.co.uk/ibl/v1/atoz/' . $letter . '/programmes?page=' . $pageNumber;
    $feed = file_get_contents($jsonUrl);
    $feed = json_decode($feed);
    $feed = $feed->atoz_programmes; // make accessing a little simpler
    $showPrev = $pageNumber > 1;
    $showNext = ($feed->count / $feed->per_page) > $pageNumber;

    $f3->set('content','letter.html');
    $f3->set('letter',     $letter);
    $f3->set('pageNumber', $pageNumber);
    $f3->set('showPrev',   $showPrev);
    $f3->set('showNext',   $showNext);
    $f3->set('feed',       $feed);

    echo View::instance()->render('layout.html');
}

foreach($routes as $request => $handler) {
    $f3->route($request, $handler);
}

$f3->run();