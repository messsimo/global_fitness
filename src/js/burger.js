document.addEventListener('DOMContentLoaded', function () {
    const openBtn = document.querySelector('.open-btn');
    const closeBtn = document.querySelector('.close-btn');
    const dropdown = document.querySelector('.dropdown-burger');

    // Скрываем меню при загрузке
    dropdown.classList.remove('active');

    openBtn.addEventListener('click', () => {
        dropdown.classList.add('active');
        openBtn.style.display = 'none';
        closeBtn.style.display = 'block';
    });

    closeBtn.addEventListener('click', () => {
        dropdown.classList.remove('active');
        closeBtn.style.display = 'none';
        openBtn.style.display = 'block';
    });
});
