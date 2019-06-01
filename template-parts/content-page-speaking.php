<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Velox
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php velox_post_thumbnail(); ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<!-- wp:heading -->
		<h2>Upcoming Presentations</h2>
		<!-- /wp:heading -->
		<?php
		// Get upcoming events if they exist
		$upcoming_events = dw_get_speaking_events( '>=', 'ASC' );

		// If upcoming events exist, display, else display the error.
		if ( ! empty( $upcoming_events ) ) :
			?>
			<!-- wp:paragraph -->
			<p>Do you plan on being here? Come say hi!</p>
			<!-- /wp:paragraph -->
			<?php
			echo $upcoming_events;
		else :
			?>
			<!-- wp:paragraph -->
			<p>I don't currently have any announced upcoming presentations. If you want to help me change that, <a href="https://davidwolfpaw.com/contact/">contact me</a>!</p>
			<!-- /wp:paragraph -->
		<?php endif; ?>

		<!-- wp:spacer -->
		<div style="height:48px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

		<!-- wp:heading -->
		<h2>Previous Presentations</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph -->
		<p>Below is an incomplete list of the lightning talks, lectures, panels, workshops, and QA sessions that I've done. I don't generally list Meetup presentations here.</p>
		<!-- /wp:paragraph -->
		<?php echo dw_get_speaking_events(); ?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
					</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
/**
 * Gets and returns speaking event posts.
 *
 * @param str $range Date range to look at. Should be a relational compare.
 * @param str $sort Sort order of results. Should be ASC or DESC.
 * @return str $event_list The HTML results to display.
 */
function dw_get_speaking_events( $range = '<=', $sort = 'DESC' ) {

	// Select all speaking events in the date range and sort.
	$event_args = array(
		'post_type'      => 'speaking_events',
		'posts_per_page' => -1,
		'orderby'        => 'meta_value_num',
		'order'          => $sort,
		'meta_query'     => array(
			array(
				'key'     => 'event_date',
				'value'   => date( 'Ymd' ),
				'compare' => $range,
			),
		),
	);

	// Create Query.
	$events = new WP_Query( $event_args );

	// Display query results if they exist.
	if ( $events->have_posts() ) {

		$event_list = '';

		while ( $events->have_posts() ) {

			$events->the_post();

			$event_list     .= '<div class="speaking-event">';
				$event_list .= '<div class="event-date">' . get_field( 'event_date' ) . '</div>';
				$event_list .= '<div class="event-name">' . get_the_title() . '</div>';
				$event_list .= '<div class="talk-name"><a href="' . esc_url( get_field( 'event_url' ) ) . '">' . get_field( 'talk_title' ) . '</a></div>';
			$event_list     .= '</div>';

		}

		wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly.

		return $event_list;

	}

}
