<?php 
        
    // Setup:
    class configuration
    {    
        const VER = 2.3;
        const HOST = 'localhost';
        const DB_NAME = 'pure_meaning';
        const DB_USER = 'mysql';
        const DB_PASSWORD = 'mysql';
        const MAIN_URL = 'http://test1.ru/drive/pure_meaning/';
        const REINSTALL = 0; // set 1 to create database, set 2 to wipe database
        
        const HOUR_PRICE = 6; // USD
        
        const FONTS_DIR = 'uploads/fonts/';
        const SCREENSHOTS_DIR = 'img/screenShots/';
        const FONTS_TYPES = array('ttf','otf','woff','woff2');
        
        const WORDPRESS_PAGES = array(
                '404','footer','page','single','index','header'
              );
        /*  
            For each key you need to create *.php file in folder /view
            These pages will be displayed in the main menu:
            example: 'page_url' => 'page_title'
        */
        
        const ALL_PAGES = array (
            'projects' => 'Projects',
            'fonts' => 'Fonts',
            //'backgrounds' => 'Backgrounds',
            'color_sets' => 'Color Sets',
            'memes' => 'Memes',
            'objections' => 'Objections',
            'test' => 'Test',
            'helper' => '<span class="glyphicon glyphicon-question-sign" title="Help"></span>',
            //'forms' => 'Forms',
            //'tables' => 'Tables',
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
                
        // All tables:
        const MYSQL_TABLES = array(
            
            // Creating projects table:
            "pm_projects" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "parentId" => "INT( 11 ) DEFAULT '0'",
                "title" => "VARCHAR( 500 ) NOT NULL",
                "customer" => "VARCHAR( 500 ) NULL",
                "skype" => "VARCHAR( 100 ) NULL",
                "phone1" => "VARCHAR( 100 ) NULL",
                "phone2" => "VARCHAR( 100 ) NULL",
                "phone3" => "VARCHAR( 100 ) NULL",
                "email1" => "VARCHAR( 100 ) NULL",
                "email2" => "VARCHAR( 100 ) NULL",
                "vk" => "VARCHAR( 100 ) NULL",
                "fb" => "VARCHAR( 100 ) NULL",
                "price" => "INT( 11 ) DEFAULT '0'",
                "currency" => "INT( 1 ) DEFAULT '0'", // 0 - usd, 1 - rub, 2 - uah
                "workBegin" => "INT( 11 ) NULL",
                "workEnd" => "INT( 11 ) NULL",
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
                "parentId" => "INT( 11 ) DEFAULT '0'", // 0 - theme
                "objection" => "TEXT NULL",
                "answerRu" => "TEXT NULL",
                "answerUkr" => "TEXT NULL",
                "moderation" => "INT( 1 ) DEFAULT '0'" // 1 - good, 2 - bad, 3 - deleted
            ), 
            
            
            // Creating font table:
            "pm_fonts" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "fontFamily" => "VARCHAR( 100 ) DEFAULT NULL", // Arial
                "fontStyle" => "VARCHAR( 20 ) DEFAULT NULL", // normal, italic, oblique
                "fontVariant" => "VARCHAR( 20 ) DEFAULT NULL", // smallerCase, upperCase
                "fontWeight" => "VARCHAR( 20 ) DEFAULT NULL", // normal, bold, what else?
                "cyrillic" => "INT( 1 ) DEFAULT NULL",
                "latin" => "INT( 1 ) DEFAULT NULL",
                "fileName" => "VARCHAR( 100 ) NOT NULL", // Arial.ttf
                "fileType" => "VARCHAR( 5 ) NOT NULL", // ttf
                "myFavourite" => "INT( 1 ) DEFAULT '0'", // 1 - yes,
                "mono" => "INT( 1 ) DEFAULT '0'", // for code, terminal, numbers
                "sans" => "INT( 1 ) DEFAULT '0'", // for headers
                "serif" => "INT( 1 ) DEFAULT '0'", // for easy reading text
                "moderation" => "INT( 1 ) DEFAULT '0'" // 1 - good, 2 - bad, 3 - deleted
            ),
/*  
Основные характеристики шрифтов
         
начертание: прямой, курсивный;
насыщенность: светлый, полужирный, жирный (отношение толщины штриха к ширине внутрибуквенного просвета);
ширина: нормальный, узкий, широкий, шрифт фиксированной ширины;
размер (кегль) в пунктах (1 пункт = 1/72 дюйма);
чёткость (чёткий, размытый);
контраст;
различимость;
удобочитаемость;
ёмкость: (убористый, объёмистый).
Кегль — параметр шрифта, означающий высоту его литер. Кегль включает в себя высоту строчной буквы с самым длинным выносным элементом и пробельное расстояние снизу неё. Величина кегля определяется числом пунктов. Самые распространённые кегли для текстовых шрифтов — 6, 7, 8, 10, 11, 12. Шрифты 4 и 5 кеглей употребляются очень редко.

Художественный облик шрифтов

Декоративный.
Динамичный.
Изящный. Римский капитальный, антиква, академические шрифты. Используются для литературных и искусствоведческих текстов, оформления архитектурных проектов, написания текстов на мемориальных досках.
Курсив. Применяется для написания текстов почётных грамот, поздравительных адресов, поздравлений и приглашений.
Монументальный. Рубленый плакатный, брусковый шрифт и гротеск. Применяется для написания лозунгов, плакатов, транспарантов.
Свободный.
Строгий. Применяется на диаграммах, схемах, графиках, технических и производственных плакатах, указателях.
Фольклорный (украинский, арабский и т. д.).

Начертания шрифтов

Прямой (римский, Roman) — произошёл от надписей на римских памятниках.
Курсивный (Italic) — базируется на рукописном письме, которое использовалось в южноевропейских манускриптах, в частности написанных в XV веке в Италии.
Полужирный (Bold) — отличается от прямого большей толщиной штриха.
Нормальный (Regular) — отличается от прямого меньшей толщиной штриха.
Узкий (Narrow) — суженный вариант прямого шрифта.
Широкий (Wide) — более широкий вариант прямого начертания[1].
*/           
            
            // Creating all colors table:
            "pm_colors" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "color" => "VARCHAR( 10 ) NOT NULL",
                "name" => "VARCHAR( 10 ) NOT NULL",
                "rainbow" => "INT( 1 ) DEFAULT '0'", // 1-7
                "tone" => "INT( 1 ) DEFAULT '0'", // 0 - light, 1 - dark
                "saturation" => "INT( 1 ) DEFAULT '0'", // 1 - saturated, 2 - muted
                "moderation" => "INT( 1 ) DEFAULT '0'" // 1 - good, 2 - bad, 3 - deleted
            ), 

            // Creating association category:
            "pm_association" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "association" => "VARCHAR( 100 ) NOT NULL",
                "moderation" => "INT( 1 ) DEFAULT '0'" // 1 - good, 2 - bad, 3 - deleted
            ),

            // Creating association pairs:
            "pm_colorAssociation" => array ( 
                "colorID" => "INT( 11 ) DEFAULT '0'",
                "associationID" => "INT( 11 ) DEFAULT '0'"
            ),
            
            // Creating color sets:
            "pm_colorSets" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "backgroundColor" => "VARCHAR( 10 ) NOT NULL", // ex. #000000
                "textColor" => "VARCHAR( 10 ) NOT NULL", // ex. #000000
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
            
            // Creating exp:
            "pm_experience" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "newExp" => "INT( 11 ) DEFAULT '0'",
                "allExp" => "INT( 11 ) DEFAULT '0'",
                "time" => "INT( 11 ) DEFAULT '0'"
            ),

            // Creating memes:
            "pm_memes" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "name" => "VARCHAR( 200 ) NULL",
                "style" => "TEXT NULL", // json
                "time" => "INT( 11 ) DEFAULT '0'",
                "moderation" => "INT( 1 ) DEFAULT '0'" // 1 - good, 2 - bad, 3 - deleted
            ),
            
            // Creating elementsBuffer:
            "pm_elementsBuffer" => array ( 
                "ID" => "INT( 11 ) AUTO_INCREMENT PRIMARY KEY",
                "projectID" => "INT( 11 ) DEFAULT '0'",
                "elementID" => "INT( 11 ) DEFAULT '0'",
                "myNote" => "TEXT NULL",
                "time" => "INT( 11 ) DEFAULT '0'",
                "moderation" => "INT( 1 ) DEFAULT '0'" // 1 - good, 2 - bad, 3 - deleted
            ),            
            
        );

        const ELEMENTS = array(
            2 => 'div',
            3 => 'button',
            4 => 'image'
        );
        
        const OTHER = array(
            'text',
            'fish',
                
        );
        
        const STYLE = array(
            'background' => array(
                'type' => 'string',
                'values' => array('')
            ),
            'background-image' => array(
                'type' => 'string',
                'values' => array('url("?") no-repeat|repeat center|left|right')
            ),
            'background-color' => array(
                'type' => 'string',
                'values' => array('#')
            ),
            'border' => array(
                'type' => 'string',
                'values' => array('?px solid|dotted|dashed #?') //
            ),            
            'color' => array(
                'type' => 'string',
                'values' => array('#')
            ),
            'display' => array(
                'type' => 'string',
                'values' => array('block','inline','inline-block','list-item','run-in','table','table-caption','table-cell','table-column','table-column-group','table-footer-group', 'table-header-group','table-row','table-row-group','none','initial','inherit')
            ),           
            'float' => array(
                'type' => 'string',
                'values' => array('left','right','none','initial','inherit')
            ),            
            'font-size' => array(
                'type' => 'int',
                'values' => array('px') // em,%
            ),
            'font-weight' => array(
                'type' => 'string',
                'values' => array('normal','bold','bolder','lighter')
            ),
            'font-style' => array(
                'type' => 'string',
                'values' => array('normal','italic','oblique','initial','inherit')
            ),
            'font-family' => array(
                'type' => 'string',
                'values' => array('')
            ),
            'padding' => array(
                'type' => 'int',
                'values' => array('px')
            ),
            'margin' => array(
                'type' => 'int',
                'values' => array('px')
            ),     
            'text-align' => array(
                'type' => 'string',
                'values' => array('left', 'right', 'justify', 'center')
            ),     
            'width' => array(
                'type' => 'int',
                'values' => array('px','%')
            ),     
            'height' => array(
                'type' => 'int',
                'values' => array('px','%')
            ), 
            'line-height' => array(
                'type' => 'int',
                'values' => array('%')
            ), 
            'text-align' => array(
                'type' => 'string',
                'values' => array(
                    'left',
                    'right',
                    'center',
                    'justify',
                    'initial',
                    'inherit'
                )
            ), 
            'text-decoration' => array(
                'type' => 'string',
                'values' => array(
                    'none',
                    'underline',
                    'overline',
                    'line-through',
                    'blink'
                )
            ),            
            'word-break' => array(
                'type' => 'string',
                'values' => array(
                    'normal',
                    'break-all',
                    'keep-all',
                    'initial',
                    'inherit'
                )
            ),
            'font-stretch' => array(
                'type' => 'string',
                'values' => array(
                    'inherit', 
                    'ultra-condensed', 
                    'extra-condensed', 
                    'condensed', 
                    'semi-condensed', 
                    'normal', 
                    'semi-expanded', 
                    'expanded', 
                    'extra-expanded', 
                    'ultra-expanded'
                )
            ),  
        );
        
        const STYLEVALUES = array(
            'font-size' => 'px',
            'padding' => 'px',
            'margin'  => 'px',
            'height'  => 'px',
            'width'  => 'px',
            'color'  => '#',
            'background'  => '#'
        );
        
        const LEVEL = array(
            1 => 0,
            2 => 68,
            3 => 363,
            4 => 1168,
            5 => 2884,
            6 => 6038,
            7 => 11287,
            8 => 19423,
            9 => 31378,
            10 => 48229,
            11 => 71202,
            12 => 101677,
            13 => 141193,
            14 => 191454,
            15 => 254330,
            16 => 331867,
            17 => 426288,
            18 => 540000,
            19 => 675596,
            20 => 835862,
            21 => 920357,
            22 => 1015431,
            23 => 1123336,
            24 => 1246808,
            25 => 1389235,
            26 => 1554904,
            27 => 1749413,
            28 => 1980499,
            29 => 2260321,
            30 => 2634751,
            31 => 2844287,
            32 => 3093068,
            33 => 3389496,
            34 => 3744042,
            35 => 4169902,
            36 => 4683988,
            37 => 5308556,
            38 => 6074376,
            39 => 7029248,
            40 => 8342182,
            41 => 8718976,
            42 => 12842357,
            43 => 14751932,
            44 => 17009030,
            45 => 19686117,
            46 => 22875008,
            47 => 26695470,
            48 => 31312332,
            49 => 36982854,
            50 => 44659561,
            51 => 48128727,
            52 => 52277875,
            53 => 57248635,
            54 => 63216221,
            55 => 70399827,
            56 => 79078300,
            57 => 89616178,
            58 => 102514871,
            59 => 118552044,
            60 => 140517709,
            61 => 153064754,
            62 => 168231664,
            63 => 186587702,
            64 => 208840245,
            65 => 235877658,
            66 => 268833561,
            67 => 309192920,
            68 => 358998712,
            69 => 421408669,
            70 => 493177635,
            71 => 555112374,
            72 => 630494192,
            73 => 722326994,
            74 => 834354722,
            75 => 971291524,
            76 => 1139165674,
            77 => 1345884863,
            78 => 1602331019,
            79 => 1902355477,
            80 => 2288742870
        );
        
        const EXPERIENCE = array(
            'LOAD' => array('min' => 10, 'max' => 30),
            'MAIN_REDIRECT' => array('min' => 20, 'max' => 100),
            'PAGE_REDIRECT' => array('min' => 40, 'max' => 120),
            'LONG_REDIRECT' => array('min' => 60, 'max' => 150),
            'UPDATE' => array('min' => 80, 'max' => 180),
            'INSERT' => array('min' => 100, 'max' => 240),
        );

        const ALLOWED_METHODS = array (
            'add_content_block' => 'addContentBlock',
            'increase_priority' => 'increasePriority',
            'decrease_priority' => 'decreasePriority',
            'add_new_element' => 'addNewElement',
            'add_leaves' => 'addLeaves',
            'delete_element' => 'deleteElement',
            'edit_element' => 'editElement',
            'add_other_option' => 'addOtherOption',
            'add_css_option' => 'addCssOption',
            'delete_other_option' => 'deleteOtherOption',
            'delete_css_option' => 'deleteCssOption',
            'fav_element' => 'favElement',
            'edit_body_style' => 'editBodyStyle',
            'delete_body_option' => 'deleteBodyOption',
            'edit_class_style' => 'editClassStyle',
            'delete_class_option' => 'deleteClassOption',
            'add_new_body_style' => 'addNewBodyStyle',
            'add_new_class_style' => 'addNewClassStyle',
            'change_parent' => 'changeParent',
            'current_tree_copy' => 'currentTreeCopy',
            
            'add_new_color' => array('colors' => 'addNewColor'),
            'delete_color' => array('colors' => 'deleteColor'),
            'add_new_color_set' => array('colors' => 'addNewColorSet'),
            'make_set_favourite' => array('colors' => 'makeSetFavourite'),
            'update_color_set' => array('colors' => 'updateColorSet'),
            'delete_color_set' => array('colors' => 'deleteColorSet'),
            
            'add_new_font' => array('fonts' => 'addNewFont'),
            'make_font_favourite' => array('fonts' => 'makeFontFavourite'),
            'make_font_favourite2' => array('fonts' => 'makeFontFavourite2'),
            'cyrillic_font' => array('fonts' => 'cyrillicFont'),
            'latin_font' => array('fonts' => 'latinFont'),
            'delete_font' => array('fonts' => 'deleteFont'),
            
            'add_new_project' => array('projects' => 'addNewProject'),
            'edit_project' => array('projects' => 'editProject'),
            'delete_project' => array('projects' => 'deleteProject'),
            'add_new_subproject' => array('projects' => 'addNewSubproject'),
            'edit_subproject' => array('projects' => 'editSubproject'),
            
            'add_new_objection_theme' => array('objections' => 'addNewObjectionTheme'),
            'delete_objection' => array('objections' => 'deleteObjection'),
            'delete_objection_theme' => array('objections' => 'deleteObjectionTheme'),
            'edit_objection' => array('objections' => 'editObjection'),
            'add_objection' => array('objections' => 'addObjection'),
            
            'get_json_style_config' => array('json' => 'getStyleConfig'),
            
            'meme_screenshot' => array('screenshot' => 'memeShot'),
            'meme_update' => 'memeUpdate',
            'meme_delete_block' => 'memeDeleteBlock',
            'add_css_to_meme' => 'addCssToMeme',
            'meme_add_style' => 'memeAddStyle',
            'meme_delete_block_style' => 'memeDeleteBlockStyle',
            'add_new_meme' => 'addNewMeme',
            'delete_meme' => 'deleteMeme',
            'meme_favourite' => 'memeFavourite',
            'delete_meme_png' => 'deleteMemePng',
            
            'copy_to_buffer' => 'copyToBuffer',
            'copy_from_buffer' => 'copyFromBuffer'
         );
        
         const FISH = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis volutpat fermentum augue a accumsan. Ut est sapien, malesuada eget convallis eu, mattis nec eros. Suspendisse suscipit vehicula augue, nec commodo mi interdum ac. Etiam id sem venenatis, hendrerit purus eu, auctor metus. Quisque lacinia nisi eu pellentesque pharetra. Phasellus malesuada id sapien ut sagittis. Nam eget dui nec dui tristique commodo at vitae nibh. In imperdiet odio ut lorem aliquam varius. Aenean facilisis tempus dui, et posuere sapien vulputate faucibus. Integer pharetra leo non leo aliquet, vitae ullamcorper dui rutrum. Duis vestibulum facilisis rhoncus. Nam ligula nunc, sagittis sed purus in, tincidunt finibus magna. Vivamus laoreet massa eu rhoncus tempus. Quisque tincidunt hendrerit metus sed vehicula. Sed iaculis mauris nec nunc suscipit hendrerit. Cras at scelerisque tellus, ut dignissim lorem.

            Suspendisse vestibulum nec tellus ultricies tristique. Sed bibendum ex arcu, ut efficitur sapien aliquet a. In nunc sapien, varius id diam sit amet, sagittis luctus nulla. Ut convallis nibh augue, id pellentesque diam convallis a. Integer ornare volutpat finibus. Pellentesque lacinia egestas faucibus. Nulla pulvinar sapien justo, vitae aliquam orci efficitur sit amet. In ut rutrum libero, vitae accumsan magna. Integer ultrices, enim sed fermentum sagittis, dui nisi semper mi, eu fringilla felis libero in elit. Nullam sit amet rhoncus leo. Vivamus egestas, elit quis luctus finibus, risus nibh pulvinar tortor, quis congue orci enim id justo. Nulla facilisi.

            Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris laoreet ipsum ac tortor venenatis feugiat. Phasellus vehicula risus eget justo dignissim rhoncus. Sed lacinia fringilla neque, sodales gravida arcu hendrerit sed. Praesent tempus enim magna, ullamcorper sodales turpis mattis vel. Nunc in finibus ipsum. Vestibulum id laoreet nibh, nec vulputate lectus. Curabitur velit sem, tristique a turpis ac, dignissim suscipit orci. Suspendisse eget tempus erat. Morbi aliquam nisi urna, id ornare velit accumsan nec. Aliquam nec magna nec dolor tincidunt bibendum et sed lorem. Pellentesque in cursus justo. Sed in justo sodales, viverra justo eu, tempus ante. Phasellus bibendum volutpat odio, sed imperdiet libero bibendum at.

            Aenean ultricies ante et neque aliquet, eget molestie libero tincidunt. Etiam nec venenatis turpis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Cras non tellus at velit euismod efficitur auctor eu leo. Suspendisse blandit turpis a ligula semper dictum. Vivamus finibus fringilla nibh quis euismod. Curabitur nec porta lacus. Ut sodales libero in ex ullamcorper consectetur eget vel nulla. Mauris hendrerit massa sagittis rutrum luctus. Donec ac vestibulum libero. Mauris nunc augue, porttitor ut porttitor sit amet, vestibulum at libero. Vivamus tempor bibendum ante sed venenatis. Donec non libero a ante tristique fringilla. Nam tincidunt urna vel ante eleifend consequat.

            Sed non tempor nunc, non viverra sem. Donec imperdiet nisi vitae erat cursus aliquet. Quisque euismod feugiat nunc eget egestas. Sed sagittis dapibus accumsan. Proin malesuada elementum metus placerat tempus. Cras mi ante, tempus vel leo id, lobortis sollicitudin eros. Donec fermentum tortor dui, sed tempor metus tempor vel.';
            
        const safeFonts = array(
            90001 => 'Arial', 
            90002 => 'Helvetica', 
            90003 => 'Arial Black',
            90004 => 'Courier New', 
            90005 => 'Impact', 
            90006 => 'Lucida Sans Unicode',
            90007 => 'Palatino Linotype', 
            90008 => 'Times New Roman', 
            90009 => 'Verdana', 
            90010 => 'Trebuchet MS'
        );
        
        const COLOR_GROUPS = array(
            'Сині',
            'Жовті',
            'Чорні'
        );
       
    }
