<?php
    
    class redirect
    {       
        public function go($array = null)
        {
            
            if ($array != null) {
                // if array send, build url:
                if (is_array($array)) {
                    $redirect_to = CONFIGURATION::MAIN_URL.'?'.http_build_query($array);
                    $exp = rand(configuration::EXPERIENCE['LONG_REDIRECT']['min'],configuration::EXPERIENCE['LONG_REDIRECT']['max']);
                } else {
                    // else, move to page without get params:
                    $redirect_to = CONFIGURATION::MAIN_URL.'?page='.$array;
                    $exp = rand(configuration::EXPERIENCE['PAGE_REDIRECT']['min'],configuration::EXPERIENCE['PAGE_REDIRECT']['max']);
                }
            } else {
                // just main page:
                $redirect_to = CONFIGURATION::MAIN_URL;
                $exp = rand(configuration::EXPERIENCE['MAIN_REDIRECT']['min'],configuration::EXPERIENCE['MAIN_REDIRECT']['max']);
            }
            
            $experience = new experience;
            $experience->addExp($exp);
            
            
            header ("Location: $redirect_to");
            exit();
        }
    }