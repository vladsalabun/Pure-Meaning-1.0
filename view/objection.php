<?php 

    $objection = new objections;  
    $form = new formGenerator;    
    $table = new tableGenerator;

?>
<div class="row">
	<div class="col-lg-12">
    <p>← <a href="<?php echo CONFIGURATION::MAIN_URL; ?>?page=objections">Objections</a></p>
    <?php $theme = $objection->getObjection($_GET['parentId']); ?>
    <h3><?php echo $theme['objection']; ?></h3>
    <p><a href="" data-toggle="modal" data-target="#add_objection">add new objection</a></p>
<?php
        $addObjection = $form->formStart();
        $addObjection .= $table->tableStart( array(
                'class'=>'table table-striped',
                'th'=> array('answerUkr:','answerRu'),
                )
            );
        $addObjection .= $form->hidden(array('name' => 'action','value' => 'add_objection'));
        $addObjection .= $form->hidden(array('name' => 'parentId','value' => $_GET['parentId']));
        $addObjection .= '<p><b>Objection:</b></p>';
        $addObjection .= $form->text(array('name' => 'objection','value' => '', 'class' => 'txtfield'));
        $addObjection .= $table->tr(
                array(
                    $form->textarea(array('name' => 'answerUkr','value' => '', 'class' => 'big_textarea')),
                    $form->textarea(array('name' => 'answerRu','value' => '', 'class' => 'big_textarea'))
                )
        ); 
        $addObjection .= $table->tr(   
                array(
                    '',
                    $form->submit(array('value'=> 'Add objection')) 
                )
        );         
        
        $addObjection .= $table->tableEnd();
        $addObjection .= $form->formEnd();
    
    echo $pure->modalHtml('add_objection','Add new objection:',$addObjection); 

    # OBJECTIONS TABLE: #
        
    $objectionsArray = $objection->getObjectionBranch($_GET['parentId']);
    
    echo $table->tableStart( array(
                'class'=>'table table-striped',
                'th'=> array('Objection:','Answer:'),
                )
            );
    foreach($objectionsArray as $objection) {
               
        echo $table->tr(
                array(
                    '<p>'.$objection['objection'].'</p><p><a href="" data-toggle="modal" data-target="#edit_objection'.$objection['ID'].'"><span class="glyphicon glyphicon-pencil"></span></a> <a href="" data-toggle="modal" data-target="#delete_objection'.$objection['ID'].'"><span class="glyphicon glyphicon-remove"></span></a></p>',
                    '<p><b>UKR:</b><br>'.$objection['answerUkr'].'</p>
                     <p><b>RUS:</b> <br>'.$objection['answerRu'].'</p>'  
                )
        ); 
    }

    echo $table->tableEnd(); 

    # /OBJECTIONS TABLE #
    
    
    
    // MODALS:
    foreach($objectionsArray as $objection) {
        
        $editObjection = $form->formStart();
        $editObjection .= '<p>'.$theme['objection'].'</p>';
        $editObjection .= $table->tableStart( array(
                'class'=>'table table-striped',
                'th'=> array('answerUkr:','answerRu'),
                )
            );
        $editObjection .= $form->hidden(array('name' => 'action','value' => 'edit_objection'));
        $editObjection .= $form->hidden(array('name' => 'ID','value' => $objection['ID']));
        $editObjection .= $form->hidden(array('name' => 'parentId','value' => $objection['parentId']));
        $editObjection .= '<p><b>Objection:</b></p>';
        $editObjection .= $form->text(array('name' => 'objection','value' => $objection['objection'], 'class' => 'txtfield'));
        $editObjection .= $table->tr(
                array(
                    $form->textarea(array('name' => 'answerUkr','value' => $objection['answerUkr'], 'class' => 'big_textarea')),
                    $form->textarea(array('name' => 'answerRu','value' => $objection['answerRu'], 'class' => 'big_textarea'))
                )
        ); 
        $editObjection .= $table->tr(   
                array(
                    '',
                    $form->submit(array('value'=> 'Edit')) 
                )
        );         
        
        $editObjection .= $table->tableEnd();
        $editObjection .= $form->formEnd();
        
        echo $pure->modalHtml('edit_objection'.$objection['ID'],'Edit objection ID:'.$objection['ID'].'?',$editObjection); 

        
        // del model:
        $delObjection = '<p>'.$objection['objection'].'</p>';
        $delObjection .= $form->formStart();
        $delObjection .= $form->hidden(array('name' => 'action','value' => 'delete_objection'));
        $delObjection .= $form->hidden(array('name' => 'ID','value' => $objection['ID']));
        $delObjection .= $form->hidden(array('name' => 'parentId','value' => $_GET['parentId']));
        $delObjection .= $form->submit(array('value'=> 'Delete'));
        $delObjection .= $form->formEnd();
        echo $pure->modalHtml('delete_objection'.$objection['ID'],'Delete objection:',$delObjection);
    }
    
?>
    </div>
</div>



