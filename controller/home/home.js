angular.module("artevisualsoft",['ngMessages','ngMaterial','money-mask','swxSessionStorage','swxLocalStorage']);
angular.module("artevisualsoft").controller("artevisualsoftCtrl", function ($scope, $http, $location, $anchorScroll, $timeout, $mdBottomSheet, $mdToast, $sessionStorage, $localStorage) {

    $scope.texto = "meu texto";
});
google.charts.load("current", {packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ["Element", "Density", { role: "style" } ],
      ["Jan.", 0, "#2E4DD4"],
      ["Fev", 0, "#2E4DD4"],
      ["Mar", 0, "#2E4DD4"],
      ["Abr", 0, "color: #2E4DD4"],
      ["Mai", 0, "#2E4DD4"],
      ["Jun", 0, "#2E4DD4"],
      ["Jul", 0, "#2E4DD4"],
      ["Ago", 0, "color: #2E4DD4"],
      ["Set", 0, "#2E4DD4"],
      ["Out", 0, "#2E4DD4"],
      ["Nov", 0, "#2E4DD4"],
      ["Dez", 0, "color: #2E4DD4"]
    ]);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" },
                     2]);

    var options = {
      title: "Gravico de vendas",
      width: 600,
      height: 400,
      bar: {groupWidth: "95%"},
      legend: { position: "none" },
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
    chart.draw(view, options);

    var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Work',     0],
        ['Eat',      0],
        
      ]);

      var options = {
        title: 'Lucro Liquido'
      };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);

}