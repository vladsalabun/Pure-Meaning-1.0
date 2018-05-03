<?php 

    /***    CRON    ***/
    
    class cron 
    {
        
        public $model;
        public $pure;
        
        function __construct() 
        {
            $this->model = new model;
            $this->pure = new pure;
        }
        
        public function checkAction() 
        {
            if ($_GET) {
                // get param => method name
                $allowed_methods = array (
                    'check_group_subs' => 'checkGroupSubs'
                );
                    
                // check method:
                if(method_exists($this, $allowed_methods[$_GET['do']])) {
                    // if exists, use it:
                    $this->$allowed_methods[$_GET['do']]($_GET);
                } else {
                    // if method don't exist, redirect to main url:
                    $redirect_to = CONFIGURATION::MAIN_URL;
                    header ("Location: $redirect_to");
                    exit();
                }
            }
        }
        
    }