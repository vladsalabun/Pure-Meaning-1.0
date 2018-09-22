<div class="row">
	<div class="col-lg-12">
    <?php 

    $css = 'text-align';
    $lastValue = 'right';
    
        // інформаційні елементи, які утворюють сайт як рекламний носій:
        $website = array(
            // поверх: (этаж)
            'header' => array('navbar'),
            'body' => array('breadcrumb','pagination'),
            'footer' => array(
                'contacts' => array(
                    'email','phone','address','skype','vk','facebook','instagram'
                )
            ),
            // спільне для всіх:
            'common' => array(
                'link',
                'h1','h2','h3','h4',
                'table'
            )
        );
        
        // що являється управляючим елементом? а що не являється?
        
/*
        $a = configuration::STYLE;
        ksort($a);
        echo '<pre>';
        print_r($a);
*/
        
        // які властивості елементів?
        // яке призначення елементів?
        // які ф-ї елементів, що вони вміють і чого не вміють?
        // в чому смисл елементів?
        // як генерувати, обробляти, зберігати елементи сайту?
        
    /*
        Копіювання блоку і його вмісту:
        
        1) Вказую блок для копіювання
        2) Вказую блок у який вставити
        3) Збираю дерево блоку
        4) Вставляю в базу даних з новими ІД (класи з старого дерева)
  
    */

    
    //  http://getcolor.ru/#731111
    //  https://colorscheme.ru/
    //  http://color.romanuke.com/ - отут кул!
    
    $colorSymbol = array(
            'ЖЕЛТЫЙ' => array(
                    'цель' => 'Для привлечения внимания посетителей',
                    'асоциации' => 'оптимистичность, юность'
            ),
            'ОРАНЖЕВЫЙ' => array(
                    'цель' => 'Для призыва к действию и привлечения внимания',
                    'асоциации' => 'агрессивность'
            ),    
            'КРАСНЫЙ' => array(
                    'цель' => 'Для распродаж и продаж продуктов питания',
                    'асоциации' => 'энергия'
            ),
            'РОЗОВЫЙ' => array(
                    'цель' => 'Для женщин и молодых девушек',
                    'асоциации' => 'романтичность,женственность'
            ),
            'СИНИЙ' => array(
                    'цель' => 'Для банковской отрасли и бизнеса',
                    'асоциации' => 'доверия,безопасности'
            ),
            'СИНИЙ' => array(
                    'цель' => 'Для банковской отрасли и бизнеса',
                    'асоциации' => 'доверия,безопасности'
            ),
            'ФИОЛЕТОВЫЙ' => array(
                    'цель' => 'Для косметических и антивозрастных продуктов и услуг',
                    'асоциации' => 'успокоение,спокойствие'
            ),
            'ЗЕЛЕНЫЙ' => array(
                    'цель' => 'Для области финансов',
                    'асоциации' => 'благосостояние'
            ),
            'ЧЕРНЫЙ' => array(
                    'цель' => 'Как роскошный и изощренный',
                    'асоциации' => 'убедительность, влияние, сила, лоск.'
            )
        );

?>
    </div>
</div>
<?php
    
    $badge = '<button class="btn btn-primary" type="button">Messages <span class="badge">4</span> </button>';
    
    $labels = array(
        '<span class="label label-default">Default</span>',
        '<span class="label label-primary">Primary</span>',
        '<span class="label label-success">Success</span>',
        '<span class="label label-info">Info</span>',
        '<span class="label label-warning">Warning</span>',
        '<span class="label label-danger">Danger</span>'
    );
    
    $alerts = array(
        '<div class="alert alert-success" role="alert">...</div>',
        '<div class="alert alert-info" role="alert">...</div>',
        '<div class="alert alert-warning" role="alert">...</div>',
        '<div class="alert alert-danger" role="alert">...</div>'
    );
    
    $breadcrumb = '<ol class="breadcrumb">
      <li><a href="#">Home</a></li>
      <li><a href="#">Library</a></li>
      <li class="active">Data</li>
    </ol>';
    
    $listGroup = '<ul class="list-group">
  <li class="list-group-item">Cras justo odio</li>
  <li class="list-group-item">Dapibus ac facilisis in</li>
  <li class="list-group-item">Morbi leo risus</li>
  <li class="list-group-item">Porta ac consectetur ac</li>
  <li class="list-group-item">Vestibulum at eros</li>
</ul>';
    
    $panel = '<div class="panel panel-default">
  <div class="panel-body">
    Panel content
  </div>
  <div class="panel-footer">Panel footer</div>
</div>';
    
    
    $navbarType = array('navbar-inverse','navbar-default');
    $navbarWhere = array('navbar-static-top','navbar-fixed-top','navbar-fixed-bottom');
    $navbarID = 'responsive-menu';
    
    $logo = '<a class="navbar-brand" href="#">
        <img alt="Brand" style="width:20px" src="https://images.all-free-download.com/images/graphicthumb/prey_logo_1_96164.jpg">
      </a>';

    $navbarText =  '<p class="navbar-text">Signed in as Mark Otto</p>';
    $navbarRight = '<p class="navbar-text navbar-right">Signed in as <a href="#" class="navbar-link">Mark Otto</a></p>';
    $navbarBtn =  '<button type="button" class="btn btn-default navbar-btn">Sign in</button>';
    
    $navbarForm = '<form class="navbar-form navbar-left" role="search">
  <div class="form-group">
    <input type="text" class="form-control" placeholder="Search">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>';
?>

<!--- FORM ---><form method="post" action="" autocomplete="off"><input type="hidden" name="action" value="add_css_option"><input type="hidden" name="id" value="392"><p>
    
    <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 ">
    <div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="0" id="0">
                  <label class="form-check-label" for="0">
                    background
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="1" id="1">
                  <label class="form-check-label" for="1">
                    background-image
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="2" id="2">
                  <label class="form-check-label" for="2">
                    background-size
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="3" id="3">
                  <label class="form-check-label" for="3">
                    background-position
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="4" id="4">
                  <label class="form-check-label" for="4">
                    background-repeat
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="5" id="5">
                  <label class="form-check-label" for="5">
                    background-color
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="6" id="6">
                  <label class="form-check-label" for="6">
                    border
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="7" id="7">
                  <label class="form-check-label" for="7">
                    border-bottom
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="8" id="8">
                  <label class="form-check-label" for="8">
                    border-top
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="9" id="9">
                  <label class="form-check-label" for="9">
                    color
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="10" id="10">
                  <label class="form-check-label" for="10">
                    display
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="11" id="11">
                  <label class="form-check-label" for="11">
                    float
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="12" id="12">
                  <label class="form-check-label" for="12">
                    font-size
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="13" id="13">
                  <label class="form-check-label" for="13">
                    font-weight
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="14" id="14">
                  <label class="form-check-label" for="14">
                    font-style
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="15" id="15">
                  <label class="form-check-label" for="15">
                    font-family
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="16" id="16">
                  <label class="form-check-label" for="16">
                    padding
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="17" id="17">
                  <label class="form-check-label" for="17">
                    margin
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="18" id="18">
                  <label class="form-check-label" for="18">
                    text-align
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="19" id="19">
                  <label class="form-check-label" for="19">
                    width
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="20" id="20">
                  <label class="form-check-label" for="20">
                    height
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="21" id="21">
                  <label class="form-check-label" for="21">
                    line-height
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="22" id="22">
                  <label class="form-check-label" for="22">
                    text-decoration
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="23" id="23">
                  <label class="form-check-label" for="23">
                    word-break
                  </label>
                </div><div class="form-check style_list_in_modal">
                  <input class="form-check-input" type="checkbox" name="checkbox[]" value="24" id="24">
                  <label class="form-check-label" for="24">
                    font-stretch
                  </label>
                </div>
    
    </div>
    
    </p>
    </div>
    <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 "><input type="submit" name="submit" value="Додати" class="btn btn-success"></div></form><!--- /FORM --->
    </div>



