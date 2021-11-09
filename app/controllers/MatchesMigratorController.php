<?php

	class MatchesMigratorController extends Controller
	{

		public function dota()
		{
			$dota = model('DotaModel');


			$files = $dota->getMatchIdsAndPopulate();
		}
		public function league()
		{
			$league = model('LeagueModel');

			$files = trim( file_get_contents(LIBS.DS.'league_matches.csv'));
			$files = explode(',' , $files);



			$matches = [];

			foreach($files as $file) 
			{
				$file = preg_replace("/[^A-Za-z0-9_]/", ' ', $file);
				$file = trim($file);
				array_push($matches , $file);
			}


			$league->db->query(
				"SELECT match_id FROM {$league->table}
					WHERE match_id in('".implode("','" , $matches)."') "
			);

			$results = $league->db->resultSet();

			if( !empty($results) )
			{
				$newResultValue = [];
				foreach($results as $result){
					$newResultValue[] = $result->match_id;
				}

				$results = $newResultValue;
			}

			$import_games = array_diff($matches , $results);


			$league->populateMatches($import_games);


		}
	}