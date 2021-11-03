<?php
	
	require_once LIBS.DS.'riot/vendor/autoload.php';

	class LeagueModel extends Model
	{
		private $_apiKey = null;

		public $table = 'league_of_legends'; 

		public function __construct()
		{
			parent::__construct();

			if( is_null($this->_apiKey) ){
				$this->_apiKey = Module::get('apis')['lol']['key'];
			}
		}

		public function getChampion($champion)
		{
			
		}


		public function getMatches()
		{
			$retVal = [];

			$matches = parent::dbgetDesc('id');

			foreach($matches as $match) 
			{
				$metaData = json_decode($match->meta_data);
				$info = json_decode($match->info);

				array_push($retVal , (object) [
					'id' => $match->id,
					'meta_data' => $metaData,
					'info'     => $info
				]);
			}

			return $retVal;
		}

		/*
		*responsible for pulling matches
		*into the riot api and storing it to the database
		*/
		public function populateMatches()
		{
			$matchIds = Module::get('lol')['matchIds'];

			$matches = [];

			$apiKey = $this->_apiKey;

			foreach($matchIds as $key => $id) 	
			{

				$url = "https://asia.api.riotgames.com/lol/match/v5/matches/{$id}?api_key={$apiKey}";

				$matchData = api_call('GET' , $url , false);
				
				if( $matchData ){
					$matches[] = $matchData;
				}
			}

			foreach($matches as $match) 
			{
				$matchData = json_decode($match);
				
				$metadata = $matchData->metadata;
				$match_id = $metadata->matchId;

				$metadata = json_encode($metadata);
				$info     = json_encode($matchData->info);

				$this->db->query(
					"INSERT INTO {$this->table}(match_id , meta_data , info )
						VALUES('{$match_id}' , '{$metadata}' , '$info')"
				);

				$this->db->execute();
			}
		}

		public function collectMatches()
		{

		}
	}