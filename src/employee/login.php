<?php
if(isset($_POST['submit']))
{
	if($_POST['username'] && $_POST['password'])
	{
		$valid = true;

		include('../connection.php');
		
		$query = $db->prepare("SELECT employeeCode 
							  FROM employee 
							  WHERE employeeUsername = ? 
							  AND employeePassword = ?");
		$query->execute(array(trim($_POST['username']),
							  md5($_POST['password'])))
		or
		header('location: index.php?err=خطای پایگاه داده.');
	
		if($row = $query->fetch())
		{
			session_start();
			
			$_SESSION['code'] = $row[0];
			
			header('location: index.php');
		}
		else
		{
			header('location: index.php?err=نام کاربری یا کلمه عبور اشتباه است. <a href="index.php">دوباره تلاش کنید.</a>');
		}
	}
	else
	{
		header('location: index.php?err=فیلدها نمی توانند خالی باشند.');
	}
}
?>

<div id="contain" style="width: 400px">
	<h1>ورود به سیستم</h1>
	<form method="post" action="login.php">
		<input name="username" type="text" placeholder="نام کاربری" />
		<input name="password" type="password" placeholder="کلمه عبور" />
		<input name="submit" type="submit" class="button" value="ورود" />
	</form>
</div>