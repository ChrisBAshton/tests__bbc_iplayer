<?php

class AZGetter {

    public function index($f3, $params) {
        $f3->set('content','index.html');
        echo View::instance()->render('layout.html');
    }

    public function letter($f3, $params) {
        $this->displayLetterListing($params['letter']);
    }

    public function letterAndPage($f3, $params) {
        $letter = $params['letter'];
        $pageNumber = (int) $params['pageNumber'];

        if ($pageNumber < 2) {
            header('Location: /letters/' . $letter);
        }
        else {
            $this->displayLetterListing($letter, $pageNumber);
        }
    }

    private function displayLetterListing($letter, $pageNumber = 1) {
        global $f3;

        $feed = $this->getApiResults($letter, $pageNumber);
        $f3->set('content','letter.html');
        $f3->set('letter',     $letter);
        $f3->set('pageNumber', $pageNumber);
        $f3->set('feed',       $feed);
        $this->calculatePagination($feed, $pageNumber);

        echo View::instance()->render('layout.html');
    }

    private function getApiResults($letter, $pageNumber) {
        $jsonUrl = 'https://ibl.api.bbci.co.uk/ibl/v1/atoz/' . $letter . '/programmes?page=' . $pageNumber;
        $feed = file_get_contents($jsonUrl);
        $feed = json_decode($feed);
        $feed = $feed->atoz_programmes; // make accessing a little simpler
        return $feed;
    }

    private function calculatePagination($feed, $pageNumber) {
        global $f3;
        $showPrev = $pageNumber > 1;
        $showNext = ($feed->count / $feed->per_page) > $pageNumber;
        $f3->set('showPrev', $showPrev);
        $f3->set('showNext', $showNext);
    }

}