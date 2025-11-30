<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package raseth
 */

?>

<header id="masthead" class="mb-5">

<nav id="site-navigation" class="bg-[#2C799A]">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

    <!-- Logo -->
    <a href="<?php echo home_url(); ?>" class="flex items-center space-x-3 rtl:space-x-reverse">
		<h1 class="text-white font-bold text-2xl">BrandName</h1>
    </a>

    <!-- Buttons / Mobile Toggle -->
    <div class="inline-flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

	  <button type="button" class="text-white bg-transparent box-border border border-transparent focus:underline shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none cursor-pointer">
        Login
      </button>

      <button type="button" class="text-white bg-purple-500 hover:bg-purple-600 box-border border border-transparent focus:bg-purple-400 shadow-xs font-medium leading-5 rounded-base text-sm px-3 py-2 focus:outline-none cursor-pointer">
        Join Us
      </button>

      <button id="mobile-menu-toggle" type="button" class="inline-flex items-center p-2 w-9 h-9 justify-center text-sm text-body rounded-base md:hidden hover:text-heading text-[#ffff] focus:outline-none cursor-pointer hover:text-purple-300" aria-controls="primary-menu-wrap" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>

    <!-- Menu -->
    <div id="primary-menu-wrap" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
      <?php
        wp_nav_menu([
          'theme_location' => 'menu-1',
          'menu_id'        => 'primary-menu',
          'container'      => false,
          'menu_class'     => 'font-medium text-[#FFFFFF] flex flex-col p-4 md:p-0 mt-4 rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 md:mt-0 md:border-0',
          'fallback_cb'    => false,
        ]);
      ?>
    </div>

  </div>
</nav>

</header><!-- #masthead -->


