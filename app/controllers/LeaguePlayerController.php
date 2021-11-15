<?php

    class LeaguePlayerController extends Controller
    {

        public function __construct()
        {
            $this->leaguePlayer = model('LeaguePlayerModel');
        }
        public function index()
        {
            $r = request()->inputs();

            $player = $this->leaguePlayer->searchPlayerByNameAndRegion($r['key'] , $r['regions']);

            if(!$player) {
                Flash::set( $this->leaguePlayer->getErrorString() , 'danger');
                return request()->return();
            }

            $matches = $this->leaguePlayer->getMatches($player->puuid , $r['regions']);
            
            $hero_matches = $this->leaguePlayer->matchesRemarks($matches , $player->puuid);

            $data = [
                'title' => 'Faker',
                'hero_matches' => $hero_matches,
                'matches'  => $hero_matches['matches'] ?? [],
                'matches_with_remarks' => $hero_matches['matches_with_remarks'] ?? [],
                'imgSrc' => 'http://ddragon.leagueoflegends.com/cdn/11.21.1/img/champion/',
                'player' => $player,
                'regions'    => $this->leaguePlayer->getRegions()
            ];

            return $this->view('league_player/index' , $data);
        }

        

        /**
         * Summoner id plus region
         */
        public function show($summoner_id_region)
        {

        }
    }