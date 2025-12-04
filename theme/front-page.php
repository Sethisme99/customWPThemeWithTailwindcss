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

<section id="primary" class="bg-[#2C799A]">
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
			
				<div class="max-w-7xl mx-auto px-6 py-[30px] grid md:grid-cols-2 gap-10 lg:gap-30 justify-items-center items-center relative z-10">
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





</section>



<!-- FEATURE CARDS -->
<section class="bg-[#2B1E5A] py-20">
  <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8">
    <?php
    // Default hardcoded values
    $default_features = array(
        array(
            'title' => '2,769 online courses',
            'description' => 'The gradual accumulation of information about atomic and small-scale behavior…',
            'image' => '014-school-1.jpg'
        ),
        array(
            'title' => 'Expert Instruction',
            'description' => 'The gradual accumulation of information about atomic and small-scale behavior…',
            'image' => '015-book.jpg'
        ),
        array(
            'title' => 'Training Courses',
            'description' => 'The gradual accumulation of information about atomic and small-scale behavior…',
            'image' => '011-health-check-1.jpg'
        )
    );

    $feature_args = array(
        'post_type' => 'feature_card',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC'
    );
    $feature_query = new WP_Query( $feature_args );

    // If database has entries, use them; otherwise use defaults
    if ( $feature_query->have_posts() ) {
        while ( $feature_query->have_posts() ) {
            $feature_query->the_post();
            
            $title = get_post_meta( get_the_ID(), '_feature_title', true );
            $description = get_post_meta( get_the_ID(), '_feature_description', true );
            $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' )[0] ?? '';
            
            // Fall back to default image if none uploaded
            if ( empty( $image_url ) ) {
                $image_url = get_template_directory_uri() . '/img/default-feature.png';
            }
            ?>
            <div class="bg-white p-8 rounded-lg shadow-xl">
              <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="w-[70px] object-cover mb-4 rounded-md">
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
    } else {
        // Use default hardcoded values if no database entries
        foreach ( $default_features as $feature ) {
            $image_path = get_template_directory_uri() . '/img/' . $feature['image'];
            ?>
            <div class="bg-white p-8 rounded-lg shadow-xl">
              <img src="<?php echo esc_url( $image_path ); ?>" alt="<?php echo esc_attr( $feature['title'] ); ?>" class="w-[70px] object-cover mb-4 rounded-md">
              <h3 class="font-bold text-lg mb-2"><?php echo esc_html( $feature['title'] ); ?></h3>
              <div><svg width="50" height="2" viewBox="0 0 50 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="50" height="2" fill="#E74040"/>
                    </svg>
              </div>
              <p class="text-gray-600"><?php echo esc_html( $feature['description'] ); ?></p>
            </div>
            <?php
        }
    }
    ?>
  </div>
</section>




<!-- EXPERT TEACHERS SECTION -->


<section class="bg-[#1F2B52] py-20 overflow-hidden">
  <div class="container mx-auto px-6 grid md:grid-cols-2 items-center gap-12">

    <!-- Left Image + Cards -->
    <div class="relative flex justify-center">

      <!-- Main Image Background -->
      <div class="bg-[#D9EBEA] rounded-2xl p-6 w-[280px] sm:w-[320px] md:w-auto">
        <img 
          src="<?php echo get_template_directory_uri(); ?>/img/technology 1.png" 
          alt="Teacher"
          class="w-full max-w-[350px] h-auto object-cover rounded-xl"
        />
      </div>

      <!-- Floating Cards WRAPPER for mobile -->
      <div class="absolute inset-0 pointer-events-none hidden md:block">

        <!-- Card 1 -->
        <div class="absolute top-20 -left-6">
          <img 
            src="<?php echo get_template_directory_uri(); ?>/img/image 10.png" 
            class="w-[120px] rounded-xl shadow-lg"
          />
        </div>

        <!-- Card 2 -->
        <div class="absolute top-1/2 -right-5 bg-white p-4 rounded-xl shadow-lg w-32">
          <p class="text-[11px] text-gray-600">Global Statistic</p>
          <div class="mt-1 flex justify-center">
            <img src="" alt="Chart">
          </div>
        </div>

        <!-- Card 3 -->
        <div class="absolute bottom-4 -left-8 bg-white p-4 rounded-xl shadow-lg w-48">
          <p class="text-[12px] font-semibold">Latest Scores</p>
          <div class="mt-1 text-[11px] text-gray-600">
            <p>Singles</p>
            <p class="flex justify-between"><span>Andrea R.</span><span>6 - 0</span></p>
            <p class="flex justify-between"><span>Naomi O.</span><span>3 - 6</span></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Content -->
    <div class="text-white space-y-6 text-center md:text-left">

      <div>
        <div class="h-1 w-12 bg-red-400 mb-4 mx-auto md:mx-0"></div>
        <h2 class="text-3xl sm:text-4xl font-bold leading-snug">
          Our Experts <br class="hidden md:block"> Teacher
        </h2>
      </div>

      <p class="text-gray-300 max-w-md mx-auto md:mx-0">
        Problems trying to resolve the conflict between the two major realms 
        of Classical physics: Newtonian mechanics.
      </p>

      <a href="#" class="inline-flex items-center gap-2 text-purple-400 font-semibold hover:text-purple-300 transition">
        Learn More 
        <span>➜</span>
      </a>

    </div>

  </div>
</section>









</main><!-- #main -->
</section><!-- #primary -->










<?php
get_footer();
