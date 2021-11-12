<?php

	load(['LeagueMatchService' , 'DotaMatchService'], APPROOT.DS.'services');

	class PopulateGamesController extends Controller
	{
		public function index()
		{
			if( Session::get('games_fetched') )
			{
				$fetched_games = intval(Session::get('games_fetched'));
				$fetched_games += 1;

				if( $fetched_games > 1) {
					Flash::set("<strong>You can only manually fetched games two times</strong> , let the robot do its job we <strong> collect new games every 5 minutes </strong> to avoid complications" , 'danger');
					return redirect('MatchesController/index');
				}
			}else{
				Session::set('games_fetched' , 1);
			}

			// $leagueMatchService = new LeagueMatchService();
			// $leagueMatchService->populateMatches();


			$dotaMatchService = new DotaMatchService();
			$dotaMatchService->populateMatches();

			Flash::set("Games Fetched");
			return redirect('MatchesController/index');
		}
	}