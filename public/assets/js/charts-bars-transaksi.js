const canvas = document.getElementById('bars');

const bulanLabels = JSON.parse(canvas.dataset.labels);
const dataPemasukan = JSON.parse(canvas.dataset.pemasukan);
const dataPengeluaran = JSON.parse(canvas.dataset.pengeluaran);
const tahun = canvas.dataset.tahun;

new Chart(canvas, {
  type: 'bar',
  data: {
    labels: bulanLabels,
    datasets: [
      {
        label: 'Pemasukan',
        backgroundColor: '#16a34a',
        data: dataPemasukan,
      },
      {
        label: 'Pengeluaran',
        backgroundColor: '#dc2626',
        data: dataPengeluaran,
      },
    ],
  },
  options: {
  responsive: true,
  title: {
    display: false,
  },
  legend: {
    display: true,
    position: 'bottom',
    labels: {
      boxWidth: 15,
      padding: 20,
    } 
  },
  tooltips: {
    callbacks: {
      label: function(tooltipItem, data) {
        const value = tooltipItem.yLabel.toLocaleString();
        return 'Rp ' + value;
      }
    }
  },
  scales: {
    yAxes: [{
      ticks: {
        beginAtZero: true,
        autoSkip: true,
        maxTicksLimit: 5,
        callback: function(value) {
          return 'Rp ' + value.toLocaleString();
        }
      }
    }]
  }
}
});
