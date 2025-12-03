<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default. Please note that
 * this is the WordPress construct of pages: specifically, posts with a post
 * type of `page`.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package raseth
 */

get_header();
?>

<section id="primary">
<main id="main">

 <section class="relative text-white overflow-hidden bg-[#2C799A]">

	<?php
	$hero_args = array(
		'post_type' => 'hero_section',
		'posts_per_page' => 1,
		'orderby' => 'date',
		'order' => 'DESC'
	);
	$hero_query = new WP_Query( $hero_args );

	if ( $hero_query->have_posts() ) {
		while ( $hero_query->have_posts() ) {
			$hero_query->the_post();
			
			$subtitle = get_post_meta( get_the_ID(), '_hero_subtitle', true );
			$title = get_post_meta( get_the_ID(), '_hero_title', true );
			$description = get_post_meta( get_the_ID(), '_hero_description', true );
			$btn1_text = get_post_meta( get_the_ID(), '_hero_btn1_text', true );
			$btn1_url = get_post_meta( get_the_ID(), '_hero_btn1_url', true );
			$btn2_text = get_post_meta( get_the_ID(), '_hero_btn2_text', true );
			$btn2_url = get_post_meta( get_the_ID(), '_hero_btn2_url', true );
			$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' )[0] ?? '';
			?>
			
				<div class="max-w-7xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-10 lg:gap-30 justify-items-center items-center relative z-10">
					<!-- LEFT TEXT SECTION -->
					<div>
						<p class="uppercase text-sm tracking-wider mb-2 opacity-75"><?php echo esc_html( $subtitle ); ?></p>
						<h1 class="text-5xl md:text-5xl font-bold leading-tight mb-6 text-balance"><?php echo wp_kses_post( $title ); ?></h1>
						<p class="text-lg mb-8 max-w-md opacity-90 text-balance"><?php echo esc_html( $description ); ?></p>
						
						<div class="flex gap-4">
							<a href="<?php echo esc_url( $btn1_url ); ?>" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white text-center inline-flex items-center justify-center px-4 py-3 rounded-lg font-semibold shadow-md">
								<?php echo esc_html( $btn1_text ); ?>
							</a>
							<a href="<?php echo esc_url( $btn2_url ); ?>" class="border border-white/40 px-4 py-3 text-center inline-flex items-center justify-center rounded-lg font-semibold">
								<?php echo esc_html( $btn2_text ); ?>
							</a>
						</div>
					</div>
					
					<!-- RIGHT IMAGE SECTION -->
					<div class="relative">
						<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="w-full lg:w-[700px] relative z-20 rounded-2xl shadow-xl" />
					</div>
				</div>

			<?php
		}
		wp_reset_postdata();
	}
	?>


  <!-- Decorative Wave Shape -->
  <div class="absolute bottom-0 left-0 w-full" style="height: 130px;">
    <svg viewBox="0 0 1440 320" preserveAspectRatio="none" style="width: 100%; height: 100%; display: block;">
      <path fill="#2B1E5A" fill-opacity="1"
        d="M0,288L60,256C120,224,240,160,360,149.3C480,139,600,181,720,192C840,203,960,181,1080,170.7C1200,160,1320,160,1380,160L1440,160L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z">
      </path>
    </svg>
  </div>


</section>



<!-- FEATURE CARDS -->
<section class="bg-[#2B1E5A] py-20">
  <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8">
    <?php
    $feature_args = array(
        'post_type' => 'feature_card',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC'
    );
    $feature_query = new WP_Query( $feature_args );

    if ( $feature_query->have_posts() ) {
        while ( $feature_query->have_posts() ) {
            $feature_query->the_post();
            
            $title = get_post_meta( get_the_ID(), '_feature_title', true );
            $description = get_post_meta( get_the_ID(), '_feature_description', true );
            $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' )[0] ?? '';
            ?>
            <div class="bg-white p-8 rounded-lg shadow-xl">
              <?php if ( $image_url ) : ?>
                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="w-[70px] object-cover mb-4 rounded-md">
              <?php endif; ?>
              <h3 class="font-bold text-lg mb-2"><?php echo esc_html( $title ); ?></h3>
			  <div><svg width="50" height="2" viewBox="0 0 50 2" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect width="50" height="2" fill="#E74040"/>
					</svg>
			  </div>
              <p class="text-gray-600"><?php echo esc_html( $description ); ?></p>
            </div>
            <?php
        }
        wp_reset_postdata();
    }
    ?>
  </div>
</section>



</main><!-- #main -->
</section><!-- #primary -->


<?php
get_footer();
