<div class="row">
	<div class="col-lg-12">
    <p>Where I am? <a href="">Objections</a> -> Objection name:</p>
    <p><a href="">add new objection</a></p>
<?php
    $objection = new objections;  
    $form = new formGenerator;    
    $table = new tableGenerator; 
        
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
        $editObjection .= $form->hidden(array('name' => 'parent','value' => $objection['parentId']));
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



