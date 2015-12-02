<?php
	require('connect.php');
    include('header.php');


			
if(@$_POST['months']){
            $month = $_POST['months'];
            $monthName = date('F', mktime(0, 0, 0, $month, 10));
            $agSales = "SELECT Concat(c.c_fname, ' ', c.c_lname) as name, s.spc_month_id as id, s.num_sales as sales, DATE_FORMAT(m.end_date,'%M') as month
	       									FROM SPCMonth as s
	       									INNER JOIN month as m
	       									ON s.month_id = m.month_id
	       									INNER JOIN customer as c
	       									ON c.c_id = s.c_id
	       									WHERE s.year_id = 26 and month(m.end_date) like $month
	       									ORDER BY sales Desc";

	       $agSales2 = "SELECT Concat(c.c_fname, ' ', c.c_lname) as name, s.spc_month_id as id, s.num_sales as sales, DATE_FORMAT(m.end_date,'%M') as month
	       									FROM SPCMonth as s
	       									INNER JOIN month as m
	       									ON s.month_id = m.month_id
	       									INNER JOIN customer as c
	       									ON c.c_id = s.c_id
	       									WHERE s.year_id = 25 and month(m.end_date) like $month
	       									ORDER BY sales Desc";									

        } 
        else{
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
}
	

	$agSalesSorted = "SELECT s.sp_month_id as id, s.num_sales as sales, DATE_FORMAT(m.end_date,'%M') as month
	       									FROM salespermonth as s
	       									INNER JOIN month as m
	       									ON s.month_id = m.month_id
	       									WHERE s.year_id = 26
	       									order by MONTH(m.end_date) Desc";

    $check = mysqli_query($connect, $agSales);
	$rows = mysqli_num_rows($check);

   $lblPHP =array();
   $salesPHP = array();
   $count = 0;
   
   while($row = mysqli_fetch_assoc($check)){
   		$id = $row['id'];
   
	$lblPHP[$count] = $row['name'];
	$salesPHP[$count] = $row['sales'];
	$count++;

	if($count == 10){
		break;
	}
		}

	$count = 0;
	$sales2PHP = array();
	$lbl2PHP =array();


	$check = mysqli_query($connect, $agSales2);
	$rows = mysqli_num_rows($check);

	while($row = mysqli_fetch_assoc($check)){
   		$id = $row['id'];

   	$lbl2PHP[$count] = $row['name'];   
	$sales2PHP[$count] = $row['sales'];
	$count++;
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
    <!-- Css -->
    <link href="css/style.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="js/jquery-2.1.4.js"></script>
    <!--Chart.js-->
    <script src="js/Chart.js"></script>
    <script type="text/javascript">
    function Line(){
    	document.getElementById('myChart').style.display='None';
    	document.getElementById('myChart2').style.display='Block';
    	document.getElementById('legend').style.display='Block';
    }

    function Bar(){
    	document.getElementById('myChart').style.display='Block';
    	document.getElementById('myChart2').style.display='None';
    	document.getElementById('legend').style.display='None';
    }

    function LineChart(){

				var lblArr = <?php echo json_encode($lblPHP); ?>;
				var salesArr = <?php echo json_encode($salesPHP); ?>;
				var sales2Arr = <?php echo json_encode($sales2PHP); ?>;
				
				

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
				var ctx = $("#myChart2").get(0).getContext("2d");
				var data = {
						    labels: lblArr,
						    datasets: [
						       			 {
							             label: "2015",
							            fillColor: "#0BAFE6",
							            strokeColor: "#0BAFE6",
							     highlightFill: "#77D0ED",
							            highlightStroke: "rgba(220,220,220,1)",
							         

							            data: salesArr
	       								 },
								        {
								            label: "2014",
								            fillColor: "#FF243D",
								            strokeColor: "#FF243D",
								            highlightFill: "#77D0ED",
							            highlightStroke: "rgba(220,220,220,1)",

								    
								            data: sales2Arr
								        }  
	       							  ]
							};

				var myLineChart = new Chart(ctx).Bar(data,options);

  document.getElementById("legend").innerHTML = myLineChart.generateLegend();

				}

				function BarChart(){

				var lblArr = <?php echo json_encode($lblPHP); ?>;
				var salesArr = <?php echo json_encode($salesPHP); ?>;

				options = {
						    responsive: true
						  };
				var ctx = $("#myChart").get(0).getContext("2d");
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
    	LineChart();
    	BarChart();
    	Bar();
    }) 

    
    </script>
  </head>
  <body >
  		

<div class="container">

	 <div class="row">

		<div class="col-lg-8">
			<h3>Top Sales Per Customer for <?php
			
			echo $monthName;
			?>

</h3>
			<form action="SalesPerCustomerPerMonth.php" method="POST" class="form-group form-inline" >
					<select name="months" class="form-control" >
						<option selected="Selected" disabled="true">Choose a Month</option>
  						<option value="1">January</option>
						<option value="2">February</option>
						<option value="3">March</option>
						<option value="4">April</option>
						<option value="5">May</option>
						<option value="6">June</option>
						<option value="7">July</option>
						<option value="8">August</option>
						<option value="9">September</option>
						<option value="10">October</option>
						<option value="11">Novermber</option>
						<option value="12">December</option>
					</select>
					<input type="submit" class="btn btn-info">

			</form>
			<div class="col-md-6">
			<button  class="btn btn-info" onclick="Bar();">2015</button>
			</div>
			<div class="col-md-6" style="text-align:right">
			<button  class="btn btn-info" onclick="Line();">Compare to 2014</button>
			</div>
			
			<center>
				<canvas id="myChart" width="720px" height="400px"></canvas>
				
				<div id = "legend" ></div>
				<canvas id="myChart2" width="720px" height="400px"></canvas>
			</center>
		</div>

		<div class="col-lg-4">
			<table class="table table-striped table-responsive">
        	<thead>
        		<th>Name</th>
        		<th>2015 Sales</th>
        		<th>Name</th>
        		<th>2014 Sales</th>
        	</thead>
        	<tbody>
      		<?php 
      		 
      		
	      for ($i = 0; $i < count($lblPHP); $i++){
	       		$id = $row['id'];
	       	echo "<tr>";
		       	echo "<td>".$lblPHP[$i]."</td>";
				echo "<td>".$salesPHP[$i]."</td>";
				echo "<td>".$lbl2PHP[$i]."</td>";
				echo "<td>".$sales2PHP[$i]."</td>";
	       	echo "</tr>";
	       	
			
       		}
       	?>
       </tbody>
		</table>
		</div>

		

	</div>


	<div class="row">

			<div class="col-lg-8">
					
				
				<center>
	</center>
			</div>

			<div class="col-lg-4">
				
			</div>

	</div>

</div> <!-- /container -->






    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>