<?php

	class BalancerController extends Controller
	{
		private $balancer;
		
		public function __construct()
		{
			//load all
			$this->balancer = model('BalancerModel');
		}


		public function index()
		{
			$r = request()->inputs();

			if( !isset($r['module']) ){
				return $this->view('balancer/index');
			}
			
			$module = $r['module'];

			$this->balancer->setModule($module);

			$result = $this->balancer->topFive($module);

			$data = [
				'topfive' => $result
			];

			return $this->view('balancer/index' , $data);
		}
	}