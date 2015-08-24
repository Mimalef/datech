<?php
session_start();

if(isset($_SESSION['code']))
{
    $valid = true;
	
	require_once('../connection.php');
	
	$query = $db->prepare("SELECT employeeManager
						  FROM employee
						  WHERE employeeCode = ?");
	$query->execute(array($_SESSION['code']))
	or
	header('location: index.php?err=خطای پایگاه داده.');
	
    if($row = $query->fetch())
    {
        if(!$row[0]) header('location: index.php?err=دسترسی غیرمجاز.');
    }
}
else
{
    header('location: login.php');
}

if(isset($_POST['submit']))
{
    if($_POST['name'] && $_POST['username'] && $_POST['password'])
    {
        $valid = true;
		
		if($_POST['manager']) $manager = 1;
		if($_POST['repairman']) $repairman = 1;
		if($_POST['registrar']) $registrar = 1;
        
        require_once('../connection.php');
        
        $query = $db->prepare("SELECT employeeUsername
							  FROM employee
							  WHERE employeeUsername = ?");
        $query->execute(array($_POST['username']))
        or
        header('location: index.php?err=خطای پایگاه داده.');
        
        $data = $query->fetch();
        if($_POST['username'] == $data[0])
        {
            header('location: index.php?err=این نام کاربری قبلا انتخاب شده.');
        }
        else
        {
            $query = $db->prepare('INSERT INTO employee
								  VALUES(NULL, ?, ?, ?, ?, ?, ?)');
            $query->execute(array(trim($_POST['name']),
								  trim($_POST['username']),
								  md5($_POST['password']),
								  $manager,
								  $repairman,
								  $registrar))
            or
            header('location: index.php?err=خطای پایگاه داده.');
            
            header('location: index.php?msg=کارمند با موفقیت ثبت سیستم شد.');
        }
    }
    else
    {
        header('location: index.php?err=فیلد نام، نام کاربری و کلمه عبور نمی تواند خالی باشد.');
    }
}
?>
<div id="contain" style="width: 400px">
	<h1>ثبت نام کارمند</h1>
    <form method="post" action="newEmployee.php">
        <input name="name" type="text" placeholder="نام و فامیل" />
        <input name="username" type="text" placeholder="کلمه کاربری" />
        <input name="password" type="password" placeholder="رمز عبور" />
		<label>مدیر</label>
        <input name="manager" type="checkbox" />
		<label>تعمیرکار</label>
        <input name="repairman" type="checkbox" />
		<label>مسول ثبت</label>
        <input name="registrar" type="checkbox" />
        <input class="button" name="submit" type="submit" value="ثبت" />
    </form>
</div>