<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php wp_title('|', true, 'left'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="container">
	
    <div id="search-box-wrap">
        <div id="search-box">
           <div id="close-x"><?php _e( 'x', 'magazino' ); ?></div>
           <?php get_search_form(); ?>
        </div>
    </div>

	<header id="branding" role="banner">
      <div id="inner-header" class="clearfix">
		<hgroup id="site-heading">
        	<?php if ( get_theme_mod( 'magazino_logo' ) ) : ?>
            <div id="site-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_theme_mod( 'magazino_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a></div>
            <?php else : ?>
			<div id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
            <?php endif; ?>
		</hgroup>
        
        <div id="social-media" class="clearfix">
        
        	<?php if ( get_theme_mod( 'magazino_facebook' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_facebook' ) ); ?>" class="social-fb" title="<?php echo esc_url( get_theme_mod( 'magazino_facebook' ) ); ?>"><?php _e('Facebook', 'magazino') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'magazino_twitter' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_twitter' ) ); ?>" class="social-tw" title="<?php echo esc_url( get_theme_mod( 'magazino_twitter' ) ); ?>"><?php _e('Twitter', 'magazino') ?></a>
            <?php endif; ?>
			
            <?php if ( get_theme_mod( 'magazino_google' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_google' ) ); ?>" class="social-gp" title="<?php echo esc_url( get_theme_mod( 'magazino_google' ) ); ?>"><?php _e('Google+', 'magazino') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'magazino_pinterest' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_pinterest' ) ); ?>" class="social-pi" title="<?php echo esc_url( get_theme_mod( 'magazino_pinterest' ) ); ?>"><?php _e('Pinterest', 'magazino') ?></a>
            <?php endif; ?>
            
            <?php if ( get_theme_mod( 'magazino_linkedin' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_linkedin' ) ); ?>" class="social-li" title="<?php echo esc_url( get_theme_mod( 'magazino_linkedin' ) ); ?>"><?php _e('Linkedin', 'magazino') ?></a>
            <?php endif; ?>
            
			<?php if ( get_theme_mod( 'magazino_youtube' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'magazino_youtube' ) ); ?>" class="social-yt" title="<?php echo esc_url( get_theme_mod( 'magazino_youtube' ) ); ?>"><?php _e('Youtube', 'magazino') ?></a>
            <?php endif; ?>
            
            <div id="search-icon"></div>
            
            
        </div>
        
        </div>

		<nav id="access" class="clearfix" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Main menu', 'magazino' ); ?></h1>
			<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'magazino' ); ?>"><?php _e( 'Skip to content', 'magazino' ); ?></a></div>
			<?php magazino_main_nav(); // Adjust using Menus in Wordpress Admin ?>
			<?php //get_search_form(); ?>
		</nav><!-- #access -->
        

      

	</header><!-- #branding -->
