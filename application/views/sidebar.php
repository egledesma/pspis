<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$region_code = $this->session->userdata('uregion');
$user_access = $this->session->userdata('access');
$uid = $this->session->userdata('uid');

?><div class="site-menubar">
	<div class="site-menubar-body">
		<div>
			<div>
				<ul class="site-menu">
					<li class="site-menu-category">General</li>

					<!------------------------ DASHBOARD ------------------------>
					<li class="site-menu-item">
						<a href="<?php echo base_url('dashboardc/dashboard/') ?>" data-slug="dashboard">
							<i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
							<span class="site-menu-title">Dashboard</span>
						</a>
					</li>

					<!------------------------ FUNDS ------------------------>
					<li class="site-menu-item has-sub">
						<a href="javascript:void(0)" data-slug="layout">
							<i class="site-menu-icon fa-money" aria-hidden="true"></i>
							<span class="site-menu-title">Funds</span>
							<span class="site-menu-arrow"></span>
						</a>
						<ul class="site-menu-sub">
							<?php if($region_code != "190000000") { } else {?>
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('cofunds/index/0') ?>" data-slug="uikit-buttons">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Consolidated Funds</span>
								</a>
							</li>
							<?php }?>
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('fundsallocation/index/0') ?>" data-slug="uikit-buttons">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Funds Allocation</span>
								</a>
							</li>
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('saa/index/0') ?>" data-slug="uikit-buttons">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">SAA</span>
								</a>
							</li>
						</ul>
					</li>

					<!------------------------ PROJECTS ------------------------>
					<li class="site-menu-item has-sub">
						<a href="javascript:void(0)" data-slug="layout">
							<i class="site-menu-icon wb-layout" aria-hidden="true"></i>
							<span class="site-menu-title">Projects</span>
							<span class="site-menu-arrow"></span>
						</a>
						<ul class="site-menu-sub">
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('individual/index') ?>" data-slug="uikit-buttons">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">AICS</span>
								</a>
							</li>
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('communities/index/0') ?>" data-slug="uikit-buttons">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">ACN</span>
								</a>
							</li>
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('cashforwork/index/0') ?>" data-slug="layout-grids">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Cash for Work</span>
								</a>
							</li>
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('foodforwork/index/0') ?>" data-slug="layout-grids">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Food for Work</span>
								</a>
							</li>
						</ul>
					</li>

					<!------------------------ REPORTS ------------------------>
					<li class="site-menu-item">
						<a href="<?php echo base_url('reports/index/') ?>" data-slug="Reports">
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
								<a class="animsition-link" href="<?php echo base_url('sourcefund/index') ?>" data-slug="layout-grids">
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
							<li class="site-menu-item">
								<a class="animsition-link" href="<?php echo base_url('status/index') ?>" data-slug="layout-grids">
									<i class="site-menu-icon " aria-hidden="true"></i>
									<span class="site-menu-title">Status</span>
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

					<li class="site-menu-item">
						<a class="animsition-link" href="<?php echo base_url('users/change_password/'.$uid.'') ?>" data-slug="app">
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