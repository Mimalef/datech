<?php

session_start();

if(isset($_SESSION['code']))
{
    $valid = true;
	
	require_once('../connection.php');
	
	$query = $db->prepare("SELECT employeeRepairman, employeeRegistrar FROM employee WHERE employeeCode = ?");
	$query->execute(array($_SESSION['code']))
	or
	header('location: index.php?err=خطای پایگاه داده.');
	
	if($row = $query->fetch())
	{
		if(!$row[0] && !$row[1]) header('location: index.php?err=دسترسی غیرمجاز.');
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
        $delivery=NULL;
		
		if($_GET['received']) $delivery = date('Y-m-d');
		
        require_once('../connection.php');
		
		$query = $db->prepare('UPDATE receipt
							  SET receiptCustomer = ?,
							  receiptDevice = ?,
							  receiptStatus = ?,
							  receiptDelivery = ?,
							  receiptCost = ?,
							  receiptReceived = ?,
							  receiptPeripherals = ?,
							  receiptOpinion = ?
							  WHERE receiptCode = ?');
		$query->execute(array($_GET['customer'],
							  $_GET['device'],
							  $_GET['status'],
							  $delivery,
							  $_GET['cost'],
							  $_GET['received'],
							  trim($_GET['peripherals']),
							  trim($_GET['opinion']),
							  $_GET['code']))
		or
		header('location: index.php?err=خطای پایگاه داده.');
		
		header('location: index.php?msg=اطلاعات رسید با موفقیت ویرایش شد.');
	}
	else
    {
        header('location: index.php?err=فیلد ها نمی توانند خالی باشند.');
    }
}
?>
<div id="contain" style="width: 400px">
	<h1>ویرایش رسید</h1>
	<form method="get" action="editReceipt.php">
	<?php
	if(isset($_GET['code']))
	{
		$valid = true;
		
		require_once('../connection.php');
		
		$query = $db->prepare("SELECT employeeRepairman, employeeRegistrar
							  FROM employee
							  WHERE employeeCode = ?");
		$query->execute(array($_SESSION['code']))
		or
		header('location: index.php?err=خطای پایگاه داده.');
		
		if($row = $query->fetch())
		{
			$query = $db->prepare("SELECT receiptCustomer,
								  receiptDevice,
								  receiptStatus,
								  receiptCost,
								  receiptReceived,
								  receiptPeripherals,
								  receiptOpinion
								  FROM receipt
								  WHERE receiptCode = ?");
			$query->execute(array($_GET['code']))
			or
			header('location: index.php?err=خطای پایگاه داده.');
			
			$rec = $query->fetch();
			
	?>
			<fieldset>
				<input name="code" type="hidden" value="<?php echo($_GET['code']) ?>"/>
				<select name="customer">
					<?php
					$valid = true;
					
					require_once('../connection.php');
					
					$query = $db->prepare("SELECT customerCode, customerName
										  FROM customer
										  ORDER BY customerName");
					$query->execute()
					or
					header('location: index.php?err=خطای پایگاه داده.');
					
					while($data = $query->fetch())
					{
						$selected = NULL;
						if($rec[0] == $data[0] ) $selected = 'selected';
						echo('<option value="' . $data[0] . '"' . $selected . '>' . $data[1] . '</option>');
					}
					?>
				</select>
				<select name="device">
				<?php
					$valid = true;
					
					require_once('../connection.php');
					
					$query = $db->prepare("SELECT deviceCode, deviceSerial
										  FROM device
										  ORDER BY deviceSerial");
					$query->execute()
					or
					header('location: index.php?err=خطای پایگاه داده.');
					
					while($data = $query->fetch())
					{
						$selected = NULL;
						if($rec[1] == $data[0] ) $selected = 'selected';
						echo('<option value="' . $data[0] . '"' . $selected . '>' . $data[1] . '</option>');
					}
				?>
				</select>
				<input type="text" name="received" placeholder="دریافتی" />
				<input type="text" name="peripherals" placeholder="لوازم جانبی" />
			</fieldset>
			<fieldset>
				<select name="status">
					<option value="0" <?php if($rec[2] == 0) echo('selected') ?>>در حال برسی </option>
					<option value="1" <?php if($rec[2] == 1) echo('selected') ?>>بازیابی شده </option>
					<option value="2" <?php if($rec[2] == 2) echo('selected') ?>>بازیابی نمی شود</option>
					<option value="3" <?php if($rec[2] == 3) echo('selected') ?>>تعمیر شده </option>
					<option value="4" <?php if($rec[2] == 4) echo('selected') ?>>تعمیر نمی شود </option>
					<option value="5" <?php if($rec[2] == 5) echo('selected') ?>>منتظر قطعه جایگزین</option>
					<option value="6" <?php if($rec[2] == 6) echo('selected') ?>>منتظر خبر مشتری </option>
				</select>
				<input type="text" name="cost" placeholder="هزینه" />
				<input type="text" name="opinion" placeholder="نظر کارشناسی" />
			</fieldset>
	<?php
		}
	}
	?>
		<input name="submit" type="submit" class="button" value="ثبت" />
	</form>
</div>