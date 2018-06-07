<div class="row">
	<div class="col-lg-12">
    <?php 
    
        $style = array(
            'body' => array(
                'background' => '#306eba',
                'color' => '#000',
                'font-size' => '16px',
                'font-family' => 'Arial',
                'padding' => '10px'
            ),
            'row' => array(
                'padding' => '10px'
            ),
            'subrow' => array(
                'padding' => '10px'
            )
        );
    
        $form = array(
            'method' => 'POST',
            'action' => '',
            'autocomplete' => 'off',
            'elements' => array(
                0 => array(
                    'text' => array(
                        'name' => 'name1',
                        'value' => 'value1',
                        'placeholder' => 'place1',
                        'class' => 'textarea'
                    )
                ),
                1 => array(
                    'text' => array(
                        'name' => 'name1',
                        'value' => 'value1',
                        'placeholder' => 'place1',
                        'class' => 'textarea'
                    )
                ),
                2 => array(
                    'hidden' => array(
                        'name' => 'hihi',
                        'value' => 'vava'
                    )
                ),
            )
        );
    
        echo json_encode($form);
        
    /*
        Копіювання блоку і його вмісту:
        
        1) Вказую блок для копіювання
        2) Вказую блок у який вставити
        3) Збираю дерево блоку
        4) Вставляю в базу даних з новими ІД (класи з старого дерева)
  
    */
    
    $fileName = str_replace(" ", "_", 'lkj lskjd klj.jhf');
    echo $fileName;
    
    ?>
    </div>
</div>



