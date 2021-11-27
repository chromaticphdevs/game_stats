<?php 

    class DotaPlayerController extends Controller
    {
        public function __construct()
        {
            $this->model = model('DotaPlayerModel');
        }
        public function search()
        {
            $q = request()->inputs();

            $users = $this->model->fetchUsers($q['key']);

            if(!$users) {
                Flash::set("No user found!" , 'warning');
                return request()->return();
            }else{
                Flash::set( count($users) . " Users found with name '{$q['key']}' ");
            }
            
            $data = [
                'title' => 'Dota Players',
                'users' => $users
            ];
            
            return $this->view('dota_player/index' , $data);
        }
        
        public function show( $account_id )
        {
            $user = $this->model->fetchUser($account_id);

            $data = [
                'title' => $user['user']->profile->personaname,
                'user' => $user['user'],
                'recent_matches' => $user['matches_with_hero'],
                'match_summaries' => $user['matches_summary'],
                'dota'  => $this->model->dota
            ];

            return $this->view('dota_player/show' , $data);
        }
    }