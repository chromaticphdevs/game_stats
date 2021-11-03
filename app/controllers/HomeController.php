<?php

    class HomeController extends Controller
    {
        public function index()
        {   
            $data = [
                'title' => 'HomeController',
            ];
            
            return $this->view('home/index' , $data);
        }
    }
?>