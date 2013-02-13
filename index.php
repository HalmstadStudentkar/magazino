<?php get_header(); ?>

    <div id="content" class="clearfix">
        
        <div id="main" class="clearfix" role="main">
        	
            <div id="slide-wrap">
			  <?php 
                $args = array(
                    'posts_per_page' => 10,
					'post_status' => 'publish',
                    'post__in' => get_option("sticky_posts")
                );
                $fPosts = new WP_Query( $args );
				$countPosts = $fPosts->found_posts;
              ?>
    
                <?php if ( $fPosts->have_posts() ) : ?>
                  
                  <?php if ($countPosts > 1) : ?>
                  <div id="loading"></div>
                  <div class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-slides="> div" data-cycle-timeout="0" data-cycle-prev="#sliderprev" data-cycle-next="#slidernext">
                    <?php /* Start the Loop */ ?>
                    <?php while ( $fPosts->have_posts() ) : $fPosts->the_post(); ?>
                    
                    <div class="slides">
                      <div id="post-<?php the_ID(); ?>" <?php post_class('post-theme'); ?>>
                         <?php if ( has_post_thumbnail()) : ?>
                            <div class="slide-thumb"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'magazino' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_post_thumbnail( array(1000, 640) ); ?></a></div>
                         <?php else : ?>
                            <div class="slide-noimg"><?php _e('No featured image set for this post.', 'magazino') ?></div>
                         <?php endif; ?>
                         <div class="slide-content">
                            <h2 class="slide-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'magazino' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                         	<?php echo magazino_excerpt(25); ?>	
                         </div>						
                      </div>
                    </div>
                    
                    <?php endwhile; ?>

                    <?php wp_reset_query(); // reset the query ?>

                  </div>
                  
                  <div class="slidernav">
                        <a id="sliderprev" href="#" title="<?php _e('Previous', 'restaurateur'); ?>"><?php _e('&#9664;', 'restaurateur'); ?></a>
                        <a id="slidernext" href="#" title="<?php _e('Next', 'restaurateur'); ?>"><?php _e('&#9654;', 'restaurateur'); ?></a>
                    </div>
                    
                    <div class="clearfix"></div>
                  
                  <?php else : ?>
                  
                  <?php /* Start the Loop */ ?>
                   <?php while ( $fPosts->have_posts() ) : $fPosts->the_post(); ?>
                  	<div class="slides">
                      <div id="post-<?php the_ID(); ?>" <?php post_class('post-theme'); ?>>
                         <?php if ( has_post_thumbnail()) : ?>
                            <div class="slide-thumb"><?php the_post_thumbnail( array(1000, 640) ); ?></div>
                         <?php else : ?>
                            <div class="slide-noimg"><?php _e('No featured image set for this post.', 'magazino') ?></div>
                         <?php endif; ?>
                         <div class="slide-content">
                            <h2 class="slide-title"><?php the_title(); ?></h2>
                         	<?php echo magazino_excerpt(25); ?>	
                         </div>						
                      </div>
                    </div>
                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); // reset the query ?>
                  
                  <?php endif; ?>
                  
                <?php endif; ?>
                    
              </div>
              
              <div class="grnbar"></div>

			<?php 
				$sticky = get_option("sticky_posts");
				$fargs = array(
					'post__not_in' => $sticky,
					'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
				);
				$rPosts = new WP_Query( $fargs );
			?>
			<?php if ( $rPosts->have_posts() ) : ?>
				<div id="post-boxes-wrap" class="clearfix">
				<?php /* Start the Loop */ ?>
				<?php while ( $rPosts->have_posts() ) : $rPosts->the_post(); ?>
					
					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content-home', get_post_format() );
					?>
                    
				<?php endwhile; ?>
                
                <?php wp_reset_query(); // reset the query ?>

				<?php if (function_exists("magazino_pagination")) {
							magazino_pagination(); 
				} elseif (function_exists("magazino_content_nav")) { 
							magazino_content_nav( 'nav-below' );
				}?>
			</div>
			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'magazino' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content post_content">
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'magazino' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

        </div> <!-- end #main -->

        <?php get_sidebar(); ?>

    </div> <!-- end #content -->
        
<?php get_footer(); ?>