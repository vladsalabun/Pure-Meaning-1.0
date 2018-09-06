<?php 
        
    // Setup:
    class icon
    {    
       
        public $iconArray = array(
            'edit' => 'edit.png',
            'plus' => 'plus.png',
            'empty-heart' => 'empty-heart.png',
            'heart' => 'heart.png',
            'check' => 'check.png',
            'no' => 'no.png',
            'up_bold' => 'up_bold.png',
            'down_bold' => 'down_bold.png',
            'eye' => 'eye.png',
            'menu' => 'menu.png',
            'tree' => 'tree.png',
            'prototype' => 'prototype.png',
            'leaves' => 'leaves.png',
            'branch' => 'branch.png',
            'down-c' => 'down-c.png',
            'up-c' => 'up-c.png',
            'help' => 'help.png',
        );
        
        public function showIcon($name,$class,$title,$js = null) {
            if ($js != null) {
                $js = $js.' ';
            }
        
            return '<img src="'.CONFIGURATION::MAIN_URL.'img/icons/'.$this->iconArray[$name].'" title="'.$title.'" '.$js.'class="'.$class.'">';
        }
       
    }

    // $icon->showIcon('plus','width15','Створити новий проект');