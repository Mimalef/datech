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
	if($_GET['type'] && $_GET['brand'] && $_GET['model'] && $_GET['serial'])
    {
		$valid = true;
        
        require_once('../connection.php');
		
		$query = $db->prepare('UPDATE device
							  SET deviceType = ?,
							  deviceBrand = ?,
							  deviceModel = ?,
							  deviceSerial = ?,
							  deviceCapacity = ?,
							  deviceMore = ?
							  WHERE deviceCode = ?');
		$query->execute(array($_GET['type'],
							  $_GET['brand'],
							  trim($_GET['model']),
							  trim($_GET['serial']),
							  $_GET['capacity'],
							  trim($_GET['more']),
							  $_GET['code']))
		or
		header('location: index.php?err=خطای پایگاه داده.');
		
		header('location: index.php?msg=اطلاعات قطعه با موفقیت ویرایش شد.');
	}
	else
    {
        header('location: index.php?err=فیلد مدل و سریال نمی توانند خالی باشند.');
    }
}
if(isset($_GET['code']))
{
	$valid = true;
	
	require_once('../connection.php');
	
	$query = $db->prepare("SELECT deviceType,
						  deviceBrand,
						  deviceModel,
						  deviceSerial,
						  deviceCapacity,
						  deviceMore
						  FROM device
						  WHERE deviceCode = ?");
	$query->execute(array($_GET['code']))
	or
	header('location: index.php?err=خطای پایگاه داده.');
	
	$data = $query->fetch();
?>
	<div id="contain" style="width: 400px">
		<h1>ویرایش قطعه</h1>
		<form method="get" action="editDevice.php">
			<input name="code" type="hidden" value="<?php echo($_GET['code']) ?>"/>
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
					$selected = NULL;
					if($row[0] == $data[0] ) $selected = 'selected';
					echo('<option value="' . $row[0] . '"' . $selected . '>' . $row[1] . '</option>');
				}
				?>
				<option>جدید...</option>
			</select>
			<input id="newType" name="newType" type="text" placeholder="قطعه جدید"/>
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
					$selected = NULL;
					if($row[0] == $data[1] ) $selected = 'selected';
					echo('<option value="' . $row[0] . '"' . $selected . '>' . $row[1] . '</option>');
				}
				?>
				<option>جدید...</option>
			</select>
			<input id="newBrand" name="newBrand" type="text" placeholder="برند جدید" />
			<input name="model" type="text" value="<?php echo($data[2]) ?>" placeholder="مدل" />
			<input name="serial" type="text" value="<?php echo($data[3]) ?>" placeholder="سریال" />
			<input name="capacity" type="text" value="<?php echo($data[4]) ?>" placeholder="فضا" />
			<textarea name="more" placeholder="بیشتر"><?php echo($data[5]) ?></textarea>
			<input name="submit" type="submit" class="button" value="ثبت" />
		</form>
	</div>
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
<?php
}
?>