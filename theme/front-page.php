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



  <!-- Decorative Wave Shape -->
  <div class="absolute bottom-0 left-0 w-full" style="height: 140px;">
    <svg viewBox="0 0 1440 320" preserveAspectRatio="none" style="width: 100%; height: 100%; display: block;">
      <path fill="#2B1E5A" fill-opacity="1"
        d="M0,288L60,256C120,224,240,160,360,149.3C480,139,600,181,720,192C840,203,960,181,1080,170.7C1200,160,1320,160,1380,160L1440,160L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z">
      </path>
    </svg>
  </div>

</section>



<!-- FEATURE CARDS -->
<section class="bg-[#2B1E5A] py-20">
  <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-8">
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

<!-- EXPERT TEACHERS SECTION -->
<section class="bg-gradient-to-br from-[#1F2B52] to-[#2C3e5a] py-20 lg:py-32 overflow-hidden relative">
  <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500 opacity-5 rounded-full blur-3xl"></div>
  <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-500 opacity-5 rounded-full blur-3xl"></div>
  
  <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 items-center gap-20 lg:gap-32 relative z-10">
    <?php
    // Default hardcoded fallback data
    $default_teacher = array(
        'title' => 'Meet Our Expert Teachers',
        'image' => get_template_directory_uri() . '/img/technology 1.png',
        'card_label' => 'Certified',
        'card_title' => 'Award Winner',
        'card_description' => '10+ Years of Excellence in Teaching',
        'cert_image' => get_template_directory_uri() . '/img/image 10.png',
        'satisfaction' => '95',
        'achievement1_name' => 'Andrea R.',
        'achievement1_score' => '6/10',
        'achievement2_name' => 'Naomi O.',
        'achievement2_score' => '9/10',
        'description' => 'Learn from industry leaders with decades of combined experience. Our expert instructors are dedicated to transforming your skills and unlocking your potential.',
        'btn_text' => 'Learn More',
        'btn_url' => '#',
		'btn2_text' => 'View Profiles',
        'btn2_url' => '#'
    );

    $teacher_args = array(
        'post_type' => 'expert_teacher',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    $teacher_query = new WP_Query( $teacher_args );

    // Use database data if exists, otherwise use defaults
    if ( $teacher_query->have_posts() ) {
        while ( $teacher_query->have_posts() ) {
            $teacher_query->the_post();
            
            // Get featured image or use default
            $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' )[0] ?? $default_teacher['image'];
            $card_label = get_post_meta( get_the_ID(), '_teacher_card_label', true ) ?: $default_teacher['card_label'];
            $card_title = get_post_meta( get_the_ID(), '_teacher_card_title', true ) ?: $default_teacher['card_title'];
            $card_description = get_post_meta( get_the_ID(), '_teacher_card_description', true ) ?: $default_teacher['card_description'];
            $cert_image = get_post_meta( get_the_ID(), '_teacher_cert_image', true ) ?: $default_teacher['cert_image'];
            $satisfaction = get_post_meta( get_the_ID(), '_teacher_satisfaction', true ) ?: $default_teacher['satisfaction'];
            $achievement1_name = get_post_meta( get_the_ID(), '_teacher_achievement1_name', true ) ?: $default_teacher['achievement1_name'];
            $achievement1_score = get_post_meta( get_the_ID(), '_teacher_achievement1_score', true ) ?: $default_teacher['achievement1_score'];
            $achievement2_name = get_post_meta( get_the_ID(), '_teacher_achievement2_name', true ) ?: $default_teacher['achievement2_name'];
            $achievement2_score = get_post_meta( get_the_ID(), '_teacher_achievement2_score', true ) ?: $default_teacher['achievement2_score'];
            $description = get_post_meta( get_the_ID(), '_teacher_description', true ) ?: $default_teacher['description'];
            $btn_text = get_post_meta( get_the_ID(), '_teacher_btn_text', true ) ?: $default_teacher['btn_text'];
            $btn_url = get_post_meta( get_the_ID(), '_teacher_btn_url', true ) ?: $default_teacher['btn_url'];
			$btn2_text = get_post_meta( get_the_ID(), '_teacher_btn2_text', true ) ?: $default_teacher['btn2_text'];
            $btn2_url = get_post_meta( get_the_ID(), '_teacher_btn2_url', true ) ?: $default_teacher['btn2_url'];
            $section_title = get_post_meta( get_the_ID(), '_teacher_section_title', true ) ?: $default_teacher['title'];
            ?>

    <!-- Left Image + Cards -->
    <div class="relative flex justify-center">
      <div class="bg-gradient-to-br from-[#D9EBEA] to-[#c5dfd9] rounded-3xl p-8 shadow-2xl transform hover:scale-105 transition-transform duration-300">
        <img 
          src="<?php echo esc_url( $image_url ); ?>" 
          alt="Expert Teacher"
          class="w-full max-w-[350px] h-auto object-cover rounded-2xl shadow-lg"
        />
      </div>

      <div class="absolute inset-0 pointer-events-none hidden md:block">
        <!-- Top Left Card with Text -->
        <div class="absolute top-16 -left-8 transform hover:scale-110 transition-transform duration-300 pointer-events-auto">
          <div class="bg-gradient-to-br from-purple-500 to-pink-500 p-4 rounded-2xl shadow-2xl w-48">
            <div class="bg-white rounded-xl p-4">
              <p class="text-xs font-semibold text-gray-700 uppercase tracking-wide mb-2"><?php echo esc_html( $card_label ); ?></p>
              <h3 class="text-sm font-bold text-gray-900 mb-2"><?php echo esc_html( $card_title ); ?></h3>
              <p class="text-xs text-gray-600 leading-relaxed"><?php echo esc_html( $card_description ); ?></p>
            </div>
          </div>
        </div>

        <!-- Top Right Card - Statistics -->
        <div class="absolute top-1/3 -right-6 bg-white p-6 rounded-2xl shadow-2xl w-40 pointer-events-auto hover:shadow-3xl transition-shadow">
          <p class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Global Statistic</p>
          <div class="mt-3 space-y-2">
            <div class="h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full w-full"></div>
            <p class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600"><?php echo esc_html( $satisfaction ); ?>%</p>
            <p class="text-xs text-gray-600">Student Satisfaction</p>
          </div>
        </div>

        <!-- Bottom Left Card - Achievements -->
        <div class="absolute -bottom-4 -left-6 bg-white p-6 rounded-2xl shadow-2xl w-56 pointer-events-auto hover:shadow-3xl transition-shadow">
          <p class="text-sm font-bold text-gray-900 mb-3">Latest Achievements</p>
          <div class="space-y-2 text-sm">
            <div class="flex justify-between items-center pb-2 border-b border-gray-100">
              <span class="font-medium text-gray-700"><?php echo esc_html( $achievement1_name ); ?></span>
              <span class="text-purple-600 font-bold"><?php echo esc_html( $achievement1_score ); ?></span>
            </div>
            <div class="flex justify-between items-center">
              <span class="font-medium text-gray-700"><?php echo esc_html( $achievement2_name ); ?></span>
              <span class="text-purple-600 font-bold"><?php echo esc_html( $achievement2_score ); ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Content -->
    <div class="text-white space-y-8 text-center md:text-left">
      <div>
        <div class="h-1 w-16 bg-gradient-to-r from-pink-500 to-purple-500 mb-6 mx-auto md:mx-0 rounded-full"></div>
        <h2 class="text-4xl sm:text-5xl font-bold leading-tight">
          <?php echo esc_html( $section_title ); ?>
        </h2>
      </div>

      <p class="text-gray-300 max-w-lg mx-auto md:mx-0 leading-relaxed text-lg">
        <?php echo esc_html( $description ); ?>
      </p>

      <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
        <a href="<?php echo esc_url( $btn_url ); ?>" class="inline-flex items-center justify-center gap-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-8 py-3 rounded-lg font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200">
          <?php echo esc_html( $btn_text ); ?>
          <span class="text-lg">→</span>
        </a>

        <a href="<?php echo esc_url( $btn2_url ); ?>" class="inline-flex items-center justify-center gap-3 border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition-all duration-200">
          <?php echo esc_html( $btn2_text ); ?>
        </a>
      </div>
    </div>

            <?php
        }
        wp_reset_postdata();
    } else {
        // Use hardcoded defaults if no database entries
        ?>

    <!-- Left Image + Cards -->
    <div class="relative flex justify-center">
      <div class="bg-gradient-to-br from-[#D9EBEA] to-[#c5dfd9] rounded-3xl p-8 shadow-2xl transform hover:scale-105 transition-transform duration-300">
        <img 
          src="<?php echo esc_url( $default_teacher['image'] ); ?>" 
          alt="Expert Teacher"
          class="w-full max-w-[350px] h-auto object-cover rounded-2xl shadow-lg"
        />
      </div>

      <div class="absolute inset-0 pointer-events-none hidden md:block">
        <!-- Top Left Card with Text -->
        <div class="absolute top-16 -left-8 transform hover:scale-110 transition-transform duration-300 pointer-events-auto">
          <div class="bg-gradient-to-br from-purple-500 to-pink-500 p-4 rounded-2xl shadow-2xl w-48">
            <div class="bg-white rounded-xl p-4">
              <p class="text-xs font-semibold text-gray-700 uppercase tracking-wide mb-2"><?php echo esc_html( $default_teacher['card_label'] ); ?></p>
              <h3 class="text-sm font-bold text-gray-900 mb-2"><?php echo esc_html( $default_teacher['card_title'] ); ?></h3>
              <p class="text-xs text-gray-600 leading-relaxed"><?php echo esc_html( $default_teacher['card_description'] ); ?></p>
            </div>
          </div>
        </div>

        <!-- Top Right Card - Statistics -->
        <div class="absolute top-1/3 -right-6 bg-white p-6 rounded-2xl shadow-2xl w-40 pointer-events-auto hover:shadow-3xl transition-shadow">
          <p class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Global Statistic</p>
          <div class="mt-3 space-y-2">
            <div class="h-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full w-full"></div>
            <p class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600"><?php echo esc_html( $default_teacher['satisfaction'] ); ?>%</p>
            <p class="text-xs text-gray-600">Student Satisfaction</p>
          </div>
        </div>

        <!-- Bottom Left Card - Achievements -->
        <div class="absolute -bottom-4 -left-6 bg-white p-6 rounded-2xl shadow-2xl w-56 pointer-events-auto hover:shadow-3xl transition-shadow">
          <p class="text-sm font-bold text-gray-900 mb-3">Latest Achievements</p>
          <div class="space-y-2 text-sm">
            <div class="flex justify-between items-center pb-2 border-b border-gray-100">
              <span class="font-medium text-gray-700"><?php echo esc_html( $default_teacher['achievement1_name'] ); ?></span>
              <span class="text-purple-600 font-bold"><?php echo esc_html( $default_teacher['achievement1_score'] ); ?></span>
            </div>
            <div class="flex justify-between items-center">
              <span class="font-medium text-gray-700"><?php echo esc_html( $default_teacher['achievement2_name'] ); ?></span>
              <span class="text-purple-600 font-bold"><?php echo esc_html( $default_teacher['achievement2_score'] ); ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Content -->
    <div class="text-white space-y-8 text-center md:text-left">
      <div>
        <div class="h-1 w-16 bg-gradient-to-r from-pink-500 to-purple-500 mb-6 mx-auto md:mx-0 rounded-full"></div>
        <h2 class="text-4xl sm:text-5xl font-bold leading-tight">
          <?php echo esc_html( $default_teacher['title'] ); ?>
        </h2>
      </div>

      <p class="text-gray-300 max-w-lg mx-auto md:mx-0 leading-relaxed text-lg">
        <?php echo esc_html( $default_teacher['description'] ); ?>
      </p>

      <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
        <a href="<?php echo esc_url( $default_teacher['btn_url'] ); ?>" class="inline-flex items-center justify-center gap-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-8 py-3 rounded-lg font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200">
          <?php echo esc_html( $default_teacher['btn_text'] ); ?>
          <span class="text-lg">→</span>
        </a>

        <a href="<?php echo esc_url( $default_teacher['btn2_url'] ); ?>" class="inline-flex items-center justify-center gap-3 border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-gray-900 transition-all duration-200">
          <?php echo esc_html( $default_teacher['btn2_text'] ); ?>
        </a>
      </div>
    </div>

        <?php
    }
    ?>
  </div>
</section>



</main><!-- #main -->
</section><!-- #primary -->










<?php
get_footer();
