
	<footer id="colophon" role="contentinfo">
		<div id="site-generator">

			<?php echo __('&copy; ', 'magazino') . esc_attr( get_bloginfo( 'name', 'display' ) );  ?>
            <?php if ( is_home() || is_front_page() ) : ?>
            <?php _e('- Powered by ', 'magazino'); ?><a href="<?php echo esc_url( __( 'http://wordpress.org/', 'magazino' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'magazino' ); ?>"><?php _e('WordPress' ,'magazino'); ?></a>
			<?php _e(' and ', 'magazino'); ?><a href="<?php echo esc_url( __( 'http://wpthemes.co.nz/magazino/', 'magazino' ) ); ?>"><?php _e('Magazino', 'magazino'); ?></a>
            <?php endif; ?>
            
		</div>
	</footer><!-- #colophon -->
</div><!-- #container -->

<?php wp_footer(); ?>


</body>
</html>