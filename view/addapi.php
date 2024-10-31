<?php
$userid = 0;
$username = "";
$password = "";
$fromname = "";
$fromemail = "";
if(count($users)){
	foreach($users as $u){
		$username = $u->username;
		$password = $u->password;
		$fromname = $u->fromname;
		$fromemail = $u->fromemail;	
		$userid = $u->id;	
	}
}
?>
<html>
<head>
  
   <style>
   .main-body{
	   width:100%;
	   float:left;
	}
   .inputbox{
		margin: 0;
		padding:0;
		float: left;
		width: 100%;
	}
	.inputbox label {
		margin: 1em 0 0.5em 0;
		float: left;
		width: 100%;
		font-family: 'Josefin Sans', sans-serif;
		color: #0c0c0c;
		font-size: 1em;
	}
	.inputbox input[type="text"], .inputbox input[type="password"],.inputbox input[type="email"]{
	    width: 30%;
		border: 1px solid #999;
		padding: 8.5px 10px;
		font-size: 1em;
		outline: none;
		color: #999;
		float: left;
	}
	.inputbox input[type="submit"] {
		width: 10%;
		margin-top: 2em;
		padding: 8.5px 10px;
		font-size: 1em;
		outline: none;
		color: #fff;
		float: left;
		background: #000;
	}
	
   </style>
</head>
<body>
	<div class="main-body" >
		<form  name="userform" method="post" action="#" id="userform" enctype="multipart/form-data">
			<div class="inputbox">
				<input type="hidden" name="userid" id="userid" value="<?= $userid;?>" >
				<label>Username <span>*</span></label>
				<input type="text" name="username" placeholder="username" id="username" value="<?= $username;?>" required>
				<div class="clearfix"></div>
			</div>
			<div class="inputbox">
				<label>Password <span>*</span></label>
				<input type="password" name="password" placeholder="password" id="password" value="<?= $password; ?>" required>
				<div class="clearfix"></div>
			</div>			
			<div class="inputbox">
				<label>Fromname <span>*</span></label>
				<input type="text" name="fromname" placeholder="fromname" id="fromname" value="<?= $fromname; ?>" required>
				<div class="clearfix"></div>
			</div>
			<div class="inputbox">
				<label>Fromemail <span>*</span></label>
				<input type="email" name="fromemail" placeholder="fromemail" id="fromemail" value="<?= $fromemail; ?>" required>
				<div class="clearfix"></div>
			</div>
			<?php wp_nonce_field("pigeonmail_action_nonce"); ?>
			<div class="inputbox">
				<input type="submit" value="Submit"  title="Submit">			
				<div class="clearfix"></div>
			</div>
			<p id="message"></p>
		</form>
	</div>
</body>
</html>