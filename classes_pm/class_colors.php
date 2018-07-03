<?php
    
    class colors extends pure
    {       
        public function addNewColor()
        {
            if (strlen($_POST['color']) > 0) {
                // check color:
                $checkColor = $this->getOneColor($_POST['color']);
                
                // if false:
                if ($checkColor == false) {                
                    $array = array(
                        "INSERT INTO" => 'pm_colors',
                        "COLUMNS" => array(
                            "color" => $_POST['color']
                        )
                    );
                    $this->model->insert($array);
                } else {
                    // if already exists:
                    
                }
            }
            $this->go->go('colors');
        }
        
        public function getAllColors()
        {
            $array = array(
                "SELECT" => "*",
                "FROM" => "pm_colors",
                "WHERE" => "moderation < 3",
                "ORDER" => "ID",
                "SORT" => "DESC",
            );
            return $this->model->select($array, null);
        }
        
        public function deleteColor()   
        {
            $array = array(
                "UPDATE" => 'pm_colors',
                "SET" => array(
                    "moderation" => 3
                ),
                "WHERE" => array(
                    "ID" => $_POST['ID']
                )
            );
                    
            $this->model->update($array); 
            $this->go->go('colors');          
        }
        
        public function getOneColor($hex) 
        {
            $array = array(
                "SELECT" => "*",
                "FROM" => "pm_colors",
                "WHERE" => "color = '$hex'",
                "fetch" => 1
            );
            return $this->model->select($array, null);
        }
        
        public function getAllSets() 
        {
            $array = array(
                "SELECT" => "*",
                "FROM" => "pm_colorSets",
                "WHERE" => "moderation < 2",
                "ORDER" => "ID",
                "SORT" => "DESC"
            );
            return $this->model->select($array, null);
        }
        
        public function addNewColorSet() 
        {
            $pure = new pure;
            $backgroundColor = $pure->verifyCss('background-color',$_POST['backgroundColor']);
            $color = $pure->verifyCss('color',$_POST['textColor']);
            
            // TODO: what if empty?
            //       add both colors to color table
            
            $array = array(
                "INSERT INTO" => 'pm_colorSets',
                "COLUMNS" => array(
                    "ID" => $_POST['ID'],
                    "backgroundColor" => $backgroundColor,
                    "textColor" => $color
                )
            );
            $this->model->insert($array);
            $this->go->go('color_sets');
        }
        
        public function makeSetFavourite() 
        {
            $array = array(
                "UPDATE" => 'pm_colorSets',
                "SET" => array(
                    "moderation" => $_POST['moderation']
                ),
                "WHERE" => array(
                    "ID" => $_POST['ID']
                )
            );
                    
            $this->model->update($array); 
            $this->go->go('color_sets'); 
        }
        
    }