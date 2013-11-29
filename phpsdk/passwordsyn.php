<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft Visual Studio 6.0">
<TITLE>otp test</TITLE>
<SCRIPT LANGUAGE=javascript>
 

function  InputCheck(form)
{

if (window.document.all.sninfo.value=="")
	{
		window.alert("sninfo is not null");
		window.document.all.sninfo.focus();
		return false;
	}

if (window.document.all.password.value=="")
	{
		window.alert("password is not null");
		window.document.all.password.focus();
		return false;
	}

return true;

}
 
</SCRIPT>

</HEAD>
<BODY>

<?php include("seamoonapi.php") ?>
<?php 
$pcb="";
$pcb= $_POST["sninfo"]; 

$key=new seamoonapi();

$password="";
$password=$_POST["password"];

$result="";
$result=$key->passwordsyn($pcb,$password);

 
?>


 <form name="LoginForm" method="post" action="passwordsyn.php" onSubmit="return InputCheck(this)">
<p>
<label for="username"  >sninfo:</label>
<textarea   name="sninfo" rows="3" cols="100" ><?php echo $pcb   ?></textarea>
<p>
<label for="password"  > password:</label>
<input id="password" name="password" type="text" class="input" >
<p>
<p>
<label for="return"  > return:</label>

<textarea   name="return" rows="3" cols="100" ><?php echo $result   ?></textarea>

 
<p>
<p>
<input type="submit" name="submit" value="passwordsyn"  class="left">&nbsp; 
  
</p>
</form>

</BODY>
</HTML>
