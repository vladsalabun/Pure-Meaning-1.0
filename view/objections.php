<div class="row">
	<div class="col-lg-8">
<?php
    $objections = new objections;
    $themes = $objections->getObjectionsTheme();
    
    echo $table->tableStart( array(
                'class'=>'table table-striped table-mini',
                'th'=> array('Theme:','Objections:','del'),
                )
            );
            
    foreach($themes as $theme) {

        $DeleteObjectionTheme = $form->formStart();
        $DeleteObjectionTheme .= '<p>'.$theme['objection'].'</p>';
        $DeleteObjectionTheme .= $form->hidden(array('name' => 'action','value' => 'delete_objection_theme'));
        $DeleteObjectionTheme .= $form->hidden(array('name' => 'objection','value' => $theme['ID']));
        $DeleteObjectionTheme .= $form->submit(array('value'=> 'Видалити','class' => 'btn btn-danger margin10'));
        $DeleteObjectionTheme .= $form->formEnd();
        
        echo modalWindow('delete_objection_theme'.$theme['ID'],'Ви справді хочете видалити заперечення ID:'.$theme['ID'].'?',$DeleteObjectionTheme);
    
        echo $table->tr(
                array(
                    '<a href="'.CONFIGURATION::MAIN_URL.'?page=objection&parentId='.$theme['ID'].'">'.$theme['objection'].'</a>',
                    $objections->objectionsThemeCount($theme['ID']),
                    '<a href="" data-toggle="modal" data-target="#delete_objection_theme'.$theme['ID'].'">Видалити</a>'
                )
            );
    }
    echo $table->tableEnd(); 
  
?>
    </div>
	<div class="col-lg-4">
<?php 

    echo 
     $form->formStart()
    .$table->tableStart(array('class'=>'table table-striped','th'=> array('','')))
    .$form->hidden(array('name' => 'action','value' => 'add_new_objection_theme'))
    .$table->tr(
            array(
                'Theme:',
                $form->text(array('name' => 'theme','value' => ''))
            )
        )
     .$table->tr(
            array(
                $form->submit(array('name' => 'submit','value' => 'Add theme','class' => 'btn btn-success margin10')),
                ''
            )
      )
       
    .$table->tableEnd()
    .$form->formEnd();

?>
    </div>
</div>



