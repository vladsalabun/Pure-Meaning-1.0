<div class="row">
	<div class="col-lg-12">
<?php
    $form = new formGenerator;    
    $table = new tableGenerator; 
        
    $objections = $pure->getObjectionBranch($_GET['parentId']);
    
    echo $table->tableStart( array(
                'class'=>'table table-striped',
                'th'=> array('Objection:','Edit','Answer:'),
                )
            );
    foreach($objections as $objection) {
               
        echo $table->tr(
                array(
                    $objection['objection'],
                    '<a href="" data-toggle="modal" data-target="#edit_objection'.$objection['ID'].'">edit</a>',
                    '<p><b>UKR:</b><br>'.$objection['answerUkr'].'</p>
                     <p><b>RUS:</b> <br>'.$objection['answerRu'].'</p>'  
                )
        );
    }
    echo $table->tableEnd(); 

    foreach($objections as $objection) {
        
        $editObjection = $form->formStart();
        $editObjection .= '<p>'.$theme['objection'].'</p>';
        $editObjection .= $table->tableStart( array(
                'class'=>'table table-striped',
                'th'=> array('answerUkr:','answerRu'),
                )
            );
        $editObjection .= $form->hidden(array('name' => 'action','value' => 'edit_objection'));
        $editObjection .= $form->hidden(array('name' => 'objection','value' => $objection['ID']));
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

    }
    
?>
    </div>
</div>



