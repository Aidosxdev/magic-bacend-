document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();

    // 1. Dark / Light Mode Toggle (localStorage bilan)
    const html = document.documentElement;
    const themeToggle = document.getElementById('themeToggle');
    const savedTheme = localStorage.getItem('mm-theme');

    if (savedTheme === 'light') {
        html.classList.remove('dark');
    } else {
        html.classList.add('dark');
    }

    themeToggle?.addEventListener('click', () => {
        html.classList.toggle('dark');
        localStorage.setItem('mm-theme', html.classList.contains('dark') ? 'dark' : 'light');
    });

    // 2. Hero Slider Auto-play
    let currentSlide = 0;
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');

    window.setHeroSlide = (index) => {
        currentSlide = index;
        slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
                slide.classList.add('opacity-100', 'z-10');
            } else {
                slide.classList.add('opacity-0', 'z-0', 'pointer-events-none');
                slide.classList.remove('opacity-100', 'z-10');
            }
        });
        dots.forEach((dot, i) => {
            dot.className = i === index
                ? 'hero-dot h-2 w-10 rounded-full bg-mm-accent transition-all duration-300'
                : 'hero-dot h-2 w-3 rounded-full bg-white/40 hover:bg-white/70 transition-all duration-300';
        });
    };

    setInterval(() => {
        if (slides.length > 0) {
            setHeroSlide((currentSlide + 1) % slides.length);
        }
    }, 6500);
});

// 3. Continue Reading Horizontal Scroll
function scrollCarousel(offset) {
    const carousel = document.getElementById('continueCarousel');
    if (carousel) {
        carousel.scrollBy({ left: offset, behavior: 'smooth' });
    }
}

// 4. Magic Translator OCR Simulation
function simulateOCR() {
    const status = document.getElementById('ocrStatus');
    const output = document.getElementById('ocrOutput');
    if (!status || !output) return;

    status.textContent = '● Scanning Bubbles...';
    output.style.opacity = '0.4';

    setTimeout(() => {
        status.textContent = '● Translation Complete (0.42s)';
        output.style.opacity = '1';
        output.textContent = '"Bu yulduzning taqdirini o‘zim qayta yozaman!"';
    }, 700);
}