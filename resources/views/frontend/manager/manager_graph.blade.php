<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load("current", {packages:['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  var managerScore = <?php echo $data->manager_review($data->id); ?>;
  var pareScore = <?php echo $data->industry_avg($data->company_id); ?>;
  var color = "#007bff";
  var pcolor = "#007bff";

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ["Element", "Density", { role: "style" } ],
      ["", null, ""],
      ["This manager's score", managerScore, color],
      ["Average of peers", pareScore, pcolor],
      ["", null, ""],
    ]);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1, { calc: "stringify", sourceColumn: 1, type: "string", role: "annotation" }, 2]);

    var options = {
      bar: {groupWidth: "97%"},
      legend: { position: "none" },
      isStacked: true,
      vAxis: {
        ticks: [0, 1, 2, 3, 4, 5]
      }
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
    chart.draw(view, options);
  }
</script>