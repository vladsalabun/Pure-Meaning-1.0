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
            'template' => array('Редактор','projects'),
            'edit_element' => array('Редактор елемента','projects'),
            'classes_editor' => array('Редактор класов','projects'),
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
                "moderation" => "INT( 1 ) DEFAULT '0'", // 1 - good, 2 - bad, 3 - deleted
                "globalStyles" => "TEXT NULL" // json fo classes
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
                // TODO: add my comment to favourite elements
            ),            

            
        );
           
        const FISH = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis volutpat fermentum augue a accumsan. Ut est sapien, malesuada eget convallis eu, mattis nec eros. Suspendisse suscipit vehicula augue, nec commodo mi interdum ac. Etiam id sem venenatis, hendrerit purus eu, auctor metus. Quisque lacinia nisi eu pellentesque pharetra. Phasellus malesuada id sapien ut sagittis. Nam eget dui nec dui tristique commodo at vitae nibh. In imperdiet odio ut lorem aliquam varius. Aenean facilisis tempus dui, et posuere sapien vulputate faucibus. Integer pharetra leo non leo aliquet, vitae ullamcorper dui rutrum. Duis vestibulum facilisis rhoncus. Nam ligula nunc, sagittis sed purus in, tincidunt finibus magna. Vivamus laoreet massa eu rhoncus tempus. Quisque tincidunt hendrerit metus sed vehicula. Sed iaculis mauris nec nunc suscipit hendrerit. Cras at scelerisque tellus, ut dignissim lorem.

Suspendisse vestibulum nec tellus ultricies tristique. Sed bibendum ex arcu, ut efficitur sapien aliquet a. In nunc sapien, varius id diam sit amet, sagittis luctus nulla. Ut convallis nibh augue, id pellentesque diam convallis a. Integer ornare volutpat finibus. Pellentesque lacinia egestas faucibus. Nulla pulvinar sapien justo, vitae aliquam orci efficitur sit amet. In ut rutrum libero, vitae accumsan magna. Integer ultrices, enim sed fermentum sagittis, dui nisi semper mi, eu fringilla felis libero in elit. Nullam sit amet rhoncus leo. Vivamus egestas, elit quis luctus finibus, risus nibh pulvinar tortor, quis congue orci enim id justo. Nulla facilisi.

Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris laoreet ipsum ac tortor venenatis feugiat. Phasellus vehicula risus eget justo dignissim rhoncus. Sed lacinia fringilla neque, sodales gravida arcu hendrerit sed. Praesent tempus enim magna, ullamcorper sodales turpis mattis vel. Nunc in finibus ipsum. Vestibulum id laoreet nibh, nec vulputate lectus. Curabitur velit sem, tristique a turpis ac, dignissim suscipit orci. Suspendisse eget tempus erat. Morbi aliquam nisi urna, id ornare velit accumsan nec. Aliquam nec magna nec dolor tincidunt bibendum et sed lorem. Pellentesque in cursus justo. Sed in justo sodales, viverra justo eu, tempus ante. Phasellus bibendum volutpat odio, sed imperdiet libero bibendum at.

Aenean ultricies ante et neque aliquet, eget molestie libero tincidunt. Etiam nec venenatis turpis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Cras non tellus at velit euismod efficitur auctor eu leo. Suspendisse blandit turpis a ligula semper dictum. Vivamus finibus fringilla nibh quis euismod. Curabitur nec porta lacus. Ut sodales libero in ex ullamcorper consectetur eget vel nulla. Mauris hendrerit massa sagittis rutrum luctus. Donec ac vestibulum libero. Mauris nunc augue, porttitor ut porttitor sit amet, vestibulum at libero. Vivamus tempor bibendum ante sed venenatis. Donec non libero a ante tristique fringilla. Nam tincidunt urna vel ante eleifend consequat.

Sed non tempor nunc, non viverra sem. Donec imperdiet nisi vitae erat cursus aliquet. Quisque euismod feugiat nunc eget egestas. Sed sagittis dapibus accumsan. Proin malesuada elementum metus placerat tempus. Cras mi ante, tempus vel leo id, lobortis sollicitudin eros. Donec fermentum tortor dui, sed tempor metus tempor vel.';
        
        const ELEMENTS = array(
            2 => 'div',
            3 => 'button',
            4 => 'image'
        );
        
        const OTHER = array(
            'fish',
            'text',    
        );
        
        const STYLE = array(
            'background',
            'color',
            'font-size',
            'font-family',
            'padding',
            'margin',     
            'float',     
            'text-align',     
            'width',     
            'height',     
        );
        
        const STYLEVALUES = array(
            'font-size' => 'px',
            'padding' => 'px',
            'margin'  => 'px'
        );
    }
