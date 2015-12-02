<?php
	require('connect.php');
    include('header.php');

    $agSales = "SELECT s.sp_year_id as id, s.num_sales as sales, YEAR(y.end_date) as year
	       									FROM salesperyear as s
	       									INNER JOIN year as y
	       									ON s.year_id = y.year_id";

	$agSalesSorted = "SELECT s.sp_year_id as id, s.num_sales as sales, YEAR(y.end_date) as year
	       									FROM salesperyear as s
	       									INNER JOIN year as y
	       									ON s.year_id = y.year_id
	       									order by year Desc";

    $check = mysqli_query($connect, $agSales);
	$rows = mysqli_num_rows($check);

   $lblPHP =array();
   $salesPHP = array();
   $count = 0;
   
   while($row = mysqli_fetch_assoc($check)){
   		$id = $row['id'];
   
	$lblPHP[$count] = $row['year'];
	$salesPHP[$count] = $row['sales'];
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
    <!-- jQuery -->
    <script src="js/jquery-2.1.4.js"></script>
    <!--Chart.js-->
    <script src="js/Chart.js">
	
    </script>

  </head>
  <body>
  		

<div class="container">

	 <div class="row">

		<div class="col-lg-8">
			<h3>Sales Per Year</h3>
			
<center>
<canvas id="myChart" width="720px" height="400px">
		<script type="text/javascript">

			$(document).ready(function(){

				var lblArr = <?php echo json_encode($lblPHP); ?>;
				var salesArr = <?php echo json_encode($salesPHP); ?>;

				options = {
						    responsive: true,
						    
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

				})
		</script>

	</canvas>
	</center>


	<div class="col-md-6">
		<form action="SalesPerMonth.php">
			<button class="btn btn-primary" type="submit">&lt; Monthly</button>
		</form>
	</div>

	<div class="col-md-6" style="text-align:right">
		<form action="SalesPerQuarter.php">
			<button class="btn btn-primary" type="submit">Quarterly &gt;</button>
		</form>
	</div>
</div>
	
  <!-- Main component for a primary marketing message or call to action -->
  

		<div class="col-lg-4">
			<table class="table table-striped table-responsive">
        	<thead>
        		<th>Year</th>
        		<th>Number of Sales</th>
        	</thead>
        	<tbody>
      		<?php 
      		 $check = mysqli_query($connect, $agSalesSorted);
      		$rows = mysqli_num_rows($check);
	       while($row = mysqli_fetch_assoc($check)){
	       		$id = $row['id'];
	       	echo "<tr>";
		       	echo "<td>".$row['year']."</td>";
				echo "<td>".$row['sales']."</td>";
	       	echo "</tr>";
			
       		}
       	?>
       </tbody>
		</table>
		</div>

		

	</div>

</div> <!-- /container -->






    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>