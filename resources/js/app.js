const scrollRoot = document.querySelector('[data-scroll-root]');
const topbar = document.querySelector('[data-topbar]');

if (scrollRoot && topbar) {
    const update = () => topbar.toggleAttribute('data-scrolled', scrollRoot.scrollTop > 40);
    scrollRoot.addEventListener('scroll', update, { passive: true });
    update();
}

document.addEventListener('click', (event) => {
    const button = event.target.closest('[data-history]');
    if (!button) return;
    button.dataset.history === 'back' ? history.back() : history.forward();
});
