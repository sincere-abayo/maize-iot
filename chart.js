<script>
    // Sample data for temperature, humidity, and date
    var data = {
        labels: ['2024-04-01', '2024-04-02', '2024-04-03', '2024-04-04', '2024-04-05'],
        temperature: [25, 26, 24, 27, 26],
        humidity: [60, 55, 58, 62, 59]
    };

    // Get the canvas element
    var ctx = document.getElementById('analyticalChart').getContext('2d');

    // Create the chart
    var analyticalChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'Temperature (°C)',
                data: data.temperature,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                yAxisID: 'temperature-y-axis'
            }, {
                label: 'Humidity (%)',
                data: data.humidity,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                yAxisID: 'humidity-y-axis'
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day'
                    },
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                temperature: {
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Temperature (°C)'
                    }
                },
                humidity: {
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Humidity (%)'
                    }
                }
            }
        }
    });
</script>