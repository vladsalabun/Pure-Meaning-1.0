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
            'fonts' => 'Шрифты',
        );
        
        /*
            For each key you need to create *.php file in folder /view
            These pages are not displayed in the main menu
            example: 'page_url' => array('page_title','parent_page_url')
        */
        
        const SUB_PAGES = array (
            'add_font' => array('Добавить шрифт','fonts'),    // don't change url!
        );        
                
        // All tables:
        const MYSQL_TABLES = array(
            
            // Creating font table:
            "pm_fonts" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "font_name" => "VARCHAR( 100 ) NOT NULL",
                "eng" => "INT( 1 ) DEFAULT '1'",
                "cyr" => "INT( 1 ) DEFAULT '1'",
                "url" => "VARCHAR( 100 ) NOT NULL",
                "deleted" => "INT( 1 ) DEFAULT '0'"
            )

        );
                
    }
