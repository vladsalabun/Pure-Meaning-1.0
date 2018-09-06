<?php 
    $projects = new projects;
    $projectArray = $projects->getProjectInfo($_GET['id']);
    $projectName = $projectArray[0]['title'];   
    $projectParent = $projectArray[0]['parentId'];  
    $parentName = $projects->getProjectInfo($projectParent)[0]['title'];
    $subProjectsArray = $projects->getAllSubProjects($projectParent);     
?>

<div class="row">
<div class="col-lg-12">
<p><a href="<?php echo configuration::MAIN_URL; ?>?page=projects">back</a></p>
</div>
    <div class="col-lg-3">
    <h4><?php echo $icon->showIcon('prototype','','').' '.$parentName; ?></h4>
    <ul class="tree">
<?php 
    foreach ($subProjectsArray as $subProject) {
        if ($subProject['ID'] == $_GET['id']) {
            echo '<li><span class="fontB">'.$subProject['title'].'</span> 
            <a href="'.configuration::MAIN_URL.'?page=preview&projectId='.$_GET['id'].'" target="blank">
            '.$icon->showIcon('eye','width20','Перегляд').'</a>
            </li>';
        } else {
            echo '<li><a href="'.configuration::MAIN_URL.'?page=project&id='.$subProject['ID'].'">'.$subProject['title'].'</a></li>';
        }
    }
?>
    <li>+</li>
    </ul>
    </div>
	<div class="col-lg-9" align="left" style="font-size: 15px;">
    
    
    
    
    
    
<?php 
    // TODO: log actions
    
    // Беру всі елементи з бази даних:
    $htmlTree = $pure->getDocumentTree($_GET['id']);

    foreach ($htmlTree AS $singleElement) {
        $branchArray[] = $singleElement['ID'];
    }
        
    if (is_array($branchArray)){
        asort($branchArray);
    }
 
        
    if (count($htmlTree) > 0 ) {

        // clean them to make sure they are good for use:
        $cleanArray = $pure->cleanLeaves($pure->createTreeArray($htmlTree));

        # copy from buffer modal:
        $currentCopyBody = 
             $form->formStart()
            .$form->hidden(array('name'=> 'action','value'=> 'copy_from_buffer'))
            .$form->hidden(array('name'=> 'id','value'=> $_GET['id']))     
            .$table->tableStart(array('th' => array('','projectID:','elementID:','MyNote:','time'),'class' => 'table table-sm table-mini'));

        $buffer = $pure->getBuffer(10);   
        
        foreach ($buffer as $bufferArray) {   

            if($bufferArray['projectID'] == $_GET['id']) {
                $buffeProjectID = 'поточна сторінка';
            } else {
                $buffeProjectID = $projects->getProjectInfo($bufferArray['projectID'])[0]['title'];
            }
            
            $currentCopyBody .=
             $table->tr(array(
                '<input type="checkbox" name="buffer[]" value="'.$bufferArray['ID'].'">',$buffeProjectID,$bufferArray['elementID'],$bufferArray['myNote'],date('H:i:s Y/m/d',$bufferArray['time'])
                )
             ); 
        }
             
        $currentCopyBody .=     
             $table->tr(array(
                '','','','',$form->submit(array('name'=> '','value'=> 'Insert','class'=>'btn btn-success'))
                )
             )             
            .$table->tableEnd()           
            .$form->formEnd();
        
        echo modalWindow('copyFromBuffer','Копіювання з буфера:',$currentCopyBody);

        # <- /copy from buffer

?>   
    
    
    <h4><?php echo $icon->showIcon('tree','',''). ' DOM Tree: «'.$projectName ; ?>» <small>[ <a href="<?php echo configuration::MAIN_URL;?>?page=classes_editor&projectId=<?php echo $_GET['id'];?>">Редагування класів</a>
        | <a href="" data-toggle="modal" data-target="#copyFromBuffer">Буфер</a> ]</small></h4>
<?php       


    ### ЗАПУСК ФУНКЦІЇ ВІДОБРАЖЕННЯ ДЕРЕВА:

    function showDOM($array,$branchArray) {
              
        $temp = new pure;
        $form = new formGenerator;    
        $table = new tableGenerator;
        $mw = new modal;
        $icon = new icon
?>   

<ul align="left" style="list-style-type: none;" class="tree">
<?php 


    // ДОДАВАННЯ НОВИХ ГІЛОК:
    
    $keysArray = array_keys($array);
    if (is_array($array[$keysArray[0]])) {
        $addId = $keysArray[0];
    } else {
        $addId = $array[$keysArray[0]];
    }
    
    $addBody = p('Скільки елементів потрібно створити:')
    .$form->formStart()
    .'<p><select name="type[]">';
    
    foreach(configuration::ELEMENTS as $elementIdentifier => $elementName) {
        $addBody .= '<option value="'.$elementIdentifier.'">'.$elementName.'</option>';
    }
    
    $addBody .='</select></p>'
	.$form->hidden(array('name'=> 'action','value'=> 'add_new_element'))
	.$form->hidden(array('name'=> 'id','value'=> $_GET['id']))
	.$form->hidden(array('name'=> 'branch_id','value'=> $addId))

	.'<p><input type="number" name="rows" placeholder="0" value="1" class="txtfield"></p>
	<p><input type="text" name="class_name" placeholder="class_name (default: row)" class="txtfield"></p>' // TODO: тут потрібні підказки по назвам класів
    .$form->submit(array('name'=> 'submit','value'=> 'Додати','class'=>'btn btn-success'))
    .$form->formEnd();
    
        echo modalWindow('AddMainRow'.$addId,'Додавання нових гілок до гілки: '.substr($addId,5), $addBody);
    
     // <--- ДОДАВАННЯ НОВИХ ГІЛОК:


 
        foreach ($array as $key => $value) {
            if (is_array($value)) {

                $blockId = substr($key,5);

                $elementInfo = $temp->getElementInfo($blockId);
                
                echo '
                <!--- Element --->
                <li><span class="fontB">'.configuration::ELEMENTS[$elementInfo['type']].'</span>: #'.$blockId.' ';               
 
                if (strlen($elementInfo['identifier']) > 0) {
                    echo '<span class="fontB"><a href="'.configuration::MAIN_URL.'?page=edit_element&id='.$blockId.'" title="Edit element">'.$elementInfo['identifier'].'</a></span>';
                }
                if (strlen($elementInfo['class']) > 0) {
                    echo ' class: <span class="fontB">'.$elementInfo['class'].'</span>';
                }
                                
                // navigation buttons:
                echo ' '
                .upArrow($blockId).downArrow($blockId)
                //.favourite($elementInfo['ID'],$elementInfo['moderation'])
                .editArrow($blockId, '');

            #### generate title:
                $modaTittle = generateModalTitle($elementInfo);
            #### generate body 
            
                $modalBody = '';
                
                    // get selection:
                    $selectNewParent = '<select name="newparent[]">';
                    
                    $result = $temp->getBranch($array, 'block'.$blockId);
                    $branchIDs = $temp->getBranchIDs($result);
                    
                    $result = array_diff($branchArray, $branchIDs);
                    asort($result);
                    
                    $selectNewParent .= '<option value="0">root</option>';
                    foreach ($result as $newParent) {
                        $selectNewParent .= '<option value="'.$newParent.'">'.$newParent.'</option>';
                    }
                    
                    $selectNewParent .= '</select>';
                
                $modalBody .= generateElementModalMenuBody($elementInfo,$selectNewParent);

           #### <- /generate body    
                
                echo modalWindow('ModalBlock'.$blockId,$modaTittle,$modalBody);
                
                ### РЕКУРСІЯ:
                showDOM($value,$branchArray);
                
            } else {
                
                $blockId = substr($value,5);

                $elementInfo = $temp->getElementInfo($blockId);
                
                echo '
                <!--- Element --->
                <li><span class="fontB">'.configuration::ELEMENTS[$elementInfo['type']].'</span>: #'.$blockId.' ';
                
                
                if (strlen($elementInfo['identifier']) > 0) {
                    echo '<span class="fontB"><a href="'.configuration::MAIN_URL.'?page=edit_element&id='.$blockId.'" title="Edit element">'.$elementInfo['identifier'].'</a></span>';
                }
                if (strlen($elementInfo['class']) > 0) {
                    echo ' class: <span class="fontB">'.$elementInfo['class'].'</span> ';
                }

                
                // navigation buttons:
                echo ' '
                .upArrow($blockId)
                .downArrow($blockId)
                //.favourite($elementInfo['ID'],$elementInfo['moderation'])
                .extendArrow($blockId,'')
                .editArrow($blockId, '');

            #### generate title:
                $modaTittle = generateModalTitle($elementInfo);
                
            #### generate body 
            
                $modalBody = '';
                
                
                    // get selection:
                    $selectNewParent = '<select name="newparent[]">';
                    
                    $result = $temp->getBranch($array, 'block'.$blockId);
                    $branchIDs = $temp->getBranchIDs($result);
                    
                    $result = array_diff($branchArray, $branchIDs);
                    asort($result);
                    
                    $selectNewParent .= '<option value="0">root</option>';
                    foreach ($result as $newParent) {
                        $selectNewParent .= '<option value="'.$newParent.'">'.$newParent.'</option>';
                    }
                    
                    $selectNewParent .= '</select>';
                
                $modalBody .= generateElementModalMenuBody($elementInfo,$selectNewParent);
                
           #### <- /generate body 
                
                echo modalWindow('ModalBlock'.$blockId,$modaTittle,$modalBody);
                echo '</li>';

            }
        }
        
        echo '<li><a href="" class="identifierLink" title="add new branch" data-toggle="modal" data-target="#AddMainRow'.$addId.'" title="Add branch">'.$icon->showIcon('branch','width20','Додати нову гілку').'</a></li>';
        
        echo '</ul>';
    }

        showDOM($cleanArray,$branchArray);

    } else {
        
       # Якщо ще немає DOM HTML: 
        
?>
    <h4><?php echo $icon->showIcon('tree','',''); ?> DOM is empty <small>[ <a href="" data-toggle="modal" data-target="#ModalFisrtGrid">Створити елемент</a> ]</small></h4>
<?php
    
    // if there is no content blocks:
    $addNewRowForm = 
    p('Скільки елементів створити?').'
    <form method="POST" action="" autocomplete="OFF">
	<input type="hidden" name="action" value="add_content_block">
	<input type="hidden" name="id" value="'.$_GET['id'].'">
    <p><select name="type[]">';
    
    foreach(configuration::ELEMENTS as $elementIdentifier => $elementName) {
        $addNewRowForm .= '<option value="'.$elementIdentifier.'">'.$elementName.'</option>';
    }
    
    $addNewRowForm .='</select></p>
	<p><input type="number" name="rows" placeholder="0" class="txtfield"></p>
    <p><input type="submit" name="submit" value="Add" class="submit_btn"></p>
    </form>'; 

    echo $pure->modalHtml('ModalFisrtGrid','Add content:',$addNewRowForm);
    }
?>   
    </div>    
</div>
<?php 
    
    
    
    
    
    
    
    
    
    /* -------------------------------------------------------------------------------------- */
    
    
                      # Далі йдуть функції для генерації коду!          
      
    
    /* -------------------------------------------------------------------------------------- */
    
    
    
    
    
    
    
    
    ### helpfull functions:
    
    function upArrow($blockId) {
        
        $icon = new icon;
        
        echo '<form method="POST" id="form'.$blockId.'up" action="" autocomplete="OFF" style="float: left;">
        <input type="hidden" name="action" value="increase_priority">
        <input type="hidden" name="block_id" value="'.$blockId.'">
        <input type="hidden" name="project_id" value="'.$_GET['id'].'">
        </form>'
        .$icon->showIcon('up-c','width20 pointer','Підняти','onclick = "document.getElementById(\'form'.$blockId.'up\').submit()"');
    }
    function downArrow($blockId) {
        
        $icon = new icon;
        
        echo '<form method="POST" id="form'.$blockId.'down" action="" autocomplete="OFF" style="float: left;">
        <input type="hidden" name="action" value="decrease_priority">
        <input type="hidden" name="block_id" value="'.$blockId.'">
        <input type="hidden" name="project_id" value="'.$_GET['id'].'">
        </form>'
        .$icon->showIcon('down-c','width20 pointer','Опустити','onclick = "document.getElementById(\'form'.$blockId.'down\').submit()"');
    }    
    function extendArrow($blockId) {
        $test = new pure;
        $icon = new icon;
        
        echo ' <a href="" data-toggle="modal" data-target="#AddLeaves'.$blockId.'" title="Add child element">'.$icon->showIcon('leaves','width20','Додати дочірній елемент').'</a>';
        
        $formBody = '
        <p>How many leaves you want?</p>
        <form method="POST" id="form'.$blockId.'leaves" action="" autocomplete="OFF">
        <input type="hidden" name="action" value="add_leaves">
        <input type="hidden" name="block_id" value="'.$blockId.'">
        <select name="type[]">';
        
        foreach(configuration::ELEMENTS as $elementIdentifier => $elementName) {
            $formBody .= '<option value="'.$elementIdentifier.'">'.$elementName.'</option>';
        }
    
        $formBody .='</select></p>
        <p><input type="number" name="rows" placeholder="0" class="txtfield" value="1"></p>
        <p><input type="text" name="class_name" placeholder="class_name (default: row)" class="txtfield"></p>
        <input type="hidden" name="project_id" value="'.$_GET['id'].'">
        <p><input type="submit" name="submit" value="Add" class="submit_btn"></p>
        </form>';

        echo $test->modalHtml('AddLeaves'.$blockId,'Add leaves to branch: #'.$blockId,$formBody);
    }    
    function editArrow($blockId, $linkParam) {
        $icon = new icon;
        echo ' 
        <a href="" class="identifierLink" data-toggle="modal" data-target="#ModalBlock'.$blockId.'">'.$icon->showIcon('menu','width20','Редагувати').'</a>';
    }
    function favourite($elementId,$mod) {
        
        $form = new formGenerator; 
        $icon = new icon; 
        
        if ($mod == 1) {
            $favIcon = 'heart';
            $moderation = 0;
        } else if ($mod == 0) {
            $favIcon = 'empty-heart';
            $moderation = 1;
        }
        
        echo $icon->showIcon($favIcon,'width20 pointer','Favourite','onclick="document.getElementById(\'save_to_favourite'.$elementId.'\').submit(); "');
        
        

        
        echo
         $form->formStart(array('id' => 'save_to_favourite'.$elementId, 'class' => 'floatLeft'))
        .$form->hidden(array('name' => 'action','value'=> 'fav_element'))
        .$form->hidden(array('name' => 'moderation','value'=> $moderation))
        .$form->hidden(array('name' => 'id','value'=> $_GET['id'])) // <- projectID
        .$form->hidden(array('name' => 'branch_id','value'=> $elementId)) // <- elementID
        .$form->formEnd();
    }

    function generateModalTitle($elementInfo) {

        $string = 'Блок #'.$elementInfo['ID'];
                
        if (strlen($elementInfo['identifier']) > 0) {
            $string .= ' id: <b>'.$elementInfo['identifier'].'</b> ';
        } 
        if (strlen($elementInfo['class']) > 0) {
            $string .=' class: <b>'.$elementInfo['class'].'</b> ';
        }
        
        return $string;
    }
    
    function generateElementModalMenuBody($elementInfo,$selectNewParent) {
        
        $form = new formGenerator; 
        
        return '<div class="row">
            <div class="col-sm-6 col-md-9 col-lg-9 col-xl-6 left">
            Змінити гілку:'
            .$form->formStart()
            .$form->hidden(array('name' => 'action','value'=> 'change_parent'))
            .$form->hidden(array('name' => 'id','value'=> $_GET['id']))
            .$form->hidden(array('name' => 'branch_id','value'=> $elementInfo['ID']))
            .$selectNewParent
            .p($form->submit(array('name'=> '','value'=> 'Change parent','class'=>'btn btn-success')),'center')
            .$form->formEnd()
        
            .$form->formStart(array('id' => 'delete_branch'.$elementInfo['ID']))
            .$form->hidden(array('name' => 'action','value'=> 'delete_element'))
            .$form->hidden(array('name' => 'id','value'=> $_GET['id'])) // <- projectID
            .$form->hidden(array('name' => 'branch_id','value'=> $elementInfo['ID'])) // <- elementID
            .$form->formEnd()
            # -------------------------------------------
            .$form->formStart(array('id' => 'copyToBuffer'.$elementInfo['ID']))
            .$form->hidden(array('name' => 'action','value'=> 'copy_to_buffer'))
            .$form->hidden(array('name' => 'id','value'=> $_GET['id'])) // <- projectID
            .$form->hidden(array('name' => 'branch_id','value'=> $elementInfo['ID'])) // <- elementID
            .$form->formEnd().'
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-6 right">'
            .p('<span class="deleteSpan" title="Delete branch" onclick="document.getElementById(\'delete_branch'.$elementInfo['ID'].'\').submit(); ">Видалити</span>')
            .p('<button type="button" title="Copy to buffer" onclick="document.getElementById(\'copyToBuffer'.$elementInfo['ID'].'\').submit(); " class="btn btn-info">Copy to buffer</button>').'
            </div>
            </div>';
            
    }
