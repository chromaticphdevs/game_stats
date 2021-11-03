<?php

    class LeagueBalancerController extends Controller
    {
        public function __construct()
        {
            $this->balancer = model('LeagueBalancerModel');
            $this->league = model('LeagueModel');
        }

        public function index()
        {
            $matchesSummary = $this->league->getMatchesSummary();
            $topTenPopularChampions = $this->league->fetchTopChampions($matchesSummary , 10);
            
            $topTenPopularChampionsComplete = $this->league->appendChampionDetailComplete($topTenPopularChampions);
            $balances = $this->balancer->balanceChampions($topTenPopularChampionsComplete);

            return $this->view('lol/balance' , [
                'balances' => $balances
            ]);
            
        }
    }