  const toggleButton = document.getElementById('mobile-menu-toggle');
  const menuWrap = document.getElementById('primary-menu-wrap');

  toggleButton.addEventListener('click', () => {
    menuWrap.classList.toggle('hidden');
    const expanded = toggleButton.getAttribute('aria-expanded') === 'true' || false;
    toggleButton.setAttribute('aria-expanded', !expanded);
  });