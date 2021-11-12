<?php
	
	load(['LeagueMatchService' , 'DotaMatchService'], APPROOT.DS.'services');

	class PopulateGames extends Controller
	{
		public function index()
		{
			$leagueMatchService = new LeagueMatchService();
			$leagueMatchService->populateMatches();

			$dotaMatchService = new DotaMatchService();
			$dotaMatchService->populateMatches();
		}
	}