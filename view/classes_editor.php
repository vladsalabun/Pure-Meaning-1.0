<?php 

    $classes = $pure->getAllClasses($_GET['projectId']);
    $json = $pure->getProjectStyle($_GET['projectId'])['globalStyles'];
    $bodyStylesArray = json_decode($json,true);
    $styleParams = array_keys(configuration::STYLE);
    
    // TODO: розділити на 2 колонки
    
?>
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script type='text/javascript' src='js/jquery-editable-select.js'></script>
<link rel="stylesheet" href="<?php echo CONFIGURATION::MAIN_URL; ?>css/jquery-editable-select.css" type="text/css" media="screen" />
<div class="row">
	<div class="col-lg-12">
    <div class="row navigationbar">
        ← <a href="<?php echo configuration::MAIN_URL;?>?page=project&id=<?php echo $_GET['projectId']; ?>">Back to project <?php echo $_GET['projectId']; ?></a>
    </div>
    <br>
    
<!--- CLASS MENU ---> 
<div class="navbar navbar-default">
	<div class="container-fluid">
    	<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#class_menu">
				<span class="sr-only">Menu</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
        </div>
		<div class="collapse navbar-collapse" id="class_menu">
			<ul class="nav navbar-nav"> 
                <li><a href="<?php echo configuration::MAIN_URL;?>?page=classes_editor&projectId=<?php echo $_GET['projectId'];?>">body</a></li>
<?php

    foreach ($classes as $ck => $classesArr) {
        if (strlen($classesArr['class']) > 0) {

        echo '<li>
        <a href="'.configuration::MAIN_URL.'?page=classes_editor&projectId='.$_GET['projectId'].'&class='. $classesArr['class'].'">'.$classesArr['class'].'</a></li>';

        }
    }

?>
			</ul>
		</div>
	</div>
</div>  
<!--- CLASS MENU ---> 

<?php   
    if ($_GET['class']) {
        ### CLASS:  ########################
?>        
    <h4><?php echo $_GET['class']; ?></h4>  
    <p align="left">+ <a href="" data-toggle="modal" data-target="#add_new_style">add new <?php echo $_GET['class'];?> style</a></p>    
<?php 
            $styleBody = '
            <p align="left">Choose option:</p>
            '.$form->formStart().'
            <input type="hidden" name="action" value="add_new_class_style">
            <input type="hidden" name="projectId" value="'.$_GET['projectId'].'">
            <input type="hidden" name="className" value="'.$_GET['class'].'">
            <p align="left"><select name="option[]">';
            
            if (is_array($bodyStylesArray[$_GET['class']])) {
                $cssKeys = array_keys($bodyStylesArray[$_GET['class']]);
            } else {
                $cssKeys = array();
            }
            
            foreach($styleParams as $styleOption) {
                if (!in_array($styleOption,$cssKeys)) {
                    $styleBody .= '<option value="'.$styleOption.'">'.$styleOption.'</option>';
                }
            }
            
            $styleBody .='</select></p>
            <p align="left">Enter value:</p>
            <p><input type="text" name="value" value="" class="txtfield"></p>
            <p><input type="submit" name="submit" value="Add" class="submit_btn"></p>
            </form>'; 

           echo $pure->modalHtml('add_new_style','Add '.$_GET['class'].' style:',$styleBody);
?>    
    <form method="POST" id="edit_element" action="" autocomplete="OFF">
    <input type="hidden" name="action" value="edit_class_style">
    <input type="hidden" name="projectId" value="<?php echo $_GET['projectId']; ?>"> 
    <input type="hidden" name="className" value="<?php echo $_GET['class']; ?>"> 
    <table class="table table-sm table-mini">
    <thead><tr><th scope="col">Option</th><th scope="col">Value:</th></tr></thead>
    <tbody>    
<?php       
        if (is_array($bodyStylesArray[$_GET['class']])) {
            foreach ($bodyStylesArray[$_GET['class']] as $classParam => $classValue) {
?> 
    <tr>
        <td><?php echo $classParam; ?></td>
        <td>
        <input type="text" name="<?php echo $classParam;?>" value="<?php echo $classValue; ?>" class="txtfield">
        </td>
        <td><a href="" data-toggle="modal" data-target="#<?php echo 'delete_'.$classParam; ?>">delete</a></td>
    </tr>  
<?php
            }
        }

?>
    <tr>
        <td></td>
        <td></td>
        <td><input type="submit" name="submit" value="Save" class="submit_btn"></td>
    </tr>
    </tbody>
    </table>
    </form>
<?php
               
        if (is_array($bodyStylesArray[$_GET['class']])) {
                
            foreach ($bodyStylesArray[$_GET['class']] as $classParam => $classValue) {
                
                $modalBody = '
                    <p align="left">Are you sure you want to delete '.$classParam.'?</p>
                    <form method="POST" action="" autocomplete="OFF">
                    <input type="hidden" name="action" value="delete_class_option">
                    <input type="hidden" name="projectId" value="'.$_GET['projectId'].'">
                    <input type="hidden" name="param" value="'.$classParam.'">
                    <input type="hidden" name="className" value="'.$_GET['class'].'"> 
                    <p><input type="submit" name="submit" value="Yes" class="submit_btn"></p>
                    </form>';
                        
                echo $pure->modalHtml('delete_'.$classParam,'Delete css option:',$modalBody);
            }
        }
    
    } else {
        ### BODY:  ########################
?>
<div class="row workspace">
    <div class="col-lg-12">       
<?php 
    echo '<h4>Editing Body style <small>[ '.modalLink('add_new_style', 'add new body style').'</small> ]</h4>';       
            
            $styleBody = 
            p('Choose option:')
            .$form->formStart()
            .$form->hidden(array('name' => 'action','value' => 'add_new_body_style'))
            .$form->hidden(array('name' => 'projectId','value' => $_GET['projectId']))
            .'<p align="left"><select name="option[]">';
            
            if (is_array($bodyStylesArray['body'])) {
                $cssKeys = array_keys($bodyStylesArray['body']);
            } else {
                $cssKeys = array();
            }
            
            foreach($styleParams as $styleOption) {
                if (!in_array($styleOption,$cssKeys)) {
                    $styleBody .= '<option value="'.$styleOption.'">'.$styleOption.'</option>';
                }
            }
            
            $styleBody .='</select></p>'
            .p('Enter value:')
            .p($form->text(array('name' => 'value','value' => '','class' => 'txtfield')))
            .p($form->submit(array('name' => 'submit','value' => 'Add','class' => 'btn btn-success')))
            .$form->formEnd(); 

           echo $pure->modalHtml('add_new_style','Add body style:',$styleBody);

    // workspace for body style editing
    echo 
     $form->formStart(array('id' => 'edit_element'))
    .$form->hidden(array('name' => 'action','value' => 'edit_body_style'))
    .$form->hidden(array('name' => 'projectId','value' => $_GET['projectId']))
    .$table->tableStart(array('class'=>'table table-sm table-mini','th'=> array('Option','Value:')));

        if (is_array($bodyStylesArray['body'])) {
            foreach ($bodyStylesArray['body'] as $bodyParam => $bodyValue) {
                
                if ($bodyParam == 'font-family') {
                    echo $table->tr(
                    array(
                        $bodyParam,
                        $form->fontSelectingForm($bodyValue,$bodyParam),
                        $mw->a(array('anchor'=>'x','window'=>'delete_'.$bodyParam))
                        )
                    );
                } else {
                    echo $table->tr(
                    array(
                        $bodyParam,
                        $form->text(array('name' => $bodyParam,'value' => $bodyValue,'class' => 'txtfield')),
                        $mw->a(array('anchor'=>'x','window'=>'delete_'.$bodyParam))
                        )
                    );
                }
            }
        }
 
    echo $table->tableEnd();
?>
    </div>
</div>
<div class="row workspace save_changes_right">
<?php
    echo $form->submit(array('name' => 'submit','value' => 'Save changes','class' => 'btn btn-success'));
?>
</div> 
<?php  
    echo $form->formEnd();
        
        //  modals for deleting body styles:
        if (is_array($bodyStylesArray['body'])) {
            foreach ($bodyStylesArray['body'] as $bodyParam => $bodyValue) {
                $modalBody = 
                 p('Are you sure you want to delete '.$bodyParam.'?')
                .$form->formStart()
                .$form->hidden(array('name' => 'action','value' => 'delete_body_option'))
                .$form->hidden(array('name' => 'projectId','value' => $_GET['projectId']))
                .$form->hidden(array('name' => 'param','value' => $bodyParam))
                .$form->submit(array('name' => 'submit','value' => 'Delete','class' => 'btn btn-danger'))
                .$form->formEnd();
                    
                echo $pure->modalHtml('delete_'.$bodyParam,'Delete css option:',$modalBody);
            }
        } //  <- /modals for deleting body styles:
        
    }
?>    
    </div>
</div>
<br>
