<script type='text/javascript' src='js/screenshotter.js'></script>
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script type='text/javascript' src='js/jquery-editable-select.js'></script>
<link rel="stylesheet" href="<?php echo CONFIGURATION::MAIN_URL; ?>css/jquery-editable-select.css" type="text/css" media="screen" />
<?php 

    $fonts = new fonts;
    // get element info: 
    $element = $pure->getElementInfo($_GET['id']);
    // get projectId:
    $projectId = $element['projectId'];
    // make style array:
    $style = json_decode($element['style'],true);

    // take all elements from database:
    $htmlTree = $pure->getDocumentTree($projectId);
    $cleanArray = $pure->cleanLeaves($pure->createTreeArray($htmlTree));
    
    if (count($htmlTree) > 0 ) {
        // clean them to make sure they are goot for use:
        $cleanArray = $pure->cleanLeaves($pure->createTreeArray($htmlTree));

        // element array 
        $currentBranchWithChildren = $pure->getBranch($cleanArray, 'block'.$_GET['id']);
        //print_r($currentBranchWithChildren);
    }

    
    $projects = new projects;
    $projectArray = $projects->getProjectInfo($projectId);
    $projectName = $projectArray[0]['title'];   
    $projectParent = $projectArray[0]['parentId']; 
    $parentName = $projects->getProjectInfo($projectParent)[0]['title'];
    // TODO:
    # 2. Випадаючий список підказок
    # 4. Корні гілки, яку я зараз переглядаю

?>
<div class="row">
	<div class="col-lg-12">
    <div class="row navigationbar">
<?php 
    echo '<p>Project #'.$element['projectId'].': <a href="'.configuration::MAIN_URL.'?page=project&id='.$element['projectId'].'">'.$projectName.'</a></p>';
?>
    </div>
    <div class="row navigationbar">
    <?php //echo childrenNavigation($currentBranchWithChildren); ?>
    </div>
    
<?php     
    echo 
     $form->formStart()
    .$form->hidden(array('name' => 'action','value' => 'edit_element'))
    .$form->hidden(array('name' => 'element_id','value' => $element['ID']))
    .$form->hidden(array('name' => 'id','value' => $_GET['projectId']))
?>
<div class="row workspace">
	<div class="col-lg-5 col-md-5">    
<?php 
    
    echo 
     $table->tableStart(array('class'=>'table table-sm table-mini','th'=> array('Option','Value:')))
    .$table->tr(array('identifier',$form->text(array('name' => 'identifier','value' => $element['identifier'],'class'=>'txtfield')),''))
    .$table->tr(array('class',$form->text(array('name'=>'class','value' => $element['class'],'class'=>'txtfield')),''))
    .$table->tr(array('<b>Other:</b>',$mw->a(array('anchor'=>'Add other option','window'=>'other_option')),''));
    
    // show all other params:
    if (count($style['other']) > 0) {
        foreach ($style['other'] as $otherParam => $otherValue) {
            echo $table->tr(
                array(
                    $otherParam,
                    $form->textarea(array('name'=>$otherParam,'value' => htmlentities($otherValue),'class'=>'edit_element_textarea')),
                    $mw->a(array('anchor'=>'x','window'=>'delete_'.$otherParam))
                )
            );
        }
    }
    echo $table->tableEnd(); 
?>      
    </div>  
	<div class="col-lg-7 col-md-7"> 
<?php 
    echo 
     $table->tableStart(array('class'=>'table table-sm table-mini','th'=> array('','')))   
    .$table->tr(array('<b>Style:</b>',$mw->a(array('anchor'=>'Add new style','window'=>'add_new_style')),''));

    // show all styles:
    if (count($style['css']) > 0) {
        foreach ($style['css'] as $cssParam => $cssValue) {
            
            // font-family
            if ($cssParam == 'font-family') {
                echo $table->tr(
                array(
                    $cssParam,
                    $form->fontSelectingForm($cssValue,$cssParam),
                    $mw->a(array('anchor'=>'x','window'=>'delete_'.$cssParam))
                    )
                ); 
            } else {
                echo $table->tr(
                    array(
                        $cssParam,
                        $form->styleSelectingForm($cssParam,$cssValue),
                        $mw->a(array('anchor'=>'x','window'=>'delete_'.$cssParam))
                    )
                ); 
            }
        } 
    }
    
    echo $table->tableEnd(); 
    
    if (count($style['css']) > 0) {
        if(isset($style['css']['font-family'])) {
                $fontFaceArray[] = $style['css']['font-family'];
        }
        echo '<style>';
        // get fonts info by font name, and plug them:
        foreach ($fontFaceArray as $fontFaceName){
            $fontFace = $fonts->getFontByName($fontFaceName);        
            echo ' @font-face { font-family: '.$fontFace['fontFamily'].'; src: url('.configuration::MAIN_URL.'/uploads/fonts/'.$fontFace['fileName'].'); }';
        }
        echo '</style>';
    }
    
?>       
    </div>   
</div>    
<div class="row workspace save_changes_right">
<?php 
    /*
    echo
     $table->tableStart(array('th' => array('',''),'class' => 'table table-sm table-mini'))
    .$table->tr(array('',$form->submit(array('name' => 'submit','value' => 'Save changes','class' => 'submit_btn'))))
    .$table->tableEnd();
    */
    echo $form->submit(array('name' => 'submit','value' => 'Save changes','class' => 'btn btn-success'));
    echo $form->formEnd();
?> 
</div> 

<!--- LIVE PREVIEW --->

    <h4>Live preview:</h4>
    
<?php 
    
    if (count($htmlTree) > 0 ) {

        $HtmlFormatter = new HtmlFormatter;
        $document = $pure->createDocumentTree($currentBranchWithChildren, NULL);
        
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
    .p($form->submit(array('name' => 'submit', 'value' => 'Add', 'class' => 'btn btn-success')))
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
       <p><input type="submit" name="submit" value="Add" class="btn btn-success"></p>
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
            <p><input type="submit" name="submit" value="Yes" class="btn btn-danger"></p>
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
            <p><input type="submit" name="submit" value="Yes" class="btn btn-danger"></p>
            </form>';
                
            echo $pure->modalHtml('delete_'.$otherParam,'Delete css option:',$modalBody);
        }
    }
    
    function childrenNavigation($array) {
        if (count($array['block'.$_GET['id']]) > 0) {
        //var_dump($array);
        $str = '
        <div class="dropdown show">
        Parent 0 → Parent 1 → edit element: #'.$element['ID'].'(brothers) →
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">child elements</a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

        foreach ($array['block'.$_GET['id']] as $key => $value) {
            if (is_array($value)) {
                $str .= '<li><a class="dropdown-item" href="#">'.$key . '</a></li>';
            } else {
                $str .= '<li><a class="dropdown-item" href="#">'.$value. '</a></li>';
            }
        }
        
        $str .= '</div></div>';
        return $str;
        }
    }
