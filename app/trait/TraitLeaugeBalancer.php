<?php

	trait TraitLeagueBalancer
	{

		public function applyBalance($hero)
		{
			$heroTag = $hero->tags;

			if( isEqual('mage' , $heroTag) || isEqual('support' , $heroTag))
				return $this->balancerMageSupport($hero->stats);

			if( isEqual('marksman' , $heroTag) || isEqual('fighter' , $heroTag))
				return $this->balancerMarksmanFighter($hero->stats);

			if( isEqual('assasin' , $heroTag))
				return $this->balancerAssasin($hero->stats);
		}

		/*
		*tag mage support
		*/
		public function balancerMageSupport(&$heroDataWithStats)
		{
			$hpPerLevel = $heroDataWithStats->hpperlevel * .001;
			$magicPerLevel = $heroDataWithStats->mpperlevel * .01;
			$manaPerLevel = $heroDataWithStats->mpregenperlevel * .016;

			$heroDataWithStats->changes = [
				'mpregenperlevel' => $manaPerLevel + $heroDataWithStats->mpregenperlevel,
				'hpperlevel' => $hpPerLevel + $heroDataWithStats->hpperlevel,
				'mpperlevel'    => $magicPerLevel + $heroDataWithStats->mpperlevel
			];

			return $heroDataWithStats;
		}

		/*
		*prepare for lategame
		*tag balancer fighter
		*/
		public function balancerMarksmanFighter(&$heroDataWithStats)
		{
			$attackDamagePerlevel = $heroDataWithStats->attackdamageperlevel * 0.25;
			$armorPerLevel = $heroDataWithStats->armorperlevel * .14;
			$spellBlock    = $heroDataWithStats->spellblock * .05;
			$hpRegenPerLevel = $heroDataWithStats->hpregenperlevel * .003;
			$attackSpeedPerLevel = $heroDataWithStats->attackspeedperlevel * .10;


			$heroDataWithStats->changes = [
				'attackdamageperlevel' => $attackDamagePerlevel + $heroDataWithStats->attackdamageperlevel,
				'armorperlevel' => $armorPerLevel + $heroDataWithStats->armorperlevel,
				'spellBlock'    => $spellBlock + $heroDataWithStats->spellblock,
				'hpregenperlevel' => $hpRegenPerLevel + $heroDataWithStats->hpregenperlevel,
				'attackspeedperlevel' => $attackSpeedPerLevel + $heroDataWithStats->attackspeedperlevel
			];

			return $heroDataWithStats;
		}

		/**
		 * Tagged as assasin
		 * */

		public function balancerAssasin(&$heroDataWithStats)
		{
			$critperlevel = $heroDataWithStats->critperlevel * .01;
			$mpperlevel = $heroDataWithStats->mpperlevel * .012;
			$movespeed = $heroDataWithStats->movespeed * .01;

			$heroDataWithStats->changes = [
				'mpregenperlevel' => $manaPerLevel + $heroDataWithStats->mpregenperlevel,
				'movespeed' => $hpPerLevel + $heroDataWithStats->movespeed,
				'mpperlevel'    => $magicPerLevel + $heroDataWithStats->mpperlevel
			];

			return $heroDataWithStats;
		}
	}