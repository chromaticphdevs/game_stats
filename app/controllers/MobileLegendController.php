<?php

	class MobileLegendController extends Controller
	{
		public function __construct()
		{
			$this->model = model('MobileLegendModel');
		}

		public function index()
		{
			$popular_heroes = $this->model->getPopularHeroes(10);

			$data = [
				'heroes' => $this->model->getHeroes(),
				'popular_heroes' => $popular_heroes
			];
			return $this->view('ml/index' , $data);
		}

		public function show($heroName)
		{
			$popular_heroes = $this->model->getPopularHeroes(5);

			$hero = $this->model->getHeroes($heroName);

			$hero_stats = $this->model->getHeroStats($heroName);

			$data = [
				'hero' => $hero,
				'hero_stats' => $hero_stats
			];

			return $this->view('ml/show' , $data);
		}

		public function populateHeroes()
		{
			$ml_games = $this->model->getHeroes($heroName);

			dd($ml_games);
		}

	}