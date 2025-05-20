const slider = document.getElementById('slider');
const arrowLeft = document.getElementById('arrow-left');
const arrowRight = document.getElementById('arrow-right');
const scrollAmount = 310;

arrowRight.addEventListener('click', () => {
    slider.scrollLeft += scrollAmount;
});

arrowLeft.addEventListener('click', () => {
    slider.scrollLeft -= scrollAmount;
});