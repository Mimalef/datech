<?php
if(isset($_GET['submit']))
{
	if($_GET['code'] && $_GET['mobile'])
	{
		$valid = true;

		include('../connection.php');
		
		$query = $db->prepare("SELECT customerCode FROM customer WHERE customerCode = ? AND customerMobile = ?");
		$query->execute(array(trim($_GET['code']), trim($_GET['mobile'])))
		or
		header('location: index.php?err=خطای پایگاه داده.');
	
		if($row = $query->fetch())
		{
			setcookie('code', $row[0]);
			header('location: index.php');
		}
		else
		{
			header('location: index.php?err=نام کاربری یا کلمه عبور اشتباه است. <a href="index.php">دوباره تلاش کنید.</a>');
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Customer Panel</title>
	<meta charset='utf-8'> 
	<link href="../style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<section id="menu">
	</section>
	<article>
		<div id="contain" style="width: 600px">
			<?php
			if(isset($_COOKIE['code']) && !isset($_GET['err']))
			{
			?>
				<h1>لیست رسیدهای شما</h1>
				<table class="result">
					<thead>
						<tr>
							<th><h2>کد</h2></th>
							<th><h2>نوع</h2></th>
							<th><h2>برند</h2></th>
							<th><h2>مدل</h2></th>
							<th><h2>وضعیت</h2></th>
							<th><h2>توضیحات</h2></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$valid = true;
						
						include('../connection.php');
						
						$query = $db->prepare("SELECT receiptCode, typeName, brandName, deviceModel, receiptStatus
                                              FROM receipt
                                              INNER JOIN customer
                                              ON receiptCustomer = customerCode
                                              INNER JOIN device
                                              ON receiptDevice = deviceCode
                                              INNER JOIN type
                                              ON deviceType = typeCode
                                              INNER JOIN brand
                                              ON deviceBrand = brandCode
											  WHERE customerCode = ?
											  ORDER BY receiptDate DESC");
						$query->execute(array($_COOKIE['code']))
                        or
                        die('<tr><td>SQL Error</td></tr>');
                        
                        while($row = $query->fetch())
                        {
							if($row[4] == 0) $status = '<span class="tool">T</span></td><td>در حال برسی ';
							if($row[4] == 1) $status = '<span class="tool">O</span></td><td>بازیابی شده ';
							if($row[4] == 2) $status = '<span class="tool">X</span></td><td>بازیابی نمی شود';
							if($row[4] == 3) $status = '<span class="tool">O</span></td><td>تعمیر شده ';
							if($row[4] == 4) $status = '<span class="tool">X</span></td><td>تعمیر نمی شود ';
							if($row[4] == 5) $status = '<span class="tool">T</span></td><td>منتظر قطعه ';
							if($row[4] == 6) $status = '<span class="tool">q</span></td><td>منتظر خبر مشتری ';
							echo('<tr><td>' .
                                 $row[0] .
                                 '</td><td>' .
                                 $row[1] .
                                 '</td><td>' .
                                 $row[2] .
                                 '</td><td>' .
                                 $row[3] .
                                 '</td><td>' .
                                 $status .
                                 '</td></tr>');
						}
						?>
					</tbody>
				</table>
			<?php
			}
			elseif(!isset($_GET['err']))
			{
			?>
				<h1>ورود به سیستم</h1>
				<form method="get">
					<input name="code" type="text" placeholder="کد مشتری" />
					<input name="mobile" type="text" placeholder="شماره مبایل" />
					<input name="submit" type="submit" class="button" value="ورود" />
				</form>
			<?php
			}
			if(isset($_GET['err']))
			{
			?>
				<h1 class="error">Error</h1>
				<p><?php echo($_GET['err']) ?></p>
			<?php
			}
			?>
		</div>
	</article>
</body>
</html>

