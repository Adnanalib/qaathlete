var labels = ['month' , 'day', 'year'];
var datasets = [0, 0, 0];
let chartData = null;
const ctx = document.getElementById('myChart');


function loadQrChartData(qrChartLabels, qrChartData) {
    if(qrChartLabels.length > 0) {
        let labelArray = qrChartLabels[0];
        labels = [];
        datasets = [];
        Object.entries(labelArray).forEach(([key, label], index) => {
            console.log(`${key} (${index}): ${label}`);
            labels.push(key);
            datasets.push(qrChartData[index] ? qrChartData[index] : 0);
        });
    }
    chartData = {
        type: 'bar',
        // type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Qr Analytics Chart',
                data: datasets,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    new Chart(ctx, chartData);

}
