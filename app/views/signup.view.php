<h1>Signup page view</h1>
<form method="post">
	
	<input value="<?=old_value('username')?>" name="username" placeHolder="Username"><br>
	<div><?=$user->getError('username')?></div><br>
	<input value="<?=old_value('email')?>" name="email" placeHolder="Email"><br>
	<div><?=$user->getError('email')?></div><br>
	<input value="<?=old_value('password')?>" name="password" placeHolder="Password"><br>
	<div><?=$user->getError('password')?></div><br>
	<button>Signup</button>
</form>