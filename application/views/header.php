<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>


<!DOCTYPE html>
<html class="no-js before-run" lang="en" ng-app="AngularApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap admin template">
    <meta name="author" content="">

    <title>PSPIS- Funds Monitoring Tool</title>

    <link rel="apple-touch-icon" href="<?php echo base_url('assets/images/apple-touch-icon.png'); ?>">
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <link href="<?php echo base_url('assets/bootstrap/css/root.css'); ?>" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-extend.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/site.min.css'); ?>">

    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/animsition/animsition.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/asscrollable/asScrollable.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/switchery/switchery.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/intro-js/introjs.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/slidepanel/slidePanel.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/flag-icon-css/flag-icon.css'); ?>">


    <!-- Fonts -->
    <link rel="stylesheet" href="<?php echo base_url('assets/fonts/web-icons/web-icons.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/fonts/font-awesome/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/fonts/brand-icons/brand-icons.min.css'); ?>">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>


    <!-- Plugin -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/chartist-js/chartist.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/jvectormap/jquery-jvectormap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/toastr/toastr.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap-sweetalert/sweet-alert.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/datatables-bootstrap/dataTables.bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/datatables-fixedheader/dataTables.fixedHeader.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/datatables-responsive/dataTables.responsive.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/alertify-js/alertify.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/jquery-wizard/jquery-wizard.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap-datepicker/bootstrap-datepicker.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/formvalidation/formValidation.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/asscrollable/asScrollable.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets//vendor/bootstrap-select/bootstrap-select.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/select2/select2.css'); ?>">

    <!-- Page -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/../fonts/weather-icons/weather-icons.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/dashboard/v1.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/pages/login.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/pages/register.css'); ?>">

    <!-- Scripts -->
    <script src="<?php echo base_url('assets/vendor/modernizr/modernizr.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/breakpoints/breakpoints.js'); ?>"></script>

    <!-- Inline -->
    <style>
        .toast-example {
            position: static;
            margin: 10px 0 30px;
        }

        .toast-example.padding-0 {
            margin-bottom: 30px;
        }

        .toast-example > div {
            width: auto;
            padding-top: 10px;
            padding-bottom: 10px;
            margin-bottom: 0;
        }

        .position-example {
            position: relative;
            height: 330px;
            margin-bottom: 20px;
        }

        .position-example > div {
            position: absolute;
            width: 100%;
            padding: 20px;
        }

        .position-example > .btn-block + .btn-block {
            margin-top: 215px;
        }

        @import url(http://fonts.googleapis.com/css?family=Roboto+Mono);
        [data-plugin="formatter"] {
            font-family: 'Roboto Mono', Menlo, Monaco, Consolas, "Courier New", monospace;
        }
    </style>
    <script>
        Breakpoints();
    </script>
</head>