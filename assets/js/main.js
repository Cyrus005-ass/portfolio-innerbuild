document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const hasGSAP = typeof window.gsap !== 'undefined';
    const hasScrollTrigger = typeof window.ScrollTrigger !== 'undefined';
const qs = (selector, scope = document) => scope.querySelector(selector);
    const qsa = (selector, scope = document) => Array.from(scope.querySelectorAll(selector));

    const loader = qs('.loading-container');
    const words = qsa('.loading-words h2');
    const menuButton = qs('.menu-toggle');
    const navLinks = qs('.nav-links');
    const lightbox = qs('#lightbox');
    const lightboxImg = qs('#lightbox-img');
    const lightboxTitle = qs('#lightbox-title');
    const lightboxLink = qs('#lightbox-link');
    const lightboxClose = qs('.lightbox-close', lightbox || document);

    const splitTargets = qsa('.js-split-text');
    const animatedSelectors = [
        '.about-text-container',
        '.skill-category',
        '.project-card',
        '.cert-project-card',
        '.contact-form-wrapper',
        '.contact-direct',
    ];

    const animatedElements = animatedSelectors.flatMap((selector) => qsa(selector));
    animatedElements.forEach((el) => el.setAttribute('data-animate', ''));

    const initSplitText = () => {
        splitTargets.forEach((el) => {
            if (el.dataset.splitReady === '1') return;

            const text = (el.textContent || '').trim().replace(/\s+/g, ' ');
            if (!text) return;

            const wordsArr = text.split(' ');
            el.textContent = '';

            wordsArr.forEach((word, index) => {
                const wrap = document.createElement('span');
                wrap.className = 'split-word-wrap';

                const inner = document.createElement('span');
                inner.className = 'split-word';
                inner.textContent = word;

                wrap.appendChild(inner);
                el.appendChild(wrap);

                if (index < wordsArr.length - 1) {
                    el.appendChild(document.createTextNode(' '));
                }
            });

            el.dataset.splitReady = '1';
        });
    };

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
                    body.style.overflow = '';
                    initMotion();
                },
            });
            return;
        }

        window.setTimeout(() => {
            loader.style.display = 'none';
            body.style.overflow = '';
            initMotion();
        }, 700);
    };

    const playLoader = () => {
        if (!loader) {
            initMotion();
            return;
        }

        body.style.overflow = 'hidden';

        if (!hasGSAP || words.length === 0) {
            hideLoader();
            return;
        }

        let index = 0;
        const animateWord = () => {
            if (index >= words.length) {
                hideLoader();
                return;
            }

            const word = words[index];
            window.gsap
                .timeline({ onComplete: animateWord })
                .fromTo(word, { opacity: 0, y: 24 }, { opacity: 1, y: 0, duration: 0.18, ease: 'power2.out' })
                .to(word, { opacity: 0, y: -24, duration: 0.18, delay: index === words.length - 1 ? 0.25 : 0.08, ease: 'power2.in' });
            index += 1;
        };

        animateWord();
    };

    const setMenuOpen = (isOpen) => {
        if (!menuButton || !navLinks) return;

        menuButton.classList.toggle('active', isOpen);
        navLinks.classList.toggle('active', isOpen);
        menuButton.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        body.style.overflow = isOpen ? 'hidden' : '';

        if (hasGSAP && isOpen) {
            window.gsap.fromTo(
                qsa('a', navLinks),
                { opacity: 0, y: 18 },
                { opacity: 1, y: 0, duration: 0.36, stagger: 0.06, ease: 'power3.out' }
            );
        }
    };

    if (menuButton && navLinks) {
        menuButton.addEventListener('click', () => {
            setMenuOpen(!navLinks.classList.contains('active'));
        });

        qsa('a', navLinks).forEach((link) => {
            link.addEventListener('click', () => setMenuOpen(false));
        });
    }

    qsa('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', (event) => {
            const href = anchor.getAttribute('href');
            if (!href || href === '#') return;

            const target = qs(href);
            if (!target) return;

            event.preventDefault();
            const header = qs('.main-header');
            const topOffset = header ? header.offsetHeight : 0;
            const destination = target.getBoundingClientRect().top + window.pageYOffset - topOffset + 4;
            window.scrollTo({ top: Math.max(0, destination), behavior: 'smooth' });
        });
    });

    const initFallbackReveal = () => {
        const io = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-inview');
                        io.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.18, rootMargin: '0px 0px -10% 0px' }
        );

        animatedElements.forEach((el) => io.observe(el));
    };

    const initMagnetic = () => {
        qsa('.magnetic').forEach((root) => {
            const inner = root.querySelector('.magnetic-inner') || root;

            root.addEventListener('mousemove', (event) => {
                const rect = root.getBoundingClientRect();
                const x = event.clientX - rect.left - rect.width / 2;
                const y = event.clientY - rect.top - rect.height / 2;

                if (hasGSAP) {
                    window.gsap.to(inner, {
                        x: x * 0.16,
                        y: y * 0.16,
                        duration: 0.26,
                        ease: 'power3.out',
                    });
                }
            });

            root.addEventListener('mouseleave', () => {
                if (hasGSAP) {
                    window.gsap.to(inner, { x: 0, y: 0, duration: 0.34, ease: 'elastic.out(1, 0.45)' });
                }
            });
        });
    };

    const initGsapMotion = () => {
        if (!hasGSAP || !hasScrollTrigger) {
            initFallbackReveal();
            return;
        }

        window.gsap.registerPlugin(window.ScrollTrigger);

        const heroTl = window.gsap.timeline();
        heroTl
            .from('.main-header', { y: -24, opacity: 0, duration: 0.45, ease: 'power2.out' })
            .from('.hero-role', { y: 44, opacity: 0, duration: 0.62, ease: 'power3.out' }, '-=0.1')
            .from('.hero-location', { y: 44, opacity: 0, duration: 0.62, ease: 'power3.out' }, '-=0.45')
            .from('.hero-big-text', { yPercent: 35, opacity: 0, duration: 0.72, ease: 'power3.out' }, '-=0.4');

        const splitWords = qsa('.split-word');
        if (splitWords.length > 0) {
            window.gsap.set(splitWords, { yPercent: 120, opacity: 0 });
            splitTargets.forEach((block) => {
                const localWords = qsa('.split-word', block);
                if (localWords.length === 0) return;

                window.gsap.to(localWords, {
                    yPercent: 0,
                    opacity: 1,
                    duration: 0.7,
                    stagger: 0.03,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: block,
                        start: 'top 82%',
                        once: true,
                    },
                });
            });
        }

        window.gsap.to('.hero-bg-full img', {
            yPercent: 8,
            ease: 'none',
            scrollTrigger: {
                trigger: '#hero',
                start: 'top top',
                end: 'bottom top',
                scrub: true,
            },
        });

        animatedElements.forEach((el, index) => {
            window.gsap.fromTo(
                el,
                { opacity: 0, y: 36 },
                {
                    opacity: 1,
                    y: 0,
                    duration: 0.7,
                    ease: 'power3.out',
                    delay: (index % 3) * 0.04,
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 86%',
                        once: true,
                    },
                }
            );
        });

        qsa('.project-card, .cert-project-card').forEach((card) => {
            const image = qs('img', card);
            if (!image) return;

            window.gsap.to(image, {
                yPercent: -7,
                ease: 'none',
                scrollTrigger: {
                    trigger: card,
                    start: 'top bottom',
                    end: 'bottom top',
                    scrub: true,
                },
            });
        });
    };

    const closeLightbox = () => {
        if (!lightbox) return;

        const finalize = () => {
            lightbox.style.display = 'none';
            lightbox.setAttribute('aria-hidden', 'true');
            if (lightboxImg) lightboxImg.src = '';
            if (lightboxLink) {
                lightboxLink.style.display = 'none';
                lightboxLink.removeAttribute('href');
            }
            body.style.overflow = '';
        };

        if (hasGSAP) {
            window.gsap.to('.lightbox-content', { scale: 0.95, opacity: 0, duration: 0.22, ease: 'power2.in' });
            window.gsap.to(lightbox, { opacity: 0, duration: 0.2, onComplete: finalize });
            return;
        }

        finalize();
    };

    const openLightboxInternal = (src, title = '', link = '') => {
        if (!lightbox || !lightboxImg || !src) return;

        lightboxImg.src = src;
        lightbox.style.display = 'flex';
        lightbox.style.opacity = '1';
        lightbox.setAttribute('aria-hidden', 'false');

        if (lightboxTitle) {
            lightboxTitle.textContent = title || 'Certification';
        }

        if (lightboxLink) {
            if (link) {
                lightboxLink.href = link;
                lightboxLink.style.display = 'inline';
            } else {
                lightboxLink.style.display = 'none';
            }
        }

        body.style.overflow = 'hidden';

        if (hasGSAP) {
            window.gsap.fromTo(lightbox, { opacity: 0 }, { opacity: 1, duration: 0.2 });
            window.gsap.fromTo('.lightbox-content', { y: 28, scale: 0.96, opacity: 0 }, { y: 0, scale: 1, opacity: 1, duration: 0.3, ease: 'power3.out' });
        }
    };

    window.openLightbox = (src, title = '', link = '') => {
        openLightboxInternal(src, title, link);
    };

    qsa('.cert-image-zoom').forEach((img) => {
        img.addEventListener('click', () => {
            openLightboxInternal(img.currentSrc || img.src, img.dataset.title || img.alt || 'Certification', img.dataset.link || '');
        });
    });

    if (lightboxClose) {
        lightboxClose.addEventListener('click', closeLightbox);
    }

    if (lightbox) {
        lightbox.addEventListener('click', (event) => {
            if (event.target === lightbox) closeLightbox();
        });
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeLightbox();
    });

    const initMotion = () => {
        initSplitText();
        initMagnetic();
        initGsapMotion();
    };

    window.addEventListener('load', playLoader);
    if (document.readyState === 'complete') {
        playLoader();
    }
});


