window.addEventListener('click', (ev) => {
    if(ev.target.classList[0] === 'navBurger') {
        ev.target.classList.toggle('show');
        if(ev.target.classList.contains('show')) {
            document.querySelector('header > nav > div:first-child').style.display = 'flex';
            document.querySelector('header > nav > div:nth-child(3)').style.display = 'flex';
            document.querySelector('header > nav').style.display = 'flex';
        }
        else {
            document.querySelector('header > nav > div:first-child').style.display = 'none';
            document.querySelector('header > nav > div:nth-child(3)').style.display = 'none';
            document.querySelector('header > nav').style.display = 'none';
        }
    }
})

window.addEventListener('click', (ev) => {
    if (ev.target.classList.contains('arrowBurger')) {
        const menu = document.querySelector('.dropdown-menu');
        const arrow = ev.target;

        // Используем класс для отслеживания состояния
        const isActive = arrow.classList.toggle('active');

        // Обновляем меню и картинку
        menu.style.display = isActive ? 'block' : 'none';
    }
});

document.querySelectorAll('.promo-card').forEach(card => {
    card.addEventListener('click', function() {
        const promoCode = this.getAttribute('data-promo');
        navigator.clipboard.writeText(promoCode)
            .then(() => {
                const feedback = this.querySelector('.copy-feedback');
                feedback.classList.add('show');
                setTimeout(() => {
                    feedback.classList.remove('show');
                }, 1500);

                console.log(`Промокод "${promoCode}" скопирован!`);
            })
            .catch(err => {
                console.error('Не удалось скопировать промокод:', err);
                alert('Не удалось скопировать промокод. Скопируйте вручную.');
            });
    });
});
