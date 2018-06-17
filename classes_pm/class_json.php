<?php
    
    class json extends pure
    {
        public function getStyleConfig()
        {
            echo json_encode(configuration::STYLE);
            exit();
        }
        
    }