<?php

    class LeagueBalancerController extends Controller
    {
        public function __construct()
        {
            $this->balancer = model('LeagueBalancerModel');
            $this->league = model('LeagueModel');
            $this->skillBalancer = model('LeagueSkillBalancerModel');
        }

        public function index()
        {
            $matchesSummary = $this->league->getMatchesSummary();
            $topTenPopularChampions = $this->league->fetchTopChampions($matchesSummary , 10);
            
            $topTenPopularChampionsComplete = $this->league->appendChampionDetailComplete($topTenPopularChampions);

            $balances = $this->balancer->balanceChampions($topTenPopularChampionsComplete);

            foreach($balances as $balance) 
            {
                $championName = trim($balance->championName);
                $champion = $this->league->getChampion($balance->championName);

                $champion = $champion->$championName;
                $spells = $champion->spells;

                $skillBalancer=  $this->skillBalancer->balanceSkills($spells , $balance->revamp->type);
                $balance->skill_revamp = $skillBalancer;

            };
            return $this->view('lol/balance' , [
                'balances' => $balances
            ]);
            
        }
    }