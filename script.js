// Dark Mode Toggle with Local Storage
const darkModeToggle = document.getElementById('darkModeToggle');

if (localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
}

darkModeToggle.addEventListener('click', function() {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', document.body.classList.contains('dark-mode') ? 'enabled' : 'disabled');
});

// Gallery Lightbox
const galleryItems = document.querySelectorAll('.gallery-item');
const lightbox = document.getElementById('lightbox');
if (lightbox) {
    const lightboxImg = document.getElementById('lightboxImage');
    const closeBtn = document.querySelector('.close-btn');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    
    let currentImageIndex = 0;
    const images = [
        'Images/foto1.jpg',
        'Images/foto2.jpg',
        'Images/foto3.jpg',
        'Images/foto4.jpg',
        'Images/foto5.jpg',
        'Images/foto6.jpg'
    ];
    
    galleryItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            currentImageIndex = index;
            lightboxImg.src = images[currentImageIndex];
            lightbox.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    });
    
    closeBtn.addEventListener('click', () => {
        lightbox.style.display = 'none';
        document.body.style.overflow = 'auto';
    });
    
    prevBtn.addEventListener('click', () => {
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        lightboxImg.src = images[currentImageIndex];
    });
    
    nextBtn.addEventListener('click', () => {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        lightboxImg.src = images[currentImageIndex];
    });
    
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) {
            lightbox.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });
}

// Contact Form Validation
const contactForm = document.querySelector('.contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const name = this.querySelector('#name').value.trim();
        const email = this.querySelector('#email').value.trim();
        const message = this.querySelector('#message').value.trim();
        
        if (name && email && message) {
            alert('Pesan berhasil dikirim!');
            this.reset();
        } else {
            alert('Harap lengkapi semua field!');
        }
    });
}

// Video Background Adjustment
const bgVideo = document.getElementById('bg-video');
if (bgVideo) {
    function adjustVideoBackground() {
        const aspectRatio = bgVideo.videoWidth / bgVideo.videoHeight || 16/9;
        
        if (window.innerWidth / window.innerHeight > aspectRatio) {
            bgVideo.style.width = '100%';
            bgVideo.style.height = 'auto';
        } else {
            bgVideo.style.width = 'auto';
            bgVideo.style.height = '100%';
        }
    }

    bgVideo.addEventListener('loadedmetadata', adjustVideoBackground);
    window.addEventListener('resize', adjustVideoBackground);
}


function animateBlogPosts() {
    const blogPosts = document.querySelectorAll('.blog-post');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    });

    blogPosts.forEach(post => {
        observer.observe(post);
    });

    // Hover effects
    blogPosts.forEach(post => {
        post.addEventListener('mouseenter', () => {
            post.style.transform = 'translateY(-5px) scale(1.02)';
            post.style.boxShadow = '0 10px 20px rgba(0,0,0,0.15)';
        });
        
        post.addEventListener('mouseleave', () => {
            if (post.classList.contains('visible')) {
                post.style.transform = 'translateY(0)';
                post.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
            }
        });
    });
}


document.addEventListener('DOMContentLoaded', function() {

    animateBlogPosts();
    

    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.gallery-item, .contact-container');
        
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.2;
            
            if (elementPosition < screenPosition) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };
    
    animateOnScroll();
    window.addEventListener('scroll', animateOnScroll);
});
