<?php
	
	load(['AbilityService'], APPROOT.DS.'services/Dota');

	class DotaBalancerController extends Controller
	{
		public function __construct()
		{
			$this->dota = model('DotaModel');
			$this->balancer = model('DotaBalancerModel');
			$this->heroAbility = model('DotaHeroAbilitiesModel');
			$this->balancerSkill= model('DotaSkillBalancerModel');
			$this->abilityService = new AbilityService();
			
		}

		public function index()
		{
			$dotaHeroMatches = $this->dota->getHeroesComplete(10);
			$dotaHeroMatches = $this->dota->sortPickRate($dotaHeroMatches);
			$dotaHeroMatches = $this->balancer->balanceHeroes($dotaHeroMatches);


			foreach($dotaHeroMatches as $heroMatch)
			{

				$abilities = $this->heroAbility->getAbilitiesByHero($heroMatch->other->name);

				$hero_ability_details = $this->abilityService->getByHeroAbilities($abilities[0]->abilities);

				if( isset($heroMatch->revamp) && isEqual($heroMatch->revamp->type , ['nerf' , 'buff']))
				{
					$heroMatch->ability_changes = $this->balancerSkill->balanceSkills($hero_ability_details,
						$heroMatch->revamp->type);
				}
				
			}

			$data = [
				'balances' => $dotaHeroMatches
			];
			return $this->view('dota/balance' , $data);
		}
	}