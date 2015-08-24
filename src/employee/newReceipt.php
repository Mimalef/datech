<?php

session_start();

if(isset($_SESSION['code']))
{
    $valid = true;
	
	include('../connection.php');
	
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
	if($_GET['customer'] && $_GET['device'])
	{
		$valid = true;
		
		require_once('../connection.php');
		
		$query = $db->prepare('INSERT INTO receipt (
							  receiptCustomer,
							  receiptDevice,
							  receiptStatus,
							  receiptDate)
							  VALUES(?, ?, ?, ?)');
		$query->execute(array($_GET['customer'],
							  $_GET['device'],
							  $_GET['status'],
							  date('Y-m-d')))
		or
		header('location: index.php?err=خطای پایگاه داده.');
		
		header('location: index.php?msg=رسید با موفقیت ثبت شد.');
	}
	else
    {
        header('location: index.php?err=فیلد مشتری ، قطعه و وضعیت نمی تواند خالی باشد.');
    }
}
?>
<div id="contain" style="width: 400px">
	<h1>رسید</h1>
	<form method="get" action="newReceipt.php" >
		<?php
		if(isset($_GET['code']))
		{
		?>
			<input type="hidden" name="customer" value="<?php echo($_GET['code']) ?>" />
		<?php
		}
		else
		{
		?>
			<select name="customer">
				<?php
				$valid = true;
				
				require_once('../connection.php');
				
				$query = $db->prepare("SELECT customerCode,
									  customerName 
									  FROM customer
									  ORDER BY customerCode DESC");
				$query->execute()
				or
				header('location: index.php?err=خطای پایگاه داده.');
				
				while($data = $query->fetch())
				{
					echo('<option value="' . $data[0] . '">' . $data[1] . '</option>');
				}
				?>
			</select>
		<?php
		}
		?>
		<select name="device">
		<?php
			$valid = true;
			
			require_once('../connection.php');
			
			$query = $db->prepare("SELECT deviceCode,
								  deviceSerial 
								  FROM device 
								  ORDER BY deviceCode DESC");
			$query->execute()
			or
			header('location: index.php?err=خطای پایگاه داده.');
			
			while($row = $query->fetch())
			{
				echo('<option value="' . $row[0] . '">' . $row[1] . '</option>');
			}
		?>
		</select>
		<select name="status">
			<option value="0">در حال برسی </option>
			<option value="1">بازیابی شده </option>
			<option value="2">بازیابی نمی شود</option>
			<option value="3">تعمیر شده </option>
			<option value="4">تعمیر نمی شود </option>
			<option value="5">منتظر قطعه جایگزین</option>
			<option value="6">منتظر خبر مشتری </option>
		</select>
		<input name="submit" type="submit" class="button" value="ثبت" />
	</form>
</div>