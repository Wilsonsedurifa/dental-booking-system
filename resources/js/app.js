document.querySelectorAll('a[href^="#"]').forEach((link) => link.addEventListener('click', (event) => { const target = document.querySelector(link.getAttribute('href')); if (target) { event.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); } }));

const motionOkay = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
if (motionOkay) {
    const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
        if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); }
    }), { threshold: 0.14 });
    document.querySelectorAll('.reveal').forEach((item) => observer.observe(item));

    window.addEventListener('scroll', () => {
        document.querySelector('.orb-one').style.transform = `translateY(${window.scrollY * .12}px)`;
        document.querySelector('.orb-two').style.transform = `translateY(${-window.scrollY * .07}px)`;
    }, { passive: true });
    document.querySelectorAll('.project-art').forEach((card) => {
        card.addEventListener('pointermove', (event) => {
            const box = card.getBoundingClientRect();
            card.style.transform = `perspective(900px) rotateX(${(box.height / 2 - (event.clientY - box.top)) / 18}deg) rotateY(${((event.clientX - box.left) - box.width / 2) / 18}deg) scale(1.015)`;
        });
        card.addEventListener('pointerleave', () => { card.style.transform = ''; });
    });
}
