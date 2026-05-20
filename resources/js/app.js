const setupNavShadow = () => {
    const nav = document.querySelector('[data-nav]');
    if (!nav) {
        return;
    }

    const handler = () => {
        if (window.scrollY > 80) {
            nav.classList.add('shadow-xl', 'shadow-black/10');
        } else {
            nav.classList.remove('shadow-xl', 'shadow-black/10');
        }
    };

    handler();
    window.addEventListener('scroll', handler, { passive: true });
};

const setupToggle = (triggerSelector, targetSelector) => {
    const trigger = document.querySelector(triggerSelector);
    const target = document.querySelector(targetSelector);
    if (!trigger || !target) {
        return;
    }

    trigger.addEventListener('click', () => {
        target.classList.toggle('hidden');
    });
};

const initSwiperWhenReady = (selector, options, attemptsLeft = 10) => {
    const slider = document.querySelector(selector);
    if (!slider) {
        return;
    }

    if (typeof Swiper === 'undefined') {
        if (attemptsLeft <= 0) {
            return;
        }
        setTimeout(() => initSwiperWhenReady(selector, options, attemptsLeft - 1), 200);
        return;
    }

    new Swiper(slider, options);
};

const setupHeroSlider = () => {
    initSwiperWhenReady('.hero-swiper', {
        loop: true,
        speed: 900,
        effect: 'fade',
        autoplay: {
            delay: 7000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.hero-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.hero-next',
            prevEl: '.hero-prev',
        },
    });
};

const setupTourGallery = () => {
    initSwiperWhenReady('.tour-gallery-swiper', {
        loop: true,
        speed: 700,
        slidesPerView: 1,
        pagination: {
            el: '.tour-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.tour-next',
            prevEl: '.tour-prev',
        },
    });
};

document.addEventListener('DOMContentLoaded', () => {
    setupNavShadow();
    setupToggle('[data-search-trigger]', '[data-search-overlay]');
    setupToggle('[data-mobile-trigger]', '[data-mobile-menu]');
    setupHeroSlider();
    setupTourGallery();
});
