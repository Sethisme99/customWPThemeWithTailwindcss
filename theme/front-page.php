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
  
  <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 items-center gap-20 lg:gap-30 relative z-10">
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





<section class="bg-gradient-to-br from-[#1F2B52] to-[#2C3e5a] py-20 lg:py-32 overflow-hidden relative">
  <!-- Decorative background elements -->
  <div class="absolute top-0 right-0 w-96 h-96 bg-purple-500 opacity-5 rounded-full blur-3xl"></div>
  <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-500 opacity-5 rounded-full blur-3xl"></div>
  
  <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 items-center gap-20 lg:gap-32 relative z-10">
<?php
    // Default hardcoded fallback data
    $default_package = array(
        'title' => 'Affordable Packages',
        'description' => 'Problems trying to resolve the conflict between the two major realms of Classical physics: Newtonian mechanics',
        'video_url' => get_template_directory_uri() . '/img/kling_20251207_Image_to_Video__4731_0.mp4',
        'video_poster' => get_template_directory_uri() . '/img/Video card.png',
        'btn_text' => 'View Profiles',
        'btn_url' => '#',
        'accent_color' => '#EF4444'
    );

    $package_args = array(
        'post_type' => 'affordable_package',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    $package_query = new WP_Query( $package_args );

    if ( $package_query->have_posts() ) {
        while ( $package_query->have_posts() ) {
            $package_query->the_post();
            
            $section_title = get_post_meta( get_the_ID(), '_package_section_title', true ) ?: $default_package['title'];
            $description = get_post_meta( get_the_ID(), '_package_description', true ) ?: $default_package['description'];
            $video_id = get_post_meta( get_the_ID(), '_package_video_id', true );
            $video_url = $video_id ? wp_get_attachment_url( $video_id ) : $default_package['video_url'];
            $video_poster = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' )[0] ?? $default_package['video_poster'];
            $btn_text = get_post_meta( get_the_ID(), '_package_btn_text', true ) ?: $default_package['btn_text'];
            $btn_url = get_post_meta( get_the_ID(), '_package_btn_url', true ) ?: $default_package['btn_url'];
            $accent_color = get_post_meta( get_the_ID(), '_package_accent_color', true ) ?: $default_package['accent_color'];
            ?>

    <!-- left Content -->
    <div class="text-white space-y-8 text-center md:text-left">
      <div>
        <div class="h-1 w-16 mb-6 mx-auto md:mx-0 rounded-full" style="background-color: <?php echo esc_attr( $accent_color ); ?>;"></div>
        <h2 class="text-4xl sm:text-5xl font-bold leading-tight">
          <?php echo esc_html( $section_title ); ?>
        </h2>
      </div>

      <p class="text-gray-300 max-w-lg mx-auto md:mx-0 leading-relaxed text-lg">
        <?php echo esc_html( $description ); ?>
      </p>

      <div class="flex justify-center md:justify-start pt-4">
        <a href="<?php echo esc_url( $btn_url ); ?>" class="inline-flex items-center justify-center gap-3 text-[#8D5CF6] font-semibold hover:underline transition-all duration-200">
          <?php echo esc_html( $btn_text ); ?>
        </a>
      </div>
    </div>

    <!-- right Content -->
    <div class="relative flex justify-center items-center">
      <div class="bg-black rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-300 w-full max-w-[500px]">
        <video 
          class="w-full h-auto object-cover rounded-2xl" 
          controls 
          poster="<?php echo esc_url( $video_poster ); ?>">
          <source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
          Your browser does not support the video tag.
        </video>  
      </div>
    </div>

            <?php
        }
        wp_reset_postdata();
    } else {
        ?>
    <!-- left Content -->
    <div class="text-white space-y-8 text-center md:text-left">
      <div>
        <div class="h-1 w-16 mb-6 mx-auto md:mx-0 rounded-full" style="background-color: <?php echo esc_attr( $default_package['accent_color'] ); ?>;"></div>
        <h2 class="text-4xl sm:text-5xl font-bold leading-tight">
          <?php echo esc_html( $default_package['title'] ); ?>
        </h2>
      </div>

      <p class="text-gray-300 max-w-lg mx-auto md:mx-0 leading-relaxed text-lg">
        <?php echo esc_html( $default_package['description'] ); ?>
      </p>

      <div class="flex justify-center md:justify-start pt-4">
        <a href="<?php echo esc_url( $default_package['btn_url'] ); ?>" class="inline-flex items-center justify-center gap-3 text-[#8D5CF6] font-semibold hover:underline transition-all duration-200">
          <?php echo esc_html( $default_package['btn_text'] ); ?>
        </a>
      </div>
    </div>

    <!-- right Content -->
    <div class="relative flex justify-center items-center">
      <!-- Main Image Background -->
      <div class="bg-black rounded-3xl shadow-2xl transform hover:scale-105 transition-transform duration-300 w-full max-w-[500px]">
        <video 
          class="w-full h-auto object-cover rounded-2xl" 
          controls 
          poster="<?php echo esc_url( $default_package['video_poster'] ); ?>">
          <source src="<?php echo esc_url( $default_package['video_url'] ); ?>" type="video/mp4">
          Your browser does not support the video tag.
        </video>  
      </div>
    </div>
    <!-- Same as above but using $default_package -->
        <?php
    }
        ?>
  </div>
</section>



<section class="bg-[#1f2b4d] py-20">
  <div class="max-w-7xl mx-auto px-4">

    <!-- Header -->
    <div class="mb-14">
      <p class="text-purple-400 font-semibold tracking-wide mb-2">
        Practice Advice
      </p>
      <h2 class="text-white text-4xl md:text-5xl font-bold mb-4">
        Our Popular Courses
      </h2>
      <p class="text-slate-300 max-w-lg leading-relaxed">
        Problems trying to resolve the conflict between the two major realms of Classical physics: Newtonian mechanics
      </p>
    </div>

    <!-- Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php
      $course_args = array(
          'post_type'      => 'popular_course',
          'posts_per_page' => 3,
          'orderby'        => 'date',
          'order'          => 'DESC',
      );
      $course_query = new WP_Query( $course_args );

      // Default hardcoded fallback data
      $default_courses = array(
          array(
              'title' => '2,769 online courses',
              'category' => 'For Better Future',
              'rating' => '4.9',
              'description' => 'We focus on ergonomics and meeting you where you work. It\'s only a keystroke away.',
              'sales' => '15',
              'original_price' => '16.48',
              'sale_price' => '6.48',
              'image' => '',
              'url' => '#'
          ),
          array(
              'title' => 'Training Courses',
              'category' => 'Welcome',
              'rating' => '4.9',
              'description' => 'We focus on ergonomics and meeting you where you work. It\'s only a keystroke away.',
              'sales' => '15',
              'original_price' => '16.48',
              'sale_price' => '6.48',
              'image' => '',
              'url' => '#'
          ),
          array(
              'title' => 'Books Library',
              'category' => 'Welcome',
              'rating' => '4.9',
              'description' => 'We focus on ergonomics and meeting you where you work. It\'s only a keystroke away.',
              'sales' => '15',
              'original_price' => '16.48',
              'sale_price' => '6.48',
              'image' => '',
              'url' => '#'
          )
      );

      // Check if database has entries
      if ( $course_query->have_posts() ) {
          // Use database entries
          while ( $course_query->have_posts() ) {
              $course_query->the_post();
              
              $category = get_post_meta( get_the_ID(), '_course_category', true ) ?: 'Course';
              $rating = get_post_meta( get_the_ID(), '_course_rating', true ) ?: '4.9';
              $description = get_post_meta( get_the_ID(), '_course_description', true ) ?: get_the_excerpt();
              $sales_count = get_post_meta( get_the_ID(), '_course_sales', true ) ?: '15';
              $original_price = get_post_meta( get_the_ID(), '_course_original_price', true ) ?: '16.48';
              $sale_price = get_post_meta( get_the_ID(), '_course_sale_price', true ) ?: '6.48';
              $button_url = get_post_meta( get_the_ID(), '_course_button_url', true ) ?: get_permalink();
              $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' )[0] ?? 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f';
              $title = get_the_title();
              ?>

      <div class="bg-white rounded-2xl shadow-xl overflow-hidden group hover:-translate-y-2 transition-all duration-300">
        <div class="relative h-60 overflow-hidden">

          <span class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded z-10">
            Sale
          </span>

          <img
            src="<?php echo esc_url( $image_url ); ?>"
            alt="<?php echo esc_attr( $title ); ?>"
            class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
          />

          <!-- Hover Icons -->
          <div class="absolute inset-0 flex items-center justify-center gap-4 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300">
            <button class="bg-white p-3 rounded-full hover:scale-110 transition">❤️</button>
            <button class="bg-white p-3 rounded-full hover:scale-110 transition">🛒</button>
            <button class="bg-white p-3 rounded-full hover:scale-110 transition">👁</button>
          </div>
        </div>

        <!-- Content -->
        <div class="p-6">
          <div class="flex justify-between items-center mb-3">
            <span class="text-purple-500 font-semibold text-sm"><?php echo esc_html( $category ); ?></span>
            <span class="bg-indigo-900 text-white text-xs px-2 py-1 rounded">⭐ <?php echo esc_html( $rating ); ?></span>
          </div>

          <h3 class="font-bold text-lg mb-2"><?php echo esc_html( $title ); ?></h3>
          <p class="text-gray-500 text-sm leading-relaxed mb-4">
            <?php echo esc_html( $description ); ?>
          </p>

          <div class="flex items-center gap-2 text-gray-500 text-sm mb-4">
            ⬇ <?php echo esc_html( $sales_count ); ?> Sales
          </div>

          <div class="flex items-center gap-3 mb-5">
            <span class="line-through text-gray-400">$<?php echo esc_html( $original_price ); ?></span>
            <span class="text-orange-500 font-bold">$<?php echo esc_html( $sale_price ); ?></span>
          </div>

          <a href="<?php echo esc_url( $button_url ); ?>" class="border border-purple-500 text-purple-500 px-5 py-2 rounded-full font-semibold hover:bg-purple-500 hover:text-white transition inline-block">
            Learn More →
          </a>
        </div>
      </div>

              <?php
          }
          wp_reset_postdata();
      } else {
          // Use hardcoded defaults if no database entries
          foreach ( $default_courses as $course ) {
              ?>

      <div class="bg-white rounded-2xl shadow-xl overflow-hidden group hover:-translate-y-2 transition-all duration-300">
        <div class="relative h-60 overflow-hidden">

          <span class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded z-10">
            Sale
          </span>

          <img
            src="<?php echo esc_url( $course['image'] ); ?>"
            alt="<?php echo esc_attr( $course['title'] ); ?>"
            class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
          />

          <!-- Hover Icons -->
          <div class="absolute inset-0 flex items-center justify-center gap-4 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300">
            <button class="bg-white p-3 rounded-full hover:scale-110 transition">❤️</button>
            <button class="bg-white p-3 rounded-full hover:scale-110 transition">🛒</button>
            <button class="bg-white p-3 rounded-full hover:scale-110 transition">👁</button>
          </div>
        </div>

        <!-- Content -->
        <div class="p-6">
          <div class="flex justify-between items-center mb-3">
            <span class="text-purple-500 font-semibold text-sm"><?php echo esc_html( $course['category'] ); ?></span>
            <span class="bg-indigo-900 text-white text-xs px-2 py-1 rounded">⭐ <?php echo esc_html( $course['rating'] ); ?></span>
          </div>

          <h3 class="font-bold text-lg mb-2"><?php echo esc_html( $course['title'] ); ?></h3>
          <p class="text-gray-500 text-sm leading-relaxed mb-4">
            <?php echo esc_html( $course['description'] ); ?>
          </p>

          <div class="flex items-center gap-2 text-gray-500 text-sm mb-4">
            ⬇ <?php echo esc_html( $course['sales'] ); ?> Sales
          </div>

          <div class="flex items-center gap-3 mb-5">
            <span class="line-through text-gray-400">$<?php echo esc_html( $course['original_price'] ); ?></span>
            <span class="text-orange-500 font-bold">$<?php echo esc_html( $course['sale_price'] ); ?></span>
          </div>

          <a href="<?php echo esc_url( $course['url'] ); ?>" class="border border-purple-500 text-purple-500 px-5 py-2 rounded-full font-semibold hover:bg-purple-500 hover:text-white transition inline-block">
            Learn More →
          </a>
        </div>
      </div>

              <?php
          }
      }
      ?>
    </div>
  </div>
</section>




<section class="bg-[#1f2b4d] py-24">
  <div class="max-w-7xl mx-auto px-4">

    <!-- Header -->
    <div class="mb-16 max-w-xl">
      <p class="text-purple-400 font-semibold tracking-wide mb-2">
        Practice Advice
      </p>
      <h2 class="text-white text-4xl md:text-5xl font-bold mb-4">
        Affordable Packages
      </h2>
      <p class="text-slate-300 leading-relaxed">
        Problems trying to resolve the conflict between the two major realms of Classical physics: Newtonian mechanics
      </p>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
      <?php
      // Default hardcoded testimonials
      $default_testimonials = array(
          array(
              'rating' => 4,
              'content' => 'Slate helps you see how many more days you need to work to reach your financial goal for the month and year.',
              'author_name' => 'Regina Miles',
              'author_role' => 'Designer',
              'image' => 'https://randomuser.me/api/portraits/men/32.jpg'
          ),
          array(
              'rating' => 4,
              'content' => 'Slate helps you see how many more days you need to work to reach your financial goal for the month and year.',
              'author_name' => 'Regina Miles',
              'author_role' => 'Designer',
              'image' => 'https://randomuser.me/api/portraits/women/44.jpg'
          ),
          array(
              'rating' => 4,
              'content' => 'Slate helps you see how many more days you need to work to reach your financial goal for the month and year.',
              'author_name' => 'Regina Miles',
              'author_role' => 'Designer',
              'image' => 'https://randomuser.me/api/portraits/women/65.jpg'
          )
      );

      $testimonial_args = array(
          'post_type' => 'testimonial',
          'posts_per_page' => 3,
          'orderby' => 'date',
          'order' => 'DESC'
      );
      $testimonial_query = new WP_Query( $testimonial_args );

      // Use database entries if they exist, otherwise use defaults
      if ( $testimonial_query->have_posts() ) {
          while ( $testimonial_query->have_posts() ) {
              $testimonial_query->the_post();
              
              $rating = get_post_meta( get_the_ID(), '_testimonial_rating', true ) ?: 4;
              $content = get_post_meta( get_the_ID(), '_testimonial_content', true );
              $author_name = get_post_meta( get_the_ID(), '_testimonial_author_name', true );
              $author_role = get_post_meta( get_the_ID(), '_testimonial_author_role', true );
              $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' )[0] ?? 'https://randomuser.me/api/portraits/men/1.jpg';
              
              // Generate star display
              $stars = str_repeat( '★ ', $rating ) . str_repeat( '☆ ', 5 - $rating );
              ?>

      <div class="bg-white rounded-xl p-10 text-center shadow-md">
        <!-- Stars -->
        <div class="flex justify-center mb-6 text-yellow-400 text-xl">
          <?php echo esc_html( trim( $stars ) ); ?>
        </div>

        <!-- Text -->
        <p class="text-gray-600 leading-relaxed mb-10">
          <?php echo esc_html( $content ); ?>
        </p>

        <!-- Profile -->
        <div class="flex items-center justify-center gap-4">
          <img
            src="<?php echo esc_url( $image_url ); ?>"
            alt="<?php echo esc_attr( $author_name ); ?>"
            class="w-12 h-12 rounded-full object-cover"
            width="48"
            height="48"
            loading="lazy"
          />
          <div class="text-left">
            <p class="text-purple-600 font-semibold"><?php echo esc_html( $author_name ); ?></p>
            <p class="text-gray-500 text-sm"><?php echo esc_html( $author_role ); ?></p>
          </div>
        </div>
      </div>

              <?php
          }
          wp_reset_postdata();
      } else {
          // Display default testimonials
          foreach ( $default_testimonials as $testimonial ) {
              $stars = str_repeat( '★ ', $testimonial['rating'] ) . str_repeat( '☆ ', 5 - $testimonial['rating'] );
              ?>

      <div class="bg-white rounded-xl p-10 text-center shadow-md">
        <!-- Stars -->
        <div class="flex justify-center mb-6 text-yellow-400 text-xl">
          <?php echo esc_html( trim( $stars ) ); ?>
        </div>

        <!-- Text -->
        <p class="text-gray-600 leading-relaxed mb-10">
          <?php echo esc_html( $testimonial['content'] ); ?>
        </p>

        <!-- Profile -->
        <div class="flex items-center justify-center gap-4">
          <img
            src="<?php echo esc_url( $testimonial['image'] ); ?>"
            alt="<?php echo esc_attr( $testimonial['author_name'] ); ?>"
            class="w-12 h-12 rounded-full object-cover"
            width="48"
            height="48"
            loading="lazy"
          />
          <div class="text-left">
            <p class="text-purple-600 font-semibold"><?php echo esc_html( $testimonial['author_name'] ); ?></p>
            <p class="text-gray-500 text-sm"><?php echo esc_html( $testimonial['author_role'] ); ?></p>
          </div>
        </div>
      </div>

              <?php
          }
      }
      ?>
    </div>
  </div>
</section>



<section class="bg-indigo-950 px-6 py-20">
    <div class="mx-auto max-w-3xl text-center text-white">

        <!-- Label -->
        <p class="mb-3 text-sm uppercase tracking-widest text-purple-400">
            Newsletter
        </p>

        <!-- Title -->
        <h2 class="mb-4 text-3xl font-bold sm:text-4xl">
            Every Client Matters
        </h2>

        <!-- Description -->
        <p class="mx-auto mb-8 max-w-xl text-sm text-indigo-200 sm:text-base">
            Problems trying to resolve the conflict between the two major
            realms of classical physics: Newtonian mechanics
        </p>

        <!-- Form -->
        <form id="newsletter-form" class="flex flex-col items-center gap-3 sm:flex-row">
            <input
                type="email"
                id="newsletter-email"
                placeholder="Your Email"
                required
                class="w-full flex-1 rounded-md px-4 py-3 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500"
            />

            <button
                type="submit"
                id="newsletter-btn"
                class="w-full rounded-md bg-purple-600 px-6 py-3 font-semibold text-white transition hover:bg-purple-700 sm:w-auto"
            >
                Subscribe
            </button>
        </form>

        <div id="newsletter-message" style="margin-top: 15px; display: none;"></div>
    </div>
</section>

<script>
document.getElementById('newsletter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('newsletter-email').value;
    const btn = document.getElementById('newsletter-btn');
    const msg = document.getElementById('newsletter-message');

    btn.disabled = true;
    btn.textContent = 'Subscribing...';

    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=newsletter_subscribe&email=' + encodeURIComponent(email)
    })
    .then(r => r.json())
    .then(data => {
        msg.style.display = 'block';
        msg.style.color = data.success ? '#10b981' : '#ef4444';
        msg.textContent = data.message;
        
        if (data.success) {
            document.getElementById('newsletter-email').value = '';
        }
        btn.disabled = false;
        btn.textContent = 'Subscribe';
    });
});
</script>






</main><!-- #main -->
</section><!-- #primary -->










<?php
get_footer();
