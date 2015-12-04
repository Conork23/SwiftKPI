<?php
	require('connect.php');
    include('header.php');

//Total Sales Per Month
    $TotalSalesPM = "SELECT s.sp_month_id as id, s.num_sales as sales, DATE_FORMAT(m.end_date,'%M') as month
                          FROM salespermonth as s
                          INNER JOIN month as m
                          ON s.month_id = m.month_id
                          WHERE s.year_id = 26";

    $agSales2 = "SELECT s.sp_month_id as id, s.num_sales as sales, DATE_FORMAT(m.end_date,'%M') as month
                          FROM salespermonth as s
                          INNER JOIN month as m
                          ON s.month_id = m.month_id
                          WHERE s.year_id = 25";

    $check = mysqli_query($connect, $TotalSalesPM);
  $rows = mysqli_num_rows($check);

   $lblPHP =array();
   $salesPHP = array();
   $count = 0;
   
   while($row = mysqli_fetch_assoc($check)){
      $id = $row['id'];
   
  $lblPHP[$count] = $row['month'];
  $salesPHP[$count] = $row['sales'];
  $count++;
    }

    $count = 0;
  $salesP2HP = array();

  $check = mysqli_query($connect, $agSales2);
  $rows = mysqli_num_rows($check);

  while($row = mysqli_fetch_assoc($check)){
      $id = $row['id'];
   
  $salesPHP2[$count] = $row['sales'];
  $count++;
    }



  //AgeGroupSales
    $agSales = "SELECT s.sp_age_group_id as id, s.num_sales as sales, s.age_Group_id as ageId, ag.min_age as min, ag.max_age as max
                          FROM SPAge_group as s
                          INNER JOIN age_group as ag
                          ON s.age_Group_id = ag.age_group_id";
    $check = mysqli_query($connect, $agSales);
  $rows = mysqli_num_rows($check);

   $lbl1PHP =array();
   $sales1PHP = array();
   $count = 0;
   
   while($row = mysqli_fetch_assoc($check)){
      $id = $row['id'];
   
  $lbl1PHP[$count] = "".$row['min']." - ".$row['max']."";
  $sales1PHP[$count] = $row['sales'];
  $count++;
    }

//CustomerSalesMonthly
    $monthName = date('F', mktime(0, 0, 0, 1, 10));
    $agSales = "SELECT Concat(c.c_fname, ' ', c.c_lname) as name, s.spc_month_id as id, s.num_sales as sales, DATE_FORMAT(m.end_date,'%M') as month
                          FROM SPCMonth as s
                          INNER JOIN month as m
                          ON s.month_id = m.month_id
                          INNER JOIN customer as c
                          ON c.c_id = s.c_id
                          WHERE s.year_id = 26 and month(m.end_date) like 1
                          ORDER BY sales Desc";
  $agSales2 = "SELECT Concat(c.c_fname, ' ', c.c_lname) as name, s.spc_month_id as id, s.num_sales as sales, DATE_FORMAT(m.end_date,'%M') as month
                          FROM SPCMonth as s
                          INNER JOIN month as m
                          ON s.month_id = m.month_id
                          INNER JOIN customer as c
                          ON c.c_id = s.c_id
                          WHERE s.year_id = 25 and month(m.end_date) like 1
                          ORDER BY sales Desc";

  

    $check = mysqli_query($connect, $agSales);
  $rows = mysqli_num_rows($check);

   $lbl2PHP =array();
   $sales2PHP = array();
   $count = 0;
   
   while($row = mysqli_fetch_assoc($check)){
      $id = $row['id'];
   
  $lbl2PHP[$count] = $row['name'];
  $sales2PHP[$count] = $row['sales'];
  $count++;

  if($count == 10){
    break;
  }
    }

//top Employees
   $topEmps = "SELECT Concat(e.e_fname, ' ', e.e_lname) as name, s.spe_month_id as id, s.num_sales as sales, DATE_FORMAT(m.end_date,'%M') as month
                          FROM SPEMonth as s
                          INNER JOIN month as m
                          ON s.month_id = m.month_id
                          INNER JOIN employee as e
                          ON e.emp_id = s.emp_id
                          WHERE s.year_id = 26 and month(m.end_date) like 1 
                          ORDER BY sales Desc";
    $check = mysqli_query($connect, $topEmps);
  $rows = mysqli_num_rows($check);

   $lbl3PHP =array();
   $sales3PHP = array();
   $count = 0;
   
   while($row = mysqli_fetch_assoc($check)){
      $id = $row['id'];
   
  $lbl3PHP[$count] = $row['name'];
  $sales3PHP[$count] = $row['sales'];
  $count++;

  if($count == 10){
    break;
  }
    }

    //branch sales

  $agSales = "SELECT b.b_address as location, bb.spb_month_id as id, bb.num_sales as sales, DATE_FORMAT(m.end_date,'%M') as month
                          FROM spbmonth as bb
                          INNER JOIN month as m
                          ON bb.month_id = m.month_id
                          INNER JOIN branch as b
                          ON b.b_id = bb.b_id
                          WHERE  bb.year_id = 25 and month(m.end_date) like 1
                          ORDER BY sales Desc";

 $check = mysqli_query($connect, $agSales);
  $rows = mysqli_num_rows($check);

   $lbl4PHP =array();
   $sales4PHP = array();
   $count = 0;
   
   while($row = mysqli_fetch_assoc($check)){
      $id = $row['id'];
   
  $lbl4PHP[$count] = $row['location'];
  $sales4PHP[$count] = $row['sales'];
  $count++;

  if($count == 10){
    break;
  }
    }


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Swift KPI</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="js/jquery-2.1.4.js"></script>
    <script src="ContentFunctions.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <!--Chart.js-->
    <script src="js/Chart.js"></script>
    <script type="text/javascript">

function TopBranches(){

        var lblArr = <?php echo json_encode($lbl4PHP); ?>;
        var salesArr = <?php echo json_encode($sales4PHP); ?>;
        

        options = {
                responsive: true,
                
              };
        var ctx = $("#topBranches").get(0).getContext("2d");
        var data = {
                labels: lblArr,
                datasets: [
                         {
                          label: "My First dataset",
                          fillColor: "#0BAFE6",
                          strokeColor: "rgba(220,220,220,0.8)",
                          highlightFill: "#77D0ED",
                          highlightStroke: "rgba(220,220,220,1)",
                          data: salesArr
                         }   
                        ]
              };

        var myBarChart = new Chart(ctx).Bar(data,options);

        }

   function TopEmps(){

        var lblArr = <?php echo json_encode($lbl3PHP); ?>;
        var salesArr = <?php echo json_encode($sales3PHP); ?>;
        

        options = {
                responsive: true,
                
              };
        var ctx = $("#topEmps").get(0).getContext("2d");
        var data = {
                labels: lblArr,
                datasets: [
                         {
                          label: "My First dataset",
                          fillColor: "#0BAFE6",
                          strokeColor: "rgba(220,220,220,0.8)",
                          highlightFill: "#77D0ED",
                          highlightStroke: "rgba(220,220,220,1)",
                          data: salesArr
                         }   
                        ]
              };

        var myBarChart = new Chart(ctx).Bar(data,options);

        }


    function TotalSalesPM(){

        var lblArr = <?php echo json_encode($lblPHP); ?>;
        var salesArr = <?php echo json_encode($salesPHP); ?>;
        

        options = {
                responsive: true,
                
              };
        var ctx = $("#TotalSalesPM").get(0).getContext("2d");
        var data = {
                labels: lblArr,
                datasets: [
                         {
                          label: "My First dataset",
                          fillColor: "#0BAFE6",
                          strokeColor: "rgba(220,220,220,0.8)",
                          highlightFill: "#77D0ED",
                          highlightStroke: "rgba(220,220,220,1)",
                          data: salesArr
                         }   
                        ]
              };

        var myBarChart = new Chart(ctx).Bar(data,options);

        }

        function salesLine(){
          var lblArr = <?php echo json_encode($lblPHP); ?>;
        var salesArr = <?php echo json_encode($salesPHP); ?>;
        var sales2Arr = <?php echo json_encode($salesPHP2); ?>;

          options = {
                responsive: true,
                datasetFill : true,
                bezierCurveTension : 0.2,
                 legendTemplate : '<ul>'
                                +'<% for (var i=0; i<datasets.length; i++) { %>'
                                  +'<li>'
                                  +'<span style="background-color:<%=datasets[i].strokeColor%>;padding:5px; border-radius:3px;">'
                                  +'<% if (datasets[i].label) { %><%= datasets[i].label %><% } %></span>'
                                +'</li>'
                              +'<% } %>'
                            +'</ul>'
                    
              };
        var ctx = $("#salesLine").get(0).getContext("2d");
        var data = {
                labels: lblArr,
                datasets: [
                         {
                           label: "2015",
                          fillColor: "rgba(11, 175, 230, 0.1)",
                          strokeColor: "#0BAFE6",
                          pointColor: "#0BAFE6",
                          pointStrokeColor: "#fff",
                          pointHighlightFill: "#24FF41",
                          pointHighlightStroke: "#24FF41",
                          data: salesArr
                         },
                        {
                            label: "2014",
                            fillColor: "rgba(255, 36, 61, 0.05)",
                            strokeColor: "#FF243D",
                            pointColor: "#FF243D",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#24FF41",
                            pointHighlightStroke: "#24FF41",
                            data: sales2Arr
                        }  
                        ]
              };

        var myLineChart = new Chart(ctx).Line(data,options);

  document.getElementById("legend").innerHTML = myLineChart.generateLegend();
        }

        function ageGroupSales(){

          var lblArr = <?php echo json_encode($lbl1PHP); ?>;
        var salesArr = <?php echo json_encode($sales1PHP); ?>;




        options = {
            responsive: true
          };

        var ctx = $("#ageGroupSales").get(0).getContext("2d");

        var data = [
    {
        value: salesArr[0],
        color:'#F7464A',
        highlight: '#24FF41',
        label: lblArr[0]
    },
    {
        value: salesArr[1],
        color:'#00BFFF',
        highlight: '#24FF41',
        label: lblArr[1]
    },{
        value: salesArr[2],
        color:'#E4FF4A',
        highlight: '#24FF41',
        label: lblArr[2]
    },{
        value: salesArr[3],
        color:'#00E8A6',
        highlight: '#24FF41',
        label: lblArr[3]
    },{
        value: salesArr[4],
        color:'#001BE8',
        highlight: '#24FF41',
        label: lblArr[4]
    },{
        value: salesArr[5],
        color:'#E8008F',
        highlight: '#24FF41',
        label: lblArr[5]
    },{
        value: salesArr[6],
        color:'#7E8F86',
        highlight: '#24FF41',
        label: lblArr[6]
    },{
        value: salesArr[7],
        color:'#138000',
        highlight: '#24FF41',
        label: lblArr[7]
    },{
        value: salesArr[8],
        color:'#F7464A',
        highlight: '#24FF41',
        label: lblArr[8]
    },{
        value: salesArr[9],
        color:'#F7464A',
        highlight: '#24FF41',
        label: lblArr[9]
    },{
        value: salesArr[10],
        color:'#F7464A',
        highlight: '#24FF41',
        label: lblArr[10]
    },{
        value: salesArr[11],
        color:'#F7464A',
        highlight: '#24FF41',
        label: lblArr[11]
    },{
        value: salesArr[12],
        color:'#F7464A',
        highlight: '#24FF41',
        label: lblArr[12]
    },{
        value: salesArr[13],
        color:'#F7464A',
        highlight: '#24FF41',
        label: lblArr[13]
    },
    {
        value: salesArr[14],
        color:'#F7464A',
        highlight: '#24FF41',
        label: lblArr[14]
    }
]

        var myBarChart = new Chart(ctx).Doughnut(data,options);


        }

function customerSales(){

        var lblArr = <?php echo json_encode($lbl2PHP); ?>;
        var salesArr = <?php echo json_encode($sales2PHP); ?>;

        options = {
                responsive: true,
                
              };
        var ctx = $("#customerSales").get(0).getContext("2d");
        var data = {
                labels: lblArr,
                datasets: [
                         {
                          label: "My First dataset",
                          fillColor: "#0BAFE6",
                          strokeColor: "rgba(220,220,220,0.8)",
                          highlightFill: "#77D0ED",
                          highlightStroke: "rgba(220,220,220,1)",
                          data: salesArr
                         }   
                        ]
              };

        var myBarChart = new Chart(ctx).Bar(data,options);
        }




  $(document).ready(function(){ 
      TopBranches();
      TopEmps();
      TotalSalesPM();
      ageGroupSales();
      customerSales();
      salesLine();
      
      
      
    });


</script>
    

  </head>
  <body>
  		

<div class="container">
  <div class="row">
    <a href="SalesPerMonth.php">
      <div class="col-md-4 ">
        <div class="indexBtn">
         <h3>Total Sales Per Month</h3>
          <canvas id="TotalSalesPM" width="720px" height="400px"></canvas>
        </div>  
      </div>
    </a>
      <a href="SPAge.php">
      <div class="col-md-4">
        <div class="indexBtn">
         <h3>Total Sales Per Age-Group</h3>
          <canvas id="ageGroupSales" width="720px" height="400px"></canvas>
          </div>
      </div>
    </a>
      <a href="SalesPerCustomerPerMonth.php">
      <div class="col-md-4">
        <div class="indexBtn">
         <h3>Top Customers for <?php  echo $monthName; ?></h3>
          <canvas id="customerSales" width="720px" height="400px"></canvas>
          </div>
      </div>
    </a>
  </div>  

  <div class="row">
    <a href="SalesPerMonth.php">
      <div class="col-md-4">
        <div class="indexBtn">
         <h3>Sales 2015 vs 2014</h3>
         <div id="legend"></div>
          <canvas id="salesLine" width="720px" height="400px"></canvas>
          </div>
      </div>
    </a>
      <a href="EmployeePerMonth.php">
      <div class="col-md-4">
        <div class="indexBtn">
         <h3>Total Employees in <?php  echo $monthName; ?></h3>
          <canvas id="topEmps" width="720px" height="400px"></canvas>
          </div>
      </div>
    </a>
      <a href="SalesPerMonthPerBranch.php">
      <div class="col-md-4">
        <div class="indexBtn">
         <h3>Top Branches for <?php  echo $monthName; ?></h3>
          <canvas id="topBranches" width="720px" height="400px"></canvas>
        </div>
      </div>
    </a>
  </div>
</div> 






    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>