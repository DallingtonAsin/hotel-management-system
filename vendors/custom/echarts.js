function eBarGraph(elementId, title) {
    // Initialize the echarts instance based on the prepared dom
    var myChart = echarts.init(document.getElementById(elementId));

    // Specify the configuration items and data for the chart
    var option = {
        title: {
            text: title,
        },
        tooltip: {},
        legend: {
            data: ["sales"],
        },
        xAxis: {
            data: [
                "Shirts",
                "Cardigans",
                "Chiffons",
                "Pants",
                "Heels",
                "Socks",
            ],
        },
        yAxis: {},
        series: [
            {
                name: "sales",
                type: "bar",
                data: [5, 20, 36, 10, 10, 20],
            },
        ],
    };

    // Display the chart using the configuration items and data just specified.
    myChart.setOption(option);
}


function ePieChart(elementId, title){

    var myChart = echarts.init(document.getElementById(elementId, title));

   let option = {
        title: {
          text: title,
          subtext: 'Fake Data',
          left: 'center'
        },
        tooltip: {
          trigger: 'item'
        },
        legend: {
          orient: 'vertical',
          left: 'left'
        },
        series: [
          {
            name: 'Access From',
            type: 'pie',
            radius: '50%',
            data: [
              { value: 1048, name: 'Search Engine' },
              { value: 735, name: 'Direct' },
              { value: 580, name: 'Email' },
              { value: 484, name: 'Union Ads' },
              { value: 300, name: 'Video Ads' }
            ],
            emphasis: {
              itemStyle: {
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowColor: 'rgba(0, 0, 0, 0.5)'
              }
            }
          }
        ]
      };

      myChart.setOption(option);
}