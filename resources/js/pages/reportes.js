import Chart from 'chart.js/auto';

// ===== ANIMACIONES DE ENTRADA =====
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.stat-card, .card-chart, .card-chart-right, .table-card').forEach(el => {
    observer.observe(el);
});

// ===== CONTADORES ANIMADOS =====
function animateCounter(el) {
    const target = parseFloat(el.dataset.target);
    const format = el.dataset.format;
    const prefix = el.dataset.prefix || '';
    const duration = 1500;
    const start = performance.now();

    function update(currentTime) {
        const elapsed = currentTime - start;
        const progress = Math.min(elapsed / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const current = Math.floor(eased * target);

        if (format === 'money') {
            el.textContent = prefix + '$' + current.toLocaleString('es-CO');
        } else {
            el.textContent = current;
        }

        if (progress < 1) {
            requestAnimationFrame(update);
        } else {
            if (format === 'money') {
                el.textContent = prefix + '$' + target.toLocaleString('es-CO');
            } else {
                el.textContent = Math.floor(target);
            }
        }
    }
    requestAnimationFrame(update);
}

// Iniciar contadores cuando las cards sean visibles
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll('.counter');
            counters.forEach(counter => animateCounter(counter));
            counterObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.3 });

document.querySelectorAll('.stat-card').forEach(el => {
    counterObserver.observe(el);
});

// ===== BARRAS DE PROGRESO =====
setTimeout(() => {
    document.querySelectorAll('.progress-fill').forEach(bar => {
        bar.style.width = bar.dataset.width + '%';
    });
}, 800);

// ===== GRÁFICA INGRESOS VS GASTOS =====
const ctx1 = document.getElementById('graficaFinanciera');
if (ctx1) {
    const meses = JSON.parse(ctx1.dataset.meses);
    const ingresos = JSON.parse(ctx1.dataset.ingresos);
    const gastos = JSON.parse(ctx1.dataset.gastos);

    new Chart(ctx1.getContext('2d'), {
        type: 'bar',
        data: {
            labels: meses,
            datasets: [
                {
                    label: 'Ingresos',
                    data: ingresos,
                    backgroundColor: 'rgba(26, 58, 42, 0.85)',
                    borderRadius: 8,
                },
                {
                    label: 'Gastos',
                    data: gastos,
                    backgroundColor: 'rgba(201, 168, 76, 0.85)',
                    borderRadius: 8,
                }
            ]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart',
            },
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: ctx => ' $' + ctx.raw.toLocaleString('es-CO')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => '$' + value.toLocaleString('es-CO')
                    }
                }
            }
        }
    });
}

// ===== GRÁFICA ACTIVIDADES =====
const ctx2 = document.getElementById('graficaActividades');
if (ctx2) {
    const pendientes = parseInt(ctx2.dataset.pendientes);
    const enProgreso = parseInt(ctx2.dataset.enProgreso);
    const completadas = parseInt(ctx2.dataset.completadas);

    new Chart(ctx2.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Pendientes', 'En Progreso', 'Completadas'],
            datasets: [{
                data: [pendientes, enProgreso, completadas],
                backgroundColor: ['#6c757d', '#c9a84c', '#1a3a2a'],
                borderWidth: 0,
                hoverOffset: 10,
            }]
        },
        options: {
            responsive: true,
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1500,
                easing: 'easeInOutQuart',
            },
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
}