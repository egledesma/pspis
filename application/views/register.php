<?php
/**
 * Created by Eugene Ledesma.
 * User: user
 * Date: 3/3/2016
 * Time: 10:47 AM
 */ ?>
<body class="page-register layout-full">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->


<!-- Page -->
<div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
     data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
        <div class="brand">
            <img class="brand-img" src="../../assets/images/logo.png" alt="...">
            <h2 class="brand-text">PSPIS</h2>
        </div>
        <p>Register</p>
        <form method="post" role="form" action="">
            <div class="form-group">
                <label class="sr-only" for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name">
            </div>
            <div class="form-group">
                <label class="sr-only" for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label class="sr-only" for="username">Full Name</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label class="sr-only" for="inputPassword">Password</label>
                <input type="password" class="form-control" id="inputPassword" name="password"
                       placeholder="Password">
            </div>
            <div class="form-group">
                <label class="sr-only" for="inputPasswordCheck">Retype Password</label>
                <input type="password" class="form-control" id="inputPasswordCheck" name="passwordCheck"
                       placeholder="Confirm Password">
            </div>
            <div class="form-group">
                <label class="sr-only" for="region">Region</label>
                <select name="regionlist" id="regionlist" class="form-control" onchange="get_prov();">
                    <option value="0">Choose Region</option>
                    <?php foreach($regionlist as $regionselect): ?>
                        <option value="<?php echo $regionselect->region_code; ?>"
                            <?php if(isset($_SESSION['region'])) {
                                if($regionselect->region_code == $_SESSION['region']) {
                                    echo " selected";
                                }
                            } ?>
                        >
                            <?php echo $regionselect->region_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        <p>Have account already? Please go to <a href="<?php echo base_url('users/login') ?>">Sign In</a></p>

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
