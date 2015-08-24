<?php

session_start();

if(isset($_SESSION['code']))
{
	$valid = true;
	require_once('../connection.php');
	
	$query = $db->prepare("SELECT employeeName FROM employee WHERE employeeCode = ?");
	$query->execute(array($_SESSION['code']))
	or
	header('location: index.php?err=خطای پایگاه داده.');
	
	$row = $query->fetch();
	$name = $row[0];
}
else
{
    header('location: login.php');
}

if(isset($_POST['submit']))
{
    if($_POST['name'] && $_POST['password'])
    {
        $valid = true;
        
		require_once('../connection.php');
        
        $query = $db->prepare("SELECT employeePassword FROM employee WHERE employeeCode = ?");
        $query->execute(array($_SESSION['code']))
        or
        header('location: index.php?err=خطای پایگاه داده.');
		
		$row = $query->fetch();
		if(md5($_POST['password']) != $row[0])
		{
			header('location: index.php?err=کلمه عبور اشتباه است.');
		}
		else
		{
			if($_POST['newPassword'])
			{
				$query = $db->prepare('UPDATE employee 
									  SET employeePassword = ? 
									  WHERE  employeeCode = ?');
				$query->execute(array(md5($_POST['newPassword']),
									  $_SESSION['code']))
				or
				header('location: index.php?err=خطای پایگاه داده.');
			}
			
			$query = $db->prepare('UPDATE employee 
								  SET employeeName = ? 
								  WHERE  employeeCode = ?');
			$query->execute(array(trim($_POST['name']),
								  $_SESSION['code']))
			or
			header('location: index.php?err=خطای پایگاه داده.');
			
			header('location: index.php?msg=اطلاعات جدید با موفقیت ثبت شد.');
		}
    }
    else
    {
        header('location: index.php?err=فیلد نام و پسورد نمی تواند خالی باشد.');
    }
}

?>

<div id="contain" style="width: 400px">
	<h1>ویرایش اطلاعات</h1>
	<form method="post" action="edit.php">
		<input name="name" type="text" value="<?php echo("$name") ?>" placeholder="نام و فامیل" />
		<input name="newPassword" type="password" placeholder="پسورد جدید"/>
		<input name="password" type="password" placeholder="پسورد قدیم"/>
		<input class="button" name="submit" type="submit" value="ثبت" />
	</form>
</div>