document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal');
    const modalImage = document.getElementById('modal-image');
    const modalClose = document.querySelector('.modal-close');

    // Открытие при клике на любое фото
    document.querySelectorAll('.portfolio-item img').forEach(img => {
        img.addEventListener('click', function () {
            modalImage.src = this.src;
            modal.style.display = 'flex'; // показываем
            document.body.style.overflow = 'hidden'; // блокируем скролл
        });
    });

    // Закрытие по крестику
    modalClose.addEventListener('click', function () {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    });

    // Закрытие по клику на фон
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });

    // Закрытие по клавише Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    });
});
