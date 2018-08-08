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

<div class="navbar <?php echo $navbarType[array_rand($navbarType)].' '.$navbarWhere[array_rand($navbarWhere)]; ?>">
	<div class="container-fluid">
    	<div class="navbar-header">
            <?php echo $logo; ?>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#<?php echo $navbarID; ?>">
				<span class="sr-only">XXX</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
        </div>
		<div class="collapse navbar-collapse" id="<?php echo $navbarID; ?>">
			<ul class="nav navbar-nav"> 
                <?php
                    for ($i = 0; $i < 5; $i++) {
                        echo '<li><a href="#" class="headerlink">Name '.$i.'</a></li>';
                    }
                ?>
			</ul>
		</div>
	</div>
</div>



