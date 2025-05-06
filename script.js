// Toggle dark mode
const toggle = document.getElementById('darkModeToggle');
toggle.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    const icon = toggle.querySelector('i');
    icon.classList.toggle('fa-moon');
    icon.classList.toggle('fa-sun');
});

// Animasi saat scroll (fade in)
const faders = document.querySelectorAll('.fade');
const appearOnScroll = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('appear');
            observer.unobserve(entry.target);
        }
    });
}, {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px"
});
faders.forEach(fadeEl => {
    appearOnScroll.observe(fadeEl);
});

// Smooth scroll saat klik menu navigasi
document.querySelectorAll('nav a').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href.startsWith('#')) {
            e.preventDefault();
            document.querySelector(href).scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Slideshow Gallery (Next/Prev)
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const nextBtn = document.getElementById('nextSlide');
const prevBtn = document.getElementById('prevSlide');

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.style.display = i === index ? 'block' : 'none';
        slide.classList.add('fade-slide');
    });
}
if (slides.length > 0) {
    showSlide(currentSlide);

    nextBtn.addEventListener('click', () => {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    });

    prevBtn.addEventListener('click', () => {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    });
}

// Validasi Form Contact
const contactForm = document.querySelector('#contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const name = contactForm.querySelector('#name').value.trim();
        const email = contactForm.querySelector('#email').value.trim();
        const message = contactForm.querySelector('#message').value.trim();

        if (name === '' || email === '' || message === '') {
            alert('Silakan lengkapi semua kolom.');
        } else {
            alert('Pesan berhasil dikirim!');
            contactForm.reset();
        }
    });
}
