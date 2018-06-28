<?php
    
    class fonts extends pure
    {
        public function addNewFont() 
        {            
            $fileName = str_replace(" ", "_", $_FILES['file']['name']);
            $fontFamily = substr($_FILES['file']['name'],0,-4);
            // check extension: 
            $fileType = substr($fileName,-3);
            // if ext is allowed:
            if (in_array($fileType,configuration::FONTS_TYPES)){
                if ($_FILES['file']['tmp_name'] != '') {
                    // convert cyrillic:
                    $uploadfile = configuration::FONTS_DIR . basename(iconv("UTF-8", "windows-1251",$fileName));
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                        // TODO: save info to db
                        $this->model->addNewFont($fontFamily,$fileName,$fileType);
                    } 
                }
            }
            $this->go->go('fonts');
        }
        
        public function getAllFonts() 
        {
            return $this->model->getAllFonts();
        }
        
        public function getFont($fontId)
        {
            return $this->model->getFont($fontId);
        }
        
        public function makeFontFavourite()
        {
            $this->model->makeFontFavourite($_POST['fontID'],$_POST['myFavourite']);
            $this->go->go(array('page' => 'font', 'ID' => $_POST['fontID']));
        }
        
        public function makeFontFavourite2()
        {
            $this->model->makeFontFavourite($_POST['fontID'],$_POST['myFavourite']);
            $this->go->go('fonts');
        }
        
        public function cyrillicFont()
        {
            $this->model->cyrillicFont($_POST['fontID'],$_POST['cyrillic']);
            $this->go->go(array('page' => 'font', 'ID' => $_POST['fontID']));
        }
        
        public function latinFont()
        {
            $this->model->latinFont($_POST['fontID'],$_POST['latin']);
            $this->go->go(array('page' => 'font', 'ID' => $_POST['fontID']));
        } 

        public function deleteFont() 
        {
            $this->model->deleteFont($_POST['fontID']);
            $this->go->go('fonts');
        }

        public function getFontByName($name) 
        {
            $array = array(
                "SELECT" => "*",
                "FROM" => "pm_fonts",
                "WHERE" => "fontFamily = '$name'",
                "fetch" => 1
            );

            return $this->model->select($array, null);
        }


        
    }