<div class="row">
	<div class="col-lg-8" style="overflow: hidden;">
    <?php 
        // TODO: editing colors in modal window
    
        $colors = $pure->getAllColors();
        foreach($colors as $color) {
    ?>
        <div id="color-block" style="overflow: hidden; height: 80px; width: 60px; border 1px #000 solid; float: left; margin: 5px; font-size: 12px;">
            <div id="color-block-show" style="overflow: hidden; height: 60px; width: 60px; border 1px #000 solid; background: <?php echo $color['color'];?>;">
            </div>
            <div id="color-block-text" style="overflow: hidden; height: 20px; width: 60px; border 1px #000 solid; text-align: center; padding: 3px;">
            <?php echo $color['color'];?>
            </div>
        </div>
    <?php 
        }
    ?>
    </div>
	<div class="col-lg-4">
<?php 
    $form = new formGenerator;    
    $table = new tableGenerator;    
?>
    <h4>Add new Color:</h4>
    <p>
<?php 

    echo 
     $form->formStart()
    .$table->tableStart(array('class'=>'table table-striped','th'=> array('#','#')))
    .$form->hidden(array('name' => 'action','value' => 'add_new_color'))
    .$table->tr(
            array(
                'color',
                $form->text(array('name' => 'color','placeholder' => '#000'))
            )
        )
    .$table->tr(
            array(
                'Тон',
                $form->text(array('name' => 'ton'))
            )
        )        
    .$table->tr(
            array(
                'Асоциации:',
                $form->text(array('name' => 'assoc',))
            )
        )
    .$table->tr(
            array(
                'Категория:',
                $form->text(array('name' => 'category',))
            )
        )
     .$table->tr(
            array(
                '',
                $form->submit(array('name' => 'submit','value' => 'Add color','class' => 'submit_btn'))
            )
        )
       
    .$table->tableEnd()
    .$form->formEnd();

    
      
?>    
    </p>
    </div>
</div>



