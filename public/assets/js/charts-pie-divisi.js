document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('chartDivisi');
    if (!canvas) return;

    const labels = JSON.parse(canvas.dataset.labels);
    const counts = JSON.parse(canvas.dataset.counts);

    new Chart(canvas, {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            data: counts,
            backgroundColor: [
                '#3b82f6', '#10b981', '#f59e0b', '#ef4444',
                '#6366f1', '#14b8a6', '#8b5cf6', '#ec4899'
            ],
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutoutPercentage: 70,
        legend: {
            position: 'bottom',
            labels: {
                boxWidth: 15, 
                padding: 20,
            }
        }
    }
});
});
