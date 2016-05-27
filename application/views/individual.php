<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>


<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Assistance to Individuals in Crisis Situations</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active"></li>
        </ol>
    </div>

    <div class="page-content">
        <div class="panel">
            <header class="panel-heading">
            </header>
            <div class="panel-body">
            <div class="col-md-12">

                <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                    <thead>
                    <tr>
                        <th>Action</th>
<!--                        <th>Saro</th>-->
                        <th>Region</th>
                        <th>Utilize</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Action</th>
<!--                        <th>Saro</th>-->
                        <th>Region</th>
                        <th>Utilize</th>
                    </tr>
                    </tfoot>
                    <tbody  data-plugin="scrollable" data-direction="horizontal">


                        <tr>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a class="btn btn-dark btn-outline" id="confirm"
                                       href="<?php echo base_url('individual/addIndividual/'.$crims->RegionAssist.'') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Utilize"><i class="icon wb-upload"" aria-hidden="true"></i></a>
                                    <a class="btn btn-info btn-outline" id="confirm"
                                       href="<?php echo base_url('individual/updatefoodforwork/'.$crims->RegionAssist.'') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Edit Project"><i class="icon wb-edit" aria-hidden="true"></i> </a>
                                    <a class="btn btn-info btn-outline" id="confirm"
                                       href="<?php echo base_url('individual/view/'.$crims->RegionAssist.'') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="View Details"><i class="icon wb-search"" aria-hidden="true"></i> </a>
                                </div>
                            </td>


                            <!--                            <td>Test</td>-->
                            <td><?php echo $crims->region_name; ?></td>
                            <td><?php echo '₱ '. number_format($crims->Utilize,2); ?></td>

                        </tr>

                    </tbody>
                </table>

            </div>
            </div>
        </div>
    </div>