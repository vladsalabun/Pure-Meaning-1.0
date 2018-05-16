<?php 
        
    // Setup:
    class configuration
    {    
        const HOST = 'localhost';
        const DB_NAME = 'pure_meaning';
        const DB_USER = 'mysql';
        const DB_PASSWORD = 'mysql';
        const MAIN_URL = 'http://test1.ru/drive/pure_meaning/';
        const REINSTALL = 0; // set 1 to create database, set 2 to wipe database
        
        
        /*  
            For each key you need to create *.php file in folder /view
            These pages will be displayed in the main menu:
            example: 'page_url' => 'page_title'
        */
        
        const ALL_PAGES = array (
            'projects' => 'Проекты',
            'fonts' => 'Шрифты',
            'backgrounds' => 'Фоны',
            'colors' => 'Цвета',
            'objections' => 'Возражения',
            'test' => 'Тесты',
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
        );        
                
        // All tables:
        const MYSQL_TABLES = array(
            
            // Creating projects table:
            "pm_projects" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "title" => "VARCHAR( 500 ) NOT NULL",
                "customer" => "VARCHAR( 500 ) NOT NULL",
                "skype" => "VARCHAR( 100 ) NULL",
                "phone1" => "VARCHAR( 100 ) NOT NULL",
                "phone2" => "VARCHAR( 100 ) NOT NULL",
                "phone3" => "VARCHAR( 100 ) NOT NULL",
                "email1" => "VARCHAR( 100 ) NOT NULL",
                "email2" => "VARCHAR( 100 ) NOT NULL",
                "vk" => "VARCHAR( 100 ) NOT NULL",
                "fb" => "VARCHAR( 100 ) NOT NULL",
                "price" => "INT( 11 ) DEFAULT '0'",
                "currency" => "INT( 1 ) DEFAULT '0'", // 0 - usd, 1 - rub, 2 - uah
                "workBegin" => "INT( 11 ) NOT NULL",
                "workEnd" => "INT( 11 ) NOT NULL",
                "done" => "INT( 1 ) DEFAULT '0'",
                "moderation" => "INT( 1 ) DEFAULT '0'" // 1 - good, 2 - bad, 3 - deleted
            ), 

            // Creating questions table:
            "pm_questions" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "type" => "INT( 1 ) DEFAULT '1'", // 1 - for me, 2 - for customer, 3 - only to 1 project
                "projectId" => "INT( 1 ) DEFAULT '0'", // 1 - for me, 2 - for customer, 3 - only to 1 project
                "text" => "TEXT NULL",
                "answerExamples" => "TEXT NULL", // json
                "required" => "INT( 1 ) DEFAULT '0'",
                "moderation" => "INT( 1 ) DEFAULT '0'" // 1 - good, 2 - bad, 3 - deleted
            ),            
            
            // Creating answers table:
            "pm_answers" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "projectId" => "INT( 1 ) DEFAULT '0'",
                "questionId" => "INT( 1 ) DEFAULT '0'",
                "text" => "TEXT NULL",
                "addDate" => "INT( 11 ) NOT NULL",
                "author" => "INT( 1 ) DEFAULT '0'" // 1 - me, 2 - customer
            ), 

            // Creating objections table:
            "pm_objections" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "objection" => "TEXT NULL",
                "answerRu" => "TEXT NULL",
                "answerUkr" => "TEXT NULL",
                "moderation" => "INT( 1 ) DEFAULT '0'" // 1 - good, 2 - bad, 3 - deleted
            ), 
            
            
            // Creating font table:
            "pm_fonts" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "fontFamily" => "VARCHAR( 100 ) NOT NULL", // Arial
                "fontStyle" => "VARCHAR( 20 ) NOT NULL", // normal, italic, oblique
                "fontVariant" => "VARCHAR( 20 ) NOT NULL", // smallerCase, upperCase
                "fontWeight" => "VARCHAR( 20 ) NOT NULL", // normal, bold, what else?
                "cyryllic" => "INT( 1 ) DEFAULT NULL",
                "latin" => "INT( 1 ) DEFAULT NULL",
                "fileName" => "VARCHAR( 100 ) NOT NULL", // Arial.ttf
                "fileType" => "VARCHAR( 5 ) NOT NULL", // ttf
                "myFavourite" => "INT( 1 ) DEFAULT '0'", // 1 - yes,
                "mono" => "INT( 1 ) DEFAULT '0'", // for code, terminal, numbers
                "sans" => "INT( 1 ) DEFAULT '0'", // for headers
                "serif" => "INT( 1 ) DEFAULT '0'", // for easy reading text
                "moderation" => "INT( 1 ) DEFAULT '0'" // 1 - good, 2 - bad, 3 - deleted
            ),

            // Creating backgrounds table:
            "pm_backgrounds" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "backgroundColor" => "VARCHAR( 10 ) NOT NULL", // ex. #000000
                "textColor" => "VARCHAR( 10 ) NOT NULL", // ex. #000000
                "moderation" => "INT( 1 ) DEFAULT '0'" // 1 - good, 2 - bad, 3 - deleted
            ),            

            // Creating all colors table:
            "pm_colors" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "color" => "VARCHAR( 10 ) NOT NULL",
                "moderation" => "INT( 1 ) DEFAULT '0'" // 1 - good, 2 - bad, 3 - deleted
            ), 
            
            // Creating elements table:
            "pm_elements" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "projectId" => "INT( 1 ) DEFAULT '0'",
                "parentId" => "INT( 11 ) DEFAULT '0'",
                "type" => "INT( 1 ) DEFAULT '0'", // 1 - header, 2 - div, 3 - button, 4 - form, 5 - slider
                "identifier" => "VARCHAR( 200 ) NULL",
                "class" => "VARCHAR( 200 ) NULL",
                "style" => "TEXT NULL", // json
                "priority" => "INT( 11 ) DEFAULT '0'",
                "moderation" => "INT( 1 ) DEFAULT '0'" // 1 - good, 2 - bad, 3 - deleted
            ),            

            
        );
                
    }
