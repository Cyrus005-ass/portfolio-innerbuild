document.addEventListener('DOMContentLoaded', () => {
    // INIT
    const hasGSAP = typeof window.gsap !== 'undefined';
    const hasScrollTrigger = typeof window.ScrollTrigger !== 'undefined';
    const body = document.body;
    let isNavAnimating = false;

    const qs = (selector, scope = document) => scope.querySelector(selector);
    const qsa = (selector, scope = document) => Array.from(scope.querySelectorAll(selector));

    const ensureNavTransitionLayer = () => {
        let layer = qs('.nav-transition-layer');
        if (layer) return layer;

        layer = document.createElement('div');
        layer.className = 'nav-transition-layer';
        layer.innerHTML = '<span class="nav-transition-blob blob-a"></span><span class="nav-transition-blob blob-b"></span><span class="nav-transition-blob blob-c"></span>';
        document.body.appendChild(layer);
        return layer;
    };

    const smoothScrollToTarget = (target) => {
        if (!target) return;

        const header = qs('.main-header');
        const headerOffset = header ? header.offsetHeight : 0;
        const targetTop = target.getBoundingClientRect().top + window.pageYOffset - headerOffset + 4;

        window.scrollTo({
            top: Math.max(0, targetTop),
            behavior: 'smooth'
        });
    };

    const runNavTransition = (callback) => {
        if (isNavAnimating) return;
        isNavAnimating = true;

        const layer = ensureNavTransitionLayer();
        const blobs = qsa('.nav-transition-blob', layer);

        if (hasGSAP) {
            window.gsap.killTweensOf(layer);
            window.gsap.set(layer, { autoAlpha: 1, scale: 1, clipPath: 'circle(0% at 50% 50%)' });
            window.gsap.set(blobs, { scale: 0, yPercent: 40, opacity: 0 });

            const tl = window.gsap.timeline({
                onComplete: () => {
                    window.gsap.set(layer, { autoAlpha: 0, clipPath: 'circle(0% at 50% 50%)' });
                    isNavAnimating = false;
                }
            });

            tl.to(layer, {
                clipPath: 'circle(140% at 50% 50%)',
                duration: 0.42,
                ease: 'power3.out'
            })
            .to(blobs, {
                scale: 1,
                yPercent: 0,
                opacity: 1,
                duration: 0.22,
                stagger: 0.05,
                ease: 'back.out(2.5)'
            }, '-=0.2')
            .add(() => callback(), '>-0.02')
            .to(blobs, {
                scale: 0.72,
                opacity: 0,
                yPercent: -25,
                duration: 0.24,
                stagger: 0.04,
                ease: 'power2.in'
            }, '+=0.06')
            .to(layer, {
                clipPath: 'circle(0% at 50% 50%)',
                duration: 0.34,
                ease: 'power2.inOut'
            }, '-=0.08');
            return;
        }

        layer.classList.add('is-active', 'is-fun');
        window.setTimeout(() => {
            callback();
            layer.classList.remove('is-active', 'is-fun');
            isNavAnimating = false;
        }, 520);
    };

    // LOADER
    const loader = qs('.loader') || qs('.loading-container');
    const loadingWords = qsa('.loading-words h2', loader || document);

    const hideLoader = () => {
        if (!loader) return;

        loader.classList.add('hide');

        if (hasGSAP) {
            window.gsap.to(loader, {
                opacity: 0,
                yPercent: -100,
                duration: 0.8,
                ease: 'power3.inOut',
                onComplete: () => {
                    loader.style.display = 'none';
                    if (body) body.style.overflow = '';
                }
            });
        } else {
            setTimeout(() => {
                loader.style.display = 'none';
                if (body) body.style.overflow = '';
            }, 700);
        }
    };

    const runLoader = () => {
        if (!loader) return;
        if (body) body.style.overflow = 'hidden';

        if (!hasGSAP || loadingWords.length === 0) {
            hideLoader();
            return;
        }

        let index = 0;

        const playWord = () => {
            if (index >= loadingWords.length) {
                hideLoader();
                return;
            }

            const word = loadingWords[index];

            window.gsap.timeline({ onComplete: playWord })
                .fromTo(word, { opacity: 0, y: 30 }, { opacity: 1, y: 0, duration: 0.16, ease: 'power2.out' })
                .to(word, { opacity: 0, y: -28, duration: 0.16, delay: index === loadingWords.length - 1 ? 0.25 : 0.08, ease: 'power2.in' });

            index += 1;
        };

        playWord();
    };

    window.addEventListener('load', runLoader);

    // MENU
    const menuBtn = qs('.menu-btn') || qs('.menu-toggle');
    const menuOverlay = qs('.menu-overlay') || qs('.nav-links');
    const menuItems = menuOverlay ? qsa('a', menuOverlay) : [];

    const isMenuOpen = () => {
        if (!menuOverlay) return false;
        return menuOverlay.classList.contains('open') || menuOverlay.classList.contains('active');
    };

    const setMenuState = (open) => {
        if (!menuOverlay || !menuBtn) return;

        menuOverlay.classList.toggle('open', open);
        menuOverlay.classList.toggle('active', open);
        menuBtn.classList.toggle('open', open);
        menuBtn.classList.toggle('active', open);
        menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');

        if (body) body.style.overflow = open ? 'hidden' : '';

        if (open && hasGSAP && menuItems.length > 0) {
            window.gsap.fromTo(menuItems, { y: 18, opacity: 0 }, { y: 0, opacity: 1, duration: 0.35, stagger: 0.08, ease: 'power2.out' });
        }
    };

    if (menuBtn && menuOverlay) {
        menuBtn.addEventListener('click', () => {
            setMenuState(!isMenuOpen());
        });

        menuItems.forEach((item) => {
            item.addEventListener('click', () => setMenuState(false));
        });
    }

    // SCROLL
    qsa('a[href^="#"]').forEach((link) => {
        link.addEventListener('click', (event) => {
            const href = link.getAttribute('href');
            if (!href || href === '#') return;

            const target = qs(href);
            if (!target) return;

            event.preventDefault();

            runNavTransition(() => {
                smoothScrollToTarget(target);
            });
        });
    });

    // ANIMATIONS GSAP
    if (hasGSAP && hasScrollTrigger) {
        window.gsap.registerPlugin(window.ScrollTrigger);

        const heroElements = qsa('.hero h1, .hero p');
        if (heroElements.length > 0) {
            window.gsap.from(heroElements, {
                opacity: 0,
                y: 40,
                duration: 0.9,
                stagger: 0.15,
                ease: 'power3.out'
            });
        }

        qsa('section').forEach((section) => {
            window.gsap.fromTo(section, {
                opacity: 0,
                y: 80
            }, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: section,
                    start: 'top 82%'
                }
            });
        });

        qsa('.parallax').forEach((item) => {
            window.gsap.to(item, {
                y: -80,
                ease: 'none',
                scrollTrigger: {
                    trigger: item,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true
                }
            });
        });
    }

    // HOVER INTERACTIONS
    qsa('.card').forEach((card) => {
        card.addEventListener('mouseenter', () => {
            if (hasGSAP) {
                window.gsap.to(card, { scale: 1.03, duration: 0.25, ease: 'power2.out' });
            } else {
                card.style.transform = 'scale(1.03)';
            }
        });

        card.addEventListener('mouseleave', () => {
            if (hasGSAP) {
                window.gsap.to(card, { scale: 1, duration: 0.25, ease: 'power2.out' });
            } else {
                card.style.transform = 'scale(1)';
            }
        });
    });

    // LIGHTBOX
    const lightbox = qs('.lightbox');
    const lightboxImg = qs('.lightbox img', lightbox || document);
    const lightboxTitle = qs('.lightbox-title', lightbox || document) || qs('#lightbox-title', lightbox || document);
    const lightboxLink = qs('.lightbox-link', lightbox || document) || qs('#lightbox-link', lightbox || document);
    const lightboxClose = qs('.lightbox-close', lightbox || document);

    const closeLightbox = () => {
        if (!lightbox) return;
        lightbox.style.display = 'none';
        lightbox.setAttribute('aria-hidden', 'true');
        if (lightboxImg) lightboxImg.src = '';
        if (lightboxLink) {
            lightboxLink.style.display = 'none';
            lightboxLink.removeAttribute('href');
        }
        if (body) body.style.overflow = '';
    };

    const openLightboxInternal = (src, title = '', link = '') => {
        if (!lightbox || !lightboxImg || !src) return;

        lightboxImg.src = src;
        lightbox.style.display = 'flex';
        lightbox.setAttribute('aria-hidden', 'false');

        if (lightboxTitle) {
            lightboxTitle.textContent = title || 'Certification';
        }

        if (lightboxLink) {
            if (link) {
                lightboxLink.setAttribute('href', link);
                lightboxLink.style.display = 'inline';
            } else {
                lightboxLink.style.display = 'none';
                lightboxLink.removeAttribute('href');
            }
        }

        if (body) body.style.overflow = 'hidden';
    };

    window.openLightbox = (src, title = '', link = '') => {
        openLightboxInternal(src, title, link);
    };

    qsa('.cert-card img, .cert-item img, .cert-image-zoom').forEach((img) => {
        img.addEventListener('click', (event) => {
            event.preventDefault();

            const certRoot = img.closest('.cert-card, .cert-item') || img.parentElement;
            const certTitle = img.dataset.title || qs('h3, h4', certRoot || document)?.textContent?.trim() || img.alt || 'Certification';
            const certLink = img.dataset.link || qs('a[href^="http"]', certRoot || document)?.getAttribute('href') || '';
            const src = img.dataset.full || img.currentSrc || img.src;

            openLightboxInternal(src, certTitle, certLink);
        });
    });

    if (lightboxClose) {
        lightboxClose.addEventListener('click', closeLightbox);
    }

    if (lightbox) {
        lightbox.addEventListener('click', (event) => {
            if (event.target === lightbox) {
                closeLightbox();
            }
        });
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeLightbox();
        }
    });
});
