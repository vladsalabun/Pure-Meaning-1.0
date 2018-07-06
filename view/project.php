<div class="row">
    <div class="col-lg-3">
    <h4>Project ID: <?php echo $_GET['id'];?></h4>
Name: <br>
Preview: <a href="<?php echo configuration::MAIN_URL;?>?page=preview&projectId=<?php echo $_GET['id'];?>" target="blank"><span class="glyphicon glyphicon-eye-open" title="Live preview"></span></a><br>
todo: <a href="" class="notcompleted" target="blank">Client answers</a><br>
todo: <a href="" class="notcompleted" target="blank">My checklist</a><br>
    <p>todo: insert elementing from: <a href="" class="notcompleted" data-toggle="modal" data-target="#copyFromCurrentTree">current tree</a> | <a class="notcompleted" href="">other tree</a> | <a href="" class="notcompleted">favourite</a> | <a href="" class="notcompleted">templates</a></p>
        <p>todo: copy <a href="" class="notcompleted">brunch style</a></p>
        <h4>Template:</h4>
        <p><a href="<?php echo configuration::MAIN_URL;?>?page=classes_editor&projectId=<?php echo $_GET['id'];?>">Body and class editor</a></p>
    </div>

	<div class="col-lg-9" align="left" style="font-size: 15px;">
    
<?php 
    // TODO: log actions
    
    // take all elements from database:
    $htmlTree = $pure->getDocumentTree($_GET['id']);

    foreach ($htmlTree AS $singleElement) {
        $branchArray[] = $singleElement['ID'];
    }
    if (is_array($branchArray)){
        asort($branchArray);
    }
    
    if (count($htmlTree) > 0 ) {

        $currentCopyBody = '
                <p align="left">Copy branch ID:</p>
                <form method="POST" action="" autocomplete="OFF">
                <input type="hidden" name="action" value="current_tree_copy">
                <input type="hidden" name="id" value="'.$_GET['id'].'">
                <table class="table table-striped">
              <thead>
                <tr>
              <th scope="col">From id:</th>
              <th scope="col">To id:</th>
              <th scope="col"></th>
              </tr>
              </thead>
                <tbody>
                <tr>
                <td>
                <select name="copyFrom[]">';
          
          
        $currentCopyBody .= '<option value="0">0</option>';
                foreach ($branchArray as $fromBranch) {
                    $currentCopyBody .= '<option value="'.$fromBranch.'">'.$fromBranch.'</option>';
                }
                
        $currentCopyBody .= '</select></td><td><select name="copyTo[]"><option value="0">0</option>';
                foreach ($branchArray as $fromBranch) {
                    $currentCopyBody .= '<option value="'.$fromBranch.'">'.$fromBranch.'</option>';
                }
                
        $currentCopyBody .= '</select></td><td></td></tr></form>
        <tr><td></td><td></td><td><input type="submit" name="submit" value="Copy" class="submit_btn"></td></tr>
        </tbody>
</table>';
        
        echo $pure->modalHtml('copyFromCurrentTree','Copy from current tree',$currentCopyBody);


?>   
    
    
    <h4>DOM Tree</h4>
<?php       
    // clean them to make sure they are good for use:
    $cleanArray = $pure->cleanLeaves($pure->createTreeArray($htmlTree));
 
    function showDOM($array,$branchArray) {
       
        
        $temp = new pure;
?>   

<ul align="left" style="list-style-type: none; line-height: 160%;" class="tree">
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
	<p><input type="number" name="rows" placeholder="0" value="1" class="txtfield"></p>
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
                    echo '<a href="" class="identifierLink" data-toggle="modal" data-target="#ModalBlock'.$blockId.'"><b>'.$elementInfo['identifier'].'</b></a>';
                }
                if (strlen($elementInfo['class']) > 0) {
                    echo ' class: <b>'.$elementInfo['class'].'</b>';
                }
                                
                // navigation buttons:
                echo ' '.upArrow($blockId).downArrow($blockId);
                if ($elementInfo['moderation'] == 1) { echo favourite(); }
                echo editArrow($blockId, '');

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
                    echo '<a data-toggle="modal" class="identifierLink" data-target="#ModalBlock'.$blockId.'" href="" class="glyphicona"><b>'.$elementInfo['identifier'].'</b></a>';
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
        
        echo '<li><a href="" class="identifierLink" title="add new branch" data-toggle="modal" data-target="#AddMainRow'.$addId.'" title="Add branch"><span class="glyphicon glyphicon-menu-down"></span></a></li>';
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
        <span onclick = \'document.getElementById("form'.$blockId.'up").submit()\' class="glyphicon glyphicon-upload" title="up"></span>';
    }
    function downArrow($blockId) {
        echo '<form method="POST" id="form'.$blockId.'down" action="" autocomplete="OFF" style="float: left;">
        <input type="hidden" name="action" value="decrease_priority">
        <input type="hidden" name="block_id" value="'.$blockId.'">
        <input type="hidden" name="project_id" value="'.$_GET['id'].'">
        </form>
        <span onclick = \'document.getElementById("form'.$blockId.'down").submit()\' class="glyphicon glyphicon-download" title="down"></span>';
    }    
    function extendArrow($blockId) {
        $test = new pure;
        echo ' <a href="" data-toggle="modal" data-target="#AddLeaves'.$blockId.'" title="Add child element"><span class="glyphicon glyphicon-menu-down"></span></a>';
        
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
        echo ' <a href="'.configuration::MAIN_URL.'?page=edit_element&id='.$blockId.'" title="Edit element"><span class="glyphicon glyphicon-pencil"></span></a>';
    }
    function favourite() {
        echo ' <span class="glyphicon glyphicon-heart" title="Favourite"></span>';
    }   
    

