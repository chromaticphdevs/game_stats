<?php

    class TopTenController extends Controller
    {
        private $_valid_modules = [];

        public function __construct()
        {
           $this->_valid_modules = Module::get('games');
        }
        /**
         * pass game name
         * dota2 
         */
        public function index(string $module)
        {
            if( !isEqual($module , $this->_valid_modules))
                return _errorWithPage();

            $data = [
                'gameName'  => 'League of Legends TOP 10',
                'gameDesc'  => ' League of Legends, commonly referred to as League, 
                is a 2009 multiplayer online battle arena video game developed and published by Riot Games'
            ];
            
            return $this->view('top_ten/index' , $data);
        }
    }