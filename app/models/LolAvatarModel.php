<?php

    load(['TraitAPIService'] , APPROOT.DS.'trait');
    class LolAvatarModel extends Model implements InterfaceAvatarModel
    {   
        use TraitAPIService;

        private $_endpoints;

        public function __construct()
        {
            parent::__construct();

            $this->_endpoints = [
                'champions' => 'http://ddragon.leagueoflegends.com/cdn/11.21.1/data/en_US/champion.json',
                'championImage' => 'http://ddragon.leagueoflegends.com/cdn/11.21.1/img/champion/',
                'champion'  => 'https://ddragon.leagueoflegends.com/cdn/11.21.1/data/en_US/champion/',
            ];
        }

        public function getAvatar($nameOrId)
        {
            $avatar = $this->apiGet( $this->getEndPoint('champion') .$nameOrId.'.json' );
            return $avatar->data ?? null;
        }

        public function getAvatars()
        {
            $champions = $this->apiGet($this->_endpoints['champions']);
            return $champions->data ?? [];
        }

        public function getEndPoint($endPoint){
            return $this->_endpoints[$endPoint];
        }

        /*
        *valid datas
        *division
        *tier
        *quue
        */
        public function getMatches($params = [])
        {
            https://br1.api.riotgames.com/lol/league/v4/entries/RANKED_SOLO_5x5/PLATINUM/III?page=1&api_key=RGAPI-ed861ccb-fd50-4203-b623-c02bd040a026
        }
    }