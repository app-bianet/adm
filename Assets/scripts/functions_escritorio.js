function Char(){
    
var dados = document.getElementById("Chart");
var ancho = dados.width;
var lienzo = dados.getContext("2d");

var myChart = new Chart(dados, {
  type: "pie",
  data: {
    labels: ["col1", "col2", "col3"],
    datasets: [
      {
        label: "Num datos",
        data: [10, 9, 15],
        backgroundColor: [
          "rgb(66, 134, 244,0.5)",
          "rgb(74, 135, 72,0.5)",
          "rgb(229, 89, 50,0.5)",
        ],
      },
    ],
  },
  options: {
    scales: {
      yAxes: [
        {
          ticks: {
            beginAtZero: true,
          },
        },
      ],
    },
  },
});
}

document.addEventListener("DOMContentLoaded", function () {
    Char()
})
