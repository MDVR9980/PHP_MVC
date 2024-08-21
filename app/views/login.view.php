<h1>Login page view</h1>
<form method="post">
	
	<input type="text" <?=old_value('email')?>" name="email" placeHolder="Email"><br>
	<div><?=$user->getError('email')?></div><br>
	<input type="password"<?=old_value('password')?>" name="password" placeHolder="Password"><br>
	<div><?=$user->getError('password')?></div><br>
	<button>Login</button>
</form>