<div id="contain" style="width: 800px">
<?php

session_start();

if(isset($_SESSION['code']))
{
    $valid = true;
    
    include('../connection.php');
    
    $query = $db->prepare("SELECT employeeManager, employeeRepairman, employeeRegistrar
                          FROM employee
                          WHERE employeeCode = ?");
    $query->execute(array($_SESSION['code']))
    or
    header('location: index.php?err=خطای پایگاه داده.');
    
    if($row = $query->fetch())
    {
        $u1 = $row[0];
        $u2 = $row[1];
        $u3 = $row[2];
        
        if($u1)
        {
?>
            <h1 onclick="toggleEmployee()">کارمندها</h1>
            <table id="employee" class="result">
                <thead>
                    <tr>
                        <th><h2>نام</h2></th>
                        <th><h2>نام کاربری</h2></th>
                        <th><h2>مدیر</h2></th>
                        <th><h2>تعمیرکار</h2></th>
                        <th><h2>مسول ثبت</h2></th>
                        <th><h2>ویرایش</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $q = '%' . $_GET['q'] . '%';
                        $query = $db->prepare("SELECT employeeName,
                                              employeeUsername,
                                              employeeManager,
                                              employeeRepairman,
                                              employeeRegistrar,
                                              employeeCode
                                              FROM employee
                                              WHERE employeeName LIKE ?
                                              OR employeeUsername LIKE ?
											  ORDER BY employeeUsername");
                        $query->execute(array($q, $q))
                        or
                        header('location: index.php?err=خطای پایگاه داده.');
                        
                        while($row = $query->fetch())
                        {
                            $manager = NULL;
                            $repairman = NULL;
                            $registerman = NULL;
                            if($row[2]) $manager = 's';
                            if($row[3]) $repairman = 's';
                            if($row[4]) $registerman = 's';
                            echo('<tr><td>' .
                                 $row[0] .
                                 '</td><td>' .
                                 $row[1] .
                                 '</td><td><span class="tool">' .
                                 $manager .
                                 '</span></td><td><span class="tool">' .
                                 $repairman .
                                 '</span></td><td><span class="tool">' .
                                 $registerman .
                                 '</span></td><td><span class="tool" onclick="employee(' .
                                 $row[5] .
                                 ')">w</span></td></tr>');
                        }
                    ?>
                </tbody>
            </table>
<?php
        }
		if($u2 || $u3)
		{
?>
			<h1 onclick="toggleRecipt()">رسید</h1>
            <table id="recipt" class="result">
                <thead>
                    <tr>
                        <th><h2>کد</h2></th>
                        <th><h2>نام</h2></th>
                        <th><h2>نوع</h2></th>
                        <th><h2>برند</h2></th>
                        <th><h2>مدل</h2></th>
                        <th><h2>سریال</h2></th>
                        <th><h2>ویرایش</h2></th>
                        <th><h2>پیرینت</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $q = '%' . $_GET['q'] . '%';
                        $query = $db->prepare("SELECT receiptCode,
											  customerName,
											  typeName,
											  brandName,
											  deviceModel,
											  deviceSerial
                                              FROM receipt
                                              INNER JOIN customer
                                              ON receiptCustomer = customerCode
                                              INNER JOIN device
                                              ON receiptDevice = deviceCode
                                              INNER JOIN type
                                              ON deviceType = typeCode
                                              INNER JOIN brand
                                              ON deviceBrand = brandCode
                                              WHERE receiptCode LIKE ?
                                              OR customerName LIKE ?
                                              OR deviceModel LIKE ?
                                              OR deviceSerial LIKE ?
                                              ORDER BY receiptDate DESC");
                        $query->execute(array($q, $q, $q, $q))
                        or
                        header('location: index.php?err=خطای پایگاه داده.');
                        
                        while($row = $query->fetch())
                        {
                            echo('<tr><td>' .
                                 $row[0] .
                                 '</td><td>' .
                                 $row[1] .
                                 '</td><td>' .
                                 $row[2] .
                                 '</td><td>' .
                                 $row[3] .
                                 '</td><td>' .
                                 $row[4] .
                                 '</td><td>' .
                                 $row[5] .
                                 '</td><td><span class="tool" onclick="receipt(' .
                                 $row[0] .
                                 ')">w</span></td><td><span class="tool"><a target="_blank" href="print.php?id=' .
                                 $row[0] .
                                 '">p</a></span></td></tr>');
                        }
                    ?>
                </tbody>
            </table>
<?php
		}
		if($u3)
		{
?>
			<h1 onclick="toggleCustomer()">مشتری</h1>
            <table id="customer" class="result">
                <thead>
                    <tr>
                        <th><h2>کد</h2></th>
                        <th><h2>نام</h2></th>
                        <th><h2>موسسه</h2></th>
                        <th><h2>موبایل</h2></th>
                        <th><h2>تلفن</h2></th>
                        <th><h2>ویرایش</h2></th>
                        <th><h2>ورود</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $q = '%' . $_GET['q'] . '%';
                        $query = $db->prepare("SELECT customerCode,
											  customerName,
											  customerCompany,
											  customerMobile,
											  customerTelephone
                                              FROM customer
                                              WHERE customerName LIKE ?
                                              OR customerCompany LIKE ?
											  ORDER BY customerCode DESC");
                        $query->execute(array($q, $q))
                        or
                        header('location: index.php?err=خطای پایگاه داده.');
                        
                        while($row = $query->fetch())
                        {
                            echo('<tr><td>' .
                                 $row[0] .
                                 '</td><td>' .
                                 $row[1] .
                                 '</td><td>' .
                                 $row[2] .
                                 '</td><td>' .
                                 $row[3] .
                                 '</td><td>' .
                                 $row[4] .
                                 '</td><td><span class="tool" onclick="customer(' .
                                 $row[0] .
                                 ')">w</span></td></td><td><span class="tool" onclick="insert(' .
                                 $row[0] .
                                 ')">@</span></td></tr>');
                        }
                    ?>
                </tbody>
            </table>
            <h1 onclick="toggleDevice()">قطعه</h1>
            <table id="device" class="result">
                <thead>
                    <tr>
                        <th><h2>نوع</h2></th>
                        <th><h2>برند</h2></th>
                        <th><h2>مدل</h2></th>
                        <th><h2>سریال</h2></th>
                        <th><h2>فضا</h2></th>
                        <th><h2>ویرایش</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $q = '%' . $_GET['q'] . '%';
                        $query = $db->prepare("SELECT typeName,
                                              brandName,
                                              deviceModel,
                                              deviceSerial,
                                              deviceCapacity,
                                              deviceCode
                                              FROM device
                                              INNER JOIN type
                                              ON deviceType = typeCode
                                              INNER JOIN brand
                                              ON deviceBrand = brandCode
                                              WHERE typeName LIKE ?
                                              OR brandName LIKE ?
                                              OR deviceModel LIKE ?
                                              OR deviceSerial LIKE ?
											  ORDER BY deviceCode DESC");
                        $query->execute(array($q, $q, $q, $q))
                        or
                        header('location: index.php?err=خطای پایگاه داده.');
                        
                        while($row = $query->fetch())
                        {
                            if($row[4] == 0) $row[4] = '<span>-</span>';
                            echo('<tr><td>' .
                                 $row[0] .
                                 '</td><td>' .
                                 $row[1] .
                                 '</td><td>' .
                                 $row[2] .
                                 '</td><td>' .
                                 $row[3] .
                                 '</td><td>' .
                                 $row[4] .
                                 '</td><td><span class="tool" onclick="device(' .
                                 $row[5] .
                                 ')">w</span></td></tr>');
                        }
                    ?>
                </tbody>
            </table>
<?php
		}
	}
}
else
{
    header('location: login.php');
}

?>
</div>
<script>
    function employee(employeeCode)
    {
        $.get("editEmployee.php", {code: employeeCode}, function(data)
        {
            $("article").html(data);
        });
    }
    function receipt(receiptCode)
    {
        $.get("editReceipt.php", {code: receiptCode}, function(data)
        {
            $("article").html(data);
        });
    }
    function customer(customerCode)
    {
        $.get("editCustomer.php", {code: customerCode}, function(data)
        {
            $("article").html(data);
        });
    }
    function device(deviceCode)
    {
        $.get("editDevice.php", {code: deviceCode}, function(data)
        {
            $("article").html(data);
        });
    }
    function insert(customerCode)
    {
        $.get("newReceipt.php", {code: customerCode}, function(data)
        {
            $("article").html(data);
        });
    }
    function toggleEmployee()
    {
        $("table#employee").toggle();
    }
    function toggleRecipt()
    {
        $("table#recipt").toggle();
    }
    function toggleCustomer()
    {
        $("table#customer").toggle();
    }
    function toggleDevice()
    {
        $("table#device").toggle();
    }
</script>