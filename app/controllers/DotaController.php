<?php

	class DotaController extends Controller
	{

		public function __construct()
		{
			$this->dota = model('DotaModel');
		}

		public function index()
		{
			$matches = $this->dota->getHeroesComplete();
			$matches = $this->dota->fetchTopChampions($matches ,10);
			$matches = $this->dota->sortPickRate($matches);

			$heroes = $this->dota->heroesAppendImageUrl();


			$data = [
				'heroes' => $heroes ?? [],
				'title'  => 'Dota 2 heroes',
				'matches' => $matches
			];

			return $this->view('dota/index' , $data);
		}

		public function migrateStats()
		{
			$this->dota->localizeHeroStats();
		}
	}