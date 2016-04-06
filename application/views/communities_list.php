<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Assistance to Communities</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboardc/dashboard') ?>">Dashboard</a></li>
            <li class="active">Communities</li>
        </ol>
    </div>

    <div class="page-content">
    <div class="panel">
        <header class="panel-heading">
        </header>
        <div class="panel-body">
            <div id="Add">
                <a class= "btn btn-outline btn-primary"   href="<?php echo base_url('communities/addCommunities') ?>"><i class="icon wb-plus" aria-hidden="true"></i> Add Record</a>

            </div><br>
            <table class="table table-hover dataTable table-striped width-full" id="communities_table">
                <thead>
                <tr>
                    <th>Project Title</th>
                    <th>Assistance Name</th>
                    <th>Nature of work</th>
                    <th>Fund Source</th>
                    <th>LGU Counterpart</th>
                    <th>LGU Fund Source</th>
                    <th>LGU Amount</th>
                    <th>Project Cost</th>
                    <th>Project Amount</th>
                    <th>Implementing Agency</th>
                    <th>Status</th>
                    <th>Region</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Project Title</th>
                    <th>Assistance Name</th>
                    <th>Nature of work</th>
                    <th>Fund Source</th>
                    <th>LGU Counterpart</th>
                    <th>LGU Fund Source</th>
                    <th>LGU Amount</th>
                    <th>Project Cost</th>
                    <th>Project Amount</th>
                    <th>Implementing Agency</th>
                    <th>Status</th>
                    <th>Region</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach($project as $projectData): ?>
                <tr>
                    <td><?php echo $projectData->project_title; ?></td>
                    <td><?php echo $projectData->assistance_name; ?></td>
                    <td><?php echo $projectData->work_nature; ?></td>
                    <td><?php echo $projectData->fund_source; ?></td>
                    <td><?php echo $projectData->lgu_counterpart; ?></td>
                    <td><?php echo $projectData->lgu_fundsource; ?></td>
                    <td><?php echo $projectData->lgu_amount; ?></td>
                    <td><?php echo $projectData->project_cost; ?></td>
                    <td><?php echo $projectData->project_amount; ?></td>
                    <td><?php echo $projectData->implementing_agency; ?></td>
                    <td><?php echo $projectData->status; ?></td>
                    <td><?php echo $projectData->region_code; ?></td>
                </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
<!--    <div class="site-action">-->
<!--        <button type="button" class="btn btn-floating btn-danger">-->
<!--            <i class="front-icon wb-plus animation-scale-up" aria-hidden="true"></i>-->
<!--            <i class="back-icon wb-close animation-scale-up" aria-hidden="true"></i>-->
<!--        </button>-->
<!--        <div class="site-action-buttons">-->
<!--            <button type="button" class="btn-raised btn btn-success btn-floating animation-slide-bottom animation-delay-100">-->
<!--                <i class="icon wb-trash" aria-hidden="true"></i>-->
<!--            </button>-->
<!--            <button type="button" class="btn-raised btn btn-success btn-floating animation-slide-bottom">-->
<!--                <i class="icon wb-inbox" aria-hidden="true"></i>-->
<!--            </button>-->
<!--        </div>-->
<!--    </div>-->
</div>