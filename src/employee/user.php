<?php
session_start();

if(isset($_SESSION['code']))
{
	$valid = true;
	$body = NULL;
	include('../connection.php');
		
	$query = $db->prepare("SELECT employeeManager, employeeRegistrar 
						  FROM employee 
						  WHERE employeeCode = ?");
	$query->execute(array($_SESSION['code']))
	or
	header('location: index.php?err=خطای پایگاه داده.');
	
	if($row = $query->fetch())
	{
		if($row[0] && !$row[1])
		{
			$head = '$("article").load("newEmployee.php");';
			
		}
		if($row[1] && !$row[0])
		{
			$head = '$("article").load("newCustomer.php");';
		}
		if($row[0] && $row[1])
		{
			$head = '$("#employee").click(function(){$("article").load("newEmployee.php");});$("#customer").click(function(){$("article").load("newCustomer.php");});';
			$body = '<div id="contain" style="width: 400px"><button class="button" id="employee">Employee</button><button class="button" id="customer">Customer</button></div>';
		}
		if(!$row[0] && !$row[1])
		{
			header('location: index.php?err=Unauthorised Access.');
		}
	}
}
else
{
    header('location: login.php');
}

?>

<script>
	<?php echo($head) ?>
</script>

<?php echo($body) ?>