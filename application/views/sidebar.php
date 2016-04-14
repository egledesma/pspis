<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?><div class="site-menubar">
	<div class="site-menubar-body">
		<div>
			<div>
				<ul class="site-menu">
					<li class="site-menu-category">General</li>

					<!------------------------ DASHBOARD ------------------------>
					<li class="site-menu-item has-sub active open">
						<a href="<?php echo base_url('dashboardc/dashboard') ?>" data-slug="dashboard">
							<i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
							<span class="site-menu-title">Dashboard</span>
							<div class="site-menu-badge">
								<span class="badge badge-success">2</span>
							</div>
						</a>
					</li>

					<!------------------------ MAIN MENU ------------------------>
					<li class="site-menu-item has-sub">
						<a href="javascript:void(0)" data-slug="layout">
							<i class="site-menu-icon wb-layout" aria-hidden="true"></i>
							<span class="site-menu-title">Main Menu</span>
							<span class="site-menu-arrow"></span>
						</a>
						<ul class="site-menu-sub">
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('fundsallocation/index') ?>" data-slug="uikit-buttons">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Funds Allocation</span>
								</a>
							</li>
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('individual/index') ?>" data-slug="uikit-buttons">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Individuals</span>
								</a>
							</li>
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('communities/index') ?>" data-slug="uikit-buttons">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Communities</span>
								</a>
							</li>
							<!--<li class="site-menu-item">
								<a class="animsition-link" href="javascript:void(0)" data-slug="layout-grids">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Food for Work</span>
								</a>
							</li>
							<li class="site-menu-item">
								<a class="animsition-link" href="javascript:void(0)" data-slug="layout-grids">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Cash for Work</span>
								</a>
							</li>-->
						</ul>
					</li>

					<!------------------------ REPORTS ------------------------>
					<li class="site-menu-item has-sub">
						<a href="javascript:void(0)" data-slug="layout">
							<i class="site-menu-icon fa-bar-chart" aria-hidden="true"></i>
							<span class="site-menu-title">Reports</span>
						</a>
					</li>



					<li class="site-menu-category">CONTROL</li>

					<!------------------------ LIBRARIES ------------------------>
					<li class="site-menu-item has-sub">
						<a href="javascript:void(0)" data-slug="layout">
							<i class="site-menu-icon wb-book" aria-hidden="true"></i>
							<span class="site-menu-title">Libraries</span>
							<span class="site-menu-arrow"></span>
						</a>
						<ul class="site-menu-sub">
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('lgu/index') ?>" data-slug="layout-grids">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">LGU Counterpart</span>
								</a>
							</li>
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('sourcefund/index/0') ?>" data-slug="layout-grids">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Source of Funds</span>
								</a>
							</li>
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('assistance/index') ?>" data-slug="layout-grids">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Type of Assistance</span>
								</a>
							</li>
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('worknature/index') ?>" data-slug="layout-grids">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Nature of Work</span>
								</a>
							</li>
						</ul>
					</li>


					<!------------------------ ACCESS CONTROL ------------------------>
					<li class="site-menu-item has-sub">
						<a href="javascript:void(0)" data-slug="uikit">
							<i class="site-menu-icon fa-user-plus" aria-hidden="true"></i>
							<span class="site-menu-title">Acces Control</span>
							<span class="site-menu-arrow"></span>
						</a>
						<ul class="site-menu-sub">
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('user/index') ?>" data-slug="layout-grids">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Users</span>
								</a>
							</li>
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('accesslevel/index') ?>" data-slug="layout-grids">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Access Level</span>
								</a>
							</li>



						</ul>
					</li>

					<li class="site-menu-category">PROFILE</li>

					<!------------------------ CHANGE PASSWORD ------------------------>
					<li class="site-menu-item has-sub">
						<a class="animsition-link" href="<?php echo base_url('users/change_password') ?>" data-slug="app">
							<i class="site-menu-icon wb-unlock" aria-hidden="true"></i>
							<span class="site-menu-title">Change Password</span>
						</a>
					</li>

					<!------------------------ LOG-OUT ------------------------>
					<li class="site-menu-item">
						<a class="animsition-link" href="<?php echo base_url('users/logout') ?>" data-slug="uikit-buttons">
							<i class="site-menu-icon wb-power" aria-hidden="true"></i>
							<span class="site-menu-title">Log-out</span>
						</a>
					</li>
				</ul>

			</div>
		</div>
	</div>

	<div class="site-menubar-footer">
		<a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip"
		   data-original-title="Settings">
			<span class="icon wb-settings" aria-hidden="true"></span>
		</a>
		<a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock">
			<span class="icon wb-eye-close" aria-hidden="true"></span>
		</a>
		<a href="<?php echo base_url('users/logout') ?>" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
			<span class="icon wb-power" aria-hidden="true"></span>
		</a>
	</div>
</div>