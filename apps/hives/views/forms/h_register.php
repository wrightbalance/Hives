		<div class="formWrapper">
					<div class="formInner">
						<h3>Create your Hives Account</h3>
						<form class="form" method="post" action="<?=site_url('signup/post')?>">
						<div class="fields">
							
							<div class="frow">
								<label for="firstname">First Name</label>
								<input type="text" class="textbox" name="firstname" id="firstname"/>
							</div>
							
							<div class="frow">
								<label for="lastname">Last Name</label>
								<input type="text" class="textbox" name="lastname" id="lastname"/>
							</div>
							
							<div class="frow">
								<label for="gender">Gender</label>
								<select name="gender" id="gender">
									<option value="">-Gender-</option>
									<option value="M">Male</option>
									<option value="F">Female</option>
								</select>
							</div>
							
							<div class="frow">
								<label for="email">Email Address</label>
								<input type="text" class="textbox" name="email" id="email"/>
							</div>
							
							<div class="frow">
								<label for="password">Prefered Password</label>
								<input type="password" class="textbox" name="password" id="password"/>
							</div>
							
							<div class="frow">
								<button class="btnBlue">Sign Up</button>
							</div>
							
					
						</div>
						</form>
					</div>
					
					<div class="frowGray">
						<a href="<?=site_url('login')?>" class="btnGreen">Already a Member? Just login</a>
					</div>
					
				</div>
				
