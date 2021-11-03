<?php

    class AvatarModel extends Model
    {
        private $_modules;
        private $_module;

        public function __construct()
        {
            parent::__construct();
            $this->_modules = Module::get('games');
        }

        public function setModule($module)
        {
            switch($module) {
                case $this->_modules['dota'] :
                    $this->gameModel = model('DotaModel');
                break;

                case $this->_modules['lol']:
                    $this->gameModel = model('LolAvatarModel');
                break;
                case $this->_modules['ml']:
                    $this->gameModel = model('MobileLegendModel');
                break;
            }
        }

        public function getAvatar($nameOrId)
        {
            return $this->gameModel->getAvatar($nameOrId);
        }
        
        public function getAvatars($module)
        {
            return $this->gameModel->getAvatars();
        }
    }