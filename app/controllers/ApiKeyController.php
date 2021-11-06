<?php

	class ApiKeyController extends Controller
	{
		public function __construct()
		{
			$this->apiKey = model('ApiKeyModel');
		}

		public function edit()
		{

			if( isSubmitted() )
			{
				$post = request()->posts();

				$res = $this->apiKey->updateByApi($post ,$post['api']);

				if($res) {
					Flash::set( "Api {$post['api']} Updated!" );
					return redirect( _route('api:edit'));
				}
			}

			$data = 
			[
				'apis' => [
					'leauge_of_legends' => 'leauge_of_legends',
					'dota' => 'dota',
					'ml' => 'ml'
				],

				'title' => 'Configure API KEYS'
			];


			return $this->view('api_key/edit' , $data);
		}
	}