<?php
	
	class DotaBalancerController extends Controller
	{
		public function __construct()
		{
			$this->dota = model('DotaModel');
			$this->balancer = model('DotaBalancerModel');
		}

		public function index()
		{
			$dotaHeroMatches = $this->dota->getHeroesComplete(10);
			$dotaHeroMatches = $this->dota->sortPickRate($dotaHeroMatches);
			$dotaHeroMatches = $this->balancer->balanceHeroes($dotaHeroMatches);

			$data = [
				'balances' => $dotaHeroMatches
			];
			return $this->view('dota/balance' , $data);
		}
	}