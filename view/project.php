<div class="row">
	<div class="col-lg-12" align="left">Project: 
<?php echo $_GET['id'];?>
<p><a href="<?php echo configuration::MAIN_URL;?>?page=preview&projectId=<?php echo $_GET['id'];?>" target="blank">Посилання на готовий шаблон</a></p>
<p>TODO:</p>
<ol align="left">
    <li>Стандартні запитання і відповіді до клієнта</li>
    <li>Стандартні запитання і відповіді до мене (робочий чек-лист)</li>
    <li>Деталі замовлення</li>
</ol>
<style>
.glyphicon {text-align: none; float: none;}
.glyphicon:hover {color: #1258DC; cursor: hand; }
.glyphicona {color: #000;}
</style>
<h3>Шаблон:</h3>
<?php 
    
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
        echo '<a href="" data-toggle="modal" data-target="#AddLeaves'.$blockId.'"><span class="glyphicon glyphicon-grain"></span></a>';
        
        $formBody = '
        <p>How many leaves you want?</p>
        <form method="POST" id="form'.$blockId.'leaves" action="" autocomplete="OFF">
        <input type="hidden" name="action" value="add_leaves">
        <input type="hidden" name="block_id" value="'.$blockId.'">
        <p><select name="type[]">
        <option selected value="2">div</option>
        <option value="3">button</option>
        <option value="4">image</option>
        </select></p>
        <p><input type="number" name="rows" placeholder="0" class="txtfield"></p>
        <p><input type="text" name="id_name" placeholder="id_name" class="txtfield"></p>
        <p><input type="text" name="class_name" placeholder="class_name (default: row)" class="txtfield"></p>
        <input type="hidden" name="project_id" value="'.$_GET['id'].'">
        <p><input type="submit" name="submit" value="Add" class="submit_btn"></p>
        </form>';

        echo $test->modalHtml('AddLeaves'.$blockId,'Add leaves to branch: #'.$blockId,$formBody);
    }    
    function editArrow($blockId, $linkParam) {
        echo '
        <a '.$linkParam.' href="" class="glyphicona"><span class="glyphicon glyphicon-edit"></span></a>';
    }

    
    if ($_GET['new_rows'] > 0) {
?>
        <font color="green">Added <?php echo $_GET['new_rows']; ?> new elements 
        <?php 
            if (strlen($_GET['id_name']) > 0) {
                echo 'id: <b>' . $_GET['id_name'].'</b> ';
            }
            if (strlen($_GET['class_name']) > 0) {
                echo 'class: <b>'.$_GET['class_name'].'</b> '; 
            }
        ?>
        </font>
<?php
    }
?>
<p><a href="" data-toggle="modal" data-target="#ModalFisrtGrid">Add content block</a></p>
<?php
    $fisrtGridBody = '
    <p>How many content block you want: </p>
    <form method="POST" action="" autocomplete="OFF">
	<input type="hidden" name="action" value="add_content_block">
	<input type="hidden" name="id" value="'.$_GET['id'].'">
	<p><input type="number" name="rows" placeholder="0" class="txtfield"></p>
    <p><input type="submit" name="submit" value="Add" class="submit_btn"></p>
    </form>'; 

    echo $pure->modalHtml('ModalFisrtGrid','Add content:',$fisrtGridBody);
?>
<?php 
    // take all elements from database:
    $htmlTree = $pure->getDocumentTree($_GET['id']);
    if (count($htmlTree) > 0 ) {
    // clean them to make sure they are goot for use:
    $cleanArray = $pure->cleanLeaves($pure->createTreeArray($htmlTree));
 
    function showDOM($array) {
        $temp = new pure;
?>   

<ul align="left">
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
    <p><select name="type[]">
    <option selected value="2">div</option>
    <option value="3">button</option>
    <option value="4">image</option>
   </select></p>
	<input type="hidden" name="action" value="add_new_element">
	<input type="hidden" name="id" value="'.$_GET['id'].'">
	<input type="hidden" name="branch_id" value="'.$addId.'">
	<p><input type="number" name="rows" placeholder="0" class="txtfield"></p>
	<p><input type="text" name="id_name" placeholder="id_name" class="txtfield"></p>
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
                    echo ' id: <b>'.$elementInfo['identifier'].'</b>';
                }
                if (strlen($elementInfo['class']) > 0) {
                    echo ' class: <b>'.$elementInfo['class'].'</b> [';
                }
                                
                // navigation buttons:
                echo ' '
                .upArrow($blockId)
                .downArrow($blockId)
                .editArrow($blockId, 'data-toggle="modal" data-target="#ModalBlock'.$blockId.'"').' ]';

                // generate title:
                $modaTittle = 'Block #'.$blockId.'<br>'; 
                
                if (strlen($elementInfo['identifier']) > 0) {
                    $modaTittle .= ' id: <b>'.$elementInfo['identifier'].'</b><br>';
                } 
                if (strlen($elementInfo['class']) > 0) {
                    $modaTittle .=' class: <b>'.$elementInfo['class'].'</b>';
                }
                
                // TODO: generate body: 
                $modalBody = 'body';
                
                echo $temp->modalHtml('ModalBlock'.$blockId,$modaTittle,$modalBody);
                
                showDOM($value);
                
            } else {
                $blockId = substr($value,5);

                echo '
                
                <!--- Element --->
                <li>#'.$blockId.' ';
                
                $elementInfo = $temp->getElementInfo($blockId);
                if (strlen($elementInfo['identifier']) > 0) {
                    echo ' id: <b>'.$elementInfo['identifier'].'</b>';
                }
                if (strlen($elementInfo['class']) > 0) {
                    echo ' class: <b>'.$elementInfo['class'].'</b> [';
                }

                
                // navigation buttons:
                echo ' '
                .upArrow($blockId)
                .downArrow($blockId)
                .extendArrow($blockId,'')
                .editArrow($blockId, 'data-toggle="modal" data-target="#ModalBlock'.$blockId.'"').' ]';

                // generate title:
                $modaTittle = 'Block #'.$blockId.'<br>'; 
                
                if (strlen($elementInfo['identifier']) > 0) {
                    $modaTittle .= ' id: <b>'.$elementInfo['identifier'].'</b><br>';
                } 
                if (strlen($elementInfo['class']) > 0) {
                    $modaTittle .=' class: <b>'.$elementInfo['class'].'</b>';
                }
                
                // TODO: generate body: 
                $modalBody = 'body';
                
                echo $temp->modalHtml('ModalBlock'.$blockId,$modaTittle,$modalBody);
                echo '</li>';

            }
        }
        
        echo '<li><a href="" data-toggle="modal" data-target="#AddMainRow'.$addId.'">+ add element</a></li>';
        echo $temp->modalHtml('AddMainRow'.$addId,'Add new element to branch: '.$addId, $addBody);
        echo '</ul>';
    }

        showDOM($cleanArray);

    } else {
        // if there is no content blocks:
    }
?>   
    </div>
</div>

