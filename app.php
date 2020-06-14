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

	if (isset($_REQUEST['s'])) {
		$subId = $_REQUEST['s'];
	}

?>
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
			<div class="btn-group">
				<button type="button" id="previous" class="btn btn-sm btn-default">Previous</button>
				<button type="button" id="submit" class="btn btn-sm btn-primary">Submit</button>
				<button type="button" id="next" class="btn btn-sm btn-default">Next</button>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<img src="<?php echo $_SESSION['photo']; ?>" class="img-responsive" width="150px">
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<ul id="exams" class="nav nav-tabs">
			<?php
				error_reporting(0);
				// foreach (@$_SESSION['enroll'] as $row => $col) {
				//  	echo "<li><a href='?s=". $row ."' >". $col ."</a></li>";
				//  } 

				echo "<li><a>" . $_SESSION['enroll'][$subId] . "</a></li>";
			?>
		</ul>
		<div class="row">
		<div id="examsContent" class="col-md-6">
			<form id="form" role="form" method="POST" action="gateway.php">
				<input type="hidden" name="subId" value="<?php echo $subId; ?>"> 
				<div class="panel">
					<div class="panel-header">
						<!-- <h3 class="panel-title" id="extras"></h3> -->
					</div>
					<div class="panel-body">
						<label for="name" id="question"></label>
						<div class="radio">
							<strong>A.</strong>
							<label>
								<input type="radio" name="optCho" id="optionsRadios1" value="A"> <span id="opt1Text"></span>
							</label>
						</div>
						<div class="radio">
							<strong>B.</strong>
							<label>
								<input type="radio" name="optCho" id="optionsRadios2" value="B"> <span id="opt2Text"></span>
							</label>
						</div>
						<div class="radio">
							<strong>C.</strong>
							<label>
								<input type="radio" name="optCho" id="optionsRadios3" value="C"> <span id="opt3Text"></span>
							</label>
						</div>
						<div class="radio">
							<strong>D.</strong>
							<label>
								<input type="radio" name="optCho" id="optionsRadios4" value="D"> <span id="opt4Text"></span>
							</label>
						</div>
						<div class="radio">
							<strong>E.</strong>
							<label>
								<input type="radio" name="optCho" id="optionsRadios5" value="E"> <span id="opt5Text"></span>
							</label>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-6">
			<div class="panel">
				<div class="panel-header"><h3 class="panel-title" id="extras"></h3></div>
			</div>
		</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		//load the first question
		$.getJSON("gateway.php?subId=<?php echo $subId; ?>&action=getCur&", getQuestion);

		//Handling timer
		//var countDownTime = new Date().getTime();
        //countDownTime += 5400000; // Hour = 3600000
        var distance;
     
        // Update the count down every 1 second
        var x = setInterval(function() {

          // Get today's date and time
          //var now = new Date().getTime();

          // Find the distance between now and the count down date
          //var distance = countDownTime - now;
          $.getJSON("gateway.php?subId=<?php echo $subId; ?>&action=getTime&", function(data, status, xhr){
          	if(status=='success'){
          		if(data.STATUS=='OK'){
          			distance = data.TIME*1000;
          		}
          	}
          });

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
            $('#form').submit();
          }
        }, 1000);

        $('#previous').on('click', function(e){
			var url = "gateway.php?";
			url += $('#form').serialize();
			url += "&action=prev";
			$.getJSON(url, getQuestion);
		});

		$('#next').on('click', function(e){
			var url = "gateway.php?";
			url += $('#form').serialize();
			url += "&action=next";
			$.getJSON(url, getQuestion);
		});

		$('#submit').on('click', function(e){
			var cho = confirm('Sure you want to submit Exams?','Alert!');
			if(cho == true){
				$('#form').submit();
			}
		});

		$('#form').on('submit', function(e){
			var url = "gateway.php?";
			url += $('#form').serialize();
			url += "&action=submit";
			$.getJSON(url, function(response, status, xhr){
				if(status == 'success'){
					if(response.STATUS != 'OK'){
						console.log(response.INFO);
						$('#form').submit();
					}else{
						console.log('Submitted');
						window.location.replace('index.php');
					}
				}
			});
			e.preventDefault();
		});

		function getQuestion(q){
			//alert('Loaded');
			if(q.ERROR){
				if(q.ERROR == 'No questions available for this subject.')
					$('#form').hide(); // hide the block from the document
				$('#examsContent').append('<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a><span id="msg"><strong>Warning!</strong>'+q.ERROR+'</span></div>');
			}else{
				if(q.extras==null){
					//$('#extras').remove(); //remove the block from the html
					$('#extras').html('<em>No extras</em>');
				}else{
					$('#extras').html(q.extras);
				}
				$('#question').html(q.question);
				$('#opt1Text').html(q.opt_A); $("#optionsRadios1, #opt1").prop('checked', false);
				$('#opt2Text').html(q.opt_B); $("#optionsRadios2, #opt2").prop('checked', false);
				$('#opt3Text').html(q.opt_C); $("#optionsRadios3, #opt3").prop('checked', false);
				$('#opt4Text').html(q.opt_D); $("#optionsRadios4, #opt4").prop('checked', false);
				$('#opt5Text').html(q.opt_E); $("#optionsRadios5, #opt5").prop('checked', false);
				if(q.cOptCho!=null & q.cOptCho!=''){
					switch(q.cOptCho){
						case 'A':
							$("#optionsRadios1, #opt1").prop('checked', true);
							break;
						case 'B':
							$("#optionsRadios2, #opt2").prop('checked', true);
							break;
						case 'C':
							$("#optionsRadios3, #opt3").prop('checked', true);
							break;
						case 'D':
							$("#optionsRadios4, #opt4").prop('checked', true);
							break;
						case 'E':
							$("#optionsRadios5, #opt5").prop('checked', true);
							break;
						default:
							break;
					}
				}
			}
		}
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
					$('#previous').click();
					break;
				case 82: //RightArrow
				case 78: //N
					$('#next').click();
					break;
				case 83: //S (submit)
					$('#form').submit();
					break;
				case 13: //ENTER
					alert('OK');
					break;
				default:
					//event.preventDefault();
					break;
			}
		});

	$(document).on('keydown', function(e){
		if(!e.metaKey){
			if(e.keyCode==116){
				//save timer before reload
				window.location.reload(true); //passing true force to reload page from server
			}
		}
		e.preventDefault();
	});

	$(document).on('change','[type="radio"]', function(){
		var url = "gateway.php?&action=updateOpt";
		var data = $('#form').serialize();
		//alert(data+url);
			$.getJSON(url, data, function(response, status, xhr){
				if(response.STATUS != 'OK'){
					console.log('Action failed, try again.');
					$('#examsContent').append('<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert">&times;</a><span id="msg"><strong>Warning!</strong>Option not saved try again</span></div>');
				}
			});
	});

	$(window).on('load', function(e){
		//alert("Loading...");
	});
	
</script>
<?php
	require_once('includes/footer.php');
?>