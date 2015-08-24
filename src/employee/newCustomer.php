<?php
session_start();

if(isset($_SESSION['code']))
{
    $valid = true;
	
	require_once('../connection.php');
	
	$query = $db->prepare("SELECT employeeRegistrar
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
    if($_GET['name'] && $_GET['mobile'])
    {
        $valid = true;
        
        require_once('../connection.php');
        
        $query = $db->prepare("SELECT customerMobile
							  FROM customer
							  WHERE customerMobile = ?");
        $query->execute(array($_GET['mobile']))
        or
        header('location: index.php?err=خطای پایگاه داده.');
        
        $data = $query->fetch();
        if($_GET['mobile'] == $data[0])
        {
            header('location: index.php?err=این شماره مبایل قبلا ثبت شده.');
        }
        else
        {
            $query = $db->prepare('INSERT INTO customer
								  VALUES(NULL, ?, ?, ?, ?, ?)');
            $query->execute(array(trim($_GET['name']),
								  trim($_GET['mobile']),
								  trim($_GET['telephone']),
								  trim($_GET['company']),
								  trim($_GET['address'])))
            or
            header('location: index.php?err=خطای پایگاه داده.');
            
            header('location: index.php?msg=مشتری با موفقیت ثبت شد.');
        }
    }
    else
    {
        header('location: index.php?err=فیلد نام و مبایل نمی تواند خالی باشد.');
    }
}
?>
<div id="contain" style="width: 400px">
	<h1>ثبت نام مشتری</h1>
    <form method="get" action="newCustomer.php">
        <input name="name" type="text" placeholder="نام و فامیل" />
        <input name="mobile" type="text" placeholder="مبایل" />
		<input name="telephone" type="text" placeholder="تلفن" />
		<input name="company" type="text" placeholder="موسسه" />
		<input name="address" type="text" placeholder="آدرس" />
        <input name="submit" type="submit" class="button" value="ثبت" />
    </form>
</div>