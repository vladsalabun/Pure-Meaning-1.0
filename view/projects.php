<div class="row">
	<div class="col-lg-12 margin20" align="left">
    
    <a href="" data-toggle="modal" data-target="#AddNewProject" title="Створити новий проект"><?php echo $icon->showIcon('plus','width15','Створити новий проект'); ?></a>
    
    <a href="" data-toggle="modal" data-target="#AddNewProject" title="Створити новий проект">Створити новий проект</a>
    </div>
    
    <div class="col-lg-12 margin20" align="left">
    
<?php

    # Створюю об'єкти:
    $projects = new projects;

    # Форма для створення проекту:
    formForCreatingNewProject();

    # ТАБЛИЦЯ ПРОЕКТІВ!
    echo $table->tableStart( array(
                'class'=>'table table-striped table-middle',
                'th'=> array(
                        '<span class="fontB">Проекти:</span>',
                        '<span class="fontB">Анкета:</span>',
                        '<span class="fontB">Клієнт:</span>',
                        '<span class="fontB">Skype:</span>',
                        '<span class="fontB">Тел.,e-mails:</span>',
                        '<span class="fontB">VK / FB:</span>',
                        '<span class="fontB">Ціна:</span>',
                        '<span class="fontB">Початок / Канець:</span>',
                        '<span class="fontB">Час:</span>'
                    )
                )
            );

    // Беру всі проекти з бази даних:       
    $projectsArray = $projects->getAllProjects();

    foreach($projectsArray as $project) {

        // Беру всі субпроекти з бази даних:     
        $subProjects = $projects->getAllSubProjects($project['ID']);

        // make subpages:
        $showSub = '<ul class="tree">';
        foreach($subProjects as $subProject) {
            $showSub .= '<li><a href="'.configuration::MAIN_URL.'?page=project&id='.$subProject['ID'].'">'.$subProject['title'].'</a> <a href="" data-toggle="modal" data-target="#Edit'.$subProject['ID'].'">'.$icon->showIcon('edit','width20','Редагувати').'</a></li>';

            // edit subproject modal body:
            $delSub = p(
             $form->formStart()
            .$form->hidden(array('name' => 'action','value' => 'delete_project'))
            .$form->hidden(array('name' => 'projectId','value' => $subProject['ID']))
            .$form->submit(array('name' => 'submit','value' => 'Видалити проект','class' => 'btn btn-danger'))
            .$form->formEnd(),'right');

            $duplicateSub = p(
             $form->formStart()
            .$form->hidden(array('name' => 'action','value' => 'duplicate_project'))
            .$form->hidden(array('name' => 'projectId','value' => $subProject['ID']))
            .$form->submit(array('name' => 'submit','value' => 'Зробити копію проекту','class' => 'btn btn-warning'))
            .$form->formEnd(),'right');


            $editSubModalBody = '<div class="row"><div class="col-lg-6 margin20">'.
             $form->formStart()
            .$form->hidden(array('name' => 'action','value' => 'edit_subproject'))
            .$form->hidden(array('name' => 'projectId','value' => $subProject['ID']))
            .$form->text(array('name' => 'title','value' => $subProject['title'],'class' => 'txtfield'))
            .'<br>'
            .$form->submit(array('name' => 'submit','value' => 'Зберегти','class' => 'btn btn-success margin10'))
            .$form->formEnd()
            .'</div>'
            .'<div class="col-lg-6 margin20">'.$delSub.$duplicateSub.'</div></div>';

            // edit subproject modal:
            echo modalWindow(
                'Edit'.$subProject['ID'],
                'Редагування проекту: «'.$subProject['title'].'»',
                 $editSubModalBody
                );
        }
            // add new subproject icon:
            $showSub .= '<li><a href="" data-toggle="modal" data-target="#AddNewSubProject'.$project['ID'].'">'.$icon->showIcon('plus','width15','Створити нову сторінку').'</a></li>';
            $showSub .= '</ul>';


        if ($project['done'] == 0) {
            $days = $project['workEnd'] - mktime();
            $days = round(($days / 60 / 60 / 24),2);
            $hours = floor(($days - floor($days)) * 24);
            $done = floor($days).' d. '.$hours.' h.';
        } else if ($project['done'] == 1) {
            $done = '<font color="green">Готово</font>';
        }

        if (strlen($project['phone1']) > 0) { $phone1 = $project['phone1'].'<br>'; } else { $phone1 = '';}
        if (strlen($project['phone2']) > 0) { $phone2 = $project['phone2'].'<br>'; } else { $phone2 = '';}
        if (strlen($project['phone3']) > 0) { $phone3 = $project['phone3'].'<br>'; } else { $phone3 = '';}
        if (strlen($project['email1']) > 0) { $email1 = $project['email1'].'<br>'; } else { $email1 = '';}
        if (strlen($project['email2']) > 0) { $email2 = $project['email2'].'<br>'; } else { $email2 = '';}

        // SHOW table:
        echo $table->tr(
             array(
                    '<b>'.$project['title'].'</b>:
                    <a href="" data-toggle="modal" data-target="#Edit'.$project['ID'].'">'.$icon->showIcon('edit','width20','Редагувати').'</a>
                    '.$showSub,
                    '<a href="" class="notcompleted" target="blank">Анкета</a>',
                    $project['customer'],
                    $project['skype'],
                    $phone1.$phone2.$phone3.$email1.$email2,
                    '<a href="'.$project['vk'].'" target="_blank">vk</a> / <a href="'.$project['fb'].'" target="_blank">fb</a>',
                    $project['price'].configuration::CURRENCY[$project['currency']],
                    date("Y-m-d", $project['workBegin']).'<br>'.date("Y-m-d", $project['workEnd']),
                    $done
                )
            );

            // add subproject modal:
            $subprojectModalBody = '';
            $subprojectModalBody .= $form->formStart()
            . $form->hidden(array('name' => 'action','value' => 'add_new_subproject'))
            . $form->hidden(array('name' => 'projectId','value' => $project['ID']))
            . p('Введіть назву сторінки:')
            . $form->text(array('name' => 'title','class' => 'txtfield'))
            . '<br><br>'
            . $form->submit(array('name' => 'submit','value' => 'Створити сторінку','class' => 'btn btn-success margin10'))
            . $form->formEnd();

            echo modalWindow(
                'AddNewSubProject'.$project['ID'],
                'Створити нову сторінку у проекті <span class="fontB">'.$project['title'].'</span>:',
                $subprojectModalBody
            );

        }

        echo $table->tableEnd();

        ###
        // foreach again to show project modal:
        foreach($projectsArray as $project) {
            // edit project modal body:
            $editModalBody = '';

            $delProject = $form->formStart()
            . $form->hidden(array('name' => 'action','value' => 'delete_project'))
            . $form->hidden(array('name' => 'projectId','value' => $project['ID']));
            $delProject .= $form->submit(array('name' => 'submit','value' => 'Видалити проект','class' => 'btn btn-danger margin10'));
            $delProject .= $form->formEnd();

            $duplicate_project = $form->formStart()
            . $form->hidden(array('name' => 'action','value' => 'duplicate_project'))
            . $form->hidden(array('name' => 'projectId','value' => $project['ID']));
            $duplicate_project .= $form->submit(array('name' => 'submit','value' => 'Копіювати проект','class' => 'btn btn-warning margin10'));
            $duplicate_project .= $form->formEnd();


            $editModalBody .= $form->formStart()
            . $form->hidden(array('name' => 'action','value' => 'edit_project'))
            . $form->hidden(array('name' => 'projectId','value' => $project['ID']));

            $editModalBody .= $table->tableStart(
                    array(
                        'class'=>'table table-striped table-mini',
                        'th'=> array('<span class="fontB">Питання:</span>','<span class="fontB">Відповідь:</span>')
                    )
                );

            // fields set:
            $fields = array('title','customer','skype','phone1','phone2','phone3','email1','email2','vk','fb','price');

            foreach ($fields as $field) {
            $editModalBody .= $table->tr(
                    array(
                        $field.':',
                        $form->text(array('name' => $field,'value' => $project[$field],'class' => 'txtfield'))
                    )
                );
            }

            // currency
            $editModalBody .= $table->tr(
                    array(
                        'currency:',
                        $form->select(
                            array(
                                'name' => 'currency',
                                'value' => array(
                                    0 => 'usd',
                                    1 => 'rub',
                                    2 => 'uah'
                                )
                            )
                        )
                    )
                );
            // workBegin
            $editModalBody .= $table->tr(
                    array(
                        'workBegin:',
                        $form->datetime(array('name' => 'workBegin','value' => date('Y-m-d',$project['workBegin']).'T'.date('H:i:s',$project['workBegin'])))
                    )
                );
            // workEnd
            $editModalBody .= $table->tr(
                    array(
                        'workEnd:',
                        $form->datetime(array('name' => 'workEnd','value' => date('Y-m-d',$project['workEnd']).'T'.date('H:i:s',$project['workEnd'])))
                    )
                );

            $editModalBody .= $table->tableEnd();

            $editModalBody .= p($form->submit(array('name' => 'submit','value' => 'Зберегти зміни','class' => 'btn btn-success margin10')),'center');
            $editModalBody .= $form->formEnd();

            // edit project modal:
            echo modalWindow(
                'Edit'.$project['ID'],
                'Редагування проекту <span class="fontB">'.$project['title'].'</span>',
                '<div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 right">
                '.$delProject.' '.$duplicate_project.'</div></div>
                <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                '.$editModalBody.'</div></div>'
                );
        }

?>
        
    </div>
</div>
<?php 

    function formForCreatingNewProject() {
        
        $form = new formGenerator;
        $table = new tableGenerator;
        
        $formBody .= $form->formStart();
        $formBody .= $form->hidden(array('name' => 'action','value' => 'add_new_project'));

        $formBody .= $table->tableStart(
            array(
                'class'=>'table table-striped table-mini',
                'th'=> array('<span class="fontB">Запитання:</span>','<span class="fontB">Відповідь:</span>')
            )
        );

        // fields set:
        $fields = array('title','customer','skype','phone1','phone2','phone3','email1','email2','vk','fb','price');

        foreach ($fields as $field) {
        $formBody .= $table->tr(
                array(
                    $field.':',
                    $form->text(array('name' => $field,'class' => 'txtfield'))
                )
            );
        }

        // currency
        $formBody .= $table->tr(
                array(
                    'currency:',
                    $form->select(
                        array(
                            'name' => 'currency',
                            'value' => array(
                                0 => 'usd',
                                1 => 'rub',
                                2 => 'uah'
                            )
                        )
                    )
                )
            );
        // workBegin
        $formBody .= $table->tr(
                array(
                    'workBegin:',
                    $form->datetime(array('name' => 'workBegin','value' => date('Y-m-d').'T'.date('H:i:s')))
                )
            );
        // workEnd
        $formBody .= $table->tr(
                array(
                    'workEnd:',
                    $form->datetime(array('name' => 'workEnd','value' => date('Y-m-d').'T'.date('H:i:s')))
                )
            );
        // project type:
        $formBody .= $table->tr(
                array(
                    'Project type:',
                    $form->select(
                        array(
                            'name' => 'project_type',
                            'value' => array(
                                99 => 'Custom',
                                0 => 'WordPress'
                            )
                        )
                    )
                )
            );
        $formBody .= $table->tableEnd();
        $formBody .= p($form->submit(array('value' => 'Створити новий проект','class' => 'btn btn-success margin10')),'center');
        $formBody .= $form->formEnd();

        echo modalWindow('AddNewProject','Створення нового проекту:',$formBody);
        # <- /form for adding new project
    }
    