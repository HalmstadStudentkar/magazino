<?php get_header(); ?>

    <div id="content" class="clearfix">
        
        <div id="main" class="clearfix" role="main">

			<?php if ( have_posts() ) : ?>
            
            <div id="post-boxes-wrap" class="clearfix">

				<header class="page-header">
					<h1 class="page-title">
						<?php
							if ( is_day() ) :
								printf( __( 'Daily Archives: %s', 'magazino' ), '<span class="colortxt">' . get_the_date() . '</span>' );
							elseif ( is_month() ) :
								printf( __( 'Monthly Archives: %s', 'magazino' ), '<span class="colortxt">' . get_the_date( 'F Y' ) . '</span>' );
							elseif ( is_year() ) :
								printf( __( 'Yearly Archives: %s', 'magazino' ), '<span class="colortxt">' . get_the_date( 'Y' ) . '</span>' );
							else :
								_e( 'Archives', 'magazino' );
							endif;
						?>
					</h1>
                    <div class="grnbar"></div>
				</header>

				<?php rewind_posts(); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 */
						get_template_part( 'content-archive', get_post_format() );
					?>

				<?php endwhile; ?>

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