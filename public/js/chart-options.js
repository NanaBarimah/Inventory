const loadGraph = (container, options) => {
    Highcharts.chart(container, options);
}

const loadColumnGraph = (container, labels, datasets, yLabel = "Result", title = "Report", subtitle = "") => {
    Highcharts.chart(container, {
        chart: {
          type: 'column'
        },
        title: {
          text: title
        },
        subtitle: {
          text: subtitle
        },
        xAxis: {
          categories: labels,
          crosshair: true
        },
        yAxis: {
          min: 0,
          title: {
            text: yLabel
          }
        },
        plotOptions: {
          column: {
            pointPadding: 0.2,
            borderWidth: 0
          }
        },
        series: datasets
      });
}

const loadPieGraph = (container, datasets, title = "Report", subtitle = "") => {
  Highcharts.chart(container, {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: title
    },
    subtitle: {
      text: subtitle
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
            enabled: true,
            style: {
                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
            }
        }
      }
    },
    series: [{
      name: 'Preventive Maintenances',
      colorByPoint: true,
      data: datasets
    }]
  });
}