/**
 * Created by ilyaChizhov on 19.07.17.
 */

"use strict";

let ctx = document.getElementById("myChart");

if (ctx) {
  let arrJson = [{
      name: "Янв",
      prise: "6000"
    },
    {
      name: "Фев",
      prise: "7600"
    },
    {
      name: "Мар",
      prise: "8100"
    },
    {
      name: "Апр",
      prise: "10300"
    },
    {
      name: "Май",
      prise: "8000"
    },
    {
      name: "Июн",
      prise: "9000"
    },
    {
      name: "Июл",
      prise: "7800"
    },
    {
      name: "Авг",
      prise: "5900"
    },
    {
      name: "Сен",
      prise: "6666"
    },
    {
      name: "Окт",
      prise: "7777"
    },
    {
      name: "Ноя",
      prise: "8954"
    },
    {
      name: "Дек",
      prise: "9842"
    },
  ];

  let arrJsonBack = [{
        name: "Янв",
        prise: "10400"
      },
      {
        name: "Фев",
        prise: "12600"
      },
      {
        name: "Мар",
        prise: "16100"
      },
      {
        name: "Апр",
        prise: "20300"
      },
      {
        name: "Май",
        prise: "14000"
      },
      {
        name: "Июн",
        prise: "12000"
      },
      {
        name: "Июл",
        prise: "15800"
      },
      {
        name: "Авг",
        prise: "11900"
      },
      {
        name: "Сен",
        prise: "16666"
      },
      {
        name: "Окт",
        prise: "17777"
      },
      {
        name: "Ноя",
        prise: "18954"
      },
      {
        name: "Дек",
        prise: "17842"
      },
    ],
    backBtn = document.getElementById('thereBack'),
    there = document.getElementById('there');


  function renderChart(arrMonths) {
    let months = [],
      price = [],
      chartPrice = [],
      arrColors = [],
      cheepest,
      count = -1;


    for (let i = 0; i < arrMonths.length; i++) {
      months.push(arrMonths[i].name)
      price.push(parseInt(arrMonths[i].prise))
      chartPrice.push(parseInt(arrMonths[i].prise))
    }


    function sortMin(arr) {
      count += 1;
      let min = Math.min.apply(null, arr);

      for (let i = 0; i < arr.length; ++i) {

        if (min === parseInt(arr[i])) {

          price.splice(i, 1)

          if (count <= months.length) {


            if (count === 0) {
              arrColors[chartPrice.indexOf(min)] = 'rgba(252, 195, 0, 1)';

              cheepest = chartPrice.indexOf(min);
            }
            if (count >= 1 && count < 6) {
              arrColors[chartPrice.indexOf(min)] = 'rgba(102, 160, 232, 1)'
            }

            if (count >= 6 && count < 9) {
              arrColors[chartPrice.indexOf(min)] = 'rgba(153, 192, 240, 1)'
            }

            if (count >= 9 && count <= 11) {
              arrColors[chartPrice.indexOf(min)] = 'rgba(204, 232, 247, 1)'
            }

            min = Math.min.apply(null, price);
            sortMin(arr)
          }
        }

      }
    }

    sortMin(price)

    function outputPrice(arr) {
      let wrap = document.querySelector('.my-chart__price'),
        months = document.querySelectorAll('.my-chart__months li'),
        wrapMob = document.querySelector('.my-chart__price-mob');

      wrap.innerText = '';


      if (window.innerWidth < 772) {

        wrapMob.innerText = '';
        wrap.classList.add('my-chart__price-top')

        arr.forEach(function(item, index) {

          let li = document.createElement("LI");

          if (arr.indexOf(item) > 5) {

            if (arr.indexOf(item) == cheepest) {
              let text = months[index].innerText;

              console.log(text)
              li.innerHTML = '<div>${item}</div><span class="my-chart__cheep">самый дешевый</span>';
              li.className = 'my-chart__cheep-li';
              wrap.appendChild(li)
            } else {
              li.innerText = item;
              wrap.appendChild(li)
            }

          } else {

            if (arr.indexOf(item) == cheepest) {
              li.innerHTML = '<div>${item}</div><span class="my-chart__cheep">самый дешевый</span>';
              li.className = 'my-chart__cheep-li';
              wrap.appendChild(li)
            } else {
              li.innerText = item;
              wrap.appendChild(li)
            }

          }
        })

      } else {
        wrap.classList.remove('my-chart__price-top')


        arr.forEach(function(item) {
          let li = document.createElement("LI");

          if (arr.indexOf(item) == cheepest) {
            li.innerHTML = '<div>${item}</div><span class="my-chart__cheep">самый<br> дешевый</span>';
            li.className = 'my-chart__cheep-li';
            console.log(li)
            wrap.appendChild(li)
          } else {
            li.innerText = item;
            wrap.appendChild(li)
          }


        })
      }


    }

    outputPrice(chartPrice)

    return [chartPrice, arrColors, months]

  }

  function initChart(labels, data, bgc, item) {
    let myChart = new Chart(item, {
      type: window.innerWidth <= 768 ? 'horizontalBar' : 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: '',
          data: data,
          backgroundColor: bgc,
          // borderWidth: 2,
          // fill: false,
          // pointRadius: 0,
          // pointBackgroundColor: '#000',
          // pointBorderColor: '#000'
          // pointBorderWidth: 0
        }]
      },
      options: {
        layout: {
          padding: {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
          }
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }],
          xAxes: [{
              ticks: {
                beginAtZero: true
              }
            }

          ]
        }

      }
    });

    myChart.options.legend.display = false;
    myChart.tooltip._options.enabled = false;
    myChart.scales["x-axis-0"].options.display = false;
    myChart.scales["y-axis-0"].options.display = false;
    // myChart.scales["x-axis-1"].options.display = false;
    myChart.chart.height = 201;
    console.log(myChart)
    return myChart;

  }

  initChart(renderChart(arrJson)[2], renderChart(arrJson)[0], renderChart(arrJson)[1], ctx)


  function toogleChart(arr) {
    let canv = document.getElementById("myChart"),
      block = document.getElementById('canvBlock'),
      newCanv = document.createElement('CANVAS'),
      labels = renderChart(arr)[2],
      data = renderChart(arr)[0],
      bgc = renderChart(arr)[1];

    newCanv.id = 'myChart';
    newCanv.style.width = '100%';
    newCanv.style.height = '470px';
    canv.remove()

    block.appendChild(newCanv)

    initChart(labels, data, bgc, newCanv)
    // }
  }


  backBtn.addEventListener('click', function(e) {
    e.preventDefault()

    toogleChart(arrJsonBack);
    there.classList.remove('active');
    this.classList.add('active');

  })

  there.addEventListener('click', function(e) {
    e.preventDefault()

    toogleChart(arrJson)
    backBtn.classList.remove('active');
    this.classList.add('active');
  })
}
