<?php 
    
    class pure
    {
        
        public $model;
        
        function __construct() 
        {
            $this->model = new model;
        }
        
        public function checkPage() 
        {
            if ($_POST) 
            {
                $allowed_methods = array (
                    'add_account' => 'addAccount',
                    'update_account' => 'updateAccount',
                    'send_private_message' => 'sendPrivateMessage',
                    'change_group_option' => 'changeGroupOption',
                    'add_group' => 'addGroup',
                );
                
                // check method:
                if (method_exists($this, $allowed_methods[$_POST['action']])) {
                    // if exists, use it:
                    $this->$allowed_methods[$_POST['action']]($_POST);
                } else {
                    // if method don't exist, redirect to main url:
                    $redirect_to = CONFIGURATION::MAIN_URL;
                    header ("Location: $redirect_to");
                    exit();
                }
            }
            
            if (isset($_GET['page'])) {
                // check if such page is specified in settings:
                if ($this->checkPagesArray($_GET['page']) == true ) {
                    // if so, I check if the file exists: 
                    if (file_exists('view/'.$_GET['page'].'.php')) {
                        // and plug it:
                        return $_GET['page'];
                    } else {
                        // if file does not exist, show error 404:
                        return '404';
                    }
                } else {
                    // if no, show 404 error:
                    return '404';
                }
            } else {
                // show the main page:
                return 'main_page';
            }
        }
        
        public function checkPagesArray($string)
        {            
            // check if such page is specified in settings:
            if (array_key_exists($_GET['page'],CONFIGURATION::ALL_PAGES) 
                OR  array_key_exists($_GET['page'],CONFIGURATION::SUB_PAGES)) {
                return true;
            } else {
                return false;
            }
        }
                
        public function generatePageTitle() 
        {
            // take page url:
            $page_url = $this->checkPage();
                
            // if page not exist, show error:
            if ($page_url == '404') {
                return 'Error 404';
            } elseif ($page_url == 'main_page') { 
                // if it's main page, we don't need title:
                return null;
            } elseif ($this->checkPagesArray($page_url) == true) {
                // else, check if such page is specified in settings:
                return CONFIGURATION::ALL_PAGES[$page_url];
            } else {
                return null;
            }                
        }
        
        public function generateSubMenu($parent) 
        {
            $sub_pages = array();
            
            // check if such parent page have subpages:
            foreach (CONFIGURATION::SUB_PAGES AS $get => $params) {
                // if so, get them:
                if (in_array($parent,$params)) {
                    $sub_pages += [$get => $params[0]];
                }
            }
            return $sub_pages;
        }

        public function getAllProjects() 
        {
            return $this->model->getAllProjects();
        }
        
        public function createDocumentTree($array, $str = NULL) 
        {
            // TODO: how to buid div, buttons, forms, sliders and other?
            // TODO: id and class
            foreach($array as $outer => $inner) {
                // if there is some object in div:
                if (is_array($inner)){
                    // get parent div:
                    $str .= '<div id="'.$outer.'">';
                    // and move down:
                    $str .= $this->createDocumentTree($inner, NULL);
                } else {
                    // if div is empty:
                    $str .= '<div id="'.$inner.'">';
                }
                $str .= '</div>'; 
            }
            
            return $str;
            
        }
        
        public function getDocumentTree($projectId) 
        {
            return $this->model->getDocumentTree($projectId);
        }
        
        public function createTreeArray($htmlTree) 
        {   
        
            // make root, where parentId = 0:
            $treeRoot = array();
            // get roots:
            foreach($htmlTree as $element) {
                if ($element['parentId'] == 0) {
                    $treeRoot += array($element['identifier'] => $element['ID']);
                }
            }

            // get branches:
            foreach($treeRoot as $root => $rootId) {
                // if root have any branches:
                if ($rootId > 0) {
                    // delete root id:
                    $treeRoot[$root] = array();
                    $treeRoot[$root] = $this->makeTreeBranches($htmlTree,$rootId);
                } else {
                   $treeRoot[$root] = $root;
                }
            }
            
            // clean brancher without leaves: 
            
            return $treeRoot;
            
        }
    
        public function makeTreeBranches($htmlTree,$rootId) 
        {
            
            // walk throught main $htmlTree:
            foreach($htmlTree as $elementId => $element) {
                // and add branches:
                if ($element['parentId'] == $rootId) {
                    $branch[$element['identifier']] = $this->makeTreeBranches($htmlTree,$element['ID']);
                }
            }
            return $branch;
            
        }
        
        public function cleanLeaves($array) 
        {      
            
            $i = 0;
            foreach($array as $branch => $leaves) {
                // if there is some object in branch:
                if (is_array($leaves)){
                    // move up:
                    $array[$branch] = $this->cleanLeaves($leaves);
                } else {
                    // make string from array: 
                    array_splice($array, $i, 0, $branch);
                    unset($array[$branch]);
                }
                $i++;
            }
            
            return $array;   
            
        }

    } // class pure end
    
    require 'class_cron.php';
    
    
