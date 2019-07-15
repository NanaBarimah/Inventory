const loadGraph = (container, options) => {
    Highcharts.chart(container, options);
}

const loadColumnGraph = (container, labels, datasets, yLabel = "Result", title = "Report", subtitle = "", tickInterval = 1) => {
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
          tickInterval: tickInterval,
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

      console.log(datasets);
}