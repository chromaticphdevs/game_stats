<?php

    class LeagueController extends Controller
    {
        public function __construct()
        {
            $this->league = model('LeagueModel');
        }


        public function show($championName)
        {
            $champion = $this->league->getChampion($championName);
            
            $data = [
                'champion' => $champion->$championName,
                'imgSrc'   => $this->league->image_link,
            ];

            return $this->view('lol/show' , $data);
        }


        public function index()
        {
            $matchesSummaries = $this->league->getMatchesSummary();

            $champions = $this->league->getChampions([
                'name',
                'title',
                'tags',
            ],true);

            $data = [
                'topFivePopular' => $this->league->fetchTopChampions($matchesSummaries , 10),
                'imageSrc'   => $this->league->image_link,
                'champions'  => $champions
            ];

            return $this->view('lol/index' , $data);
        }
    }