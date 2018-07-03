<div class="row">
	<div class="col-lg-8" style="overflow: hidden;">
    <?php 
    // TODO: editing colors in modal window
    // TODO: add association to colors
    $colors = new colors;   
    
        $colorsArray = $colors->getAllColors();
        foreach($colorsArray as $color) {
    ?>
        <div id="color-block" style="overflow: hidden; height: 20px; width: 122px; float: left; margin: 5px; font-size: 13px; border: 1px solid #eee;">
            <div id="color-block-text" style="float: left; overflow: hidden; height: 25px; width: 60px;  text-align: center;">
                <?php echo $color['color'];?> 
            </div>
            <a href="" data-toggle="modal" data-target="#delete_color<?php echo $color['ID'];?>">
            <div id="color-block-show" style="float: left; overflow: hidden; height: 20px; width: 60px; background: <?php echo $color['color'];?>;">
            </div>
            </a>

        </div>
    <?php 
    
        $DeleteColor = $form->formStart(array('id'=>'delete_color'.$color['ID']));
        $DeleteColor .= $form->hidden(array('name' => 'action','value' => 'delete_color'));
        $DeleteColor .= $form->hidden(array('name' => 'ID','value' => $color['ID']));
        $DeleteColor .= '<div id="color-block-show" style="overflow: hidden; height: 60px; width: 60px; border: 1px #eee solid; background: '.$color['color'].';"></div><br>';
        $DeleteColor .= $form->submit(array('value'=> 'Delete'));
        $DeleteColor .= $form->formEnd();
        
        echo $pure->modalHtml('delete_color'.$color['ID'],'Do you want to delete color?',$DeleteColor);

        }
    ?>
    </div>
	<div class="col-lg-4">
    <h4>Add new Color:</h4>
    <p>
<?php 
    echo 
     $form->formStart()
    .$table->tableStart(array('class'=>'table table-sm table-mini','th'=> array('#','#')))
    .$form->hidden(array('name' => 'action','value' => 'add_new_color'))
    .$table->tr(
            array(
                'color',
                $form->text(array('name' => 'color','placeholder' => '#000'))
            )
        )
    .$table->tr(array('Tone',$form->text(array('name' => 'tone'))))        
    .$table->tr(array('Rainbow:',$form->text(array('name' => 'rainbow'))))
    .$table->tr(array('Saturation:',$form->text(array('name' => 'saturation'))))
    .$table->tr(array(
            '',
            $form->submit(
            array(
                'name' => 'submit',
                'value' => 'Add color',
                'class' => 'btn')
            )
        )
     ) 
    .$table->tableEnd()
    .$form->formEnd();
   
?>    
    </p>
    </div>
</div>



