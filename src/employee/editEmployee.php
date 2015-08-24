<?php
session_start();

if(isset($_SESSION['code']) && isset($_GET['code']))
{
    $valid = true;
	
	include('../connection.php');
	
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
if(isset($_GET['submit']))
{
    if($_GET['name'] && $_GET['username'])
    {
        $valid = true;
		
		if($_GET['manager']) $manager = 1;
		if($_GET['repairman']) $repairman = 1;
		if($_GET['registrar']) $registrar = 1;
        
        require_once('../connection.php');
        
        $query = $db->prepare("SELECT employeeUsername
							  FROM employee
							  WHERE employeeCode = ?");
        $query->execute(array($_GET['code']))
        or
        header('location: index.php?err=خطای پایگاه داده.');
        
        $data = $query->fetch();
        if($_GET['username'] != $data[0])
        {
            $query = $db->prepare("SELECT employeeUsername
								  FROM employee
								  WHERE employeeUsername = ?");
			$query->execute(array($_GET['username']))
			or
			header('location: index.php?err=خطای پایگاه داده.');
			
			$data = $query->fetch();
			if($_GET['username'] == $data[0])
			{
				header('location: index.php?err=این نام کاربری فبلا ثبت شده.');
			}
        }
		$query = $db->prepare('UPDATE employee
							  SET employeeName = ?,
							  employeeUsername = ?,
							  employeeManager = ?,
							  employeeRepairman = ?,
							  employeeRegistrar = ?
							  WHERE employeeCode = ?');
		$query->execute(array(trim($_GET['name']),
							  trim($_GET['username']),
							  $manager,
							  $repairman,
							  $registrar,
							  $_GET['code']))
		or
		header('location: index.php?err=خطای پایگاه داده.');
		
		header('location: index.php?msg=اطلاعات کارمند با موفقیت ویرایش شد.');
    }
    else
    {
        header('location: index.php?err=فیلد نام و پسورد نمی تواند خالی باشد.');
    }
}
if(isset($_GET['code']))
{
	$valid = true;
	
	require_once('../connection.php');
	
	$query = $db->prepare("SELECT employeeName,
						  employeeUsername,
						  employeeManager,
						  employeeRepairman,
						  employeeRegistrar
						  FROM employee
						  WHERE employeeCode = ?");
	$query->execute(array($_GET['code']))
	or
	header('location: index.php?err=SQL failed.');
	
	$row = $query->fetch();
?>
	<div id="contain" style="width: 400px">
	<h1>ویرایش اطلاعات کارمند</h1>
    <form method="get" action="editEmployee.php">
		<input name="code" type="hidden" value="<?php echo($_GET['code']) ?>"/>
        <input name="name" type="text" value="<?php echo($row[0]) ?>" placeholder="نام و فامیل"/>
        <input name="username" type="text" value="<?php echo($row[1]) ?>" placeholder="نام کاربری" />
		<label>مدیر</label>
        <input name="manager" type="checkbox" <?php if($row[2]) echo('checked') ?>/>
		<label>تعمیرکار</label>
        <input name="repairman" type="checkbox" <?php if($row[3]) echo('checked') ?>/>
		<label>مسول ثبت</label>
        <input name="registrar" type="checkbox" <?php if($row[4]) echo('checked') ?>/>
        <input name="submit" type="submit" class="button" value="ثبت" />
    </form>
</div>
<?php
}
?>