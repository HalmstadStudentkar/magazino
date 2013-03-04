
<article id="post-<?php the_ID(); ?>" <?php post_class('post-box'); ?>>

    <header class="entry-header">
        <?php if ( 'post' == get_post_type() ) : ?>
        <div class="entry-meta">
            <a href="<?php the_permalink() ?>" rel="bookmark"><?php printf( __('%s', 'magazino'), get_the_date('m.d.y') ); ?></a>
        </div><!-- .entry-meta -->
        <?php endif; ?>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'magazino' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>		
    </header><!-- .entry-header -->
    
    <div class="entry-content post_content">
        <?php echo magazino_excerpt(12); ?>
    </div><!-- .entry-content -->
    
    <div class="go-button"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'magazino' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php _e('&#9654;', 'magazino'); ?></a></div>
    
    <?php if ( has_post_thumbnail()) : ?>
     	<div class="post-box-img"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( array(250, 250), array( 'style' => 'position:absolute', 'onload' => 'thumb_img_onload(this)' ) ); ?></a></div>
		
	<?php else : ?>
    <?php
    	$postimgs =& get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
		if ( !empty($postimgs) ) {
			$firstimg = array_shift( $postimgs );
			$th_image = wp_get_attachment_image( $firstimg->ID, array( 250, 250 ), false, array( 'style' => 'position:absolute', 'onload' => 'thumb_img_onload(this)') );
		 ?>
			<div class="post-box-img"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo $th_image; ?></a></div> 
		
	<?php } ?>
    <?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
    

