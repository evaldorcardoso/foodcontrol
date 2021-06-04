
$(document).ready(function() {
  

  //Docs at http://www.chartjs.org 
    

    
    
    var bar_data = {
    labels: ["Monday", "Tuesday", "Wednesday", "Thrusday", "May", "June", "July"],
    datasets: [
        {
            fillColor: "rgba(226,83,49,1)",
            strokeColor: "rgba(226,83,49,1)",
            highlightFill: "rgba(226,83,49,0.5)",
            highlightStroke: "rgba(226,83,49,0.5)",
            data: [65, 59, 80, 81, 56, 55, 40]
        }
    ]
    };
    
    
    // PIE CHART WIDGET
    var ctx = document.getElementById("myPieChart").getContext("2d");
    var myDoughnutChart = new Chart(ctx).Doughnut(pie_data,
            {
                responsive:true, 
                tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %> %"
            });
    
    
    // LINE CHART WIDGET
    var ctx2 = document.getElementById("myLineChart").getContext("2d");
    var myLineChart = new Chart(ctx2).Line(line_data,
            {
                responsive:true,
                scaleShowGridLines : false,
                scaleShowLabels: false,
                showScale: false,
                pointDot : true,
                bezierCurveTension : 0.2,
                pointDotStrokeWidth : 1,
                pointHitDetectionRadius : 5,
                datasetStroke : false,
                tooltipTemplate: "<%= value %><%if (label){%> - <%=label%><%}%>"
            });
            
        // BAR CHART ON LINE WIDGET    
        var ctx3 = document.getElementById("myBarChart").getContext("2d");
        var myBarChart = new Chart(ctx3).Bar(bar_data,
            {
                responsive:true,
                scaleShowGridLines : false,
                scaleShowLabels: false,
                showScale: false,
                pointDot : true, 
                datasetStroke : false,
                tooltipTemplate: "<%= value %><%if (label){%> - <%=label%><%}%>"
            });
    
});