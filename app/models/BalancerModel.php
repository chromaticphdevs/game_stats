<?php
	require_once APPROOT.DS.'trait/TraitBalancer.php';

	class BalancerModel extends Model
	{
		use TraitBalancer;

		private $_module;
		private $_model;

		public function setModule($module)
		{
			$this->_module = $module;

			switch($module)
			{
				case GAMES_LOL:
					$this->_model = model('LeagueBalancerModel');
				break;
			}
		}

		public function topFive()
		{
			$topFive = $this->_model->topFive();


			return $topFive;
			
			// $revamp = $this->balancer($topFive);

			// dd($revamp);
		}
	}
?>