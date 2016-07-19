<?php
/**
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
$region_code = $this->session->userdata('uregion');
if (!$this->session->userdata('user_data')){
error_reporting(0);
?>
	<body class="page-login layout-full">
	<!--[if lt IE 8]>
	<![endif]-->


	<!-- Page -->
	<div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
		 data-animsition-out="fade-out">>
		<div class="page-content vertical-align-middle">
			<div class="brand">
				<img class="brand-img" src="<?php echo base_url('assets/images/logo.png'); ?>" alt="...">
				<h2 class="brand-text">PSPIS</h2>
			</div>
			<p>FORGOT PASSWORD</p>
			<form method="post" action="">
				<div class="form-group"><?php echo $form_message;?><?php echo validation_errors(); ?>
					<label class="sr-only" for="username">Email Address</label>
					<input type="email" name="email" class="form-control" id="email" placeholder="Email Address" required>
				</div>
				<div class="form-group clearfix">
					<a class="pull-right" href="<?php echo base_url('users/index') ?>">Sign In Here</a>
				</div>
				<button type="submit" class="btn btn-primary btn-block">Forgot Password</button>
			</form>
			<p>Still no account? Please go to <a href="<?php echo base_url('users/register/0') ?>">Register</a></p>

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