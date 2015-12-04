<?php
	require('connect.php');
    include('header.php');

	
	if(@$_POST['years'] && @$_POST['years'] != 26){
            $year = $_POST['years'];
            $yearTitle = 1989+$year;
            $yearTitle2 = 2015;
            $agSales = $agSales = "SELECT  Concat(e.e_fname, ' ', e.e_lname) as emp, s.spe_year_id as id, s.num_sales as sales, YEAR(m.end_date) as month
	       									FROM SPEYear as s
											Inner Join employee as e
											on e.emp_id = s.emp_id
	       									INNER JOIN year as m
	       									ON s.year_id = m.year_id
	       									WHERE s.year_id = $year
											order by sales desc";
											
											$agSales2 = "SELECT  Concat(e.e_fname, ' ', e.e_lname) as emp, s.spe_year_id as id, s.num_sales as sales, YEAR(m.end_date) as month
	       									FROM SPEYear as s
											Inner Join employee as e
											on e.emp_id = s.emp_id
	       									INNER JOIN year as m
	       									ON s.year_id = m.year_id
	       									WHERE s.year_id = 26 
											order by sales desc";

        } 
		else {
			$yearTitle = 2015;
			$yearTitle2 = 2014;
			 $agSales = "SELECT  Concat(e.e_fname, ' ', e.e_lname) as emp, s.spe_year_id as id, s.num_sales as sales, YEAR(m.end_date) as month
	       									FROM SPEYear as s
											Inner Join employee as e
											on e.emp_id = s.emp_id
	       									INNER JOIN year as m
	       									ON s.year_id = m.year_id
	       									WHERE s.year_id = 26
											order by sales desc";
											
											$agSales2 = "SELECT  Concat(e.e_fname, ' ', e.e_lname) as emp, s.spe_year_id as id, s.num_sales as sales, YEAR(m.end_date) as month
	       									FROM SPEYear as s
											Inner Join employee as e
											on e.emp_id = s.emp_id
	       									INNER JOIN year as m
	       									ON s.year_id = m.year_id
	       									WHERE s.year_id = 25 
											order by sales desc";
		}

    $check = mysqli_query($connect, $agSales);
	$rows = mysqli_num_rows($check);

   $lblPHP =array();
   $salesPHP = array();
   $count = 0;
   
   while($row = mysqli_fetch_assoc($check)){
   		$id = $row['id'];
   
	$lblPHP[$count] = $row['emp'];
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

	$lbl2PHP[$count] = $row['emp'];   	   
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
							             label: "<?php echo $yearTitle;  ?>",
							            fillColor: "rgba(11, 175, 230, 0.1)",
							            strokeColor: "#0BAFE6",
							            pointColor: "#0BAFE6",
							            pointStrokeColor: "#fff",
							            pointHighlightFill: "#24FF41",
							            pointHighlightStroke: "#24FF41",
							            data: salesArr
	       								 },
								        {
								            label: "<?php echo $yearTitle2;  ?>",
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
			<h3>Top Selling Employees for <?php echo $yearTitle;  ?>

</h3>
			<form action="EmployeePerYear.php" method="POST" class="form-group form-inline" >
					<select name="years" class="form-control" >
						<option selected="Selected" disabled="true">Choose a Year</option>
						<option value="26">2015</option>
						<option value="25">2014</option>
						<option value="24">2013</option>
						<option value="23">2012</option>
						<option value="22">2011</option>
						<option value="21">2010</option>
						<option value="20">2009</option>
						<option value="19">2008</option>
						<option value="18">2007</option>
						<option value="17">2006</option>
						<option value="16">2005</option>
						<option value="15">2004</option>
						<option value="14">2003</option>
						<option value="13">2002</option>
						<option value="12">2001</option>
						<option value="11">2000</option>
						<option value="10">1999</option>
						<option value="9">1998</option>
						<option value="8">1997</option>
						<option value="7">1996</option>
						<option value="6">1995</option>
						<option value="5">1994</option>
						<option value="4">1993</option>
						<option value="3">1992</option>
						<option value="2">1991</option>
  						<option value="1">1990</option>
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
		<div class="col-md-6">
		<form action="EployeePerMonth.php">
			<button class="btn btn-primary" type="submit">&lt; Monthly</button>
		</form>
	</div>

	<div class="col-md-6" style="text-align:right">
		<form action="EmployeePerQuarter.php">
			<button class="btn btn-primary" type="submit">Quarterly &gt;</button>
		</form>
	</div>
		</div>

		<div class="col-lg-4">
			<table class="table table-striped table-responsive">
        	<thead>
        		<th>Name</th>
        		<th><?php echo $yearTitle;  ?> Sales</th>
        		<th>Name</th>
        		<th><?php echo $yearTitle2;  ?> Sales</th>
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