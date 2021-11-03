<?php

	trait TraitLeagueBalancer
	{

		public function applyBalance($hero)
		{
			$heroTag = $hero->tags;

			if( isEqual('mage' , $heroTag) || isEqual('support' , $heroTag))
				return $this->balancerMageSupport($hero);

			if( isEqual('marksman' , $heroTag) || isEqual('fighter' , $heroTag))
				return $this->balancerMarksmanFighter($hero);

			if( isEqual('assasin' , $heroTag))
				return $this->balancerAssasin($hero);
		}

		/*
		*tag mage support
		*/
		public function balancerMageSupport($hero)
		{
			$stats = $hero->stats;

			$hpPerLevel = $stats->hpperlevel * .001;
			$magicPerLevel = $stats->mpperlevel * .01;
			$manaPerLevel = $stats->mpregenperlevel * .016;

			$row = (object)[
				'mpregenperlevel' => $manaPerLevel,
				'hpperlevel' => $hpPerLevel,
				'mpperlevel'    => $magicPerLevel
			];

			$hero->changes = $row;


			return $hero;
		}

		/*
		*prepare for lategame
		*tag balancer fighter
		*/
		public function balancerMarksmanFighter($hero)
		{
			$stats = $hero->stats;

			$attackDamagePerlevel = $stats->attackdamageperlevel * 0.25;
			$armorPerLevel = $stats->armorperlevel * .14;
			$spellBlock    = $stats->spellblock * .05;
			$hpRegenPerLevel = $stats->hpregenperlevel * .003;
			$attackSpeedPerLevel = $stats->attackspeedperlevel * .10;

			$row = (object)[
				'attackdamageperlevel' => $attackDamagePerlevel,
				'armorperlevel' => $armorPerLevel,
				'spellblock'    => $spellBlock,
				'attackspeedperlevel' => $attackSpeedPerLevel,
				'hpregenperlevel' => $hpRegenPerLevel
			];

			$hero->changes = $row;

			return $hero;
		}

		/**
		 * Tagged as assasin
		 * */

		public function balancerAssasin($hero)
		{
			$stats = $hero->stats;
			
			$critperlevel = $stats->critperlevel * .01;
			$mpperlevel = $stats->mpperlevel * .012;
			$movespeed = $stats->movespeed * .01;

			$row = (object)[
				'mpregenperlevel' => $critperlevel,
				'movespeed' => $movespeed,
				'mpperlevel'    => $mpperlevel
			];

			$hero->changes = $row;

			return $hero;
		}
	}