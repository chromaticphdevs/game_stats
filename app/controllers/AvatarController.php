<?php
    /**
     * HERO OR CHAMPION CONTROLLER
     */
    class AvatarController extends Controller
    {

        public function __construct()
        {   
            $this->avatar = model('AvatarModel');
        }

        public function index()
        {
            $r = request()->inputs();
            
            if( !isset($r['module']) ){
                //display error
            }

            $this->avatar->setModule($r['module']);

            $data = [
                'avatars' => $this->avatar->getAvatars($r['module'])
            ];

            $data['champImageLink'] = $this->avatar->gameModel->getEndPoint('championImage');
            $data['gameDesc']  = 'LOL';
            $data['gameName']  = 'OP.GG uses data based on ranked games from Platinum and higher.';
            
            return $this->view('avatar/lol/top_10' , $data);
        }

        public function downloadToDatabase()
        {
            $champions = api_call('get' , 'http://ddragon.leagueoflegends.com/cdn/11.21.1/data/en_US/champion.json');

            dd( json_decode($champions) );
        }

        /**
         * ACCEPTS MODULE AND AVATAR_ID
         */
        public function show()
        {
            $league = model('LeagueModel');

            $q = request()->inputs();

            if( !isset($q['module'] , $q['avatar_id']) )
                return _errorWithPage("Error");

            $this->avatar->setModule($q['module']);
            $avatar = $this->avatar->getAvatar($q['avatar_id']);


            dump($avatar);

            $data = [
                'module' => $q['module'],
                'avatar' => $avatar->Aatrox
            ];

            return $this->view('avatar/lol/show' , $data);
        }
    }