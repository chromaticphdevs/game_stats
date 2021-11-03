<?php

	trait TraitRevamp
	{
		public function nerf($heroDetails)
		{
			$changesKeys = $this->getKeys($heroDetails);

			foreach($changesKeys as $key => $changes) 
			{
				$heroDetails->stats->$changes -= $heroDetails['balance']->changes[$changes];
			}

			dd($heroDetails);

			return $heroDetails;
		}

		public function getKeys($heroDetails)
		{
			if( !isset($heroDetails['balance']->changes) )
				return false;

			$changes = $heroDetails['balance']->changes;

			$changesKeys = array_keys($changes);

			return $changesKeys;
		}

		public function buff($heroDetails)
		{
			$changesKeys = $this->getKeys($heroDetails);

			foreach($changesKeys as $key => $changes) {
				$heroDetails[$key] += $changes[$changes];
			}

			return $heroDetails;
		}
	}