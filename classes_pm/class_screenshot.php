<?php
    
    class screenshot extends pure
    {
        public function memeShot() {  
            // create filename: 
            $name = time().'.png';
            $dir = 'img/screenShots';
            // convert to base64 and save:
            file_put_contents("$dir/$name", base64_decode($_POST['data']));
            return $name;
        }
        
    }