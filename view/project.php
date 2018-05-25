<div class="row">
	<div class="col-lg-12" align="left" style="font-size: 15px;">
    Project ID: 
<?php echo $_GET['id'];?>
<br><a href="<?php echo configuration::MAIN_URL;?>?page=preview&projectId=<?php echo $_GET['id'];?>" target="blank">Live preview</a> 
| todo: <a href="" target="blank">Client answers</a>
| todo: <a href="" target="blank">My checklist</a>
| todo: <a href="" target="blank">subPage 1</a>

<?php 
    // TODO: log actions
    
    // take all elements from database:
    $htmlTree = $pure->getDocumentTree($_GET['id']);

    foreach ($htmlTree AS $singleElement) {
        $branchArray[] = $singleElement['ID'];
    }
    
    if (count($htmlTree) > 0 ) {
?> 
    <h4>Template:</h4>
        <p><a href="<?php echo configuration::MAIN_URL;?>?page=classes_editor&projectId=<?php echo $_GET['id'];?>">Class style editor</a></p>
        <p><a href="">Insert element from favourite</a></p>
    <h4>DOM Tree</h4>
<?php       
    // clean them to make sure they are good for use:
    $cleanArray = $pure->cleanLeaves($pure->createTreeArray($htmlTree));
 
    function showDOM($array,$branchArray) {
       
        
        $temp = new pure;
?>   

<ul align="left" style="list-style-type: none; line-height: 160%;">
<?php 
    $keysArray = array_keys($array);
    if (is_array($array[$keysArray[0]])) {
        $addId = $keysArray[0];
    } else {
        $addId = $array[$keysArray[0]];
    }
    
    $addBody = '
    <p>How many elements you want: </p>
    <form method="POST" action="" autocomplete="OFF">
    <p>
    <select name="type[]">';
    
    foreach(configuration::ELEMENTS as $elementIdentifier => $elementName) {
        $addBody .= '<option value="'.$elementIdentifier.'">'.$elementName.'</option>';
    }
    
    $addBody .='</select></p>
	<input type="hidden" name="action" value="add_new_element">
	<input type="hidden" name="id" value="'.$_GET['id'].'">
	<input type="hidden" name="branch_id" value="'.$addId.'">
	<p><input type="number" name="rows" placeholder="0" class="txtfield"></p>
	<p><input type="text" name="class_name" placeholder="class_name (default: row)" class="txtfield"></p>
    <p><input type="submit" name="submit" value="Add" class="submit_btn"></p>
    </form>'; 
?>
<?php

        foreach ($array as $key => $value) {
            if (is_array($value)) {

                $blockId = substr($key,5);

                echo '
                
                <!--- Element --->
                <li>#'.$blockId.' ';               
                
                
                $elementInfo = $temp->getElementInfo($blockId);
                if (strlen($elementInfo['identifier']) > 0) {
                    echo '<a href="" data-toggle="modal" data-target="#ModalBlock'.$blockId.'"><b>'.$elementInfo['identifier'].'</b></a>';
                }
                if (strlen($elementInfo['class']) > 0) {
                    echo ' class: <b>'.$elementInfo['class'].'</b>';
                }
                                
                // navigation buttons:
                echo ' '
                .upArrow($blockId)
                .downArrow($blockId)
                .editArrow($blockId, '');

                // generate title:
                $modaTittle = 'Block #'.$blockId.'<br>'; 
                
                if (strlen($elementInfo['identifier']) > 0) {
                    $modaTittle .= ' id: <b>'.$elementInfo['identifier'].'</b><br>';
                } 
                if (strlen($elementInfo['class']) > 0) {
                    $modaTittle .=' class: <b>'.$elementInfo['class'].'</b>';
                }
                
                $modalBody = '
                <form method="POST" action="" autocomplete="OFF">
                <input type="hidden" name="action" value="change_parent">
                <input type="hidden" name="id" value="'.$_GET['id'].'">
                <input type="hidden" name="branch_id" value="'.$blockId.'">
                <p align="left">Change branch:
                <select name="newparent[]">';
                
                $result = $temp->getBranch($array, 'block'.$blockId);
                $branchIDs = $temp->getBranchIDs($result);
                
                $result = array_diff($branchArray, $branchIDs);
                asort($result);
                
                $modalBody .= '<option value="0">0</option>';
                foreach ($result as $newParent) {
                    $modalBody .= '<option value="'.$newParent.'">'.$newParent.'</option>';
                }
                
                $modalBody .= '</select>
                <input type="submit" name="submit" value="Change parent" class="submit_btn"></p>
                ';
                $modalBody .= '</form>';
                
                
                $modalBody .= '
                <p>Other options:
                <form method="POST" action="" autocomplete="OFF">
                <input type="hidden" name="action" value="fav_element">
                <input type="hidden" name="id" value="'.$_GET['id'].'">
                <input type="hidden" name="branch_id" value="'.$blockId.'">
                <p align="left"><input type="submit" name="submit" value="Save to favourite" class="submit_btn">
                </form>
                
                <form method="POST" action="" autocomplete="OFF">
                <input type="hidden" name="action" value="delete_element">
                <input type="hidden" name="id" value="'.$_GET['id'].'">
                <input type="hidden" name="branch_id" value="'.$blockId.'">
                <p align="left"><input type="submit" name="submit" value="Delete branch #'.$blockId.'" class="submit_btn"></a>
                </form>
                ';
                
                echo $temp->modalHtml('ModalBlock'.$blockId,$modaTittle,$modalBody);
                
                showDOM($value,$branchArray);
                
            } else {
                $blockId = substr($value,5);

                echo '
                
                <!--- Element --->
                <li>#'.$blockId.' ';
                
                $elementInfo = $temp->getElementInfo($blockId);
                if (strlen($elementInfo['identifier']) > 0) {
                    echo '<a data-toggle="modal" data-target="#ModalBlock'.$blockId.'" href="" class="glyphicona"><b>'.$elementInfo['identifier'].'</b></a>';
                }
                if (strlen($elementInfo['class']) > 0) {
                    echo ' class: <b>'.$elementInfo['class'].'</b> ';
                }

                
                // navigation buttons:
                echo ' '
                .upArrow($blockId)
                .downArrow($blockId)
                .extendArrow($blockId,'')
                .editArrow($blockId, '');

                // generate title:
                $modaTittle = 'Block #'.$blockId.'<br>'; 
                
                if (strlen($elementInfo['identifier']) > 0) {
                    $modaTittle .= ' id: <b>'.$elementInfo['identifier'].'</b><br>';
                } 
                if (strlen($elementInfo['class']) > 0) {
                    $modaTittle .=' class: <b>'.$elementInfo['class'].'</b>';
                }
                
                $modalBody = '
                <p align="left">Change branch:
                <form method="POST" action="" autocomplete="OFF">
                <input type="hidden" name="action" value="change_parent">
                <input type="hidden" name="id" value="'.$_GET['id'].'">
                <input type="hidden" name="branch_id" value="'.$blockId.'">
                <select name="newparent[]">';
                
                
                $result = $temp->getBranch($array, 'block'.$blockId);
                $branchIDs = $temp->getBranchIDs($result);
                 
                $result = array_diff($branchArray, $branchIDs);
                asort($result);
                
                $modalBody .= '<option value="0">0</option>';
                foreach ($result as $newParent) {
                    $modalBody .= '<option value="'.$newParent.'">'.$newParent.'</option>';
                }
                
                $modalBody .= '</select>
                <input type="submit" name="submit" value="Change parent" class="submit_btn"></p>
                ';
                $modalBody .= '</form>';
                
                $modalBody .= '
                <p>Other options:</p>
                <form method="POST" action="" autocomplete="OFF">
                <input type="hidden" name="action" value="fav_element">
                <input type="hidden" name="id" value="'.$_GET['id'].'">
                <input type="hidden" name="branch_id" value="'.$blockId.'">
                <p><input type="submit" name="submit" value="Save to favourite" class="submit_btn"></p>
                </form>
                
                <form method="POST" action="" autocomplete="OFF">
                <input type="hidden" name="action" value="delete_element">
                <input type="hidden" name="id" value="'.$_GET['id'].'">
                <input type="hidden" name="branch_id" value="'.$blockId.'">
                <p><input type="submit" name="submit" value="Delete branch #'.$blockId.'" class="submit_btn"></p>
                </form>
                ';
                
                echo $temp->modalHtml('ModalBlock'.$blockId,$modaTittle,$modalBody);
                echo '</li>';

            }
        }
        
        echo '<li><a href="" data-toggle="modal" data-target="#AddMainRow'.$addId.'">++</a></li>';
        echo $temp->modalHtml('AddMainRow'.$addId,'Add new element to branch: '.$addId, $addBody);
        echo '</ul>';
    }

        showDOM($cleanArray,$branchArray);

    } else {
?>
<p>DOM is empty. You can <a href="" data-toggle="modal" data-target="#ModalFisrtGrid">add new element</a>.</p>
<?php
    // if there is no content blocks:
    $addNewRowForm = '
    <p>How many rows you want: </p>
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
    
    ### helpfull functions:
    function upArrow($blockId) {
        echo '<form method="POST" id="form'.$blockId.'up" action="" autocomplete="OFF" style="float: left;">
        <input type="hidden" name="action" value="increase_priority">
        <input type="hidden" name="block_id" value="'.$blockId.'">
        <input type="hidden" name="project_id" value="'.$_GET['id'].'">
        </form>
        <span onclick = \'document.getElementById("form'.$blockId.'up").submit()\' class="glyphicon glyphicon-upload"></span>';
    }
    function downArrow($blockId) {
        echo '<form method="POST" id="form'.$blockId.'down" action="" autocomplete="OFF" style="float: left;">
        <input type="hidden" name="action" value="decrease_priority">
        <input type="hidden" name="block_id" value="'.$blockId.'">
        <input type="hidden" name="project_id" value="'.$_GET['id'].'">
        </form>
        <span onclick = \'document.getElementById("form'.$blockId.'down").submit()\' class="glyphicon glyphicon-download"></span>';
    }    
    function extendArrow($blockId) {
        $test = new pure;
        echo ' <a href="" data-toggle="modal" data-target="#AddLeaves'.$blockId.'">child</a>';
        
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
        <p><input type="number" name="rows" placeholder="0" class="txtfield"></p>
        <p><input type="text" name="class_name" placeholder="class_name (default: row)" class="txtfield"></p>
        <input type="hidden" name="project_id" value="'.$_GET['id'].'">
        <p><input type="submit" name="submit" value="Add" class="submit_btn"></p>
        </form>';

        echo $test->modalHtml('AddLeaves'.$blockId,'Add leaves to branch: #'.$blockId,$formBody);
    }    
    function editArrow($blockId, $linkParam) {
        echo '  / <a href="'.configuration::MAIN_URL.'?page=edit_element&id='.$blockId.'">edit</a>';
    }

