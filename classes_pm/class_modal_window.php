<?php
    
    class modal extends pure
    {
        public function a($array = null, $anchor = null)
        {
            if (is_array($array)) {
                return '<a href="" data-toggle="modal" data-target="#'.$array['window'].'">'.$array['anchor'].'</a>';
            } else {
                if(isset($array) and isset($anchor)) {
                    return '<a href="" data-toggle="modal" data-target="#'.$array.'">'.$anchor.'</a>';
                } else {
                    return 'Error! Bad modal link param!';
                }
            }
        }

    }