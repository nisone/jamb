<?php
	require_once('includes/head.php');
	if(!isset($_SESSION['regNo'])){
		$data = '<form name="data" method="POST" action="login.php">
				<input type="hidden" name="class" value="%s">
				<input type="hidden" name="error" value="%s">
				<input type="hidden" name="info" value="%s">
				<input type="hidden" name="warning" value="%s">
			</form>
			<script type="text/javascript">
				//alert(\'Processing...\');
				document.data.submit();
			</script>';
		echo sprintf($data, 'info', 'You are not logged in', 'Please login with your registration number', 'not registered? <a href=registration/register.php>click to register</a> online');
		exit();
	}

?>
<link rel="stylesheet" type="text/css" href="assets/datatables/datatables.css">
<div class="row">
	<div class="col-md-12">
		<div class="alert alert-info">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<span id="msg"><strong>Warning!</strong> There was a problem with yournetwork connection speed.</span>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-5">
		<div class="panel">
			<ul class="list-group">
				<li class="list-group-item"><strong>Center</strong>&nbsp;<?php echo $_SESSION['center']; ?></li>
				<li class="list-group-item"><strong>Details</strong>&nbsp;<?php echo $_SESSION['regNo'] . ' ' . $_SESSION['fullName']; ?></li>
				<li class="list-group-item"><strong>State</strong>&nbsp;<?php echo $_SESSION['state']; ?></li>
			</ul>
		</div>
	</div>
	<div class="col-md-5">
		<div class="panel" id="timerPanel">
			<strong><span class="glyphicon glyphicon-dashboard"></span>&nbsp;Remaining Time</strong>
			<h1 id="timer">00:00:00</h1>
			<button type="submit" class="btn btn-sm btn-primary">Submit</button>
		</div>
	</div>
	<div class="col-md-2">
		<img src="<?php echo $_SESSION['photo']; ?>" class="img-responsive" width="150px">
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<ul id="examsTab" class="nav nav-tabs">
			<?php
				$c = true; 
				foreach ($_SESSION['enroll'] as $row => $col) {
					$s = ($c) ? 'active' : '';
					$c = false;
				 	echo "<li><a class='tab-pane fade in " . ((!empty($s)?$s:'')) . "' href='#tab". $row ."' data-toggle='tab'>". $col ."</a></li>";
				 } 
			?>
		</ul>
		<div id="examsTabContent" class="tab-content">
			<?php
				$count = 1;
				foreach ($_SESSION['enroll'] as $row => $col) { 
			?>
			
			<div class="tab-pane fade in active" id="tab<?php echo $row; ?>">
				<p>
					<form id="form<?php echo $row ?>" action="test.php" method="POST">
					<table id="sub<?php echo $count ?>Table">
						<thead><tr><th>Attempt all questions</th></tr></thead>
						<tbody>
							<!-- <?php foreach ($_SESSION['qBank'][$row] as $x => $y) { ?> -->
							<?php $y = $_SESSION['qBank'][$row][$_SESSION['qPos'][$row]]; ?>
							<tr>
								<td>
									<div class="panel">
										<div class="panel-header">
											<h3 class="panel-title">Question <?php echo $y['extras']; ?></h3>
										</div>
										<div class="panel-body">
											<label for="name"><?php echo "Q".($_SESSION['qPos'][$row]+1)." ".$y['question']; ?> </label>
											<div class="radio">
												<strong>A.</strong>
												<label>
													<input type="radio" name="optCho" id="optionsRadios1" value="A"> <?php echo $y['opt_A'] ?>
												</label>
											</div>
											<div class="radio">
												<strong>B.</strong>
												<label>
													<input type="radio" name="optCho" id="optionsRadios2" value="B"> <?php echo $y['opt_B'] ?>
												</label>
											</div>
											<div class="radio">
												<strong>C.</strong>
												<label>
													<input type="radio" name="optCho" id="optionsRadios3" value="C"> <?php echo $y['opt_C'] ?>
												</label>
											</div>
											<div class="radio">
												<strong>D.</strong>
												<label>
													<input type="radio" name="optCho" id="optionsRadios4" value="D"> <?php echo $y['opt_D'] ?>
												</label>
											</div>
											<div class="radio">
												<strong>E.</strong>
												<label>
													<input type="radio" name="optCho" id="optionsRadios5" value="E"> <?php echo $y['opt_E'] ?>
												</label>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<!-- <?php } ?> -->
						</tbody>
					</table>
					</form>
				</p>
			</div>

			<?php
				$count++;	} ?>
		</div>
	</div>
</div>

<script type="text/javascript" src="assets/datatables/datatables.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#sub1Table, #sub2Table, #sub3Table, #sub4Table').DataTable({
			"processing": true,
			"pageLength": 1,
			"lengthChange": false,
			"info": false,
			"rowCallback": function( row, data, index ){
			},
			retrieve: true,
			paging: true,
			searching: false,
			ordering: false,
			stateSave: true
		});

		var countDownTime = new Date().getTime();
        countDownTime += 180000;

        // Update the count down every 1 second
        var x = setInterval(function() {

          // Get today's date and time
          var now = new Date().getTime();

          // Find the distance between now and the count down date
          var distance = countDownTime - now;

          // Time calculations for days, hours, minutes and seconds
          //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);

          // Display the result in the element with id="demo"
          document.getElementById("timer").innerHTML = hours + ":"
          + minutes + ":" + seconds;

          // If the count down is finished, write some text
          if(distance < 300000) {
             document.getElementById("timer").style.color = "red";
          } 

          if (distance < 0) {
            clearInterval(x);
            document.getElementById("timer").innerHTML = "EXPIRED";
            $('#action').val('Submit');
            $('#myForm').submit();
          }
        }, 1000);
	});

	$(document).on('keyup', function(e) {

			switch(e.which){
				case 65: //A
					$("#optionsRadios1, #opt1").prop('checked', true);
					break;
				case 66: //B
					$("#optionsRadios2, #opt2").prop('checked', true);
					break;
				case 67: //C
					$("#optionsRadios3, #opt3").prop('checked', true);
					break;
				case 68: //D
					$("#optionsRadios4, #opt4").prop('checked', true);
					break;
				case 69: //E
					$("#optionsRadios5,#opt5").prop('checked', true);
					break;
				case 37: //LeftArrow
				case 80: //P
					$('.previous').click();
					break;
				case 82: //RightArrow
				case 78: //N
					$('.next').click();
					break;
				case 83: //S (submit)
					$('#form').submit();
				case 13: //ENTER
					alert('OK');
					break;
				default:
					//event.preventDefault();
					break;
			}
		});
	
</script>
<?php
	require_once('includes/footer.php');
?>