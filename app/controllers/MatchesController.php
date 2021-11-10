<?php

	class MatchesController extends Controller
	{

		public function index()
		{
			$db = Database::getInstance();

			$db->query(
				"SELECT (SELECT count(id) from dota_games) as dota_total_games,
					(SELECT count(id) from league_of_legends) as league_total_games"
			);

			$result = $db->single();

			$data = [
				'matches' => [
					'dota' => $result->dota_total_games,
					'league'  => $result->league_total_games
				]
			];

			return $this->view('matches/index' , $data);
		}
	}