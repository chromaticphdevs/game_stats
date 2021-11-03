<?php 	

	class API_Notification extends Controller
	{

		public function __construct()
		{
			$this->notification = model('NotificationModel');
		}

		public function index()
		{
			$req = request()->inputs();
			
			$notifications = $this->notification->all([
				'recipient_id' => $req['recipient_id'] ?? whoIs('id')
			] , 'id desc');

			ee(api_response( $notifications ));
		}
	}