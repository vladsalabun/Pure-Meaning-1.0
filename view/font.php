<?php 
    if (isset($_GET['font-size'])) { 
        $fontSize = $_GET['font-size']; 
    } else { 
        $fontSize = 18;
    }
    if (isset($_GET['h2'])) { 
        $h2 = $_GET['h2']; 
    } else { 
        $h2 = 26;
    }   
    
    $fonts = new fonts;
    $form = new formGenerator;    
    $table = new tableGenerator;    
?>
<div class="row">
	<div class="col-lg-3 col-sm-4">
    <p><a href="<?php echo CONFIGURATION::MAIN_URL.'?page=fonts'; ?>">Fonts</a> ← back</p>
<?php 

    $font = $fonts->getFont($_GET['ID']);
        
        echo $table->tableStart( array(
                'class'=>'table table-striped',
                'th'=> array('Param:','Value:')
                )
            );
        
        foreach ($font as $param => $value) {
            
            if ($param == 'fileName') {
                $fileName = $value;
            }
            if ($param == 'fontFamily') {
                $fontFamily = $value;
            }
            
            // Cyrillic:
            if ($param == 'cyrillic') {        
                $cyryllic .= $form->formStart(array('id' => 'cyrillic_font'));
                $cyryllic .= $form->hidden(array('name' => 'action','value' => 'cyrillic_font'));
                $cyryllic .= $form->hidden(array('name' => 'fontID','value' => $_GET['ID']));
                
                if ($value == 0) {
                    $cyryllic .= $form->hidden(array('name' => 'cyrillic','value' => 1));
                    $cyryllic .= '<span class="glyphicon glyphicon-remove-sign" title="Cyrillic" onclick="document.getElementById(\'cyrillic_font\').submit(); "></span>';
                } else if ($value == 1) {
                    $cyryllic .= $form->hidden(array('name' => 'cyrillic','value' => 0));
                    $cyryllic .= '<span class="glyphicon glyphicon-ok-sign" title="Cyrillic" onclick="document.getElementById(\'cyrillic_font\').submit(); "></span>';
                }
                
                $cyryllic .= $form->formEnd();
                $value = $cyryllic;
            }
            
            // Latin:
            if ($param == 'latin') {
                $latin .= $form->formStart(array('id' => 'latin_font'));
                $latin .= $form->hidden(array('name' => 'action','value' => 'latin_font'));
                $latin .= $form->hidden(array('name' => 'fontID','value' => $_GET['ID']));
                
                if ($value == 0) {
                    $latin .= $form->hidden(array('name' => 'latin','value' => 1));
                    $latin .= '<span class="glyphicon glyphicon-remove-sign" title="Latin" onclick="document.getElementById(\'latin_font\').submit(); "></span>';
                } else if ($value == 1) {
                    $latin .= $form->hidden(array('name' => 'latin','value' => 0));
                    $latin .= '<span class="glyphicon glyphicon-ok-sign" title="Latin" onclick="document.getElementById(\'latin_font\').submit(); "></span>';
                }
                
                $latin .= $form->formEnd();
                $value = $latin;
            }            
            
            // Favourite:
            if ($param == 'myFavourite') {
                $favForm .= $form->formStart(array('id'=>'make_font_favourite'));
                $favForm .= $form->hidden(array('name' => 'action','value' => 'make_font_favourite'));
                $favForm .= $form->hidden(array('name' => 'fontID','value' => $_GET['ID']));
            
                if ($value == 1) {
                    $favForm .= $form->hidden(array('name' => 'myFavourite','value' => 0));
                    $favForm .= '<span class="glyphicon glyphicon-heart" title="Favourite" onclick="document.getElementById(\'make_font_favourite\').submit(); "></span>';
                    
                } else if ($value == 0) {
                    $favForm .= $form->hidden(array('name' => 'myFavourite','value' => 1));
                    $favForm .= '<span class="glyphicon glyphicon-heart-empty" title="Not favourite" onclick="document.getElementById(\'make_font_favourite\').submit(); "></span>';
                }
                $favForm .= $form->formEnd();
                $value = $favForm;
            }
            
            $hide = array('mono','sans','serif','moderation','fontStyle','fontVariant','fileName','fontWeight');
            if (!in_array($param,$hide)){
                echo $table->tr(
                    array(
                        $param,
                        $value
                    )
                );
            }
        }
        echo $table->tr(
            array(
                'font-size',
                $fontSize .' <a href="'.CONFIGURATION::MAIN_URL.'?page=font&ID='.$_GET['ID'].'&font-size='.($fontSize + 1).'&h2='.$h2.'"><span class="glyphicon glyphicon-arrow-up"></span></a> : <a href="'.CONFIGURATION::MAIN_URL.'?page=font&ID='.$_GET['ID'].'&font-size='.($fontSize - 1).'&h2='.$h2.'"><span class="glyphicon glyphicon-arrow-down"></span></a> '
            )
        );        
        echo $table->tr(
            array(
                'H2',
                $h2 .' <a href="'.CONFIGURATION::MAIN_URL.'?page=font&ID='.$_GET['ID'].'&font-size='.$fontSize.'&h2='.($h2 + 1).'"><span class="glyphicon glyphicon-arrow-up"></span></a> 
                : 
                <a href="'.CONFIGURATION::MAIN_URL.'?page=font&ID='.$_GET['ID'].'&font-size='.$fontSize.'&h2='.($h2 - 1).'"><span class="glyphicon glyphicon-arrow-down"></span></a> '
            )
        );       
        echo $table->tr(
            array(
                '<a href="" data-toggle="modal" data-target="#delete_font">Delete</a>',
                ''
            )
        );         
        echo $table->tableEnd();
        
        $fontDeleteForm .= $form->formStart(array('id'=>'delete_font'));
        $fontDeleteForm .= $form->hidden(array('name' => 'action','value' => 'delete_font'));
        $fontDeleteForm .= $form->hidden(array('name' => 'fontID','value' => $_GET['ID']));
        $fontDeleteForm .= $form->submit(array('value'=> 'Delete'));
        $fontDeleteForm .= $form->formEnd();
        
        echo $pure->modalHtml('delete_font','Do you want to delete font?',$fontDeleteForm);
        
?>
    
    </div>
	<div class="col-lg-9 col-sm-8">

    <p align="left">    
    <style>
    @font-face{
        font-family: <?php echo $fontFamily;?>; 
        src:url(<?php echo CONFIGURATION::MAIN_URL.'uploads/fonts/'.$fileName; ?>);
        }
    #test { 
        font-family: <?php echo $fontFamily;?>; 
        overflow: hidden; 
        width: 100%; margin-left: auto;
        margin-right: auto; 
        position: relative;
        font-size: <?php echo $fontSize;?>px;
        background: ; 
        color: ;
        background: #fff;
    }
    #test_inner {
        margin: 10px; 
    }
    .font-preview { 
            font-size: <?php echo $h2; ?>px;
    }
    </style>
        <div id="test">
            <div id="test_inner">
            <h2 class="font-preview">What is Lorem Ipsum? (<?php echo $fontFamily;?>)</h2>
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
<h2 class="font-preview">Что такое Lorem Ipsum? (<?php echo $fontFamily;?>)</h2>
<p>Отображаются ли буквы: ы ё ъ ь (4 шт)</p>
Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн. Его популяризации в новое время послужили публикация листов Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.
<h2 class="font-preview">Що таке Lorem Ipsum? (<?php echo $fontFamily;?>)</h2>
<p>Чи відображаються букви: і ї й щ є (5 шт)</p>
Lorem Ipsum - це текст-"риба", що використовується в друкарстві та дизайні. Lorem Ipsum є, фактично, стандартною "рибою" аж з XVI сторіччя, коли невідомий друкар взяв шрифтову гранку та склав на ній підбірку зразків шрифтів. "Риба" не тільки успішно пережила п'ять століть, але й прижилася в електронному верстуванні, залишаючись по суті незмінною. Вона популяризувалась в 60-их роках минулого сторіччя завдяки виданню зразків шрифтів Letraset, які містили уривки з Lorem Ipsum, і вдруге - нещодавно завдяки програмам комп'ютерного верстування на кшталт Aldus Pagemaker, які використовували різні версії Lorem Ipsum.
            </div>
        </div>
    </div>
</div>

