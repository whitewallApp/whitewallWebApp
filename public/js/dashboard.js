// const myChart = new Chart("myChart", {
//     type: "bar",
//     data: {
//         labels: ["Test"],
//         datasets: [{
//             backgroundColor: "blue",
//             data: [10]
//         }]
//     },
//     options: {}
// });

google.charts.load('current', { packages: ['corechart'] });

google.charts.setOnLoadCallback(drawChart);

function drawChart() {

    const linkdata = google.visualization.arrayToDataTable(linkData);

    const linkoptions = {
        legend: "none",
        hAxis: {format: "0"},
    };

    const linkchart = new google.visualization.BarChart(document.getElementById('linkChart'));
    linkchart.draw(linkdata, linkoptions);

    const wallpaperdata = google.visualization.arrayToDataTable(wallpaperData);

    const wallpaperoptions = {
        legend: "none",
        hAxis: { format: "0" },
    };

    const wallpaperchart = new google.visualization.BarChart(document.getElementById('wallpaperChart'));
    wallpaperchart.draw(wallpaperdata, wallpaperoptions);


    const limitdata = google.visualization.arrayToDataTable(limitData);

    const limitoptions = {
        hAxis: {
            logScale: true  // <- key part
        },
        isStacked: true,
    };

    const limitchart = new google.visualization.BarChart(document.getElementById('limitsChart'));
    limitchart.draw(limitdata, limitoptions);

}