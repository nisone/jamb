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
<div class="col-md-8" id="leftContent">
	<div class="well">
		<span class="glyphicon glyphicon-map-marker"></span>&nbsp;Home / Examination
	</div>
	<div>
		<p class="pull-left">
			<span class="glyphicon glyphicon-user"></span> Logged in with <?php echo $_SESSION['regNo']; ?>
		</p> 
		<button class="btn btn-sm btn-danger pull-right" onclick="window.location = 'scripts/logout.php'">
			<span class="glyphicon glyphicon-off"></span> Log Out
		</button>
	</div>
	<div style="clear: both;">
		<h2>Available examinations</h2>
		<table class="table table-hover table-bordered table-responsive">
			<thead>
				<tr>
					<th>S/N</th>
					<th>Code</th>
					<th>Title</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$subject = $db->getRows('SELECT * FROM jamb_enrollment WHERE user_id=?', [$_SESSION['user_id']]);
					//$_SESSION['enroll'] = [];
					foreach ($subject as $row => $col) {
						$title = $db->getRow('SELECT title FROM jamb_subject WHERE id=?', [$col['subject_id']])['title'];
						echo "<tr><td>".++$row."</td><td>0$col[subject_id]0</td><td>$title</td></tr>";

						$_SESSION['enroll'][$col['subject_id']] = $title;
						$_SESSION['qBank'][$col['subject_id']] = $db->getRows('SELECT * FROM jamb_question WHERE subject_id=? LIMIT 50', [$col['subject_id']]);
						$_SESSION['qAns'][$col['subject_id']] = 0;
						$_SESSION['qPos'][$col['subject_id']] = 0;
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="3"><button class="btn btn-success" onclick="window.location = 'app.php'">
						<span class="glyphicon glyphicon-pencil"></span> Start exam
					</button></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<div class="col-md-4" id="rightContent">
	<center><img src="<?php echo $_SESSION['photo']; ?>" class="img-responsive img-circle" alt="Profile" width="150px" hspace="10px"></center>
	<ul>
		<li><strong><?php echo $_SESSION['fullName']; ?></strong></li>
		<li><?php echo $_SESSION['regNo']; ?></li>
		<li><strong>Center</strong>&nbsp;<?php echo $_SESSION["center"]; ?></li>
		<li>Examinations
			<ul>
				<li>JAMB UTME <?php echo date('Y'); ?> e-Test</li>
			</ul></li>
		<li>
			<button class="btn btn-sm btn-danger" onclick="window.location = 'scripts/logout.php'">
				<span class="glyphicon glyphicon-off"></span> Log Out
			</button>
		</li>
	</ul>
	
</div>


<?php
	require_once('includes/footer.php');
?>