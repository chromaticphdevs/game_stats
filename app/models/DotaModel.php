<?php

	load(['TraitAPIService'], APPROOT.DS.'trait');

	class DotaModel extends Model
	{

		use TraitAPIService;

		public $table = 'dota_games';

		private $_matches = null;


		/**
		*allowed pair
		* ['id' , int] or ['name' , string]
		*/
		public function getHeroes($searchPair = [])
		{
			$retVal = [];

			$endpoint = 'https://api.opendota.com/api/heroes';

			$api_call_results = $this->apiGet($endpoint);
			
			if( empty($api_call_results) )
				return false;

			if( !empty($searchPair) ) 
			{
				list($property , $value) = $searchPair;

				foreach($api_call_results as $row) 
				{
					if( isEqual($row->$property , $value) ){
						$retVal = $row;
						break;
					}
				}
			}else{
				$retVal = $api_call_results;
			}

			return $retVal;
		}


		public function heroesAppendImageUrl( $hero_name = null)
		{
			$retVal = [];
			
			$heroes = $this->getHeroes( $hero_name ); 

			foreach($heroes as $key => $hero) 
			{
				$hero->image_src = $this->getHeroImageUrl($hero->name);

				if(!is_null($hero_name))
				{
					if( $hero->name == $hero_name){
						$retVal = $hero;
						break;
					}
				}	
			}

			$retVal = $heroes;

			return $retVal;
		}

		/**
		*Valid prefix
		* [sb , lg , full] -> png
		* vert.jpg
		*/
		public function getHeroImageUrl($hero_name , $prefix = 'full.png')
		{
			$endpoint = "http://cdn.dota2.com/apps/dota2/images/heroes/";

			$hero_name = str_replace("npc_dota_hero_" , '' , $hero_name);

			return $endpoint.$hero_name.'_'.$prefix;
		}


		public function localizeHeroStats()
		{
			$endpoint = 'https://api.opendota.com/api/heroStats';

			$results = $this->apiGet($endpoint);


			foreach($results as $res) 
			{
				$this->dbHelper->insert(...[
					'dota_hero_stats',
					[
						'id'   => $res->id,
						'name' => $res->name,
						'localized_name' => $res->localized_name,
						'info' => json_encode($res)
					]
				]);
			}
		}

		public function localizeGames( $games = [] )
		{
			$endpoint = 'https://api.opendota.com/api/matches';

			if( empty($games))
				$games = Module::get('dota')['matchIds'];
				
			$game_datas = [];

			foreach($games as $key => $game_id)
			{
				$game_data = $this->apiGet( $endpoint.'/'.$game_id );

				if($game_data)
				{
					dd($game_data);
					
					array_push($game_datas , [
						'match_id' => $game_data->match_id,
						'duration' => $game_data->duration,
						'game_mode' => $game_data->game_mode,
						'picks_bans' => $game_data->picks_bans,
						'radiant_win' => $game_data->radiant_win
					]);
				}
			}

			foreach($game_datas as $game)
			{
				parent::store([
					'match_id' => $game['match_id'],
					'info'     => json_encode($game)
				]);
			}
		}

		public function getMatchIdsAndPopulate()
		{
			$players = [
				'111620041',
				'164532005',
				'111750003',
				'340296152'
			];

			$fetchedGames = 0;
			$fetchedFromPlayerGames = 0;

			$matchIds = [];

			foreach( $players as $player )
			{
				$matches = $this->apiGet("https://api.opendota.com/api/players/{$player}/matches");

				if( $fetchedGames >= 25)
					break;

				foreach($matches as $match) 
				{
					if($fetchedFromPlayerGames >= 25){
						$fetchedFromPlayerGames = 0;
						break;
					}

					array_push($matchIds , $match->match_id);
					$fetchedGames++;
				}
			}

			$this->localizeGames($matchIds);
		}

		/**
		*allowed pair
		* ['id' , int] or ['name' , string]
		*/
		public function getLocalizeHeroes($searchPair = [] , $extractInfo = false)
		{
			$retVal = [];

			if( !empty($searchPair) )
			{
				list($column , $value) = $searchPair;

				$retVal = $this->dbHelper->single(...[
					'dota_hero_stats',
					'*',
					"{$column} = '{$value}'",
				]);
			}else
			{
				$retVal = $this->dbHelper->resultSet(...[
					'dota_hero_stats',
					'*',
					null,
					'name asc'
				]);
			}

			if( $extractInfo )
			{
				if( is_array($retVal) && !empty($retVal)) {
					foreach($retVal as $res) {
						$res->info = json_decode($res->info);
					}
				}else{
					$retVal->info = json_decode($retVal->info);
				}
				
			}

			return $retVal;
		}

		public function formatDatasForMostUsed($games)
		{
			$retVal = [];

			foreach($games as $game)
			{
				$info = $game->info;

				$picks_bans = $info->picks_bans;

				foreach($picks_bans as $hero)
				{
					$hero_id = trim($hero->hero_id);
					//skip banned heroes
					if( !$hero->is_pick )
						continue;
						

					if( !isset($retVal[$hero->hero_id]))
						$retVal[$hero->hero_id] = [];

					$row = [];

					$row['match_id'] = $game->match_id;
					$row['hero_id'] = $hero_id;
					$row['win'] = false;
					$row['hero_detail'] = $this->getLocalizeHeroes(['id' , $hero_id]);

					//if hero is radiant and radiant win then win is true other wise false
					/**
					*check hero if radiant and radiant win if true then win
					*check hero if dire and radiant lose if true then win
					*/
					$teamRadiantAndWin = $hero->team == 0 && $info->radiant_win;
					$teamDireAndWin = $hero->team == 1 && $info->radiant_win == false;
					/**
					*if either on condition is true then it means the hero won the match
					*/
					if( $teamRadiantAndWin || $teamDireAndWin)
						$row['win'] = true;

					array_push($retVal[$hero->hero_id] , (object) $row);
				}
			}

			return $retVal;
		}

		/*
		*Matches in local
		*/
		public function getMatches()
		{
			$matches = parent::dbgetDesc('id');

			foreach($matches as $key => $match){
				$match->info = json_decode($match->info);

				if( is_null($match->info->picks_bans) )
					unset($matches[$key]);
			}

			if( is_null($this->_matches) )
				$this->_matches = $matches;

			return $matches;
		}


		public function calcHeroesWinsAndLosesPerMatch($matches)
		{
			$retVal = [];

			$heroesMatchesWinsAndLoses = [];

			foreach($matches as $heroMatches)
			{
				foreach($heroMatches as $heroMatch)
				{
					if( !isset($heroesMatchesWinsAndLoses[$heroMatch->hero_id]) )
						$heroesMatchesWinsAndLoses[$heroMatch->hero_id] = [];
					
					$winLose = boolval($heroMatch->win);
					array_push($heroesMatchesWinsAndLoses[$heroMatch->hero_id] , $winLose);
				}
			}


			foreach($heroesMatchesWinsAndLoses as $key => $games)
			{
				$retVal[$key] = (object)[
					'matches' => $games,
					'hero_id' => $key,
					'hero_detail' => $matches[$key][0]->hero_detail
				];
			}

			return $retVal;
		}

		public function calcWinRateLoseRate($heroWithMatches)
		{
			foreach($heroWithMatches as $heroId => $hero)
			{
				if( is_null($hero) ) continue;

				$loseRate = 0;
				$winRate = 0;
				$matches = $hero->matches;

				foreach($matches as $win) {
					if( $win ){
						$winRate++;
					}else{
						$loseRate++;
					}
				}

				$totalMatches = count($matches);

				if( $winRate )
					$winRate = round(($winRate / $totalMatches) * 100 , 2);

				if($loseRate)
					$loseRate = round(($loseRate / $totalMatches) * 100 , 2);

				$heroWithMatches[$heroId]->winLoseRate = (object) [
					'win' => $winRate,
					'lose' => $loseRate,
					'total' => $totalMatches
				];
			}

			return $heroWithMatches;
		}

		public function appendPickRate($heroMatchesSummary)
		{

			//count matches

			$totalMatches = 0;

			foreach($heroMatchesSummary as $heroMatches) 
			{
				$totalMatches += count($heroMatches->matches);
			}

			foreach($heroMatchesSummary as $heroId => $hero)
			{
				
				$totalPicks = $hero->winLoseRate->total;

				$pickRate = ($totalPicks / $totalMatches) * 100;

				$hero->pickRate = $pickRate;

				$heroMatchesSummary[$heroId] = $hero;
			}

			return $heroMatchesSummary;
		}

		public function sortPickRate($matches)
		{
			$pickRate = array_column((array) $matches, 'pickRate');

			array_multisort($pickRate, SORT_DESC , $matches);

			return $matches;
		}

		/**
		 * DEFAULTS TO TOP 5
		 */
		public function fetchTopChampions($matchesSummary , $limit = 5 , $completeDetails = false)
		{
			$matchesSummary = $this->sortPickRate($matchesSummary);

			$matchesSummary = array_slice($matchesSummary , 0 , $limit);

			return $matchesSummary;
		}


		public function getHeroesComplete( $limit = null)
		{
			$matches = $this->getMatches();


			$matches = $this->formatDatasForMostUsed($matches);

			$matches = $this->calcHeroesWinsAndLosesPerMatch($matches);

			$matches = $this->calcWinRateLoseRate($matches);

			$matches = $this->appendPickRate($matches);

			if( !is_null($limit))
				$matches = $this->fetchTopChampions($matches , $limit);

			return $matches;
		}
	}