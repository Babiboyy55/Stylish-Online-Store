/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */
const barConfig = {
  type: 'bar',
  data: {
    labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7'],
    datasets: [
      {
        label: 'Nike',
        backgroundColor: '#1c64f2',
        // borderColor: window.chartColors.red,
        borderWidth: 1,
        data: [45, 68, 82, 94, 103, 120, 135],
      },
      {
        label: 'Adidas',
        backgroundColor: '#0694a2',
        // borderColor: window.chartColors.blue,
        borderWidth: 1,
        data: [38, 52, 63, 72, 84, 95, 108],
      },
      {
        label: 'Puma',
        backgroundColor: '#7e3af2',
        // borderColor: window.chartColors.blue,
        borderWidth: 1,
        data: [32, 45, 58, 68, 75, 88, 98],
      },
    ],
  },
  options: {
    responsive: true,
    legend: {
      display: false,
    },
  },
}

const barsCtx = document.getElementById('bars')
window.myBar = new Chart(barsCtx, barConfig)
