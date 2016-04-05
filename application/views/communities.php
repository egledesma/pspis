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
            <h3 class="panel-title">Add Row</h3>
        </header>
        <div class="panel-body">
            <div id="exampleTableAddToolbar">
                <button id="exampleTableAddBtn" class="btn btn-outline btn-primary" type="button">
                    <i class="icon wb-plus" aria-hidden="true"></i> Add Record
                </button>
            </div><br>
            <table class="table table-hover dataTable table-striped width-full" id="exampleTableSearch">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
                </tfoot>
                <tbody>
                <tr>
                    <td>Kate</td>
                    <td>5516 Adolfo Rode</td>
                    <td>Littelhaven</td>
                    <td>26</td>
                    <td>2014/06/13</td>
                    <td>$635,852</td>
                </tr>
                <tr>
                    <td>Torrey</td>
                    <td>3658 Richie Street</td>
                    <td>West Sedrickstad</td>
                    <td>28</td>
                    <td>2014/09/12</td>
                    <td>$243,577</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <div class="site-action">
        <button type="button" class="btn btn-floating btn-danger">
            <i class="front-icon wb-plus animation-scale-up" aria-hidden="true"></i>
            <i class="back-icon wb-close animation-scale-up" aria-hidden="true"></i>
        </button>
        <div class="site-action-buttons">
            <button type="button" class="btn-raised btn btn-success btn-floating animation-slide-bottom animation-delay-100">
                <i class="icon wb-trash" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn-raised btn btn-success btn-floating animation-slide-bottom">
                <i class="icon wb-inbox" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>