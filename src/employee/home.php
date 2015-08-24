<?php
session_start();
if(!isset($_SESSION['code'])) header('location: login.php');
?>
<div id="contain" style="width: 400px">
	<h1>خوش آمدید</h1>
	<P>شما با موفقیت وارد پنل خود شدید. با انتخاب یک گزینه از نوار ابزار به کار خود ادامه دهید.</P>
</div>