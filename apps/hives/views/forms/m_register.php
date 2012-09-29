<div style="margin: 50px auto; width: 500px; background: #fff; color: #000; padding: 30px;">
	<div style="width: 250px; float: left">
		<h3>Login if you already have an account</h3>
		<form class="form" method="post" action="<?=site_url('auth/post')?>">
		<label>Email</label><br/>
		<input type="text" name="l_email"/><br/>

		<label>Password</label><br/>
		<input type="password" name="l_password"/><br/>

		<input type="submit" name="Login"/>
		<div class="response"></div>
		</form>

	</div>
	<div style="width: 250px; float: left">
		<h3>or create your account</h3>
		<br/>
		<form class="form" method="post" action="<?=site_url('signup/post')?>">
		<label>First Name</label><br/>
		<input type="text" name="firstname"/><br/>
		<label>Last Name</label><br/>
		<input type="text" name="lastname"/><br/>
		<label>Email</label><br/>
		<input type="text" name="email"/><br/>
		<label>Password</label><br/>
		<input type="password" name="password"/><br/>
		

		<input type="submit" value="Create Account"/>
		<div class="response"></div>
		</form>
	</div>
	<div style="clear: both"></div>
</div>
