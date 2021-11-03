<?php
	
	require_once APPROOT.DS.'trait/TraitRevamp.php';

	trait TraitBalancer 
	{	

		use TraitRevamp;

		private $do = null;
		/*
		*with pickrate winrate loserate
		*/
		public function balancer($avatars)
		{
			if( empty($avatars) )
				echo die("Avatar is empty");

			$mostUsed = $avatars[0];

			foreach($avatars as $key => $avatar) 
			{
				/*
				*BUFFING PARAMETERS
				*/
				$winRateFiftyPercent = $mostUsed['winRate'] < floatval(50);
				$winRateEightyPercent = $mostUsed['winRate'] < floatval(80);
				//comparison to the most used
				$pickRateComparison = (($avatar['pickRate'] / $mostUsed['pickRate']) * 100);
				$pickRateLessSenventyPercent = $pickRateComparison < 70;
				$pickRateLessTwentyPercent = $pickRateComparison < 20;
				/*
				*END BUFFING PARAMETERS
				*/

				//for buff
				if(($winRateFiftyPercent && $pickRateLessSenventyPercent) || ($pickRateLessTwentyPercent && $winRateEightyPercent)){
					$buff = $this->buff($avatar);
					$avatars[$key]['revamp'] = $buff;
					continue;
				}
				/*
				*NERFING PARAMETERS
				*/
				$winrateFourtyPercent = $avatar['winRate'] > floatval(40);
				$winRateNinetyPercent = $avatar['winRate'] > floatval(90);

				$pickRateHigherSeventy = $pickRateComparison > 70;

				//for nerf
				if( ($pickRateHigherSeventy && $winrateFourtyPercent)  || $winRateNinetyPercent)
				{
					$nerf = $this->nerf($avatar);
					$avatars[$key]['revamp'] = $nerf;
				}
			}

			return $avatars;
		}
	}