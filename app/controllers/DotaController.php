<?php
	
	load(['AbilityService'], APPROOT.DS.'services/Dota');

	class DotaController extends Controller
	{

		public function __construct()
		{
			$this->dota = model('DotaModel');
			$this->heroAbility = model('DotaHeroAbilitiesModel');

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


		public function show($heroName)
		{
			$abilityService = new AbilityService();
			$hero = $this->dota->getLocalizeHeroes(['name' , $heroName] , $extractInfo = true);
			$heroImage = $this->dota->getHeroImageUrl($heroName);

			$this->heroAbility = model('DotaHeroAbilitiesModel');
			$abilities = $this->heroAbility->getAbilitiesByHero($heroName);

			$abilitiesComplete = $abilityService->getByHeroAbilities($abilities[0]->abilities);
			
			$data = [
				'hero' => $hero,
				'title' => $hero->localized_name,
				'heroImage' => $heroImage,
				'abilities' => $abilitiesComplete,
				'abilityNames' => $abilities[0]->abilities
			];

			return $this->view('dota/show' , $data);
		}
	}