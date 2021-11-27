<?php 

    load(['TraitAPIService'], APPROOT.DS.'trait');

    class DotaPlayerModel extends Model
    {
        use TraitAPIService;

        public function fetchUsers($key)
        {
            // dotaApiWrapper
            $key = trim($key);

            $users = $this->apiGet( dotaApiWrapper("https://api.opendota.com/api/search?q={$key}") );

            if(!$users)
                return false;

            $users = $this->sortSimilarity($users);
            return $users;
        }

        public function sortSimilarity($users)
		{
			$similarity = array_column((array) $users, 'similarity');

			array_multisort($similarity, SORT_DESC , $users);

			return $users;
		}

        /**
         * -player_details
         * -matches
         * -summary
         */
        public function fetchUser($account_id)
        {
            $this->dota = model('DotaModel');

            $user = $this->apiGet( dotaApiWrapper("https://api.opendota.com/api/players/{$account_id}") );
            $matches = $this->apiGet( dotaApiWrapper("https://api.opendota.com/api/players/{$account_id}/matches") ); 
            $heroes = $this->dota->getHeroes();


            /**
             * hero_id = [
             *   'wins' => 3,
             *   'total'   => 5,
             *   'matches' => [
             *
             *   ]
             * ]
             */
            $matches_summary = [];
            $matches_with_hero = [];


            if( empty($matches) ){
                return [
                    'matches_summary' => $matches_summary,
                    'matches_with_hero' => $matches_with_hero,
                    'user' => $user
                ];
            }
            foreach($matches as $match) 
            {
                $hero_name = null;
                $localized_name  = null;

                $win = false;
                

                if( ($match->player_slot <= 5) && $match->radiant_win )
                    $win = true;

                foreach($heroes as $hero) 
                {
                    if( isEqual($hero->id, $match->hero_id) ) 
                    {
                        $hero_name = $hero->name;
                        $localized_name = $hero->localized_name;

                        $match->hero_name = $hero_name;
                        $match->localized_name = $localized_name;
                        $match->win = $win;


                        array_push($matches_with_hero , $match);
                    } 
                }

                if( !isset( $matches_summary[$match->hero_id]) ){
                    $matches_summary[$match->hero_id] = [
                        'wins' => 0,
                        'matches' => [],
                        'total'  => 0,
                        'localized_name'   => $localized_name,
                        'name'           => $hero_name,
                    ];
                }
                
                if( $win )
                    $matches_summary[$match->hero_id]['wins']++;

                $matches_summary[$match->hero_id]['matches'][] = [
                    'hero_name' => $hero_name,
                    'detail'    => $match
                ];

                $matches_summary[$match->hero_id]['total']++;
            }


            return [
                'matches_summary' =>  $this->sortUsage($matches_summary),
                'matches_with_hero' => $matches_with_hero,
                'user' => $user
            ];

        }

        public function sortUsage($matches)
		{
			$total = array_column((array) $matches, 'total');

			array_multisort($total, SORT_DESC , $matches);

			return $matches;
		}
    }