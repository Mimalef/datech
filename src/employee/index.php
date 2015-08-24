<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Data Technology - Employment Panel</title>
	<meta charset='utf-8'> 
	<link href="../style.css" rel="stylesheet" type="text/css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
	</script>
	<script>
	$(document).ready(function(){
		
		<?php
		if(!isset($_GET['msg']) && !isset($_GET['err']))
		{
		?>
			$("article").load("<?php if(isset($_SESSION['code'])) { echo('home.php'); } else { echo('login.php'); } ?>");
		<?php
		}
		?>
		
		$('#search').on('keyup', function(e) {
			if (e.which == 13) {
				$.get("search.php", {q: $('#search').val()}, function(data) {
					$("article").html(data);
				});
			}
		});
		
		$("li").click(function(){
			if($(this).attr("class") != "disable")
			{
				$("li").removeClass("active");
				$(this).addClass("active");
				
				if($(this).attr("id") == "home")
				{
					$("article").load("home.php");
				}
				
				if($(this).attr("id") == "register")
				{
					$("article").load("user.php");
				}
				
				if($(this).attr("id") == "device")
				{
					$("article").load("newDevice.php");
				}
				
				if($(this).attr("id") == "receipt")
				{
					$("article").load("newReceipt.php");
				}
				
				if($(this).attr("id") == "edit")
				{
					$("article").load("edit.php");
				}
			}
		});
	});
	</script>
</head>
<body>
	<section id="menu">
		<nav>
			<?php
			if(isset($_SESSION['code']))
			{
				$valid = true;
				
				include('../connection.php');
				
				$query = $db->prepare("SELECT employeeManager,
									  employeeRepairman,
									  employeeRegistrar
									  FROM employee
									  WHERE employeeCode = ?");
				$query->execute(array($_SESSION['code']))
				or
				header('location: index.php?err=خطای پایگاه داده.');
				
				if($row = $query->fetch())
				{
			?>
					<ul id="admin-bar">
						<li id="home" title="خانه" class="enable">H</li>
						<li id="register" title="ثبت نام" class="<?php if(!$row[0] && !$row[2]) { echo('disable'); } else { echo('enable'); } ?>">A</li>
						<li id="device" title="قطعه" class="<?php if(!$row[2]) { echo('disable'); } else { echo('enable'); } ?>">C</li>
						<li id="receipt" title="رسید" class="<?php if(!$row[2]){ echo('disable'); } else { echo('enable'); } ?>">D</li>
						<li id="Stats" title="وظعیت" class="<?php if(!$row[0]) { echo('disable'); } else { echo('disable'); } ?>">v</li>
						<li id="edit" title="ویرایش" class="enable">G</li>
					</ul>
					<input id="search" name="search" type="text" placeholder="جستجو" >
					<a id="logout" href="logout.php">خروج</a>
			<?php
				}
			}
			?>
		</nav>
	</section>
	<article>
		
	<?php
	if(isset($_GET['msg']))
	{
	?>
	<div id="contain" style="width: 400px">
		<h1 class="success">موفقیت</h1>
		<p><?php echo($_GET['msg']) ?></p>
	</div>
	<?php
	}
	elseif(isset($_GET['err']))
	{
	?>
	<div id="contain" style="width: 400px">
		<h1 class="error">خطا</h1>
		<p><?php echo($_GET['err']) ?></p>
	</div>
	<?php
	}
	?>
		<noscript>برای ادامه کار باید جاوااسکریپت فعال باشد.</noscript>
	</article>
</body>
</html>