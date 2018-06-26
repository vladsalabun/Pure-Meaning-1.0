<?php
    
    class json extends pure
    {
        public function getStyleConfig()
        {
            echo json_encode(configuration::STYLE);
            exit();
        }
        public function getAllFonts() 
        {
            $array = array(
                "SELECT" => "*",
                "FROM" => "pm_fonts",
                "WHERE" => "MODERATION < 2",
                "ORDER" => "fontFamily",
                "SORT" => "ASC"
            );
            return $this->model->select($array, null);
        }
    }