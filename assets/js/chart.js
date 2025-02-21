Chart.Tooltip.positioners.custom = function(elements, eventPosition) {
  /** @type {Chart.Tooltip} */
  var tooltip = this;

  /* ... */

  return {
    x: eventPosition.x,
    y: eventPosition.y
  };
}
var ctx = document.getElementById("myChart").getContext("2d");
var barChart = new Chart(ctx, {
  type: 'bar',
  options: {
    scales: {
      yAxes: [{
        display: true,
        ticks: {
          min: 0,
          max: 60000
        },
      }],
    },
    tooltips: {
      position: 'custom',
      yAlign:'bottom',
       //<-- important same name as your function above     
      callbacks: {
        label: function(tooltipItem, data) {
          var label = Math.floor(tooltipItem.yLabel * 100) / 100 + " " + data.datasets[tooltipItem.datasetIndex].label;
          return label;
        }
      }
    },
    legend: {
      display: false
    }
  },
  data: {
    labels: ["Jan", "Feb", "Mar", "April", "May", "Jun", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
    datasets: [{
      label: "Data Set 1",
      backgroundColor: [
        'skyblue',
        'skyblue',
        'skyblue',
        'skyblue',
        'skyblue',
        'skyblue',
        'skyblue',
        'skyblue',
        'skyblue',
        'skyblue',
        'skyblue',
        'skyblue',
      ],
      borderColor: [
        
      ],
      borderWidth: 0,
      data: [6000, 20000, 3000, 30000,9000,45000,9000,18000,32000,4000,30000,25000]
    }]
  }
});