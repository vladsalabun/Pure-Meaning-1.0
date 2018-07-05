<?php
    
    class colors extends pure
    {       
        public function addNewColor($hex = null)
        {
            if (isset($_POST['color'])) {
                $hex = $_POST['color'];
            } else {
                $hex = $hex;
            }
            
            if (strlen($hex) > 0) {
            
                $pure = new pure;
                $hex = $pure->verifyCss('background-color',$hex);
                
                // check color:
                $checkColor = $this->getOneColor($hex);
                
                // if false:
                if ($checkColor == false) {                
                    $array = array(
                        "INSERT INTO" => 'pm_colors',
                        "COLUMNS" => array(
                            "color" => $hex
                        )
                    );
                    $this->model->insert($array);
                } else {
                    // if already exists:
                    
                }
            }
            if (isset($_POST['color'])) {
                $this->go->go('colors');
            }
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
        
        // check one color, if not in the database, return NULL:
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
            // if data not entered, redirect:
            if (strlen($_POST['backgroundColor']) > 0 and strlen($_POST['textColor']) > 0) {
                
                $pure = new pure;
                
                // verify css:
                $backgroundColor = $pure->verifyCss('background-color',$_POST['backgroundColor']);
                $color = $pure->verifyCss('color',$_POST['textColor']);
                
                // check colors :
                if ($this->getOneColor($backgroundColor) == false) {
                    // if not in the database, add: 
                    $this->addNewColor($backgroundColor);
                }
                if ($this->getOneColor($color) == false) {
                    // if not in the database, add: 
                    $this->addNewColor($color);
                }
                
                $array = array(
                    "INSERT INTO" => 'pm_colorSets',
                    "COLUMNS" => array(
                        "ID" => $_POST['ID'],
                        "backgroundColor" => $backgroundColor,
                        "textColor" => $color
                    )
                );
                $this->model->insert($array);
            }
            
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
        
        public function updateColorSet() 
        {
            // if data not entered, redirect:
            if (strlen($_POST['backgroundColor']) > 0 and strlen($_POST['textColor']) > 0) {
                $pure = new pure;
                $backgroundColor = $pure->verifyCss('background-color',$_POST['backgroundColor']);
                $color = $pure->verifyCss('color',$_POST['textColor']);
                
                // check colors :
                if ($this->getOneColor($backgroundColor) == false) {
                    // if not in the database, add: 
                    $this->addNewColor($backgroundColor);
                }
                if ($this->getOneColor($color) == false) {
                    // if not in the database, add: 
                    $this->addNewColor($color);
                }
                
                $array = array(
                    "UPDATE" => 'pm_colorSets',
                    "SET" => array(
                        "backgroundColor" => $backgroundColor,
                        "textColor" => $color
                    ),
                    "WHERE" => array(
                        "ID" => $_POST['ID']
                    )
                );
                $this->model->update($array);
            }
            $this->go->go('color_sets');
        }
        
        public function deleteColorSet() 
        {
            $array = array(
                    "UPDATE" => 'pm_colorSets',
                    "SET" => array(
                        "moderation" => 3
                    ),
                    "WHERE" => array(
                        "ID" => $_POST['ID']
                    )
                );
                $this->model->update($array);
                
            $this->go->go('color_sets');
        }
        
    }