<?php 
    // get element info: 
    $element = $pure->getElementInfo($_GET['id']);
    // make style array:
    $style = json_decode($element['style'],true);
?>
<div class="row">
	<div class="col-lg-12">
    <p align="left"> ← <a href="<?php echo configuration::MAIN_URL;?>?page=project&id=<?php echo $element['projectId']; ?>">Back to project <?php echo $element['projectId']; ?></a></p>
    <h4>Edit element: #<?php echo $element['ID']; ?></h4>
    
    <p align="left">+ <a href="" data-toggle="modal" data-target="#add_new_style">add new style</a></p>
<?php 
            $styleBody = '
            <p align="left">Choose option:</p>
            <form method="POST" action="" autocomplete="OFF">
            <input type="hidden" name="action" value="add_css_option">
            <input type="hidden" name="id" value="'.$element['ID'].'">
            <p align="left"><select name="option[]">';
            
            if (is_array($style['css'])) {
                $cssKeys = array_keys($style['css']);
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

           echo $pure->modalHtml('add_new_style','Add style:',$styleBody);
           
           if (count(configuration::OTHER) > count($style['other'])) {
?>
    <p align="left">+ <a href="" data-toggle="modal" data-target="#other_option">add other option</a></p>
<?php 
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
           
?>
    <form method="POST" id="edit_element" action="" autocomplete="OFF">
    <input type="hidden" name="action" value="edit_element">
    <input type="hidden" name="element_id" value="<?php echo $element['ID']; ?>">
    <table class="table table-striped">
    <thead><tr><th scope="col">Option</th><th scope="col">Value:</th></tr></thead>
    <tbody>
    
    <tr>
        <td>identifier</td>
        <td><input type="text" name="identifier" value="<?php echo $element['identifier']; ?>" class="txtfield"></td>
        <td></td>
    </tr>
    
    <tr>
        <td>class</td>
        <td><input type="text" name="class" value="<?php echo $element['class']; ?>" class="txtfield"></td>
        <td></td>
    </tr>
    
    <tr>
        <td></td>
        <td><h3>Other:</h3></td>
        <td></td>
    </tr> 
<?php 
    if (is_array($style['other'])) {
        foreach ($style['other'] as $otherParam => $otherValue) {
?>
    <tr>
        <td><?php echo $otherParam ; ?></td>
        <td><input type="text" name="<?php echo $otherParam; ?>" value="<?php echo $otherValue; ?>" class="txtfield"></td>
        <td><a href="" data-toggle="modal" data-target="#<?php echo 'delete_'.$otherParam; ?>">delete</a></td>
    </tr>
<?php 
        } 
    }
?>  
    <tr>
        <td></td>
        <td><h3>Style:</h3></td>
        <td></td>
    </tr>
<?php 
    if (is_array($style['css'])) {
        foreach ($style['css'] as $cssParam => $cssValue) {
?> 

    <tr>
        <td><?php echo $cssParam; ?></td>
        <td>
        <input type="text" name="<?php echo $cssParam ;?>" value="<?php echo $cssValue; ?>" class="txtfield">
        </td>
        <td><a href="" data-toggle="modal" data-target="#<?php echo 'delete_'.$cssParam; ?>">delete</a></td>
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


?>
    <h4>Live preview:</h4>
    TODO
    </div>
</div>



