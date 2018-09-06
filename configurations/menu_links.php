<?php 
        
    // Setup:
    class menuLinks
    {    
       
       /*  
            For each key you need to create *.php file in folder /view
            These pages will be displayed in the main menu:
            example: 'page_url' => 'page_title'
       */
       const ALL_PAGES = array (
            'projects' => 'Проекти',
            'fonts' => 'Шрифти',
            //'backgrounds' => 'Backgrounds',
            'color_sets' => 'Кольори',
            'memes' => 'Меми',
            'objections' => 'Заперечення',
            'test' => 'Тести',
            'helper' => 'Документація',
            'typograph' => 'Типограф',
        );
        
        
        /*
            For each key you need to create *.php file in folder /view
            These pages are not displayed in the main menu
            example: 'page_url' => array('page_title','parent_page_url')
        */
        
        const SUB_PAGES = array (
            'add_font' => array('Добавить шрифт','fonts'),    // don't change url!
            'questions' => array('Вопросы и ответы','projects'),    // don't change url!
            'project' => array('Проект','projects'),    // don't change url!
            'preview' => array('Просмотр','projects'),
            'template' => array('Редактор','projects'),
            'edit_element' => array('Редактор елемента','projects'),
            'classes_editor' => array('Редактор класов','projects'),
            'pdo_query' => array('Генератор запросов PDO',''),
            'form_generator' => array('Генератор форм',''),
            'new_form' => array('Создать новую форму',''),
            'font' => array('Шрифт','fonts'),
            'objection' => array('Возражения','objection'),
            'memegen' => array('memegen','memegen'),
            'colors' => 'Colors',
            'association' => 'Association',
        );   
       
    }
    
