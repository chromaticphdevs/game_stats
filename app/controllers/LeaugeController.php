<?php 

	class LeaugeController extends Controller
	{


		public function __construct()
		{
			$this->_leagueModel = model('LeagueModel');

		}

		public function index()
		{
			$matches = $this->_leagueModel->populateMatches();

			dd($matches);
		}
	}