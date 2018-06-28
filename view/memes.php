<div class="row">
	<div class="col-lg-5">
<?php

    echo p('<a href="'.CONFIGURATION::MAIN_URL.'?page=memes">Add new meme</a>');
    
    $memeList = $pure->getMemeList();

    echo $table->tableStart(
            array(
            'th' => array('#','Meme name:','Date:'),
            'class' => 'table table-sm table-mini'
            )
        );
    
    foreach ($memeList as $memeArray) {
        echo $table->tr(
            array(
                $memeArray['ID'],
                '<a href="'.configuration::MAIN_URL.'/?page=memegen&ID='.$memeArray['ID'].'">'.$memeArray['name'].'</a>',
                date('Y-m-d H:i:s',$memeArray['time'])
            )
        );
    }
    
    echo $table->tableEnd();

?>    
    </div>
    <div class="col-lg-7">
<?php
    echo p('<b>screenShots:</b>');

    $dirUrl = 'img/screenShots';
    $screenShots = scandir($dirUrl);
    for ($i = 2; $i < count($screenShots); $i++) {
        echo '<a target="_blank" href="'.CONFIGURATION::MAIN_URL.'/'.$dirUrl.'/'.$screenShots[$i].'">'.$screenShots[$i].'</a> / x <br>';
    }

?>
    </div>
</div>



