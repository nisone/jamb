<?php
 // var_dump($_REQUEST);
 // if($_SERVER['HTTP_USER_AGENT']=='nisone API' && $_SERVER['SERVER_ADDR']==$_SERVER['REMOTE_ADDR'])
 // foreach ($_SERVER as $row => $col) {
 // 	echo $row . ' ' . $col . '<br>';
 // }
//session_start();

// try{
// throw new Exception("Error Processing Request", 1);
// }catch(Exception $e){
// 	echo $e->getMessage();
// }
//$_SESSION['qBank'][1][0]['cOptCho'] = 'C';
//print_r($_SESSION['qBank']);
//var_dump($_SESSION['qAns'])

//echo count($_SESSION['qBank']).' '.Count($_SESSION['qBank'][1]).' '.(($_SESSION['qBank'][1][0]['extras']===NULL)?'yes':'NO');

// $sum = 0;
// foreach ($_SESSION['qBank'][1] as $key => $value) {
// 	$sum += $value['mark'];
// }
// echo $sum;

// $nextWeek = time() + (7 * 24 * 60 * 60);
//                    // 7 days; 24 hours; 60 mins; 60 secs
// echo 'Now:       '. date('Y-m-d') ."\n";
// echo 'Next Week: '. date('Y-m-d', $nextWeek) ."\n";
// // or using strtotime():
// echo 'Next Week: '. date('Y-m-d', strtotime('+1 week')) ."\n";


#Testing result printing
/*
require('includes/config.php');
$db->test();
$results = $db->getRows("SELECT DISTINCT(user_id),score FROM jamb_result WHERE subject_id=1");
foreach ($results as $row) {
	# code...
	$name = $db->getRow("SELECT fname, lname FROM user_profile WHERE user_id=$row[user_id]");
	echo "<p>" . $name['fname'] . " " . strtoupper($name['lname']) . " " . $row['score'] . "</p>";
}
*/
?>





























<!-- <script type="text/javascript">
	alert("<?php echo 'Hello javascript, this is PHP'; ?>");
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
</script> -->




















