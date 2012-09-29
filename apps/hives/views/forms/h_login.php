
	<div class="formWrapper marginTop35">
		<div class="formInner">
			<h3>Login to your Hives Account</h3>
			<form class="form" method="post" action="<?=site_url('auth/post')?>">
			<div class="fields">
			
				<div class="frow">
					<label for="email">Email Address</label>
					<input type="text" class="textbox" name="email" id="email"/>
				</div>
				
				<div class="frow">
					<label for="password">Password</label>
					<input type="password" class="textbox" name="password" id="password"/>
				</div>
				
				<div class="frow">
					<button class="btnBlue">Sign In</button>
				</div>
				
				<div class="frow frowAction">
					<a href="">Forgot password</a>
					<a href="">Problem signing in?</a>
				</div>
			</div>
			</form>
		</div>
		
		<div class="frowGray">
			<a href="<?=site_url('register')?>" class="btnGreen">New to Hive? Create your account</a>
		</div>
		
	</div>
				
