<?php
	require('connect.php');
    include('header.php');

    $agSales = "SELECT s.sp_age_group_id as id, s.num_sales as sales, s.age_Group_id as ageId, ag.min_age as min, ag.max_age as max
	       									FROM SPAge_group as s
	       									INNER JOIN age_group as ag
	       									ON s.age_Group_id = ag.age_group_id";
    $check = mysqli_query($connect, $agSales);
	$rows = mysqli_num_rows($check);

   $lblPHP =array();
   $salesPHP = array();
   $count = 0;
   
   while($row = mysqli_fetch_assoc($check)){
   		$id = $row['id'];
   
	$lblPHP[$count] = "".$row['min']." - ".$row['max']."";
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
			<h3>Sales Per Age-Group</h3>
			
<center>
<canvas id="myChart" width="720px" height="400px">
		<script type="text/javascript">

			$(document).ready(function(){

				var lblArr = <?php echo json_encode($lblPHP); ?>;
				var salesArr = <?php echo json_encode($salesPHP); ?>;




				options = {
				    responsive: true
				  };

				var ctx = $("#myChart").get(0).getContext("2d");
				/*var data = {
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
*/

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
        label: lblArr[41]
    }
]

				var myBarChart = new Chart(ctx).Doughnut(data,options);

				})
		</script>

	</canvas>
	</center>

	</div>
  <!-- Main component for a primary marketing message or call to action -->


		<div class="col-lg-4">
			<table class="table table-striped table-responsive">
        	<thead>
        		<th>Age Range</th>
        		<th>Number of Sales</th>
        	</thead>
        	<tbody>
      		<?php 
      		 $check = mysqli_query($connect, $agSales);
      		$rows = mysqli_num_rows($check);
	       while($row = mysqli_fetch_assoc($check)){
	       		$id = $row['id'];
	       	echo "<tr>";
		       	echo "<td>".$row['min']." - ".$row['max']."</td>";
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