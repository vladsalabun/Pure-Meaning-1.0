<div class="row">
	<div class="col-lg-12" align="left">
    <a href="" data-toggle="modal" data-target="#AddNewProject" title="Add new project"><span class="glyphicon glyphicon-plus" ></span> Add new project</a>
<?php 

    $projects = new projects;    
    $form = new formGenerator;    
    $table = new tableGenerator; 
    
    # form for adding new project:
    $formBody .= $form->formStart();
    $formBody .= $form->hidden(array('name' => 'action','value' => 'add_new_project'));
    
    $formBody .= $table->tableStart( 
        array(
            'class'=>'table table-striped',
            'th'=> array('Question:','Answer:')
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
    $formBody .= $form->submit(array('value' => 'Add new project','class' => 'submit_btn'));   
    $formBody .= $form->formEnd();

    echo $pure->modalHtml('AddNewProject','Add new project:',$formBody);
    # <- /form for adding new project
    
    echo $table->tableStart( array(
                'class'=>'table table-striped',
                'th'=> array('Projects:','Asnwers','pdf','Customer:','Skype:','Phones,emails:','VK / FB:','Price:','Start / End:','Day:')
                )
            );

    $projectsArray = $projects->getAllProjects();

    foreach($projectsArray as $project) {
            
        //$project['done'] 
        if ($project['currency'] == 0) {
            $currency = '$';
        } elseif ($project['currency'] == 1) {
            $currency = '₽';
        } elseif ($project['currency'] == 2) {
            $currency = '₴';
        } 
            
        $subProjects = $projects->getAllSubProjects($project['ID']);
        
        // make subpages:
        $showSub = '<ul class="tree">';
        foreach($subProjects as $subProject) {
            $showSub .= '<li><a href="'.configuration::MAIN_URL.'?page=project&id='.$subProject['ID'].'">'.$subProject['title'].'</a> <a href="" data-toggle="modal" data-target="#Edit'.$subProject['ID'].'"><span class="glyphicon glyphicon-pencil" title="Edit"></span></a></li>';
            
            // edit subproject modal body:
            $delSub = $form->formStart()
            . $form->hidden(array('name' => 'action','value' => 'delete_project'))
            . $form->hidden(array('name' => 'projectId','value' => $subProject['ID']));
            $delSub .= $form->submit(array('name' => 'submit','value' => 'Delete project','class' => 'submit_btn'));
            $delSub .= $form->formEnd();
            
            $duplicateSub = $form->formStart()
            . $form->hidden(array('name' => 'action','value' => 'duplicate_project'))
            . $form->hidden(array('name' => 'projectId','value' => $subProject['ID']));
            $duplicateSub .= $form->submit(array('name' => 'submit','value' => 'Duplicate project','class' => 'submit_btn'));
            $duplicateSub .= $form->formEnd();

            
            $editSubModalBody = '';

            $editSubModalBody .= $form->formStart()
            . $form->hidden(array('name' => 'action','value' => 'edit_subproject'))
            . $form->hidden(array('name' => 'projectId','value' => $subProject['ID']))
            . $form->text(array('name' => 'title','value' => $subProject['title'],'class' => 'txtfield'))
            . '<br><br>'
            . $form->submit(array('name' => 'submit','value' => 'Edit subproject','class' => 'submit_btn'))
            . $form->formEnd();
            
            // edit subproject modal:
            echo $pure->modalHtml(
                'Edit'.$subProject['ID'],
                'Edit '.$subProject['title'].':'.$delSub.'<br><br>'.$duplicateSub,
                 $editSubModalBody
                );            
        }
            // add new subproject icon:
            $showSub .= '<li><a href="" data-toggle="modal" data-target="#AddNewSubProject'.$project['ID'].'"><span class="glyphicon glyphicon-plus" title="Add new subproject"></span></a></li>';
            $showSub .= '</ul>';


        if ($project['done'] == 0) {
            $days = $project['workEnd'] - mktime();
            $days = round(($days / 60 / 60 / 24),2);
            $hours = floor(($days - floor($days)) * 24);
            $done = floor($days).' d. '.$hours.' h.';
        } else if ($project['done'] == 1) {
            $done = '<font color="green">Готово</font>';
        }
        
        if (strlen($project['phone1']) > 0) $phone1 = $project['phone1'].'<br>';
        if (strlen($project['phone2']) > 0) $phone2 = $project['phone2'].'<br>';
        if (strlen($project['phone3']) > 0) $phone3 = $project['phone3'].'<br>';
        if (strlen($project['email1']) > 0) $email1 = $project['email1'].'<br>';
        if (strlen($project['email2']) > 0) $email2 = $project['email2'].'<br>';
        
        // SHOW table:
        echo $table->tr(
             array(
                    '<b>'.$project['title'].'</b>: 
                    <a href="" data-toggle="modal" data-target="#Edit'.$project['ID'].'"><span class="glyphicon glyphicon-pencil" title="Edit"></span></a>
                    '.$showSub,
                    'todo: <a href="" class="notcompleted" target="blank">Client answers</a>',
                    // TODO: generate PDF
                    'pdf',
                    $project['customer'],
                    $project['skype'],
                    $phone1.$phone2.$phone3.$email1.$email2,
                    '<a href="'.$project['vk'].'" target="_blank">vk</a> / <a href="'.$project['fb'].'" target="_blank">fb</a>',
                    $project['price'].$currency,
                    date("Y-m-d", $project['workBegin']).'<br>'.date("Y-m-d", $project['workEnd']),
                    $done
                ) 
            );
 
            // add subproject modal:
            $subprojectModalBody = '';
            $subprojectModalBody .= $form->formStart()
            . $form->hidden(array('name' => 'action','value' => 'add_new_subproject'))
            . $form->hidden(array('name' => 'projectId','value' => $project['ID']))
            . $form->text(array('name' => 'title','class' => 'txtfield'))
            . '<br><br>'
            . $form->submit(array('name' => 'submit','value' => 'Add subproject','class' => 'submit_btn'))
            . $form->formEnd();
            
            echo $pure->modalHtml(
                'AddNewSubProject'.$project['ID'],
                'Add subproject to project #'.$project['ID'].':',
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
            $delProject .= $form->submit(array('name' => 'submit','value' => 'Delete project','class' => 'submit_btn'));
            $delProject .= $form->formEnd();

            $duplicate_project = $form->formStart()
            . $form->hidden(array('name' => 'action','value' => 'duplicate_project'))
            . $form->hidden(array('name' => 'projectId','value' => $project['ID']));
            $duplicate_project .= $form->submit(array('name' => 'submit','value' => 'Duplicate project','class' => 'submit_btn'));
            $duplicate_project .= $form->formEnd();
            
            
            $editModalBody .= $form->formStart()
            . $form->hidden(array('name' => 'action','value' => 'edit_project'))
            . $form->hidden(array('name' => 'projectId','value' => $project['ID']));

            $editModalBody .= $table->tableStart( 
                    array(
                        'class'=>'table table-striped',
                        'th'=> array('Question:','Answer:')
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

            $editModalBody .= $form->submit(array('name' => 'submit','value' => 'Edit project','class' => 'submit_btn'));
            $editModalBody .= $form->formEnd();
 
            // edit project modal:
            echo $pure->modalHtml(
                'Edit'.$project['ID'],
                'Edit '.$project['title'].':'.$delProject.'<br>'.$duplicate_project,
                 $editModalBody
                );   
        }
        
?>
        <p align="left">Створюю новий проект і всю інформацію про нього зберігаю туди, включаючи те, 
        що вводить користувач, посилання на відео конференції з клієнтом і телефонні розмови.</p>

    </div>
</div>



