
const toggleButton = document.getElementById('mobile-menu-toggle');
  const menuWrap = document.getElementById('primary-menu-wrap');

  toggleButton.addEventListener('click', () => {
    menuWrap.classList.toggle('hidden');
    const expanded = toggleButton.getAttribute('aria-expanded') === 'true' || false;
    toggleButton.setAttribute('aria-expanded', !expanded);
  });




document.addEventListener('DOMContentLoaded', function() {
    const menuLinks = document.querySelectorAll('[data-has-submenu="true"]');

    menuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const parentLi = this.closest('li');
            const submenu = parentLi.querySelector('.submenu');
            const svg = this.querySelector('.submenu-toggle');

            if (submenu) {
                // Toggle visibility classes
                submenu.classList.toggle('opacity-0');
                submenu.classList.toggle('opacity-100');
                submenu.classList.toggle('invisible');
                submenu.classList.toggle('visible');
                
                // Rotate the arrow
                if (svg) {
                    svg.classList.toggle('rotate-180');
                }
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!link.closest('li').contains(e.target)) {
                const submenu = link.closest('li').querySelector('.submenu');
                if (submenu) {
                    submenu.classList.add('opacity-0', 'invisible');
                    submenu.classList.remove('opacity-100', 'visible');
                }
            }
        });
    });
});