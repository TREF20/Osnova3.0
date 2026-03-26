document.addEventListener('DOMContentLoaded', () => {
    // Плавный скролл
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', e => {
            e.preventDefault();
            document.querySelector(anchor.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Анимация карточек и категорий
    const elements = document.querySelectorAll('.product-card, .category-card');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.2 });

    elements.forEach(el => {
        el.classList.add('animate-on-scroll');
        observer.observe(el);
    });

    // Glow-эффект на кнопках
    document.querySelectorAll('.add-to-cart-btn, .hero-btn').forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            btn.style.boxShadow = '0 0 40px rgba(201, 76, 109, 0.5)';
            btn.style.transform = 'scale(1.08) translateY(-6px)';
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.boxShadow = '0 8px 32px rgba(201,76,109,0.3)';
            btn.style.transform = 'scale(1) translateY(0)';
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.gallery-slide');
    const thumbs = document.querySelectorAll('.thumb-item');

    if (thumbs.length > 0) {
        thumbs.forEach(thumb => {
            thumb.addEventListener('click', () => {
                const index = thumb.dataset.index;

                // Убираем активность со всех
                thumbs.forEach(t => t.classList.remove('active'));
                slides.forEach(s => s.classList.remove('active'));

                // Активируем выбранные
                thumb.classList.add('active');
                slides[index].classList.add('active');
            });
        });
    }
});