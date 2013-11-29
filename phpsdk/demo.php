<?php include("seamoonapi.php") ?>
<?php 
$pcb="SS000060797037495B64612700E588FF30EB1188336B7BBC8EE0749CE5DC7A41074C797E3C33136B199A5A3BF42B2E0F1FC75262C1832CFC0FC75262C1832CFC0FC75262C1832CFC08AFE67C892ABE2483D4E21D437E33E6825C99E25C7986A550E85EAEFBB7B12890E85EAEFBB7B12890E85EAEFBB7B12890E85EAEFBB7B12890E85EAEFBB7B12890E85EAEFBB7B1289==";
$key=new seamoonapi();

//check password
$result=$key->checkpassword($pcb,"991041");

echo  $result; 
echo "<br>";
if(strlen($result)>3)
{
    echo "pass";
    
}
else
{
  echo "error";
}

echo "<br>";

//token time sync
 $result=$key->passwordsyn($pcb,"145473");
 echo  $result;
 echo "<br>";
if(strlen($result)>3)
{
    echo "OK";
    
}
else
{
  echo "error";
}


?>
