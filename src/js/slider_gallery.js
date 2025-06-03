document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('#slider-3 .slide');
    const leftArrow = document.getElementById('arrow-left-3');
    const rightArrow = document.getElementById('arrow-right-3');
    let currentSlide = 0;

    function updateSlider() {
        slides.forEach((slide, index) => {
            slide.classList.toggle('active', index === currentSlide);
        });
    }

    leftArrow.addEventListener('click', () => {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        updateSlider();
    });

    rightArrow.addEventListener('click', () => {
        currentSlide = (currentSlide + 1) % slides.length;
        updateSlider();
    });

    // Инициализация на старте
    updateSlider();
});
