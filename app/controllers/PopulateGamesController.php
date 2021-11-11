<?php

	load(['LeagueMatchService' , 'DotaMatchService'], APPROOT.DS.'services');

	class PopulateGamesController extends Controller
	{
		public function index()
		{
			$leagueMatchService = new LeagueMatchService();
			$leagueMatchService->populateMatches();


			$dotaMatchService = new DotaMatchService();
			$dotaMatchService->populateMatches();


			if( Session::get('games_fetched') )
			{
				$fetched_games = intval(Session::get('games_fetched'));
				$fetched_games += 1;

				if( $fetched_games < 1) {
					Flash::set("You can only manually fetched games two times , let the robot do its job to avoid complications" , 'danger');
					return redirect('MatchesController/index');
				}
			}else{
				Session::set('games_fetched' , 1);
			}

			Flash::set("Games Fetched");
			return redirect('MatchesController/index');
		}
	}