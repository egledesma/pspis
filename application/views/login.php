<?php
/**
 * Created by JOSEF FRIEDRICH S. BALDO
 * Date Time: 10/17/15 11:16 PM
 * --
 * Michael
 *Leri
 * Leri II
 * mikel
 * YouGene
 * kel
 * josef
 * another
 */
if (!$this->session->userdata('user_data')){
echo validation_errors();
?>
	<body class="page-login layout-full">
	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->


	<!-- Page -->
	<div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
		 data-animsition-out="fade-out">>
		<div class="page-content vertical-align-middle">
			<div class="brand">
			<img class="brand-img" src="<?php base_url('assets/images/logo.png'); ?>" alt="...">
				<h2 class="brand-text">PSPIS</h2>
			</div>
			<p>SIGN-IN</p>
			<form method="post" action="">
				<div class="form-group">
					<label class="sr-only" for="username">Username</label>
					<input type="text" name="username" class="form-control" id="inputName" placeholder="Username" required>
				</div>
				<div class="form-group">
					<label class="sr-only" for="inputPassword">Password</label>
					<input type="password" class="form-control" id="inputPassword" name="password" required
						   placeholder="Password">
				</div>
				<div class="form-group clearfix">
					<div class="checkbox-custom checkbox-inline pull-left">
						<input type="checkbox" id="inputCheckbox" name="checkbox">
						<label for="inputCheckbox">Remember me</label>
					</div>
					<a class="pull-right" href="forgot-password.html">Forgot password?</a>
				</div>
				<button type="submit" class="btn btn-primary btn-block">Sign in</button>
			</form>
			<p>Still no account? Please go to <a href="<?php echo base_url('users/register') ?>">Register</a></p>

			<footer class="page-copyright">
				<p>DSWD IMB-BSSDCD</p>
				<p>© 2016. All RIGHT RESERVED.</p>
				<div class="social">
					<a href="javascript:void(0)">
						<i class="icon bd-twitter" aria-hidden="true"></i>
					</a>
					<a href="javascript:void(0)">
						<i class="icon bd-facebook" aria-hidden="true"></i>
					</a>
					<a href="javascript:void(0)">
						<i class="icon bd-dribbble" aria-hidden="true"></i>
					</a>
				</div>
			</footer>
		</div>
	</div>
	<!-- End Page -->



<?php } else { ?>
    <?php redirect('/dashboardc/dashboard','location'); ?>
<?php } ?>