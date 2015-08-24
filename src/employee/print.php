<?php

session_start();

if(isset($_SESSION['code']))
{
    $valid = true;
	
	include('../connection.php');
	
	$query = $db->prepare("SELECT employeeRegistrar FROM employee WHERE employeeCode = ?");
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

if(isset($_GET['id']))
{
    $valid = true;
    
    $query = $db->prepare("SELECT receiptDate,
						  receiptPeripherals,
						  receiptOpinion,
						  customerCode,
						  customerName,
						  customerCompany,
						  deviceModel,
						  deviceSerial,
						  deviceMore,
						  typeName,
						  brandName
						  FROM receipt
						  INNER JOIN customer
						  ON receiptCustomer = customerCode
						  INNER JOIN device
						  ON receiptDevice = deviceCode
						  INNER JOIN type
						  ON deviceType = typeCode
						  INNER JOIN brand
                          ON deviceBrand = brandCode
						  WHERE receiptCode = ?");
	$query->execute(array($_GET['id']))
	or
	header('location: index.php?err=خطای پایگاه داده.');
	
	$row = $query->fetch();
	
	$receiptCode = $_GET['id'];
	$receiptDate = $row[0];
	$receiptPeripherals = $row[1];
	$receiptOpinion = $row[2];
	$customerCode = $row[3];
	$customerName = $row[4];
	$customerCompany = $row[5];
	$deviceModel = $row[6];
	$deviceSerial = $row[7];
	$deviceMore = $row[8];
	$typeName = $row[9];
	$brandName = $row[10];
}
else
{
    header('location: index.php?err=دسترسی غیرمجاز.');
}
?>
<style>
	@charset "UTF-8";
	
	@font-face {
		font-family: koodak;
		src: url('../koodak.ttf');
	}
	
	body {
        height: 421px;
        width: 594px;
        margin-left: auto;
        margin-right: auto;
		padding:4px;
		direction: rtl;
		font-family: koodak;
    }
	table
	{
		text-align: right;
		font-size: 8pt;
		border-spacing: 0;
	}
	td
	{
		vertical-align: center;
	}
	.title
	{
		text-align: center;
		font-size: 12pt;
	}
	.font1
	{
		text-align: center;
		font-size: 6pt;
	}
	.font2
	{
		font-size: 6pt;
	}
	.en
	{
		font-family: 'Source Sans Pro', sans-serif;
		direction: ltr;
	}
	.td-header
	{
		width: 172px;
		text-align: center;
	}
	.td-logo
	{
		width: 250px;
	}
	.td-row
	{
		width: 100%;
	}
	.td-space
	{
		width: 50px;
	}
	.td-field
	{
		width: 123px;
	}
	.td-big-field
	{
		width: 371px;
	}
</style>
<head>
    <meta charset='utf-8'> 
</head>
<body onload="window.print(); window.close()">
	<table cellpadding="2" cellspacing="2">
		<tr>
		  <td colspan="2" rowspan="1" class="td-header">تلفن : 7655783 -7655795</td>
		  <td colspan="2" rowspan="1" class="td-logo"><img style="width: 250px; height: 64px;" alt="Data Technology" src="../images/data_technology.png"></td>
		  <td colspan="2" rowspan="1" class="td-header">آدرس : چهارراه خیام مجتمع تک یک طبقه منهای یک واحد 38</td>
		</tr>
		<tr>
		  <td colspan="6" rowspan="1" class="td-row title">برگه رسید مشتری</td>
		</tr>
		<tr>
		  <td colspan="6" rowspan="1" class="td-row font1">جهت دریافت اطلاعات فنی و پیگیری وضعیت کالای خود به سایت www.datatechnology.ir مراجعه فرمایید.</td>
		</tr>
		<tr>
		  <td colspan="6" rowspan="1" class="td-row font1" style="border-bottom: solid 1px;">مشتری گرامی برای وارد شدن به صفحه پیگیری قطعه باید کد مشتری و تلفن همراه خود را وارد کنید.</td>
		</tr>
		<tr>
		  <td class="td-space"></td>
		  <td class="td-field">شماره رسید:</td>
		  <td class="td-field"><?php echo($receiptCode) ?></td>
		  <td class="td-field">تاریخ دریافت:</td>
		  <td class="td-field"><?php echo($receiptDate) ?></td>
		  <td class="td-space"></td>
		</tr>
		<tr>
		  <td class="td-space"></td>
		  <td class="td-field">کد مشتری:</td>
		  <td class="td-field"><?php echo($customerCode) ?></td>
		  <td class="td-field">نوع قطعه:</td>
		  <td class="td-field en"><?php echo($typeName . ' (' . $brandName . ')') ?></td>
		  <td class="td-space"></td>
		</tr>
		<tr>
		  <td class="td-space"></td>
		  <td class="td-field">نام مشتری:</td>
		  <td class="td-field"><?php echo($customerName) ?></td>
		  <td class="td-field">مدل:</td>
		  <td class="td-field"><?php echo($deviceModel) ?></td>
		  <td class="td-space"></td>
		</tr>
		<tr>
		  <td class="td-space"></td>
		  <td class="td-field">نام شرکت:</td>
		  <td class="td-field"><?php echo($customerCompany) ?></td>
		  <td class="td-field">سریال:</td>
		  <td class="td-field"><?php echo($deviceSerial) ?></td>
		  <td class="td-space"></td>
		</tr>
		<tr>
		  <td class="td-space"></td>
		  <td class="td-field"></td>
		  <td class="td-field"></td>
		  <td class="td-field"></td>
		  <td class="td-field"></td>
		  <td class="td-space"></td>
		</tr>

		<tr>
		  <td class="td-space"></td>
		  <td class="td-field">متعلقات:</td>
		  <td colspan="3" rowspan="1" class="class="td-big-field"><?php echo($receiptPeripherals) ?></td>
		  <td class="td-space"></td>
		</tr>
		<tr>
		  <td class="td-space"> </td>
		  <td class="td-field">توضیحات: </td>
		  <td colspan="3" rowspan="1" class="class="td-big-field"><?php echo($receiptOpinion) ?></td>
		  <td class="td-space"></td>
		</tr>
		<tr>
		  <td class="td-space"> </td>
		  <td class="td-field">اظهارات مشتری:</td>
		  <td colspan="3" rowspan="1" class="class="td-big-field"><?php echo($deviceMore) ?></td>
		  <td class="td-space"></td>
		</tr>
		<tr>
		  <td colspan="6" rowspan="1" class="td-row" style="border-bottom: solid 1px;">اینجانب	.............. متعهد میگردم در صورت عدم تعمیر یا بازیابی اطلاعات	اعتراضی نسبت به این مرکز نداشته باشم و تمام شرایط در این فرم را میپذیرم </td>
		</tr>
		<tr>
		  <td colspan="6" rowspan="1" class="td-row font2">این	مرکزبه مدت دو ماه نگهدار کالا می باشد و پس از آن این مرکز هیچگونه	مسئولیتی در قبال تحویل دستگاه یا قطعه شما ندارد  </td>
		</tr>
		<tr>
		  <td colspan="6" rowspan="1" class="td-row font2">لطفا قبل از مراجه حضوری جهت دریافت کالا به صورت تلفنی و یا از طریق وب سایت از اماده بودن کالای خود اطمینان حاصل فرمایید </td>
		</tr>
		<tr>
		  <td colspan="6" rowspan="1" class="td-row font2">دستگاه /قطعه بدون برسی و تست فنی تحویل گرفته شده لذا خرابی و هزینه توسط بخش فنی اعلام خواهد شد  </td>
		</tr>
		<tr>
		  <td colspan="6" rowspan="1" class="td-row font2">در حفظ این رسید کوشا باشید المثنی صادر نخواهد شد و تحویل کالا فقط در قبال ارئه رسید امکان پذیر میباشد </td>
		</tr>
		<tr>
		  <td colspan="6" rowspan="1" class="td-row font2">اورنده این رسید صاحب کالا شناخته میشود  </td>
		</tr>
	</table>
</body>