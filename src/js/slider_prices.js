const slider_2 = document.getElementById('slider-2');
const arrowLeft_2 = document.getElementById('arrow-left-2');
const arrowRight_2 = document.getElementById('arrow-right-2');
const scrollAmount_2 = 310;

arrowRight_2.addEventListener('click', () => {
    slider_2.scrollLeft += scrollAmount_2;
});

arrowLeft_2.addEventListener('click', () => {
    slider_2.scrollLeft -= scrollAmount_2;
});