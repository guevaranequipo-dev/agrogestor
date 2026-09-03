// ===== ANIMACIONES DE ENTRADA GLOBALES =====

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });

// Observar todos los elementos con clases de animación
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll(
        '.anim-fade-up, .anim-fade-left, .anim-fade-right, .anim-fade-in'
    ).forEach(el => observer.observe(el));
});