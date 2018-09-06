<?php 
        
    // Setup:
    class mysqlTables
    {    
               
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
       
    }
    
