<?php
/**
 * Created by Eugene Ledesma.
 * User: user
 * Date: 3/3/2016
 * Time: 10:47 AM
 */
error_reporting(0);
$form_validation = '<div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <?php echo validation_errors() ?> <a class="alert-link" href="javascript:void(0)"></a></div>';?>
<body class="page-register layout-full">
<!--[if lt IE 8]>

<![endif]-->


<!-- Page -->
<div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
     data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
        <div class="brand">
            <img class="brand-img" src="<?php echo base_url('assets/images/logobig.jpg'); ?>" alt="...">
            <h2 class="brand-text">PSPIS</h2>
        </div>
        <p>Register</p>
        <form method="post" action="">
              <div class="form-group">
                  <?php echo $form_message;?>
                <label class="sr-only" for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" value="<?php echo htmlspecialchars($_POST['fullname']); ?>" name="fullname" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <label class="sr-only" for="email">Email</label>
                <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($_POST['email']); ?>" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label class="sr-only" for="username">Full Name</label>
                <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($_POST['username']); ?>" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label class="sr-only" for="inputPassword">Password</label>
                <input type="password" maxlength="30" class="form-control" value="<?php echo htmlspecialchars($_POST['password']); ?>" id="password" name="password"
                       placeholder="Password" required>
            </div>
            <div class="form-group">
                <label class="sr-only" for="inputPasswordCheck">Retype Password</label>
                <input type="password"  maxlength="30"  class="form-control" value="<?php echo htmlspecialchars($_POST['password2']); ?>" id="password2" name="password2"
                       placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
                <label class="sr-only" for="region">Region</label>
                <select name="regionlist" id="regionlist" class="form-control" required>
                    <option value="">Choose Region</option>
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
