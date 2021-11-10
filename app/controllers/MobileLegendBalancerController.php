<?php

	class MobileLegendBalancerController extends Controller
	{	

		public function __construct()
		{
			$this->model = model('MobileLegendModel');
		}

		public function index()
		{

			$hero_matches = $this->model->getHeroStats();
			$balance_heroes = $this->model->balanceHeroes($hero_matches);


			$data = [
				'hero_matches' => $hero_matches,
				'balances' => $balance_heroes
			];

			return $this->view('ml/balance' , $data);
		}
	}
?>