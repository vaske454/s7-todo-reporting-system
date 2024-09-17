import { ChartJSNodeCanvas } from 'chartjs-node-canvas';
import fs from 'fs';

const width = 400;
const height = 200;

const chartJSNodeCanvas = new ChartJSNodeCanvas({ width, height });

const generateChart = async (completionRate) => {
    const configuration = {
        type: 'bar',
        data: {
            labels: ['Completion Rate (%)'],
            datasets: [{
                label: 'Task Completion',
                data: [completionRate],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                }
            }
        }
    };

    const imageBuffer = await chartJSNodeCanvas.renderToBuffer(configuration);
    fs.writeFileSync('../public/chart-image.png', imageBuffer);
};

const completionRate = parseFloat(process.argv[2]);
generateChart(completionRate);
