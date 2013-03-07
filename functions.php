<?php
/**
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 */


if ( ! function_exists( 'magazino_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function magazino_setup() {
		
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'magazino', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'magazino' ),
	) );

	add_theme_support('post-thumbnails'); 
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	
	
	// custom backgrounds
	$magazino_custom_background = array(
		'default-color' => 'e5e5e5',
		'default-image' => '',
		'wp-head-callback' => '_custom_background_cb'
	);
	add_theme_support('custom-background', $magazino_custom_background );
	
	
	// adding post format support
	add_theme_support( 'post-formats', 
		array( 
			'aside', /* Typically styled without a title. Similar to a Facebook note update */
			'gallery', /* A gallery of images. Post will likely contain a gallery shortcode and will have image attachments */
			'link', /* A link to another site. Themes may wish to use the first <a href=ÓÓ> tag in the post content as the external link for that post. An alternative approach could be if the post consists only of a URL, then that will be the URL and the title (post_title) will be the name attached to the anchor for it */
			'image', /* A single image. The first <img /> tag in the post could be considered the image. Alternatively, if the post consists only of a URL, that will be the image URL and the title of the post (post_title) will be the title attribute for the image */
			'quote', /* A quotation. Probably will contain a blockquote holding the quote content. Alternatively, the quote may be just the content, with the source/author being the title */
			'status', /*A short status update, similar to a Twitter status update */
			'video', /* A single video. The first <video /> tag or object/embed in the post content could be considered the video. Alternatively, if the post consists only of a URL, that will be the video URL. May also contain the video as an attachment to the post, if video support is enabled on the blog (like via a plugin) */
			'audio', /* An audio file. Could be used for Podcasting */
			'chat' /* A chat transcript */
		)
	);
}
endif;
add_action( 'after_setup_theme', 'magazino_setup' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
function magazino_content_width() {
	global $content_width;
	if (!isset($content_width))
		$content_width = 550; /* pixels */
}
add_action( 'after_setup_theme', 'magazino_content_width' );


/**
 * Title filter 
 */
function magazino_filter_wp_title( $old_title, $sep, $sep_location ) {

	$site_name = get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description' );
	// add padding to the sep
	$ssep = ' ' . $sep . ' ';
	
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		return $site_name . ' | ' . $site_description;
	} else {
		// find the type of index page this is
		if( is_category() ) $insert = $ssep . __( 'Category', 'magazino' );
		elseif( is_tag() ) $insert = $ssep . __( 'Tag', 'magazino' );
		elseif( is_author() ) $insert = $ssep . __( 'Author', 'magazino' );
		elseif( is_year() || is_month() || is_day() ) $insert = $ssep . __( 'Archives', 'magazino' );
		else $insert = NULL;
		 
		// get the page number we're on (index)
		if( get_query_var( 'paged' ) )
		$num = $ssep . __( 'Page ', 'magazino' ) . get_query_var( 'paged' );
		 
		// get the page number we're on (multipage post)
		elseif( get_query_var( 'page' ) )
		$num = $ssep . __( 'Page ', 'magazino' ) . get_query_var( 'page' );
		 
		// else
		else $num = NULL;
		 
		// concoct and return new title
		return $site_name . $insert . $old_title . $num;
		
	}

}

// call our custom wp_title filter, with normal (10) priority, and 3 args
add_filter( 'wp_title', 'magazino_filter_wp_title', 10, 3 );


/*******************************************************************
* These are settings for the Theme Customizer in the admin panel. 
*******************************************************************/
function magazino_theme_customizer( $wp_customize ) {
	
	$wp_customize->remove_section( 'title_tagline');
	$wp_customize->remove_section( 'static_front_page' );


	/* color scheme option */
	$wp_customize->add_setting( 'magazino_color_settings', array (
		'default'	=> '#9dbb41',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'magazino_color_settings', array(
		'label'    => __( 'Theme Color Scheme', 'magazino' ),
		'section'  => 'colors',
		'settings' => 'magazino_color_settings',
	) ) );
	
	
	/* logo option */
	$wp_customize->add_section( 'magazino_logo_section' , array(
		'title'       => __( 'Site Logo', 'magazino' ),
		'priority'    => 31,
		'description' => __( 'Upload a logo to replace the default site name in the header', 'magazino' ),
	) );
	
	$wp_customize->add_setting( 'magazino_logo' );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'magazino_logo', array(
		'label'    => __( 'Choose your logo (ideal width is 100-300px and ideal height is 40-100px)', 'restaurateur' ),
		'section'  => 'magazino_logo_section',
		'settings' => 'magazino_logo',
	) ) );

	
	/* social media option */
	$wp_customize->add_section( 'magazino_social_section' , array(
		'title'       => __( 'Social Media Icons', 'magazino' ),
		'priority'    => 32,
		'description' => __( 'Optional facebook icon in the navigation bar', 'magazino' ),
	) );
	
	$wp_customize->add_setting( 'magazino_facebook' );
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'magazino_facebook', array(
		'label'    => __( 'Enter your facebook url', 'magazino' ),
		'section'  => 'magazino_social_section',
		'settings' => 'magazino_facebook',
	) ) );

	$wp_customize->add_setting( 'magazino_twitter' );
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'magazino_twitter', array(
		'label'    => __( 'Enter your twitter url', 'magazino' ),
		'section'  => 'magazino_social_section',
		'settings' => 'magazino_twitter',
	) ) );
	
	$wp_customize->add_setting( 'magazino_google' );
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'magazino_google', array(
		'label'    => __( 'Enter your google+ url', 'magazino' ),
		'section'  => 'magazino_social_section',
		'settings' => 'magazino_google',
	) ) );
	
	$wp_customize->add_setting( 'magazino_pinterest' );
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'magazino_pinterest', array(
		'label'    => __( 'Enter your pinterest url', 'magazino' ),
		'section'  => 'magazino_social_section',
		'settings' => 'magazino_pinterest',
	) ) );
	
	$wp_customize->add_setting( 'magazino_linkedin' );
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'magazino_linkedin', array(
		'label'    => __( 'Enter your linkedin url', 'magazino' ),
		'section'  => 'magazino_social_section',
		'settings' => 'magazino_linkedin',
	) ) );
	
	$wp_customize->add_setting( 'magazino_youtube' );
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'magazino_youtube', array(
		'label'    => __( 'Enter your youtube url', 'magazino' ),
		'section'  => 'magazino_social_section',
		'settings' => 'magazino_youtube',
	) ) );
	
	/* slider options */
	
	$wp_customize->add_section( 'magazino_slider_section' , array(
		'title'       => __( 'Slider Options', 'magazino' ),
		'priority'    => 33,
		'description' => __( 'Adjust the behavior of the image slider.', 'magazino' ),
	) );
	
	$wp_customize->add_setting( 'magazino_slider_effect', array(
		'default' => 'scrollHorz',
		'capability' => 'edit_theme_options',
	));
	
	 $wp_customize->add_control( 'effect_select_box', array(
		'settings' => 'magazino_slider_effect',
		'label' => __( 'Select Effect:', 'magazino' ),
		'section' => 'magazino_slider_section',
		'type' => 'select',
		'choices' => array(
			'scrollHorz' => 'Horizontal (Default)',
			'scrollVert' => 'Vertical',
			'tileSlide' => 'Tile Slide',
			'tileBlind' => 'Blinds',
		),
	));
	
	$wp_customize->add_setting( 'magazino_slider_timeout' );
	
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'magazino_slider_timeout', array(
		'label'    => __( 'Autoplay Speed in Seconds (0 for Manual)', 'magazino' ),
		'section'  => 'magazino_slider_section',
		'settings' => 'magazino_slider_timeout',
	) ) );
	
	$wp_customize->add_setting( 'magazino_slider_pager' );
	
	 $wp_customize->add_control('enable_pager', array(
		'settings' => 'magazino_slider_pager',
		'label' => __('Enable pager', 'magazino'),
		'section' => 'magazino_slider_section',
		'type' => 'checkbox',
	));

}
add_action('customize_register', 'magazino_theme_customizer');

/**
* Apply Color Scheme
*/
function magazino_apply_color() {
	if ( get_theme_mod('magazino_color_settings') ) {
?>
	<style>
		a, a:visited,
		#site-title a,
		nav[role=navigation] .menu ul li a:hover,
		nav[role=navigation] .menu ul li.current-menu-item a, 
		.nav ul li.current_page_item a, 
		nav[role=navigation] .menu ul li.current_page_item a,
		#sidebar .widget-title,
		.slides .slide-title,
		.commentlist .vcard cite.fn a,
		.commentlist .comment-meta a:hover,
		.post_content ul li:before,
		.post_content ol li:before,
		.colortxt,
		.commentlist .bypostauthor > article > footer > .vcard cite.fn,
		.cycle-pager span.cycle-pager-active { 
			color: <?php echo get_theme_mod('magazino_color_settings'); ?>;
		}
		
		#container,
		#sidebar {
			border-top: 2px solid <?php echo get_theme_mod('magazino_color_settings'); ?>;
		}
		
		#search-box-wrap,
		#social-media a,
		#search-icon,
		.go-button a,
		.go-button a:visited,
		.grnbar,
		.pagination a:hover,
		.pagination .current,
		#respond #submit {
			background-color: <?php echo get_theme_mod('magazino_color_settings'); ?>;
		}
		
		.post_content pre { 
			border-left-color: <?php echo get_theme_mod('magazino_color_settings'); ?>;
		}
	</style>
<?php
	}
}
add_action( 'wp_head', 'magazino_apply_color' );

/**
* Filter the RSS Feed Site Title
*/
function magazino_blogname_rss( $val, $show ) {
    if( 'name' == $show )
        $out = '';
    else
        $out = $val;

    return $out;
}
add_filter('bloginfo_rss', 'magazino_blogname_rss', 10, 2);




/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
if ( ! function_exists( 'magazino_main_nav' ) ) :
function magazino_main_nav() {
	// display the wp3 menu if available
    wp_nav_menu( 
    	array( 
    		'menu' => '', /* menu name */
    		'theme_location' => 'primary', /* where in the theme it's assigned */
    		'container_class' => 'menu', /* container class */
    		'fallback_cb' => 'magazino_main_nav_fallback' /* menu fallback */
    	)
    );
}
endif;

if ( ! function_exists( 'magazino_main_nav_fallback' ) ) :
	function magazino_main_nav_fallback() { wp_page_menu( 'show_home=Home&menu_class=menu' ); }
endif;


function magazino_enqueue_comment_reply() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
        }
 }
add_action( 'comment_form_before', 'magazino_enqueue_comment_reply' );


function magazino_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'magazino_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function magazino_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Footer Sidebar', 'magazino' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<div class="widget-title">',
		'after_title' => '</div>',
	) );

}
add_action( 'widgets_init', 'magazino_widgets_init' );

if ( ! function_exists( 'magazino_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 */
function magazino_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>">
		<h1 class="assistive-text section-heading"><?php _e( 'Post navigation', 'magazino' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr; Previous', 'Previous post link', 'magazino' ) . '</span>' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '<span class="meta-nav">' . _x( 'Next &rarr;', 'Next post link', 'magazino' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'magazino' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'magazino' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif;


if ( ! function_exists( 'magazino_comment' ) ) :
/**
 * Template for comments and pingbacks.
 */
function magazino_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'magazino' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'magazino' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>">
			<footer class="clearfix comment-head">
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s', 'magazino' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'magazino' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s <span class="bsep">&bull;</span> ', 'magazino' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit) <span class="bsep">&bull;</span> ', 'magazino' ), ' ' );
					?>
                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif;

if ( ! function_exists( 'magazino_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function magazino_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="byline"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'magazino' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'magazino' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Adds custom classes to the array of body classes.
 */
function magazino_body_classes( $classes ) {
	// Adds a class of single-author to blogs with only 1 published author
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes;
}
add_filter( 'body_class', 'magazino_body_classes' );

/**
 * Returns true if a blog has more than 1 category
 */
function magazino_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so magazino_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so magazino_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in magazino_categorized_blog
 */
function magazino_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'magazino_category_transient_flusher' );
add_action( 'save_post', 'magazino_category_transient_flusher' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function magazino_enhanced_image_navigation( $url ) {
	global $post, $wp_rewrite;

	$id = (int) $post->ID;
	$object = get_post( $id );
	if ( wp_attachment_is_image( $post->ID ) && ( $wp_rewrite->using_permalinks() && ( $object->post_parent > 0 ) && ( $object->post_parent != $id ) ) )
		$url = $url . '#main';

	return $url;
}
add_filter( 'attachment_link', 'magazino_enhanced_image_navigation' );


if ( ! function_exists( 'magazino_pagination' ) ) :
function magazino_pagination($pages = '', $range = 4)
{
     $showitems = ($range * 2)+1; 
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  
 
     if(1 != $pages)
     {
         printf( __( '<div class="pagination"><span>Page %1$s of %2$s</span>', 'magazino'), $paged, $pages );
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) printf( __( '<a href="%1$s">&laquo; First</a>', 'magazino' ), get_pagenum_link(1) );
         if($paged > 1 && $showitems < $pages) printf( __( '<a href="%1$s">&lsaquo; Previous</a>', 'magazino' ), get_pagenum_link($paged - 1) );
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) printf( __( '<a href="%1$s">Next &rsaquo;</a>', 'magazino' ), get_pagenum_link($paged + 1) );
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) printf( __( '<a href="%1$s">Last &raquo;</a>', 'magazino' ), get_pagenum_link($pages) );
         echo "</div>\n";
     }
}
endif;

function magazino_excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt).'...';
	} else {
	$excerpt = implode(" ",$excerpt);
	}	
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}
 
function magazino_content($limit) {
	$content = explode(' ', get_the_content(), $limit);
	if (count($content)>=$limit) {
	array_pop($content);
	$content = implode(" ",$content).'...';
	} else {
	$content = implode(" ",$content);
	}	
	$content = preg_replace('/\[.+\]/','', $content);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	  return $content;
}

function magazino_w3c_valid_rel( $text ) {
	$text = str_replace('rel="category tag"', 'rel="tag"', $text); return $text; 
}
add_filter( 'the_category', 'magazino_w3c_valid_rel' );


function magazino_modernizr_addclass($output) {
    return $output . ' class="no-js"';
}
add_filter('language_attributes', 'magazino_modernizr_addclass');


function magazino_modernizr_script() {
    wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/library/js/modernizr-2.6.2.min.js', false, '2.6.2');
}    
add_action('wp_enqueue_scripts', 'magazino_modernizr_script');


function magazino_custom_scripts() {
	wp_enqueue_script( 'magazino_cycle_js', get_template_directory_uri() . '/library/js/jquery.cycle2.min.js', array( 'jquery' ), '20130202' );
	wp_enqueue_script( 'magazino_cycle_tile_js', get_template_directory_uri() . '/library/js/jquery.cycle2.tile.min.js', array( 'jquery' ), '20121120' );
	wp_enqueue_script( 'magazino_cycle_scrollvert_js', get_template_directory_uri() . '/library/js/jquery.cycle2.scrollVert.min.js', array( 'jquery' ), '20121120' );
	wp_enqueue_script( 'magazino_custom_js', get_template_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_style( 'magazino_style', get_stylesheet_uri() );
}
add_action('wp_enqueue_scripts', 'magazino_custom_scripts');

?>