<?php

    class LeagueController extends Controller
    {
        public function __construct()
        {
            $this->league = model('LeagueModel');
        }

        public function index()
        {
            $matchesSummaries = $this->league->getMatchesSummary();

            // $champions = $this->league->getChampions([
            //     'name',
            //     'title',
            //     'tags',
            // ],true);

            $data = [
                'topFivePopular' => $this->league->fetchTopChampions($matchesSummaries , 5),
                'imageSrc'   => $this->league->image_link
            ];

            return $this->view('lol/index' , $data);
        }
    }