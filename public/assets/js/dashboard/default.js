(function () {
  const date = new Date();
  function renderApexChart(selector, options) {
    var chartEl = document.querySelector(selector);
    if (!chartEl) {
      return;
    }

    var chart = new ApexCharts(chartEl, options);
    chart.render();
  }
  // visitor chart
  var visitorUser = {
    series: [
      {
        name: "Growth",
        data: window.appConfig.dataVisitor,
      },
    ],
    chart: {
      height: 160,
      type: "line",
      stacked: true,
      offsetY: -10,
      toolbar: {
        show: false,
      },
    },
    colors: ["#7366FF"],
    stroke: {
      width: 3,
      curve: "smooth",
    },
    xaxis: {
      lines: {
        show: true,
      },
      type: "category",
      categories: ["H-12","", "H-10", "","H-8", "","H-6", "","H-4", "","H-2", "", "Today"],
      labels: {
        style: {
          fontFamily: "Rubik, sans-serif",
          fontWeight: 500,
          colors: "#8D8D8D",
        },
      },
      axisTicks: {
        show: false,
      },
      axisBorder: {
        show: false,
      },
    },
    grid: {
      show: true,
      borderColor: "var(--chart-dashed-border)",
      strokeDashArray: 3,
      position: "back",
      xaxis: {
        lines: {
          show: true,
        },
      },
      yaxis: {
        lines: {
          show: false,
        },
      },
    },
    fill: {
      type: "gradient",
      gradient: {
        shade: "dark",
        gradientToColors: ["#7366FF"],
        shadeIntensity: 1,
        type: "horizontal",
        opacityFrom: 1,
        opacityTo: 1,
        colorStops: [
          {
            offset: 0,
            color: "#48A3D7",
            opacity: 1,
          },
          {
            offset: 100,
            color: "#7366FF",
            opacity: 1,
          },
        ],
      },
    },
    yaxis: {
      labels: {
        show: false,
      },
    },
    responsive: [
      {
        breakpoint: 1400,
        options: {
          chart: {
            height: 310,
            offsetY: 0,
          },
        },
      },
      {
        breakpoint: 1345,
        options: {
          chart: {
            height: 300,
            offsetY: 0,
          },
        },
      },
      {
        breakpoint: 1248,
        options: {
          chart: {
            height: 300,
            offsetY: 0,
          },
        },
      },

      {
        breakpoint: 1200,
        options: {
          chart: {
            height: 130,
            offsetY: -20,
          },
        },
      },
      {
        breakpoint: 792,
        options: {
          chart: {
            offsetY: 0,
          },
        },
      },
      {
        breakpoint: 576,
        options: {
          chart: {
            height: 150,
            offsetY: -20,
          },
        },
      },
      {
        breakpoint: 389,
        options: {
          chart: {
            offsetY: 0,
          },
        },
      },
    ],
  };

  renderApexChart("#visitor_chart", visitorUser);

  // currently sale
  var chartLPSE = {
    series: [
      {
        name: "Sirup LKPP",
        type: "line",
        data: window.appConfig.dataScrapeSirup,
      },
      {
        name: "Tender LPSE",
        type: "line",
        data: window.appConfig.dataScrapeLPSE,
      },
    ],
    chart: {
      height: 315,
      type: "line",
      stacked: false,
      toolbar: {
        show: false,
      },
      dropShadow: {
        enabled: true,
        enabledOnSeries: [2],
        top: 10,
        left: 0,
        blur: 4,
        color: "#7366FF",
        opacity: 0.2,
      },
    },
    stroke: {
      width: [2, 3],
      curve: "smooth",
      dashArray: [8, 0],
    },
    plotOptions: {
      bar: {
        columnWidth: "30%",
      },
    },
    colors: ["#ffb829", "#7366FF"],
    fill: {
      type: "solid",
      gradient: {
        shade: "dark",
        type: "vertical",
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100],
      },
    },
    grid: {
      borderColor: "var(--chart-border)",
      yaxis: {
        lines: {
          show: true,
        },
      },
    },
    legend: {
      show: false,
    },
    markers: {
      size: 0,
    },
    xaxis: {
      categories: window.appConfig.tanggalAxis,
      labels: {
        style: {
          fontFamily: "Rubik, sans-serif",
          colors: ["#52526c"],
        },
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    yaxis: {
      title: {
        text: "Points",
      },
      min: 0,
      title: {
        text: undefined,
      },
    },
    responsive: [
      {
        breakpoint: 1870,
        options: {
          chart: {
            height: 320,
          },
        },
      },
      {
        breakpoint: 486,
        options: {
          xaxis: {
            tickAmount: 4,
          },
        },
      },
    ],
  };

  renderApexChart("#grafik-lpse", chartLPSE);

  // Monthly targets
  var monthlyTarget = {
    series: [10.77],
    chart: {
      type: "radialBar",
      height: 320,
      offsetY: -20,
      sparkline: {
        enabled: true,
      },
    },
    plotOptions: {
      radialBar: {
        hollow: {
          size: "65%",
        },
        startAngle: -90,
        endAngle: 90,
        track: {
          background: "#d7e2e9",
          strokeWidth: "97%",
          margin: 5,
          dropShadow: {
            enabled: true,
            top: 2,
            left: 0,
            color: "#999",
            opacity: 1,
            blur: 2,
          },
        },
        dataLabels: {
          name: {
            show: true,
            offsetY: -10,
          },
          value: {
            show: true,
            offsetY: -50,
            fontSize: "18px",
            fontWeight: "600",
            color: "#2F2F3B",
          },
          total: {
            show: true,
            label: "+60%",
            color: CubaAdminConfig.primary,
            fontSize: "14px",
            fontFamily: "Rubik, sans-serif",
            fontWeight: 400,
            formatter: function () {
              return "99%";
            },
          },
        },
      },
    },
    grid: {
      padding: {
        top: -10,
      },
    },
    fill: {
      type: "gradient",
      gradient: {
        shade: "dark",
        shadeIntensity: 0.4,
        inverseColors: false,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [100],
        colorStops: [
          {
            offset: 0,
            color: "#7366FF",
            opacity: 1,
          },
        ],
      },
    },
    labels: ["Average Results"],
    responsive: [
      {
        breakpoint: 1591,
        options: {
          chart: {
            height: 270,
          },
        },
      },
      {
        breakpoint: 1426,
        options: {
          chart: {
            height: 240,
          },
        },
      },
      {
        breakpoint: 1331,
        options: {
          chart: {
            height: 210,
          },
          plotOptions: {
            radialBar: {
              dataLabels: {
                value: {
                  fontSize: "16px",
                },
                total: {
                  fontSize: "13px",
                },
              },
            },
          },
        },
      },
      {
        breakpoint: 1233,
        options: {
          chart: {
            height: 200,
          },
        },
      },
      {
        breakpoint: 768,
        options: {
          chart: {
            height: 250,
          },
        },
      },
    ],
  };

  renderApexChart("#monthly_target", monthlyTarget);

  // Sales Report
  var saleReport = {
    series: [
      {
        name: "Users",
        type: "column",
        data: window.appConfig.users,
      },
      {
        name: "Invoice",
        type: "line",
        data: window.appConfig.invoices,
      },
      {
        name: "Paid Invoices",
        type: "line",
        data: window.appConfig.paidInvoices,
      },
    ],
    chart: {
      height: 315,
      type: "line",
      stacked: false,
      toolbar: {
        show: false,
      },
      dropShadow: {
        enabled: true,
        enabledOnSeries: [2],
        top: 10,
        left: 0,
        blur: 4,
        color: "#7366FF",
        opacity: 0.2,
      },
    },
    stroke: {
      width: [0, 2, 3],
      curve: "smooth",
      dashArray: [0, 8, 0],
    },
    plotOptions: {
      bar: {
        columnWidth: "30%",
      },
    },
    colors: ["var(--chart-progress-light)", "#ffb829", "#7366FF"],
    fill: {
      type: "solid",
      gradient: {
        shade: "dark",
        type: "vertical",
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100],
      },
    },
    grid: {
      borderColor: "var(--chart-border)",
      yaxis: {
        lines: {
          show: true,
        },
      },
    },
    legend: {
      show: false,
    },
    markers: {
      size: 0,
    },
    xaxis: {
      categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      labels: {
        style: {
          fontFamily: "Rubik, sans-serif",
          colors: ["#52526c"],
        },
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    yaxis: {
      title: {
        text: "Points",
      },
      min: 0,
      title: {
        text: undefined,
      },
    },
    responsive: [
      {
        breakpoint: 1870,
        options: {
          chart: {
            height: 320,
          },
        },
      },
      {
        breakpoint: 486,
        options: {
          xaxis: {
            tickAmount: 4,
          },
        },
      },
    ],
  };

  renderApexChart("#sale_report", saleReport);
})();



// time
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  // var s = today.getSeconds();
  var ampm = h >= 12 ? "PM" : "AM";
  h = h % 12;
  h = h ? h : 12;
  m = checkTime(m);
  // s = checkTime(s);
  document.getElementById("txt").innerHTML = h + ":" + m + " " + ampm;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {
    i = "0" + i;
  } // add zero in front of numbers < 10
  return i;
}
