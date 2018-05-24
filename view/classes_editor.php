<div class="row">
	<div class="col-lg-12">
    <p align="left"> ← <a href="<?php echo configuration::MAIN_URL;?>?page=project&id=<?php echo $_GET['projectId']; ?>">Back to project <?php echo $_GET['projectId']; ?></a></p>
    [ <a href="<?php echo configuration::MAIN_URL;?>?page=classes_editor&projectId=<?php echo $_GET['projectId'];?>">body</a> ]
<?php
    $classes = $pure->getAllClasses($_GET['projectId']);
    $json = $pure->getProjectStyle($_GET['projectId'])['globalStyles'];
    $bodyStylesArray = json_decode($json,true);

    foreach ($classes as $ck => $classesArr) {
        if (strlen($classesArr['class']) > 0) {
?> 
    [ <a href="<?php echo configuration::MAIN_URL;?>?page=classes_editor&projectId=<?php echo $_GET['projectId'];?>&class=<?php echo $classesArr['class'];?>">
    <?php echo $classesArr['class']; ?></a> ]
<?php
        }
    }
   
    if ($_GET['class']) {
?>        
    <h4><?php echo $_GET['class']; ?></h4>  
    <p align="left">+ <a href="" data-toggle="modal" data-target="#add_new_style">add new <?php echo $_GET['class'];?> style</a></p>    
<?php 
            $styleBody = '
            <p align="left">Choose option:</p>
            <form method="POST" action="" autocomplete="OFF">
            <input type="hidden" name="action" value="add_new_class_style">
            <input type="hidden" name="projectId" value="'.$_GET['projectId'].'">
            <input type="hidden" name="className" value="'.$_GET['class'].'">
            <p align="left"><select name="option[]">';
            
            if (is_array($bodyStylesArray[$_GET['class']])) {
                $cssKeys = array_keys($bodyStylesArray[$_GET['class']]);
            } else {
                $cssKeys = array();
            }
            
            foreach(configuration::STYLE as $styleOption) {
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
    <table class="table table-striped">
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
?>
    <h4>Body:</h4>
    <p align="left">+ <a href="" data-toggle="modal" data-target="#add_new_style">add new body style</a></p>
<?php 
            $styleBody = '
            <p align="left">Choose option:</p>
            <form method="POST" action="" autocomplete="OFF">
            <input type="hidden" name="action" value="add_new_body_style">
            <input type="hidden" name="projectId" value="'.$_GET['projectId'].'">
            <p align="left"><select name="option[]">';
            
            if (is_array($bodyStylesArray['body'])) {
                $cssKeys = array_keys($bodyStylesArray['body']);
            } else {
                $cssKeys = array();
            }
            
            foreach(configuration::STYLE as $styleOption) {
                if (!in_array($styleOption,$cssKeys)) {
                    $styleBody .= '<option value="'.$styleOption.'">'.$styleOption.'</option>';
                }
            }
            
            $styleBody .='</select></p>
            <p align="left">Enter value:</p>
            <p><input type="text" name="value" value="" class="txtfield"></p>
            <p><input type="submit" name="submit" value="Add" class="submit_btn"></p>
            </form>'; 

           echo $pure->modalHtml('add_new_style','Add body style:',$styleBody);
?>

    <form method="POST" id="edit_element" action="" autocomplete="OFF">
    <input type="hidden" name="action" value="edit_body_style">
    <input type="hidden" name="projectId" value="<?php echo $_GET['projectId']; ?>"> 
    <table class="table table-striped">
    <thead><tr><th scope="col">Option</th><th scope="col">Value:</th></tr></thead>
    <tbody>
<?php 
        if (is_array($bodyStylesArray['body'])) {
            foreach ($bodyStylesArray['body'] as $bodyParam => $bodyValue) {
?> 
    <tr>
        <td><?php echo $bodyParam; ?></td>
        <td>
        <input type="text" name="<?php echo $bodyParam ;?>" value="<?php echo $bodyValue; ?>" class="txtfield">
        </td>
        <td><a href="" data-toggle="modal" data-target="#<?php echo 'delete_'.$bodyParam; ?>">delete</a></td>
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
        // 
        if (is_array($bodyStylesArray['body'])) {
            foreach ($bodyStylesArray['body'] as $bodyParam => $bodyValue) {
                $modalBody = '
                <p align="left">Are you sure you want to delete '.$bodyParam.'?</p>
                <form method="POST" action="" autocomplete="OFF">
                <input type="hidden" name="action" value="delete_body_option">
                <input type="hidden" name="projectId" value="'.$_GET['projectId'].'">
                <input type="hidden" name="param" value="'.$bodyParam.'">
                <p><input type="submit" name="submit" value="Yes" class="submit_btn"></p>
                </form>';
                    
                echo $pure->modalHtml('delete_'.$bodyParam,'Delete css option:',$modalBody);
            }
        }
    }
?>    
    </div>
</div>



