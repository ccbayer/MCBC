<?php
//	require('lib/facebook-php-sdk-master/src/facebook.php');
//	require('lib/index.php');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	  <meta charset="<?php bloginfo( 'charset' ); ?>" />
	  <!-- OPEN GRAPH meta data -->
	  <meta property="og:title" content="<?php
	  	  $title =  get_field('page_title');
	  if($title) {
		  echo $title;
	  } else {
	      if( ! is_home() ):
	        wp_title( '|', true, 'right' );
	      endif;
	      bloginfo( 'name' );
	  }
	    ?>">
	<meta property="og:site_name" content="Marin County Bicycle Coalition"/>
	<meta property="og:url" content="<?php echo $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ?>"/>
	<meta property="og:description" content="<?php the_field('meta_description'); ?>">
	<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/mcbc-logo.gif"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="<?php the_field('meta_keywords'); ?>"/>
	<meta name="description" content="<?php the_field('meta_description'); ?>"/>
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/ico/favicon.ico">
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/ico/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/ico/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/ico/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/ico/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/ico/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/ico/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/ico/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/ico/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/ico/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo get_template_directory_uri(); ?>/ico/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/ico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/ico/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/ico/favicon-16x16.png">
	<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/ico/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/ico/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<title>
    <?php
	  $title =  get_field('page_title');
	  if($title) {
		  echo $title;
	  } else {
	      if( ! is_home() ):
	        wp_title( '|', true, 'right' );
	      endif;
	      bloginfo( 'name' );
	  }
    ?>
  </title>
<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Arvo::latin', 'Raleway:400,700:latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>
  <?php wp_head(); ?>
	<?php
	$cats = get_field('display_event_category');
	if(!empty($cats)):
		$events = tribe_get_events( array(
			'posts_per_page' => -1,
			'start_date' => current_time( 'Y-m-d' ),
			) );
	$GLOBALS['events'] = get_events_in_cat($events, $cats);
	endif;
	if(get_field('show_events') && !empty($GLOBALS['events'])):
?>
	<link rel='stylesheet' id='tribe-events-calendar-style-css'  href='/wp-content/plugins/the-events-calendar/src/resources/css/tribe-events-full.min.css?ver=4.0.4' type='text/css' media='all' />
<?php
	endif;
?>
<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" />
</head>

<body <?php body_class(); ?>>
<div class="body-wrapper">

	<header>
		<div id="mobile-nav-target"></div>
		<div id="meanMenu"><span class="hidden-md hidden-lg logo-text-mobile">Marin County Bicycle Coalition</span></div>
		<div class="container-xl">
			<div class="row-fluid hide-more-than-1000">
					<div class="text-center logo-wrapper">
						<a href="<?php echo home_url(); ?>">
							<img src="<?php echo get_template_directory_uri(); ?>/images/mcbc-logo.gif" alt="The Marin County Bicycle Commission" class="logo-img mcbc-visible-inline-above-sm">
						</a>
					</div>
				</div>
			</div>
			<div class="row navigation-wrapper">
				<div class="logo col-lg-2 col-md-2 col-sm-3 col-xs-12 hide-less-than-1000">
					<a href="<?php echo home_url(); ?>">
						<?php // svg logo - toddmotto.com/mastering-svg-use-for-a-retina-web-fallbacks-with-png-script ?>
						<img src="<?php echo get_template_directory_uri(); ?>/images/mcbc-logo.gif" alt="The Marin County Bicycle Commission" class="logo-img">
					</a>
				</div>
				<nav class="nav navbar col-lg-8 col-md-8 col-sm-12 col-xs-12" role="navigation" id="main-nav">
					<?php
						wp_nav_menu( array(
							'menu' => 'header',
							'depth' => 0,
							'container' => false,
							'menu_class' => 'false',
							//Process nav menu using our custom nav walker
							'walker' => new wp_bootstrap_navwalker())
						);
					?>

        <!-- Collect the nav links, forms, and other content for toggling -->
				</nav>
				<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
					<?php get_template_part('modules/links', 'socialmedia-header'); ?>
				</div>
			</div>
		</div>
	</header>
	<div class="inner-body-wrapper">
