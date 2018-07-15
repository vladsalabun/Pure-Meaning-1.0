<div class="row">
    <div class="col-lg-4">
    <p>[ <a href="<?php echo CONFIGURATION::MAIN_URL.'?page=colors'; ?>">All colors</a> ] [ <a href="<?php echo CONFIGURATION::MAIN_URL.'?page=association'; ?>">All association</a> ]</p>
<?php

    echo
     $form->formStart()
    .$table->tableStart(array('th' => array('Param:','Value:'),'class' => 'table table-sm table-mini'))
    .$form->hidden(array('name'=> 'action','value'=> 'add_new_color_set'))
    .$table->tr(array(
        'backgroundColor:',
        $form->text(array('name'=> 'backgroundColor','value'=> '','class'=>'txtfield')),
        
    ))
    .$table->tr(array(
        'textColor:',
        $form->text(array('name'=> 'textColor','value'=> '','class'=>'txtfield'))
    ))    
    .$table->tr(array(
        '',
        $form->submit(array('name'=> 'submit','value'=> 'Add set','class'=>'btn'))
    )) 
    .$table->tableEnd()
    .$form->formEnd();
    
?>    
    
    </div>
	<div class="col-lg-8" style="overflow: hidden;">
<?php 
    $colors = new colors;
    $sets = $colors->getAllSets();
    
    foreach ($sets as $setID => $setArray) {

        echo '
        <div id="set'.$setID.'">
        <h2>Імітація гостинності</h2>
        <p class="p18">Keep it professional</p>
        <p class="p17">Текст це смисловий дизайн</p>
        <p class="p16">Красива деталь це вишенька зверху</p>
        <p class="p15">Молодість це ресурс, і він не безмежний</p>
        <p class="p14">background-color: '.$setArray['backgroundColor'].';</p>
        <p class="p13">text-color: '.$setArray['textColor'].';</p>
        <p>';
        
            // FAVOURITE:
            echo 
             $form->formStart(array('id'=>'favourite_set'.$setArray['ID']))
            .$form->hidden(array('name' => 'action','value' => 'make_set_favourite'))
            .$form->hidden(array('name' => 'ID','value' => $setArray['ID']));
            
            if ($setArray['moderation'] == 0 ) {
                
                echo $form->hidden(array('name' => 'moderation','value' => 1))
                .'<span class="glyphicon glyphicon-heart-empty" title="Fav set" style="color:'.$setArray['textColor'].';margin: 10px;" onclick="document.getElementById(\'favourite_set'.$setArray[
                'ID'].'\').submit();"></span>';
                
            } else if ($setArray['moderation'] == 1 ) {
                
                echo $form->hidden(array('name' => 'moderation','value' => 0))
                .'<span class="glyphicon glyphicon-heart" title="Unfav set" style="color:'.$setArray['textColor'].';margin: 10px;" onclick="document.getElementById(\'favourite_set'.$setArray[
                'ID'].'\').submit(); "></span>';
                
            }
            
            echo modalLink('windowSet'.$setArray['ID'], '<span class="glyphicon glyphicon-pencil" title="Edit set" style="color:'.$setArray['textColor'].';margin: 10px;"></span>');
            echo modalLink('deleteSet'.$setArray['ID'], '<span class="glyphicon glyphicon-remove" title="Delete set" style="color:'.$setArray['textColor'].';margin: 10px;"></span>');
            
            echo $form->formEnd();
            // <--- FAVOURITE:
            


        echo '</p>
        </div>
        <style>
        #set'.$setID.' {
            float:left; margin: 2px;  
            width:300px; height:235px; text-align: center;
            background:'.$setArray['backgroundColor'].'; 
            color:'.$setArray['textColor'].';
        }
        #set'.$setID.' h2 {color:'.$setArray['textColor'].';}
        #set'.$setID.' h3 {color:'.$setArray['textColor'].';}
        #set'.$setID.' p {color:'.$setArray['textColor'].';}
        </style>';
        
        $editSetModalBody = 
         $form->formStart()
        .$form->hidden(array('name' => 'action','value' => 'update_color_set'))
        .$form->hidden(array('name' => 'ID','value' => $setArray['ID']))
        .$table->tableStart(array('th' => array('Param:','Value:'),'class' => 'table table-sm table-mini'))
        .$table->tr(array('background-color:',$form->text(array('name'=> 'backgroundColor','value'=> $setArray['backgroundColor'],'class'=>'txtfield'))))
        .$table->tr(array('text-color:',$form->text(array('name'=> 'textColor','value'=> $setArray['textColor'],'class'=>'txtfield'))))
        .$table->tr(array('',$form->submit(array('name'=> '','value'=> 'Update','class'=>'btn'))))
        .$table->tableEnd()
        .$form->formEnd();
        
        $deleteSetModalBody = 
         $form->formStart()
        .$form->hidden(array('name' => 'action','value' => 'delete_color_set'))
        .$form->hidden(array('name' => 'ID','value' => $setArray['ID']))
        .$form->submit(array('name'=> '','value'=> 'Delete','class'=>'btn'))
        .$form->formEnd();
        
        
        // MODALS:
        echo modalWindow('windowSet'.$setArray['ID'],'Edit set #'.$setArray['ID'],$editSetModalBody);
        echo modalWindow('deleteSet'.$setArray['ID'],'Delete set #'.$setArray['ID'],$deleteSetModalBody);
        
    }

?>
    
    </div>
</div>



