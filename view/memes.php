<div class="row">
	<div class="col-lg-12">
<?php

    echo p(modalLink('AddNewMeme', 'Add new meme'));
    
    $memeList = $pure->getMemeList();

    echo $table->tableStart(
            array(
            'th' => array('#','Fav','Meme name:','Date:','Del:'),
            'class' => 'table table-sm table-mini'
            )
        );
    
    foreach ($memeList as $memeArray) {
        
        if ($memeArray['moderation'] == 1) { 
            $heart = 'glyphicon-heart';
            $moderation = 0;
        } else {
            $heart = 'glyphicon-heart-empty';
            $moderation = 1;
        }
        
        
        echo $table->tr(
            array(
                $memeArray['ID'],
                 $form->formStart(array('id' => 'meme_favourite'.$memeArray['ID']))
                .$form->hidden(array('name'=> 'action','value'=> 'meme_favourite'))
                .$form->hidden(array('name'=> 'ID','value'=> $memeArray['ID']))
                .$form->hidden(array('name'=> 'moderation','value'=> $moderation))
                .$form->formEnd()
                .'<span class="glyphicon '.$heart.'" title="Favourite" onclick="document.getElementById(\'meme_favourite'.$memeArray['ID'].'\').submit(); "></span>',
                '<a href="'.configuration::MAIN_URL.'?page=memegen&ID='.$memeArray['ID'].'">'.$memeArray['name'].'</a>',
                date('Y-m-d H:i:s',$memeArray['time']),
                modalLink('deleteMeme'.$memeArray['ID'], 'x')
            )
        );
    }
    
    echo $table->tableEnd();

?>    
    </div>
    <div class="col-lg-12">
<?php
    echo p('<b>screenShots:</b>');

    $screenShots = scandir(configuration::SCREENSHOTS_DIR);
    
    $countScreenShots = count($screenShots) - 1;
    while ($countScreenShots > 1) {    
    
        $meme = '<img src="'.CONFIGURATION::MAIN_URL.configuration::SCREENSHOTS_DIR.$screenShots[$countScreenShots].'" width="120px" style="float: left;">';
        echo modalLink('meme'.$countScreenShots, $meme);
        echo modalWindow(
            'meme'.$countScreenShots,
            'text in modal header',
            p('<div><img src="'.CONFIGURATION::MAIN_URL.configuration::SCREENSHOTS_DIR.$screenShots[$countScreenShots].'" style="max-width:100%;" ></div>')
            .$form->formStart()
            .$form->hidden(array('name'=> 'action','value'=> 'delete_meme_png'))
            .$form->hidden(array('name'=> 'FilePng','value'=> $screenShots[$countScreenShots]))
            .p($form->submit(array('name'=> '','value'=> 'Delete Meme PNG','class'=>'btn')))
            .$form->formEnd()
        );
        $countScreenShots--;
        
    }

?>
    </div>
</div>
<?php 

    # AddNewMeme:
    $bodyAddNewMeme = 
     $form->formStart()
    .$form->hidden(array('name' => 'action','value'=> 'add_new_meme'))
    .p('Enter meme name:')
    .p($form->text(array('name'=> 'name','value'=> '','class'=>'txtfield','placeholder' =>'')))
    .p($form->submit(array('name'=> '','value'=> 'add meme','class'=>'btn')))
    .$form->formEnd();
    
    echo modalWindow('AddNewMeme','Add New Meme',$bodyAddNewMeme);
    
    # deleteMeme:
    foreach ($memeList as $memeArray) {
        $bodydeleteMem = '';
        $bodydeleteMem = 
         $form->formStart()
        .$form->hidden(array('name' => 'action','value'=> 'delete_meme'))
        .$form->hidden(array('name' => 'ID','value'=> $memeArray['ID']))
        .p($form->submit(array('name'=> '','value'=> 'delete meme: '.$memeArray['name'],'class'=>'btn')))
        .$form->formEnd();
        
        echo modalWindow('deleteMeme'.$memeArray['ID'],'delete Mem',$bodydeleteMem);
    }

