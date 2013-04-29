<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $this->getMeta('title'); ?></title>	
		<meta name="keywords" content="<?php echo $this->getMeta('keywords'); ?>">
        <meta name="description" content="<?php echo $this->getMeta('description'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet/less" type="text/css" href="<?php echo $this->urlHome(); ?>css/main.less">
        <script src="<?php echo $this->urlHome(); ?>js/vendor/less-1.3.3.min.js"></script>
        <script src="<?php echo $this->urlHome(); ?>js/vendor/modernizr.custom.73218.js"></script>
    </head>
    <body data-url-base="<?php echo $this->urlHome(); ?>">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div class="wrap">
            <a class="logo" href="<?php echo $this->urlHome(); ?>">
                <img src="<?php echo $this->urlHome(); ?>img/main/logov2.png" alt="<?php echo $this->get('model_mainoption', 'site_title'); ?> Logo">
                <span class="full-text"><?php echo $this->get('model_mainoption', 'site_title'); ?></span>
                <abbr title="<?php echo $this->get('model_mainoption', 'site_title'); ?>">ELTTL</abbr>
            </a>


            <header class="main">
                
                <div class="search">
                    <form>
                        <input type="text" name="search" type="search" maxlength="999" placeholder="Search">
                        <section></section>
                    </form> 
                </div>
                <nav class="sub">
                    <ul>
                        <li><a href="<?php echo $this->urlHome(); ?>coaching/">Coaching</a></li>
                        <li><a href="<?php echo $this->urlHome(); ?>schools/">Schools</a></li>
                        <li><a href="<?php echo $this->urlHome(); ?>town-teams/">Town Teams</a></li>
                        <li><a href="<?php echo $this->urlHome(); ?>summer-league/">Summer League</a></li>
                        <li><a href="<?php echo $this->urlHome(); ?>local-clubs/">Local Clubs</a></li>
                    </ul>
                </nav>   
                <nav class="main">
                    <ul>
                        <li><a href="<?php echo $this->urlHome(); ?>">Home</a></li>
                        <li>
                            <div>
                                <span></span>
                                <a href="#">Tables and Results</a>
                                    
<?php if ($this->get('model_mainmenu', 'division')): ?>

                                <ul>

    <?php foreach ($this->get('model_mainmenu', 'division') as $division): ?>

                                <li>
                                    <div>
                                        <span></span>
                                        <a href="<?php echo $this->get($division, 'url') ?>"><?php echo $this->get($division, 'name') ?></a>
                                        <ul>
                                            <li><a href="<?php echo $this->get($division, 'url') ?>">Overview</a></li>
                                            <li><a href="<?php echo $this->get($division, 'url') ?>merit/">Merit Table</a></li>
                                            <li><a href="<?php echo $this->get($division, 'url') ?>league/">League Table</a></li>
                                            <li><a href="<?php echo $this->get($division, 'url') ?>fixture/">Fixtures</a></li>
                                        </ul>
                                    </div>
                                </li>
        
    <?php endforeach ?>

                                </ul>

<?php endif ?>
                                
                            </div>
                        </li>
                        <li>
                            <div>
                                <span></span>
                                <a href="#">The League</a>
                                <ul>
                                    <li><a href="#">Handbook</a></li>
                                    <li><a href="#">Handbook</a></li>
                                    <li><a href="#">Handbook</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="<?php echo $this->urlHome(); ?>player/performance/">Player Performance</a></li>
                        <li><a href="<?php echo $this->urlHome(); ?>post/">Press Releases</a></li>
                        <li><a href="<?php echo $this->urlHome(); ?>page/10/competitions/">Competitions</a></li>
                        <li><a href="#">Contact us</a></li>
                    </ul>
                </nav>             
                <div class="clearfix"></div>
            </header>