<?php
if(isset($valid) && $valid == true)
{
    try
    {
        $db = new PDO('mysql:dbname=data_technology;host=localhost', 'root', '');
        $db->exec("SET CHARACTER SET utf8");
    }
    catch(PDOException $e)
    {
        header('location: index.php?err=خطای پایگاه داده.');
    }
}
else
{
    header('location: index.php?err=دسترسی غیرمجاز.');
}
?>