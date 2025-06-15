document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('saldoLine');
    if (ctx) {
        const labels = JSON.parse(ctx.dataset.labels);
        const values = JSON.parse(ctx.dataset.values);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Saldo Bulanan',
                    data: values,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4,
                }],
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            autoSkip: true,
                            maxTicksLimit: 5,
                            callback: value => 'Rp ' + value.toLocaleString()
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return 'Rp ' + tooltipItem.yLabel.toLocaleString();
                        }
                    }
                },
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        });
    }
});
