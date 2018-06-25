<?php 
    // get element info: 
    $element = $pure->getElementInfo($_GET['id']);
    // get projectId:
    $projectId = $element['projectId'];
    // make style array:
    $style = json_decode($element['style'],true);

    // TODO:
    # 1. Таблицю стилей компактно
    # 2. Випадаючий список підказок
    # 3. Шрифти з випадаючого списку (пишеш букву і випадає підказка)
    # 4. Корні гілки, яку я зараз переглядаю

?>
<div class="row">
	<div class="col-lg-12">
    
    <p align="left">
        ← <a href="<?php echo configuration::MAIN_URL;?>?page=project&id=<?php echo $element['projectId']; ?>">
        Back to project <?php echo $element['projectId']; ?></a>
    </p>
    <h4>Edit element: #<?php echo $element['ID']; ?></h4>
    <p align="left">
    + add 
        <?php echo $mw->a(array('anchor'=>'other option','window'=>'other_option')); ?>
     or
        <?php echo $mw->a(array('anchor'=>'style','window'=>'add_new_style')); ?>
    </p>
    
<?php     
    echo 
     $form->formStart()
    .$form->hidden(array('name' => 'action','value' => 'edit_element'))
    .$form->hidden(array('name' => 'element_id','value' => $element['ID']))
    .$form->hidden(array('name' => 'id','value' => $_GET['projectId']))
?>
<div class="row">
	<div class="col-lg-5 col-md-5">    
<?php 
    
    echo 
     $table->tableStart(array('class'=>'table table-sm table-mini','th'=> array('Option','Value:')))
    .$table->tr(array('identifier',$form->text(array('name' => 'identifier','value' => $element['identifier'],'class'=>'txtfield')),''))
    .$table->tr(array('class',$form->text(array('name'=>'class','value' => $element['class'],'class'=>'txtfield')),''))
    .$table->tr(array('<b>Other:</b>','',''));
    
    // show all other params:
    if (count($style['other']) > 0) {
        foreach ($style['other'] as $otherParam => $otherValue) {
            echo $table->tr(
                array(
                    $otherParam,
                    $form->text(array('name'=>$otherParam,'value' => htmlentities($otherValue),'class'=>'txtfield')),
                    $mw->a(array('anchor'=>'x','window'=>'delete_'.$otherParam))
                )
            );
        }
    } else {
        echo $table->tr(
            array(
                $mw->a(array('anchor'=>'Add other option','window'=>'other_option')),
                '',
                ''
            )
        );
    }
    echo $table->tableEnd(); 
?>      
    </div>  
	<div class="col-lg-7 col-md-7"> 
<?php 
    echo 
     $table->tableStart(array('class'=>'table table-sm table-mini','th'=> array('','')))   
    .$table->tr(array('<b>Style:</b>','',''));

    // show all styles:
    if (count($style['css']) > 0) {
        foreach ($style['css'] as $cssParam => $cssValue) {  
            echo $table->tr(
                array(
                    $cssParam,
                    '<input type="text" name="'.$cssParam.'" value="'.$cssValue.'" class="txtfield">',
                    $mw->a(array('anchor'=>'x','window'=>'delete_'.$cssParam))
                )
            ); 
        } 
    } else {
        echo $table->tr(
            array(
                $mw->a(array('anchor'=>'add style','window'=>'add_new_style')),
                '',
                ''
            )
        );
    }
    
    echo 
     $table->tr(array('','',$form->submit(array('name' => 'submit','value' => 'Save','class' => 'submit_btn'))))
    .$table->tableEnd(); 
?>       
    </div>    
</div>    
<?php 
    echo $form->formEnd();
?>

<!--- LIVE PREVIEW --->

    <h4>Live preview:</h4>
    
<?php 

    // take all elements from database:
    $htmlTree = $pure->getDocumentTree($projectId);
    
    if (count($htmlTree) > 0 ) {
        // clean them to make sure they are goot for use:
        $cleanArray = $pure->cleanLeaves($pure->createTreeArray($htmlTree));

        // element array 
        $result = $pure->getBranch($cleanArray, 'block'.$_GET['id']);

        $HtmlFormatter = new HtmlFormatter;
        $document = $pure->createDocumentTree($result, NULL);
        
        // show template:
        echo HtmlFormatter::format($document);
        
    }

?>

    
<!--- /LIVE PREVIEW --->  

    </div>
</div>
<?php 
    // MODALS: 
    $styleBody = '<p align="left">Choose css option:</p>'
    .$form->formStart()
    .$form->hidden(array('name' => 'action','value' => 'add_css_option'))
    .$form->hidden(array('name' => 'id','value' => $element['ID'])).'
    <p align="left"><select name="option[]">';

    if (is_array($style['css'])) {
        $cssKeys = array_keys($style['css']);
    } else {
        $cssKeys = array();
    }

    foreach(configuration::STYLE as $styleOption => $styleParams) {
        if (!in_array($styleOption,$cssKeys)) {
            $styleBody .= '<option value="'.$styleOption.'">'.$styleOption.'</option>';
        }
    }

    $styleBody .='</select></p>'
    .p('Enter value:')
    .p($form->text(array('name'=>'value','value' => '','class'=>'txtfield')))
    .p($form->submit(array('name' => 'submit', 'value' => 'Add', 'class' => 'btn')))
    .$form->formEnd();

    echo $pure->modalHtml('add_new_style','Add style:',$styleBody);

    if (count(configuration::OTHER) > count($style['other'])) {

    $otherBody = '
    <p align="left">Choose option:</p>
    <form method="POST" action="" autocomplete="OFF">
    <input type="hidden" name="action" value="add_other_option">
    <input type="hidden" name="id" value="'.$element['ID'].'">
    <p align="left"><select name="option[]">';

    if (is_array($style['other'])) {
        $otherKeys = array_keys($style['other']);
    } else {
        $otherKeys = array();
    }

    foreach(configuration::OTHER as $other) {
        if (!in_array($other,$otherKeys)) {
            $otherBody .= '<option value="'.$other.'">'.$other.'</option>';
        }
    }

       $otherBody .='</select></p>
       <p align="left">Enter value:</p>
       <p><input type="text" name="value" value="" class="txtfield"></p>
       <p><input type="submit" name="submit" value="Add" class="submit_btn"></p>
       </form>';
        
       echo $pure->modalHtml('other_option','Add other option:',$otherBody);

    }    
    ////
    
    
    if (is_array($style['css'])) {
        foreach ($style['css'] as $cssParam => $cssValue) {
            $modalBody = '
            <p align="left">Are you sure you want to delete '.$cssParam.'?</p>
            <form method="POST" action="" autocomplete="OFF">
            <input type="hidden" name="action" value="delete_css_option">
            <input type="hidden" name="id" value="'.$element['ID'].'">
            <input type="hidden" name="param" value="'.$cssParam.'">
            <p><input type="submit" name="submit" value="Yes" class="submit_btn"></p>
            </form>';
                
            echo $pure->modalHtml('delete_'.$cssParam,'Delete css option:',$modalBody);
        }
    }
    
    if (is_array($style['other'])) {
        foreach ($style['other'] as $otherParam => $otherValue) {
            $modalBody = '
            <p align="left">Are you sure you want to delete '.$otherParam.'?</p>
            <form method="POST" action="" autocomplete="OFF">
            <input type="hidden" name="action" value="delete_other_option">
            <input type="hidden" name="id" value="'.$element['ID'].'">
            <input type="hidden" name="param" value="'.$otherParam.'">
            <p><input type="submit" name="submit" value="Yes" class="submit_btn"></p>
            </form>';
                
            echo $pure->modalHtml('delete_'.$otherParam,'Delete css option:',$modalBody);
        }
    }
