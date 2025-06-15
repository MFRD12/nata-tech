document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('pie-absensi');
    if (ctx) {
        const absensiData = JSON.parse(ctx.dataset.absensi);

        const data = {
            datasets: [{
                data: Object.values(absensiData),
                backgroundColor: ['#0694a2', '#1c64f2', '#7e3af2', '#f87171', '#facc15', '#10b981'],
                label: 'Status Absensi',
            }],
            labels: Object.keys(absensiData),
        };

        new Chart(ctx, {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 70,
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 15,
                        padding: 20,
                    }
                },
            },
        });
    }
});
