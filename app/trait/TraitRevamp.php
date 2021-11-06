<?php

	trait TraitRevamp
	{
		protected $maxPickRate = 0;

		public function revamp($avatars)
		{
			if( empty($avatars) )
				echo die("Avatar is empty");

			$mostUsed = $avatars[0];

			foreach($avatars as $key => $avatar) 
			{
				if( is_null($avatar) )
					continue;

				$winRate = $avatar->winLoseRate->win;
				$pickRate = $avatar->pickRate;

				/*
				*BUFFING PARAMETERS
				*/
				$winRateFiftyPercent = $winRate < floatval(50);
				$winRateEightyPercent = $winRate < floatval(80);

				$pickRateComparison = (($pickRate / $mostUsed->pickRate) * 100);
				$pickRateLessSenventyPercent = $pickRateComparison < 80;
				$pickRateLessTwentyPercent = $pickRateComparison < 20;
				
				/*
				*END BUFFING PARAMETERS
				*/


				/*
				*NERFING PARAMETERS
				*/
				$winrateFourtyPercent = $winRate > floatval(40);
				$winRateNinetyPercent = $winRate > floatval(90);

				$pickRateHigherSeventy = $pickRateComparison > 70;

				// dump([
				// 	$avatar,
				// 	$pickRate,
				// 	$mostUsed->pickRate,
				// 	$pickRateComparison,
				// 	$pickRateLessTwentyPercent
				// ]);

				//for nerf
				if( ($pickRateHigherSeventy && $winrateFourtyPercent)  || $winRateNinetyPercent)
				{
					$revampParam = (object) [
						'stats' => $this->nerf($avatar->stats , $avatar->changes),
						'type'  => 'nerf'
					];
				}

				//for buff
				if(($winRateFiftyPercent && $pickRateLessSenventyPercent) || 
				($pickRateLessTwentyPercent && $winRateEightyPercent)){
					$revampParam = (object) [
						'stats' => $this->buff($avatar->stats , $avatar->changes),
						'type'  => 'buff'
					];
				}

				$avatar->revamp = $revampParam;
			}

			return $avatars;
		}

		public function buff($stats , $changes)
		{
			foreach($changes as $key => $value) 
			{
				$currentStats  = floatval($stats->$key);
				$variableStats = floatval($value);

				//set stats to new!
				$changes->$key = $currentStats + $variableStats;
			}

			return $changes;
		}

		public function nerf($stats , $changes)
		{
			
			foreach($changes as $key => $value) 
			{
				$currentStats = floatval($stats->$key);
				$variableStats = floatval($value);
				//set stats to new!
				$changes->$key = $currentStats - $variableStats;
			}

			return $changes;
		}
	}