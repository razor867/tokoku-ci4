// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
  '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + "").replace(",", "").replace(" ", "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
}

function run_chart_area(info) {
  // Area Chart Example
  var ctx = document.getElementById("myAreaChart");
  var myLineChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      datasets: [
        {
          label: info ? "Pengeluaran" : "Pendapatan",
          lineTension: 0.3,
          backgroundColor: "#e4e4e4",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: info ? total_beli_per_month : total_jual_per_month,
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0,
        },
      },
      scales: {
        xAxes: [
          {
            time: {
              unit: "date",
            },
            gridLines: {
              display: false,
              drawBorder: false,
            },
            ticks: {
              maxTicksLimit: 7,
            },
          },
        ],
        yAxes: [
          {
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              // Include a dollar sign in the ticks
              callback: function (value, index, values) {
                return "Rp" + number_format(value);
              },
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2],
            },
          },
        ],
      },
      legend: {
        display: false,
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: "#6e707e",
        titleFontSize: 14,
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: "index",
        caretPadding: 10,
        callbacks: {
          label: function (tooltipItem, chart) {
            var datasetLabel =
              chart.datasets[tooltipItem.datasetIndex].label || "";
            return datasetLabel + ": Rp" + number_format(tooltipItem.yLabel);
          },
        },
      },
    },
  });
}

function run_pie_chart() {
  // Pie Chart Example
  var ctx = document.getElementById("myPieChart");
  var myPieChart = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: list_cat_produk,
      datasets: [
        {
          data: total_cat_produk,
          backgroundColor: arr_color,
          hoverBackgroundColor: arr_color,
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      legend: {
        display: false,
      },
      cutoutPercentage: 80,
    },
  });
}

function getRandomColor() {
  var letters = "0123456789ABCDEF";
  var color = "#";
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

var arr_color = [];
var arr_detail_pie_chart = [];
for (let i = 0; i < list_cat_produk.length; i++) {
  arr_color.push(getRandomColor());
}

for (let i = 0; i < arr_color.length; i++) {
  arr_detail_pie_chart.push(
    '<span class="mr-2"><i class="fas fa-circle" style="color:' +
      arr_color[i] +
      ';"></i> ' +
      list_cat_produk[i] +
      "</span>"
  );
}

$(document).ready(function () {
  var data_chart_area = false;

  $(".penjualan").click(function () {
    $(".chart-area").empty();
    $(".chart-area").append('<canvas id="myAreaChart"></canvas>');
    $(".grafik_title").text("Grafik Penjualan Perbulan");
    data_chart_area = false;
    run_chart_area(data_chart_area);
  });

  $(".pembelian").click(function () {
    $(".chart-area").empty();
    $(".chart-area").append('<canvas id="myAreaChart"></canvas>');
    $(".grafik_title").text("Grafik Pembelian Perbulan");
    data_chart_area = true;
    run_chart_area(data_chart_area);
  });

  run_chart_area(data_chart_area);
  run_pie_chart();

  for (let i = 0; i < arr_detail_pie_chart.length; i++) {
    $(".detail_pie_chart").append(arr_detail_pie_chart[i]);
  }
});
