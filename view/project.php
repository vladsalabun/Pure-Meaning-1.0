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
    function upArrow($blockId, $priotiry) {
        echo '<form method="POST" id="form'.$blockId.'" action="" autocomplete="OFF" style="float: left;">
        <input type="hidden" name="action" value="increase_priority">
        <input type="hidden" name="block_id" value="'.$blockId.'">
        <input type="hidden" name="project_id" value="'.$_GET['id'].'">
        </form>
        <span onclick = \'document.getElementById("form'.$blockId.'").submit()\' class="glyphicon glyphicon-upload"></span>';
    }
    function downArrow($blockId, $linkParam) {
        echo '
        <a href="'.configuration::MAIN_URL.'?page='.$_GET['page'].'&id='.$_GET['id'].'" class="glyphicona"><span class="glyphicon glyphicon-download"></span></a>';
    }    
    function extendArrow($blockId, $linkParam) {
        echo '
        <a href="'.configuration::MAIN_URL.'?page='.$_GET['page'].'&id='.$_GET['id'].'" class="glyphicona"><span class="glyphicon glyphicon-tree-deciduous"></span></a>';
    } 
    function intendArrow($blockId, $linkParam) {
        echo '
        <a href="'.configuration::MAIN_URL.'?page='.$_GET['page'].'&id='.$_GET['id'].'" class="glyphicona"><span class="glyphicon glyphicon-grain"></span></a>';
    }    
     function editArrow($blockId, $linkParam) {
        echo '
        <a '.$linkParam.' href="" class="glyphicona"><span class="glyphicon glyphicon-edit"></span></a>';
    }

    
    if ($_GET['new_rows'] > 0) {
?>
        <font color="green">Added <?php echo $_GET['new_rows']; ?> new rows!</font>
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
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $elementInfo = $temp->getElementInfo(substr($key,5));

                echo '<li>'.$key.':'; 
                echo strlen($elementInfo['identifier']) > 0 ? ' id: <b>'.$elementInfo['identifier'].'</b>' : ''; 
                echo strlen($elementInfo['class']) > 0 ? ' class: <b>'.$elementInfo['class'].'</b>': '';
                echo ' [ <a href="" data-toggle="modal" data-target="#ModalBlock'.substr($key,5).'">edit</a> | <a href="">add</a> ] </li>';

                // generate title:
                $modaTittle = 'Block #'.substr($key,5).'<br><h3 class="modal-title" id="exampleModalLongTitle">'; 
                if (strlen($elementInfo['identifier']) > 0) {
                    $modaTittle .= ' id: <b>'.$elementInfo['identifier'].'</b><br>';
                } 
                if (strlen($elementInfo['class']) > 0) {
                    $modaTittle .=' class: <b>'.$elementInfo['class'].'</b>';
                }
                $modaTittle .= '</h3>';
                
                // TODO: generate body: 
                $modalBody = 'body';
                
                echo $temp->modalHtml('ModalBlock'.substr($key,5),$modaTittle,$modalBody);
                
                showDOM($value);
                
                
                
            } else {
                $blockId = substr($value,5);

                echo '
                
                <!--- Element --->
                <li>'.$value.':';
                
                $elementInfo = $temp->getElementInfo($blockId);
                if (strlen($elementInfo['identifier']) > 0) {
                    echo ' id: <b>'.$elementInfo['identifier'].'</b>';
                }
                if (strlen($elementInfo['class']) > 0) {
                    echo ' class: <b>'.$elementInfo['class'].'</b> [';
                }
                
                // navigation buttons:
                echo ' '
                .upArrow($blockId, $elementInfo['priority'])
                .downArrow($blockId,'')
                .extendArrow($blockId,'')
                .intendArrow($blockId,'')
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
         echo '</ul>';
    }

        showDOM($cleanArray);

    } else {
        // if there is no content blocks:
    }
?>   
    </div>
</div>

