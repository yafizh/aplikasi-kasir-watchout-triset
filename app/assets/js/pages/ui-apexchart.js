var areaOptions = {
  series: [
    {
      name: "Total Penjualan",
      data: [50, 40, 28, 51, 42, 109, 100],
    },
  ],
  chart: {
    height: 453,
    type: "area",
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    curve: "smooth",
  },
  yaxis: {
    labels: {
      formatter: function (value) {
        return `Rp ${value}`;
      }
    },
  },
  xaxis: {
    categories: [
      "1 Jan 22",
      "2 Jan 22",
      "3 Jan 22",
      "4 Jan 22",
      "5 Jan 22",
      "6 Jan 22",
      "7 Jan 22",
    ],
  },
}

var area = new ApexCharts(document.querySelector("#area"), areaOptions)

area.render()