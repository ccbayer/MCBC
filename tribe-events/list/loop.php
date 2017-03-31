<?php
/**
 * List View Loop
 * This file sets up the structure for the list loop
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/loop.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<?php
global $post;
global $more;
$more = false;
?>

<div class="tribe-events-loop">

	<?php while ( have_posts() ) : the_post(); ?>
		<?php do_action( 'tribe_events_inside_before_loop' ); ?>

		<!-- Month / Year Headers -->
		<?php tribe_events_list_the_date_headers(); ?>

		<!-- Event  -->
		<?php
		$post_parent = '';
		if ( $post->post_parent ) {
			$post_parent = ' data-parent-post-id="' . absint( $post->post_parent ) . '"';
		}
		
		$img = get_field('event_image');
		
		?>
		<div id="post-<?php the_ID() ?>" class="<?php tribe_events_event_classes() ?> row" <?php echo $post_parent; ?>>
			<?php
				if($img): 
					echo '<div class="event-image col-md-2"><a class="tribe-event-url" href="'. esc_url( tribe_get_event_link() ).'" title="'. the_title_attribute().'" rel="bookmark"><img src="'.$img['url'].'" /></a></div>';
					$offset = '';
				else:
					$offset = 'col-md-offset-2';
				endif;
			?>
			<div class="col-md-9 <?php echo $offset; ?>">
				<?php tribe_get_template_part( 'list/single', 'event' ) ?>
			</div>
		</div>


		<?php do_action( 'tribe_events_inside_after_loop' ); ?>
	<?php endwhile; ?>

</div><!-- .tribe-events-loop -->
