<?php
    
    class experience extends pure
    {       
        public function addExp($newExp)
        {
            $this->model->addExp($newExp);
        }
        public function allExp()
        {
            return $this->model->allExp();
        }
    }