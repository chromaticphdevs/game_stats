<?php

	class LoginController extends Controller
	{

		private $_db;

		public function __construct()
		{
			//no need model because for basic auth only
			$this->_db = Database::getInstance();
		}

		public function index()
		{
			$data = [
				'title' => 'Admin Login',
			];

			return $this->view('login/index' , $data);
		}

		public function loginAction()
		{
			if( isSubmitted() )
			{
				$post = request()->posts();

				$username = trim($post['username']);
				$password = trim($post['password']);


				$this->_db->query(
					"SELECT * FROM users 
						WHERE 
						username = '{$username}'
						AND password = '{$password}' "
				);

				$auth = $this->_db->single();

				if($auth) 
				{
					$isSaved = authSet((object)[
						'username' => $auth->username,
						'display_name' => $auth->display_name
					]);

					if(!$isSaved)
					{
						//redo if wala pa din then reset
						authSet((object)[
							'username' => $auth->username,
							'display_name' => $auth->display_name
						]);
					}

					if( !$isSaved )
					{
						Flash::set("Try to re-login");
						return redirect(_route('login:index'));
					}

					Flash::set("Welcome Back . {$auth->display_name}");
					return redirect(_route('api:edit'));
				}else{
					Flash::set("Invalid login" , 'warning');
					return redirect(_route('login:index'));
				}
			}
		}

		public function destroy()
		{
			session_destroy();
			Flash::set("Account Logged out");
			return redirect(_route('login:index'));
		}
	}