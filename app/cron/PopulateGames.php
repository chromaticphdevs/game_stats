<?php
	
	load(['LeagueMatchService' , 'DotaMatchService'], APPROOT.DS.'services');

	class PopulateGames extends Controller
	{
		public function index()
		{
			$this->postGameFetchAndPossibleReset();

			// $leagueMatchService = new LeagueMatchService();
			// $leagueMatchService->populateMatches();


			// $dotaMatchService = new DotaMatchService();
			// $dotaMatchService->populateMatches();
		}

		private function postGameFetchAndPossibleReset()
		{
			$db = Database::getInstance();

			$db->query(
				"SELECT * FROM fetch_game_logs"
			);

			$res = $db->single();

			$today = today();

			$date_difference =  date_difference( $res->recent_reset ,  $today);
			$date_difference_number = (int) filter_var($date_difference, FILTER_SANITIZE_NUMBER_INT);

			if( $date_difference_number >= 12 )
			{
				//reset
				$db->query("UPDATE fetch_game_logs set recent_reset = '{$today}'");
				$db->execute();

				$this->deleteSomeGames();
			}
		}

		private function deleteSomeGames()
		{
			$db = Database::getInstance();

			$db->query("DELETE * FROM dota_games");
			$db->execute();

			$db->query("DELETE * FROM league_of_legends");
			$db->execute();
		}
	}
	
	