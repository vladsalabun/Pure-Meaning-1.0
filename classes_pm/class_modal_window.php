<?php
    
    class modal extends pure
    {
        public function a($array)
        {
            return '<a href="" data-toggle="modal" data-target="#'.$array['window'].'">'.$array['anchor'].'</a>';
        }

    }