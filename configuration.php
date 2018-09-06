<?php 
        
    require_once 'configurations/mysql_tables.php';
    require_once 'configurations/menu_links.php';
    require_once 'configurations/other.php';
    
    // Setup:
    class configuration
    {    
                
        const VER = 2.5;
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
        
        const CURRENCY = array('$','₽','₴',);
        
        const WORDPRESS_PAGES = array(
                '404','footer','page','single','index','header'
              );
        
        # Меню:
        const ALL_PAGES = menuLinks::ALL_PAGES;
        const SUB_PAGES = menuLinks::SUB_PAGES;
                
        # Таблиці бази даних:
        const MYSQL_TABLES = mysqlTables::MYSQL_TABLES;

        const ELEMENTS = array(
            2 => 'div',
            5 => 'span',
            10 => 'p',
            20 => 'blockquote',
            30 => 'button',
            100 => 'h1',
            101 => 'h2',
            102 => 'h3',
            103 => 'h4',
            104 => 'h5',
            105 => 'h6',
            130 => 'sup',
            131 => 'sub',
            150 => 'header',
            160 => 'footer',
            170 => 'aside',
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
            'background-size' => array(
                'type' => 'string',
                'values' => array(
                    'cover',
                    'contain',
                    'auto'
                )
            ),
            'background-position' => array(
                'type' => 'string',
                'values' => array(
                    'top left',
                    'top',
                    'right top',
                    'left',
                    'center',
                    'right',
                    'bottom left',
                    'bottom right'
                )
            ),     
            'background-repeat' => array(
                'type' => 'string',
                'values' => array(
                    'no-repeat',
                    'repeat',
                    'repeat-x',
                    'repeat-y',
                    'inherit'
                )
            ),
            'background-color' => array(
                'type' => 'string',
                'values' => array('#')
            ),
            'border' => array(
                'type' => 'string',
                'values' => array('?px solid|dotted|dashed #?') //
            ),
            'border-bottom' => array(
                'type' => 'string',
                'values' => array('?px solid|dotted|dashed #?') //
            ),
            'border-top' => array(
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
            )
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
        
        const LEVEL = other::LEVEL;
        
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
            'duplicate_project' => array('projects' => 'duplicateProject'),
            
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
        
        const FISH = other::FISH;
            
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
    
