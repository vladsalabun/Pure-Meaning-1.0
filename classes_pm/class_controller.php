<?php 
    
    class pure
    {
        
        public $model;
        public $go;
        
        function __construct() 
        {
            $this->model = new model;
            $this->go = new redirect;
        }
        
        public function checkPage() 
        {
            if ($_POST) 
            {
                $allowed_methods = array (
                    'add_content_block' => 'addContentBlock',
                    'increase_priority' => 'increasePriority',
                    'decrease_priority' => 'decreasePriority',
                    'add_new_element' => 'addNewElement',
                    'add_leaves' => 'addLeaves',
                    'delete_element' => 'deleteElement',
                    'edit_element' => 'editElement',
                    'add_other_option' => 'addOtherOption',
                    'add_css_option' => 'addCssOption',
                    'delete_other_option' => 'deleteOtherOption',
                    'delete_css_option' => 'deleteCssOption',
                    'fav_element' => 'favElement',
                    'edit_body_style' => 'editBodyStyle',
                    'delete_body_option' => 'deleteBodyOption',
                    'edit_class_style' => 'editClassStyle',
                    'delete_class_option' => 'deleteClassOption',
                    'add_new_body_style' => 'addNewBodyStyle',
                    'add_new_class_style' => 'addNewClassStyle',
                    'change_parent' => 'changeParent',
                    'current_tree_copy' => 'currentTreeCopy',
                    'add_new_color' => array('colors' => 'addNewColor'),
                    'delete_color' => array('colors' => 'deleteColor'),
                    'add_new_font' => array('fonts' => 'addNewFont'),
                    'make_font_favourite' => array('fonts' => 'makeFontFavourite'),
                    'make_font_favourite2' => array('fonts' => 'makeFontFavourite2'),
                    'cyrillic_font' => array('fonts' => 'cyrillicFont'),
                    'latin_font' => array('fonts' => 'latinFont'),
                    'delete_font' => array('fonts' => 'deleteFont'),
                    'add_new_project' => array('projects' => 'addNewProject'),
                    'edit_project' => array('projects' => 'editProject'),
                    'delete_project' => array('projects' => 'deleteProject'),
                    'add_new_subproject' => array('projects' => 'addNewSubproject'),
                    'edit_subproject' => array('projects' => 'editSubproject'),
                    'add_new_objection_theme' => array('objections' => 'addNewObjectionTheme'),
                    'delete_objection' => array('objections' => 'deleteObjection'),
                    'edit_objection' => array('objections' => 'editObjection')
                );
                
                if (is_array($allowed_methods[$_POST['action']])) {
                    // handle it to his class:
                    foreach ($allowed_methods[$_POST['action']] as $className => $methodName) {
                        $tmpObject = new $className;
                        // check method:
                        if (method_exists($tmpObject, $methodName)) {
                            // and use it:
                            $tmpObject->$methodName();
                        } else {
                            // if method don't exist, redirect to main url:
                            $this->go->go();
                        }
                    }
                } else {
                    // check method:
                    if (method_exists($this, $allowed_methods[$_POST['action']])) {
                        // and use it:
                        $this->$allowed_methods[$_POST['action']]($_POST);
                    } else {
                        // if method don't exist, redirect to main url:
                        $this->go->go();
                    }
                }
                
            } // <- / $_POST
            
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
        
        public function getPage() 
        {
            
        }
        
        public function checkPagesArray($string)
        {            
            // check if such page is specified in settings:
            if (array_key_exists($_GET['page'],CONFIGURATION::ALL_PAGES) 
                or array_key_exists($_GET['page'],CONFIGURATION::SUB_PAGES)) {
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

        public function fish($max) 
        {
            return substr(configuration::FISH,0,$max);
        }      
 
        public function createDocumentTree($array, $str = NULL) 
        {
            $styles = '<style>';
            // TODO: build div, buttons, forms, sliders and other
            
            foreach($array as $outer => $inner) {
                // if div have inner elements: 
                if (is_array($inner)) {
                    // get parent element, and take element params:
                    $elementInfo = $this->getElementInfo(substr($outer,5));

                    $str .= '<'.configuration::ELEMENTS[$elementInfo['type']].' id="'.$elementInfo['identifier'].'" class="'.$elementInfo['class'].'">';
                    
                    if ($elementInfo['style'] != null) {
                        // get style array:
                        $elementStyle = json_decode($elementInfo['style'],true);
                        // check if there is some styles:
                        if (isset($elementStyle['css']) and count($elementStyle['css']) > 0) {
                            $styles .= '#'.$elementInfo['identifier']. '{';
                            
                            foreach ($elementStyle['css'] as $styleName => $styleValue) {
                                $styles .= $styleName.':'.$styleValue.'; ';
                            }
                            $styles .= '}';
                        }
                        // check other options:
                        if (isset($elementStyle['other']) and count($elementStyle['other']) > 0) {
                            if (isset($elementStyle['other']['fish'])) {
                                $str .= substr(configuration::FISH,0,$elementStyle['other']['fish']);
                            }
                            if (isset($elementStyle['other']['text'])) {
                                $str .= $elementStyle['other']['text'];
                            }
                        }
                    }
                    
                    // and move down:
                    $str .= $this->createDocumentTree($inner, NULL); 
                } else {
                    // if div is empty:
                    $elementInfo = $this->getElementInfo(substr($inner,5));
                    $str .= '<'.configuration::ELEMENTS[$elementInfo['type']].' id="'.$elementInfo['identifier'].'" class="'.$elementInfo['class'].'">';
                    
                    if ($elementInfo['style'] != null) {
                        // get style array:
                        $elementStyle = json_decode($elementInfo['style'],true);
                        // check if there is some styles:
                        if (isset($elementStyle['css']) and count($elementStyle['css']) > 0) {
                            $styles .= '#'.$elementInfo['identifier']. '{';
                            
                            foreach ($elementStyle['css'] as $styleName => $styleValue) {
                                $styles .= $styleName.':'.$styleValue.'; ';
                            }
                            $styles .= '}';
                        }
                        // check other options:
                        if (isset($elementStyle['other']) and count($elementStyle['other']) > 0) {
                            if (isset($elementStyle['other']['fish'])) {
                                $str .= substr(configuration::FISH,0,$elementStyle['other']['fish']);
                            }
                            if (isset($elementStyle['other']['text'])) {
                                $str .= $elementStyle['other']['text'];
                            }
                        }
                    }
                    
                }
                $str .= '</'.configuration::ELEMENTS[$elementInfo['type']].'>'; 
            }
            $styles .= '</style>';
            return $str.$styles; 
        }
       
        public function globalStyles($projectId) 
        {
            $globalStylesJson = $this->model->globalStyles($projectId)['globalStyles'];
            $globalStylesArray = json_decode($globalStylesJson, true);
            
            $str = '<style>';
            
            foreach($globalStylesArray as $class => $styleArray) {
                if ($class == 'body') {
                    $str .= $class.' {';
                    foreach ($styleArray as $styleName => $styleValue) {
                        $str .= $styleName . ': ' . $styleValue . '; ';
                    }
                    $str .= '} ';
                } else {
                    $str .= '.' . $class.' {';
                    foreach ($styleArray as $styleName => $styleValue) {
                        $str .= $styleName . ': ' . $styleValue. '; ';
                    }
                    $str .= '} ';
                }
            }
            
            $str .= '</style>';
            return $str;
        }
       
        public function getElementInfo($elementId) 
        {
            return $this->model->getElementInfo($elementId);
        }
        
        public function getBranch($array, $value) 
        { 
        
            $branch = array();
        
            foreach ($array as $arrayKey => $arrayValue) {
                
                if ($arrayKey === $value) {
                    //echo "[ $arrayKey === $value ] <br>";                
                    $branch[$arrayKey] = $arrayValue;
                } else {
                    if (is_array($arrayValue)) {
                        //echo "[ $arrayKey: recursion ] <br>";  
                        $temp = $this->getBranch($arrayValue, $value);
                        if (count($temp) > 0) {
                            $branch += $temp;
                        }
                    } else if ($arrayValue === $value) {
                        //echo "[ add:  array(0 => $arrayValue)] <br>";  
                        $branch = array(0 => $arrayValue);
                    } else {
                        //echo "$arrayKey : smth else <br>";  
                    }
                }
            }
            
            return $branch;
        }       
 
        public function getBranchIDs($array) 
        { 
            $IDs = array() ;
            foreach ($array as $key => $value) {
                if(is_array($value)) {
                    $IDs[] = substr($key,5);
                    $tmp = $this->getBranchIDs($value);
                    foreach ($tmp as $block) {
                        $IDs[] = $block;
                    }
                } else {
                    $IDs[] = substr($value,5);
                }
            }
            return $IDs;
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
                    $blockName = 'block'.$element['ID'];
                    $treeRoot += array($blockName => $element['ID']);
                    unset($blockName);
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
                    $blockName = 'block'.$element['ID'];
                    $branch[$blockName] = $this->makeTreeBranches($htmlTree,$element['ID']);
                    unset($blockName);
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
        
        public function modalHtml($modalId,$modalTitle,$modalBody) 
        { 
            return   '
            <!-- Modal -->
                <div class="modal fade" id="'.$modalId.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="exampleModalLongTitle">'.$modalTitle.'</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">'.$modalBody.'</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </div>
                </div>
            <!-- /Modal -->
                ';
        }
       
        public function addContentBlock($post) 
        {
            $count = $this->model->addContentBlock($post['rows'],$post['id'],$post['type'][0]);
            
            $this->go->go(
                array(
                    'page' => 'project',
                    'id' => $post['id']
                )
            );
  
        }
      
        public function addNewElement($post) 
        {
            // add:
            $this->model->addNewElement($post['rows'],$post['id'],$post['branch_id'],$post['class_name'],$post['type'][0]);
            
            $this->go->go(
                array(
                    'page'=>'project',
                    'id' => $post['id'],
                    'new_rows' => $post['rows'],
                    'id_name' => $post['id_name'],
                    'class_name' => $post['class_name']
                )
            );
        }
        
        public function deleteElement($post)
        {
            $this->model->deleteElement($post['branch_id']);

            $this->go->go(
                array(
                    'page'=>'project',
                    'id' => $post['id'],
                    'deleted' => $post['branch_id']
                )
            );
        }
        
        public function favElement($post)
        {
            $this->model->favElement($post['branch_id']);
            
            $this->go->go(
                array(
                    'page'=>'project',
                    'id' => $post['id'],
                    'deleted' => $post['branch_id']
                )
            );
        }

        #
        #   All actions:
        #
        
        public function getAllClasses($projectId)
        {
            return $this->model->getAllClasses($projectId);
        }
        
        public function getProjectStyle($projectId)
        {
             return $this->model->getProjectStyle($projectId);
        }
        
        public function editBodyStyle($post) 
        {
            $this->changingStyles('edit','body','body',$post['projectId'],null,$post,$post['param'],'classes_editor',NULL);
        }
        
        public function editClassStyle($post)
        {
            $this->changingStyles('edit','body',$post['className'],$post['projectId'],null,$post,$post['param'],'classes_editor',NULL);
        }   
        
        public function editElement($post) 
        {
            $this->changingStyles('edit','element','',null,$post['element_id'],$post,null,'edit_element',NULL);
        } 
        
        public function addOtherOption($post)
        {            
            $this->changingStyles('add','identifier','other',null,$post['id'],$post['option'][0],$post['value'],'edit_element',NULL);
        }
        
        public function addCssOption($post)
        {
            $this->changingStyles('add','identifier','css',null,$post['id'],$post['option'][0],$post['value'],'edit_element',NULL);
        }
        
        public function addNewClassStyle($post)
        {
            $this->changingStyles('add','class',$post['className'],$post['projectId'],null,$post['option'][0],$post['value'],'classes_editor',NULL);
        }

        public function addNewBodyStyle($post)
        {
            $this->changingStyles('add','body','body',$post['projectId'],null,$post['option'][0],$post['value'],'classes_editor',NULL);
        } 

        public function deleteClassOption($post)
        {            
            $this->changingStyles('delete','class_style',$post['className'],$post['projectId'],null,$post['className'],$post['param'],'classes_editor',NULL);
        }
        
        public function deleteBodyOption($post)
        {  
            $this->changingStyles('delete','body','body',$post['projectId'],null,$post['className'],$post['param'],'classes_editor',NULL);
        }

        public function deleteOtherOption($post)
        {            
            $this->changingStyles('delete','identifier','other',null,$post['id'],$post['param'],$post['value'],'edit_element',NULL);
        }
        
        public function deleteCssOption($post) 
        {
            $this->changingStyles('delete','identifier','css',null,$post['id'],$post['param'],$post['value'],'edit_element',NULL);
        }        
        
        #
        #   Method to handling all actions with styles
        #
        
        public function changingStyles($actionType,$actionWith,$whatToAdd,$projectId = null,$elementId = null,$cssName = null ,$cssValue = null,$page,$className = NULL)
        {
            if ($actionType == 'add') {
                if ($actionWith == 'body') {
                    
                    # ADD NEW BODY STYLE:
                    $style = $this->getProjectStyle($projectId)['globalStyles'];
                    $styleArray = json_decode($style, true);
                    // add to style array:
                    $styleArray[$whatToAdd][$cssName] = $cssValue;
                    // save to db:
                    $this->model->changeProjectStyle($projectId,json_encode($styleArray));
                    $this->go->go(array('page' => $page,'projectId' => $projectId));
                } else if ($actionWith == 'identifier') {
                    
                    # ADD NEW IDENTIFIER STYLE:
                    $style = $this->model->getElementInfo($elementId)['style'];
                    $styleArray = json_decode($style, true);
                    $styleArray[$whatToAdd][$cssName] = $cssValue;
                    // save to db:
                    $this->model->deleteElementStyle($elementId,json_encode($styleArray));
                    $this->go->go(array('page' => $page,'id' => $elementId));
                    
                } else if ($actionWith == 'class') {
                    
                    # ADD NEW CLASS STYLE:
                    $style = $this->getProjectStyle($projectId)['globalStyles'];
                    $styleArray = json_decode($style, true);
                    // add to style array:
                    $styleArray[$whatToAdd][$cssName] = $cssValue;
                    // save to db:
                    $this->model->changeProjectStyle($projectId,json_encode($styleArray));
                    $this->go->go(array('page'=> $page,'projectId' => $projectId,'class' => $whatToAdd));
                }
            } else if ($actionType == 'delete') {
                if ($actionWith == 'class_style') {
                    
                    # DELETE CLASS CSS STYLE:
                    $style = $this->getProjectStyle($projectId)['globalStyles'];
                    $styleArray = json_decode($style, true);
                    // delete other option:
                    unset($styleArray[$whatToAdd][$cssValue]);
                    // save to db:
                    $this->model->changeProjectStyle($projectId,json_encode($styleArray));
                    $this->go->go(array('page'=> $page,'projectId' => $projectId,'class' => $whatToAdd));
                
                } else if ($actionWith == 'body') {
                    
                    # DELETE BODY CSS STYLE:
                    $style = $this->getProjectStyle($projectId)['globalStyles'];
                    $styleArray = json_decode($style, true);
                    // delete other option:
                    unset($styleArray[$whatToAdd][$cssValue]);
                    // save to db:
                    $this->model->changeProjectStyle($projectId,json_encode($styleArray));
                    $this->go->go(array('page'=> $page,'projectId' => $projectId));
                    
                } else if ($actionWith == 'identifier') {
                    
                    # DELETE IDENTIFIER CSS STYLE:
                    $style = $this->model->getElementInfo($elementId)['style'];
                    $styleArray = json_decode($style, true);
                    // delete other option:
                    unset($styleArray[$whatToAdd][$cssName]);
                    // save to db:
                    $this->model->deleteElementStyle($elementId,json_encode($styleArray));
                    $this->go->go(array('page'=> $page,'id' => $elementId));
                    
                }
            } else if ($actionType == 'edit') {
                if ($actionWith == 'body') {
                    
                    # EDIT BODY AND CLASS CSS STYLE:
                    $style = json_decode($this->getProjectStyle($projectId)['globalStyles'],true);
                    $css = array();
                    // make new style array:
                    foreach ($cssName as $key => $value) {
                        if (in_array($key,configuration::STYLE)) {
                            // TODO: add 'px' and '#' to values
                            $css[$key] = $value;
                        }
                    }
                    // put new style to grobalStyle:
                    $style[$whatToAdd] = $css;
                    // save:
                    $this->model->changeProjectStyle($projectId,json_encode($style));
                    if ($whatToAdd == 'body') {
                        $this->go->go(array('page'=> $page,'projectId' => $projectId));
                    } else {
                        $this->go->go(array('page'=> $page,'projectId' => $projectId, 'class' => $whatToAdd));
                    }
                    
                } else if ($actionWith == 'element') {
                    
                        # EDIT ELEMENT CSS STYLE:
                        $style = array();
                        $other = array();
                        $css = array();
                        
                        foreach ($cssName as $key => $value) { 
                            if (in_array($key,configuration::STYLE)) {
                                // TODO: add 'px' and '#' to values
                                $css[$key] = $value;
                            }
                            if (in_array($key,configuration::OTHER)) {
                                $other[$key] = $value;
                            }  
                        }
                        
                        if (count($css) > 0 or count($other) > 0) {      
                            $style['css'] = $css;
                            $style['other'] = $other;
                            $this->model->updateElementStyle($elementId,json_encode($style),$cssName['identifier'],$cssName['class']);
                        } else {
                            // if all styles deleted:
                           $this->model->updateElementStyle($elementId,NULL,$cssName['identifier'],$cssName['class']);
                        }
                        
                        $redirect_to = CONFIGURATION::MAIN_URL.'?page='.$page.'&id='.$elementId;
                        $this->go->go(array('page'=> $page,'id' => $elementId));
                        
                }
            }
        }           
        
        ###
        
        public function addLeaves($post) 
        {
            $this->model->addLeaves($post['block_id'],$post['type'][0],$post['rows'],$post['class_name'],$post['project_id']);
            $this->go->go(array('page'=> 'project','id' => $post['project_id']));
        }
        
        public function changeParent($post)
        {
            $this->model->changeParent($post['branch_id'],$post['newparent'][0]) ;   
            $this->go->go(array('page'=> 'project','id' => $post['id']));            
        }
        
        public function currentTreeCopy($post)
        {
            var_dump($post);
            exit();
        }
      
      
        public function increasePriority($post) 
        {
            // get full tree:
            $tree = $this->getDocumentTree($post['project_id']);
            
            // search parent id for current branch:
            foreach($tree AS $branch) {
                if ($branch['ID'] == $post['block_id']) {
                    $rootForWork = $branch['parentId'];
                }
            }
            
            $branchArray = array();
            // make current branch array:
            foreach($tree AS $branch) {
                if ($branch['parentId'] == $rootForWork) {
                    $branchArray[$branch['ID']] = $branch['priority'];
                }
            }            
          
            // reverse array:
            $newKeys = array_reverse(array_keys($branchArray));
            $newValues= array_reverse(array_values($branchArray));
            $branchArray = array_combine($newKeys,$newValues);
            $changeArray = array();
            
            $walk = 0;
            $nextElement = 0;
            foreach ($branchArray as $blockId => $priority) {    
                if ($blockId == $post['block_id']) {
                    $walk = 1;
                }
                if ($walk == 1) {
                    $changeArray[$blockId] = $priority;
                }
            }
            
            // increase priority:
            $elementCount = 0;
            foreach($changeArray as $bid => $bpriority) {  

                if ($last_block > 0) {
                    if ($elementCount == 1) {
                        $changeArray[$last_block] = $bpriority + 1;
                        $currentPriority = $bpriority + 1;
                    } else {
                        if ($changeArray[$bid] <= $currentPriority) {
                            $changeArray[$bid] = $currentPriority + 1;
                            $currentPriority = $currentPriority + 1;
                        }
                    }
                }
                
                $last_block = $bid; 
                $last_priority = $bpriority;
                $elementCount = $elementCount + 1;
                
            }

            // insert new priority to DB
            foreach($changeArray as $blockId => $newPriority) {  
                $this->model->updateBlockPriority($blockId, $newPriority);
            }
 
            $this->go->go(array('page'=> 'project','id' => $post['project_id']));  
        }
        
        public function decreasePriority($post) 
        {
            
            // get full tree:
            $tree = $this->getDocumentTree($post['project_id']);
            
            // search parent id for current branch:
            foreach($tree AS $branch) {
                if ($branch['ID'] == $post['block_id']) {
                    $rootForWork = $branch['parentId'];
                }
            }
            
            $branchArray = array();
            // make current branch array:
            foreach($tree AS $branch) {
                if ($branch['parentId'] == $rootForWork) {
                    $branchArray[$branch['ID']] = $branch['priority'];
                }
            }
            
            // walk:
            $walk = 0;
            $nextElement = 0;
            foreach ($branchArray as $blockId => $priority) {    
                if ($blockId == $post['block_id']) {
                    $walk = 1;
                }
                if ($walk == 1) {
                    $changeArray[$blockId] = $priority;
                }
            }
            
            // decrease priority:
            $elementCount = 0;
            foreach($changeArray as $bid => $bpriority) {  

                if ($last_block > 0) {
                    if ($elementCount == 1) {
                        $changeArray[$last_block] = $bpriority - 1;
                        $currentPriority = $bpriority - 1;
                    } else {
                        if ($changeArray[$bid] >= $currentPriority) {
                            $changeArray[$bid] = $currentPriority - 1;
                            $currentPriority = $currentPriority - 1;
                        }
                    }
                }
                
                $last_block = $bid; 
                $last_priority = $bpriority;
                $elementCount = $elementCount + 1;
                
            }
            
            // insert new priority to DB
            foreach($changeArray as $blockId => $newPriority) {  
                $this->model->updateBlockPriority($blockId, $newPriority);
            }
            
            $this->go->go(array('page'=> 'project','id' => $post['project_id']));  
        }
        
    } // class pure end
    
    require 'class_cron.php';
    require 'classes_pm/class_beautifyDom.php';
    require 'classes_pm/class_form.php';
    require 'classes_pm/class_table.php';
    require 'classes_pm/class_go.php';
    require 'classes_pm/class_objections.php';
    require 'classes_pm/class_experience.php';
    require 'classes_pm/class_projects.php';
    require 'classes_pm/class_fonts.php';
    require 'classes_pm/class_colors.php';