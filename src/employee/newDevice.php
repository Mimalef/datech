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
	if($_GET['newType'])
	{
		
		$valid = true;
		
		include('../connection.php');
        
        $query = $db->prepare('INSERT INTO type VALUES(NULL, ?)');
        $query->execute(array($_GET['newType']))
        or
        header('location: index.php?err=خطای پایگاه داده.');
		
		$query = $db->prepare("SELECT typeCode FROM type WHERE typeName = ?");
		$query->execute(array($_GET['newType']))
		or
		header('location: index.php?err=خطای پایگاه داده.');
		
		$row = $query->fetch();
		$_GET['type'] = $row[0];
	}
	
	if($_GET['newBrand'])
	{

		$valid = true;
		
		include('../connection.php');
        
        $query = $db->prepare('INSERT INTO brand VALUES(NULL, ?)');
        $query->execute(array($_GET['newBrand']))
        or
        header('location: index.php?err=خطای پایگاه داده.');
        
		$query = $db->prepare("SELECT brandCode FROM brand WHERE brandName = ?");
		$query->execute(array($_GET['newBrand']))
		or
		header('location: index.php?err=خطای پایگاه داده.');
		
		$row = $query->fetch();
		$_GET['brand'] = $row[0];
	}
	
	if($_GET['type'] && $_GET['brand'] && $_GET['serial'])
    {
		if(ctype_digit($_GET['type']) && ctype_digit($_GET['brand']))
		{
			$valid = true;
			
			include('../connection.php');
			
			$query = $db->prepare("SELECT deviceSerial FROM device WHERE deviceSerial = ?");
			$query->execute(array($_GET['serial']))
			or
			header('location: index.php?err=خطای پایگاه داده.');
			
			$row = $query->fetch();
			if($_GET['serial'] == $row[0])
			{
				header('location: index.php?err=Device already excited.');
			}
			else
			{
				$query = $db->prepare('INSERT INTO device VALUES(NULL, ?, ?, ?, ?, ?, ?)');
				$query->execute(array($_GET['type'],
									  $_GET['brand'],
									  trim($_GET['model']),
									  trim($_GET['serial']),
									  $_GET['capacity'],
									  trim($_GET['more'])))
				or
				header('location: index.php?err=خطای پایگاه داده.');
				
				header('location: index.php?msg=قطعه با موفقیت ثبت شد.');
			}
		}
		else
		{
			header('location: index.php?err=نوع داده مجاز نیست.');
		}
    }
    else
    {
        header('location: index.php?err=فیلد نوع و برند نمی تواند خالی باشد.');
    }
}
?>

<script>
	$(document).ready(function(){
		
		$("#newType").hide();
		$("#newBrand").hide();
		
		$("#type").click(function(){
			if($("#type").val() == "جدید...")
			{
				$("#type").hide();
				$("#newType").show(400);
			}
		});
		
		$("#brand").click(function(){
			if($("#brand").val() == "جدید...")
			{
				$("#brand").hide();
				$("#newBrand").show(400);
			}
		});
	});
</script>

<div id="contain" style="width: 400px">
	<h1>قطعه</h1>
	<form method="get" action="newDevice.php">
		<select id="type" name="type">
			<?php
			$valid = true;
			
			require_once('../connection.php');
			
			$query = $db->prepare("SELECT typeCode, typeName FROM type ORDER BY typeName");
			$query->execute()
			or
			header('location: index.php?err=خطای پایگاه داده.');
			
			while($row = $query->fetch())
			{
				echo('<option value="' . $row[0] . '">' . $row[1] . '</option>');
			}
			?>
			<option>جدید...</option>
		</select>
		<input id="newType" name="newType" type="text" placeholder="نوع جدید"/>
		<select id="brand" name="brand">
			<?php
			$valid = true;
			
			require_once('../connection.php');
			
			$query = $db->prepare("SELECT brandCode, brandName FROM brand ORDER BY brandName");
			$query->execute()
			or
			header('location: index.php?err=خطای پایگاه داده.');
			
			while($row = $query->fetch())
			{
				echo('<option value="' . $row[0] . '">' . $row[1] . '</option>');
			}
			?>
			<option>جدید...</option>
		</select>
		<input id="newBrand" name="newBrand" type="text" placeholder="برند جدید" />
		<input name="model" type="text" placeholder="مدل" />
		<input name="serial" type="text" placeholder="سریال" />
		<input name="capacity" type="text" placeholder="فضا" />
		<textarea name="more" placeholder="بیشتر"></textarea>
		<input name="submit" type="submit" class="button" value="ثبت" />
	</form>
</div>