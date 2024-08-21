<h1>Signup page view</h1>
<form method="post">
	
	<input type="text" value="<?=old_value('username')?>" name="username" placeHolder="Username"><br>
	<div><?=$user->getError('username')?></div><br>
	<input type="text" value="<?=old_value('email')?>" name="email" placeHolder="Email"><br>
	<div><?=$user->getError('email')?></div><br>
	<input type="password" value="<?=old_value('password')?>" name="password" placeHolder="Password"><br>
	<div><?=$user->getError('password')?></div><br>
	<button>Signup</button>
</form>