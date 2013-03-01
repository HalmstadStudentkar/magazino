
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
    
    <div class="post-box-img"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( array(250, 250), array( 'style' => 'position:absolute', 'onload' => 'thumb_img_onload(this)' ) ); ?></a></div> 

</article><!-- #post-<?php the_ID(); ?> -->
    

