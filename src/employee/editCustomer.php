<?php
session_start();

if(isset($_SESSION['code']) && isset($_GET['code']))
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
							  WHERE customerCode = ?");
        $query->execute(array($_GET['code']))
        or
        header('location: index.php?err=خطای پایگاه داده.');
        
        $data = $query->fetch();
        if($_GET['mobile'] != $data[0])
        {
            $query = $db->prepare("SELECT customerMobile
								  FROM customer
								  WHERE customerMobile = ?");
			$query->execute(array($_GET['code']))
			or
			header('location: index.php?err=خطای پایگاه داده.');
			
			$data = $query->fetch();
			if($_GET['mobile'] == $data[0])
			{
				header('location: index.php?err=این شماره مبایل قبلا ثبت شده.');
			}
        }
		$query = $db->prepare('UPDATE customer
							  SET customerName = ?,
							  customerMobile = ?,
							  customerTelephone = ?,
							  customerCompany = ?,
							  customerAddress = ?
							  WHERE customerCode = ?');
		$query->execute(array(trim($_GET['name']),
							  trim($_GET['mobile']),
							  trim($_GET['telephone']),
							  trim($_GET['company']),
							  trim($_GET['address']),
							  $_GET['code']))
		or
		header('location: index.php?err=خطای پایگاه داده.');
		
		header('location: index.php?msg=اطلاعات مشتری با موفقیت ویرایش شد.');
    }
    else
    {
        header('location: index.php?err=فیلد نام و مبایل نمی تواند خالی باشد.');
    }
}

if(isset($_GET['code']))
{
	$valid = true;
	
	require_once('../connection.php');
	
	$query = $db->prepare("SELECT customerName,
						  customerMobile,
						  customerTelephone,
						  customerCompany,
						  customerAddress
						  FROM customer
						  WHERE customerCode = ?");
	$query->execute(array($_GET['code']))
	or
	header('location: index.php?err=خطای پایگاه داده.');
	
	$row = $query->fetch();
?>
	<div id="contain" style="width: 400px">
	<h1>ثبت نام مشتری</h1>
    <form method="get" action="editCustomer.php">
		<input name="code" type="hidden" value="<?php echo($_GET['code']) ?>"/>
        <input name="name" type="text" value="<?php echo($row[0]) ?>" placeholder="نام و فامیل"/>
        <input name="mobile" type="text" value="<?php echo($row[1]) ?>" placeholder="مبایل"/>
		<input name="telephone" type="text" value="<?php echo($row[2]) ?>" placeholder="تلفن"/>
		<input name="company" type="text" value="<?php echo($row[3]) ?>" placeholder="موسسه"/>
		<input name="address" type="text" value="<?php echo($row[4]) ?>" placeholder="آدرس"/>
        <input name="submit" type="submit" class="button" value=""ثبت />
    </form>
</div>
<?php
}
?>