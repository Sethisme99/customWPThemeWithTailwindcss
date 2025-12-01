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

      <button type="button" class=" w-full flex justify-center items-center gap-2 rounded-sm bg-purple-500 hover:bg-purple-600 focus:bg-purple-400 shadow-xs px-1 py-1 focus:outline-none cursor-pointer lg:px-2 lg:py-2">
        <p class="font-bold leading-5 text-sm text-white">JOIN US</p>

        <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 5C0 4.81059 0.079009 4.62895 0.219646 4.49502C0.360282 4.36109 0.551026 4.28584 0.749916 4.28584H9.43845L6.21831 1.22068C6.07749 1.08658 5.99838 0.904705 5.99838 0.715059C5.99838 0.525414 6.07749 0.343536 6.21831 0.209436C6.35912 0.0753365 6.5501 0 6.74925 0C6.94839 0 7.13937 0.0753365 7.28019 0.209436L11.7797 4.49438C11.8495 4.56072 11.9049 4.63952 11.9427 4.72629C11.9805 4.81305 12 4.90606 12 5C12 5.09394 11.9805 5.18695 11.9427 5.27371C11.9049 5.36048 11.8495 5.43928 11.7797 5.50562L7.28019 9.79056C7.13937 9.92466 6.94839 10 6.74925 10C6.5501 10 6.35912 9.92466 6.21831 9.79056C6.07749 9.65646 5.99838 9.47459 5.99838 9.28494C5.99838 9.0953 6.07749 8.91342 6.21831 8.77932L9.43845 5.71416H0.749916C0.551026 5.71416 0.360282 5.63892 0.219646 5.50499C0.079009 5.37106 0 5.18941 0 5Z" fill="white"/>
        </svg>

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
          'menu_class'     => 'font-medium text-[#FFFFFF] flex flex-col p-0 md:p-0 mt-4 gap-5 rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 md:mt-0 md:border-0 md:gap-0 lg:gap-0',
          'fallback_cb'    => false,
          'walker'         => new Tailwind_Dropdown_Walker(),
        ]);
      ?>
    </div>

  </div>
</nav>

</header><!-- #masthead -->


