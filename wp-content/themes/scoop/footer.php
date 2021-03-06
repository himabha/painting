<?php
/**
 * The template for displaying the footer.
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
			</div><!-- #content -->
		</div><!-- .container -->
	</div><!-- #primary -->

	<?php if ( ! pojo_is_blank_page() ) : ?>

		<?php get_sidebar( 'footer' ); ?>

		<footer id="footer-copyright">
			<div class="<?php echo WRAP_CLASSES; ?>">
				<div class="content-copyright">
					<div class="pull-left-copyright">
						<?php echo nl2br( pojo_get_option( 'txt_copyright_left' ) ); ?>
					</div>
					<div class="pull-right-copyright">
						<?php echo nl2br( pojo_get_option( 'txt_copyright_right' ) ); ?>
					</div>
				</div>
			</div><!-- .container -->
		</footer>

	<?php endif; // end blank page ?>

</div><!-- #container -->
<?php wp_footer(); ?>
</body>
</html>