<?php
	require_once APPROOT.DS.'trait/TraitLeaugeBalancer.php';

	class LeagueBalancerModel extends Model
	{
		use TraitLeagueBalancer;

		private $_leagueModel = null;
		private $_matches = null;

		private $_leagueAvatarModel = null;


		public function __construct()
		{
			if( is_null($this->_leagueModel) )
				$this->_leagueModel = model('LeagueModel');
		}
		/*
		*get apis from database
		*/
		public function getChampionSummaries()
		{
			$matches = $this->getMatches();
			$matchesSummary = $this->calculatePickRateLoseRateWinRate($matches);

			return $this->sortPickRate($matchesSummary);
		}


		public function topFive()
		{

			$avatarSummaries = $this->getChampionSummaries();

			if( is_null($this->_leagueAvatarModel) )
				$this->_leagueAvatarModel = model('LolAvatarModel');

			$avatarSummaries = array_slice($avatarSummaries , 0 , 10);

			foreach($avatarSummaries as $key=> $avatar) 
			{
				$heroDetail = $this->_leagueAvatarModel->getAvatar($avatar['avatarName']);

				try
				{
					$avatarName = $avatar['avatarName'];
					$heroBalanced = $this->applyBalance($heroDetail->$avatarName);

					$avatarSummaries[$key]['hero_detail'] = $heroDetail;
					$avatarSummaries[$key]['balance'] = $heroBalanced;

				}catch(Exception $e)
				{
					dd([
						$e->getMessage(),
						$heroBalanced
					]);
				}
			}

			return $avatarSummaries;
		}

		public function calculateWinRate($matchesSummary = [])
		{

		}

		public function sortPickRate($matches)
		{
			$pickRate = array_column($matches, 'pickRate');

			array_multisort($pickRate, SORT_DESC , $matches);

			return $matches;
		}

		public function computePickrate(& $matches = [])
		{
			$totalMatches = count($this->_matches);

			foreach($matches as $key => $match) 
			{
				if(!isset($match['totalMatches'])){
					echo die("Must have total matches key with int value");
				}

				$matches[$key]['pickRate'] = (($match['totalMatches'] / $totalMatches) * 10);
			}

			return $matches;
		}


		public function calculatePickRateLoseRateWinRate($games)
		{
			//store heroes here.
			$championsSummary = [];

			foreach($games as $game) 
			{

				$info = $game->info ?? null;

				if( !isset($info) )
					continue; //skip the game

				$participants = $info->participants;

				foreach($participants as $participant)
				{
					if( !isset($championsSummary[$participant->championName]) )
						$championsSummary[$participant->championName] = [];

					$winLose = boolval($participant->win);

					array_push($championsSummary[$participant->championName], $winLose);
				}
			}


			//get winrate

			$championsSummaryWithWinLosePickrate = [];

			foreach($championsSummary as $key => $championSummary) 
			{

				$loseRate = 0;
				$winRate = 0;

				$matchesResult = array_values($championSummary);

				foreach($matchesResult as $result) {
					if( $result ){
						$winRate++;
					}else{
						$loseRate++;
					}
				}

				$totalMatches = count($matchesResult);
				$winRate = round(($winRate / $totalMatches) * 100 , 2);
				$loseRate = round(($loseRate / $totalMatches) * 100 , 2);

				array_push($championsSummaryWithWinLosePickrate , [
					'totalMatches' => $totalMatches,
					'winRate' => $winRate,
					'loseRate' => $loseRate,
					'avatarName'   => $key
				]);

			}

			return $this->computePickrate($championsSummaryWithWinLosePickrate);
		}

		public function getMatches()
		{
			if( is_null($this->_matches) )
				$this->_matches = $this->_leagueModel->getMatches();

			return $this->_matches;
		}
	}