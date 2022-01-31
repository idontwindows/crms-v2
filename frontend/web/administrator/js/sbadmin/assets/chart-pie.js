// // Set new default font family and font color to mimic Bootstrap's default styling
// Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
// Chart.defaults.global.defaultFontColor = '#292b2c';

// Pie Chart Example
var ctx1 = document.getElementById("myPieChart-1").getContext('2d');
var myPieChart = new Chart(ctx1, {
  type: 'pie',
  data: {
    labels: ["Outstanding", "Very Satisfactory", "Satisfactory", "Unsatisfactory", "Poor"],
    datasets: [{
      data: [1, 1, 1, 1, 1],
      backgroundColor: ['#007bff', '#FFA500', '#808080', '#FFFF00', '#FF0000'],
    }],
  },
  options: {
    tooltips: {
      enabled: false
    },
    legend: {
      position: 'left'
    },
    plugins: {
      datalabels: {
        formatter: (value, ctx) => {
          let sum = ctx.dataset._meta[0].total;
          let percentage = (value * 100 / sum).toFixed(2) + "%";
          return percentage;
        },
        color: '#000000',
      }
    }
  }
});
var ctx2 = document.getElementById("myPieChart-2").getContext('2d');
var myPieChart = new Chart(ctx2, {
  type: 'pie',
  data: {
    labels: ["Outstanding", "Very Satisfactory", "Satisfactory", "Unsatisfactory", "Poor"],
    datasets: [{
      data: [1, 1, 1, 1, 1],
      backgroundColor: ['#007bff', '#FFA500', '#808080', '#FFFF00', '#FF0000'],
    }],
  },
  options: {
    tooltips: {
      enabled: false
    },
    legend: {
      position: 'left'
    },
    plugins: {
      datalabels: {
        formatter: (value, ctx) => {
          let sum = ctx.dataset._meta[0].total;
          let percentage = (value * 100 / sum).toFixed(2) + "%";
          return percentage;
        },
        color: '#000000',
      }
    }
  }
});
var ctx3 = document.getElementById("myPieChart-3").getContext('2d');
var myPieChart = new Chart(ctx3, {
  type: 'pie',
  data: {
    labels: ["Outstanding", "Very Satisfactory", "Satisfactory", "Unsatisfactory", "Poor"],
    datasets: [{
      data: [1, 1, 1, 1, 1],
      backgroundColor: ['#007bff', '#FFA500', '#808080', '#FFFF00', '#FF0000'],
    }],
  },
  options: {
    tooltips: {
      enabled: false
    },
    legend: {
      position: 'left'
    },
    plugins: {
      datalabels: {
        formatter: (value, ctx) => {
          let sum = ctx.dataset._meta[0].total;
          let percentage = (value * 100 / sum).toFixed(2) + "%";
          return percentage;
        },
        color: '#000000',
      }
    }
  }
});
var ctx4 = document.getElementById("myPieChart-4").getContext('2d');
var myPieChart = new Chart(ctx4, {
  type: 'pie',
  data: {
    labels: ["Outstanding", "Very Satisfactory", "Satisfactory", "Unsatisfactory", "Poor"],
    datasets: [{
      data: [1, 1, 1, 1, 1],
      backgroundColor: ['#007bff', '#FFA500', '#808080', '#FFFF00', '#FF0000'],
    }],
  },
  options: {
    tooltips: {
      enabled: false
    },
    legend: {
      position: 'left'
    },
    plugins: {
      datalabels: {
        formatter: (value, ctx) => {
          let sum = ctx.dataset._meta[0].total;
          let percentage = (value * 100 / sum).toFixed(2) + "%";
          return percentage;
        },
        color: '#000000',
      }
    }
  }
});
var ctx5 = document.getElementById("myPieChart-5").getContext('2d');
var myPieChart = new Chart(ctx5, {
  type: 'pie',
  data: {
    labels: ["Outstanding", "Very Satisfactory", "Satisfactory", "Unsatisfactory", "Poor"],
    datasets: [{
      data: [1, 1, 1, 1, 1],
      backgroundColor: ['#007bff', '#FFA500', '#808080', '#FFFF00', '#FF0000'],
    }],
  },
  options: {
    tooltips: {
      enabled: false
    },
    legend: {
      position: 'left'
    },
    plugins: {
      datalabels: {
        formatter: (value, ctx) => {
          let sum = ctx.dataset._meta[0].total;
          let percentage = (value * 100 / sum).toFixed(2) + "%";
          return percentage;
        },
        color: '#000000',
      }
    }
  }
});
var ctx6 = document.getElementById("myPieChart-6").getContext('2d');
var myPieChart = new Chart(ctx6, {
  type: 'pie',
  data: {
    labels: ["Outstanding", "Very Satisfactory", "Satisfactory", "Unsatisfactory", "Poor"],
    datasets: [{
      data: [1, 1, 1, 1, 1],
      backgroundColor: ['#007bff', '#FFA500', '#808080', '#FFFF00', '#FF0000'],
    }],
  },
  options: {
    tooltips: {
      enabled: false
    },
    legend: {
      position: 'left'
    },
    plugins: {
      datalabels: {
        formatter: (value, ctx) => {
          let sum = ctx.dataset._meta[0].total;
          let percentage = (value * 100 / sum).toFixed(2) + "%";
          return percentage;
        },
        color: '#000000',
      }
    }
  }
});
var ctx7 = document.getElementById("myPieChart-7").getContext('2d');
var myPieChart = new Chart(ctx7, {
  type: 'pie',
  data: {
    labels: ["Outstanding", "Very Satisfactory", "Satisfactory", "Unsatisfactory", "Poor"],
    datasets: [{
      data: [1, 1, 1, 1, 1],
      backgroundColor: ['#007bff', '#FFA500', '#808080', '#FFFF00', '#FF0000'],
    }],
  },
  options: {
    tooltips: {
      enabled: false
    },
    legend: {
      position: 'left'
    },
    plugins: {
      datalabels: {
        formatter: (value, ctx) => {
          let sum = ctx.dataset._meta[0].total;
          let percentage = (value * 100 / sum).toFixed(2) + "%";
          return percentage;
        },
        color: '#000000',
      }
    }
  }
});
var ctx8 = document.getElementById("myPieChart-8").getContext('2d');
var myPieChart = new Chart(ctx8, {
  type: 'pie',
  data: {
    labels: ["Outstanding", "Very Satisfactory", "Satisfactory", "Unsatisfactory", "Poor"],
    datasets: [{
      data: [1, 1, 1, 1, 1],
      backgroundColor: ['#007bff', '#FFA500', '#808080', '#FFFF00', '#FF0000'],
    }],
  },
  options: {
    tooltips: {
      enabled: false
    },
    legend: {
      position: 'left'
    },
    plugins: {
      datalabels: {
        formatter: (value, ctx) => {
          let sum = ctx.dataset._meta[0].total;
          let percentage = (value * 100 / sum).toFixed(2) + "%";
          return percentage;
        },
        color: '#000000',
      }
    }
  }
});
