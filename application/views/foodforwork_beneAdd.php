<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!$this->session->userdata('user_data')){
    redirect('/users/login','location');

}
$user_region = $this->session->userdata('uregion');
error_reporting(0);
?>

<script type="text/javascript">

    function checkValidate(){

//        var countBene = parseInt($('#countBene').val());
//        var countBeneMuni = parseInt($('#countBeneMuni').val());
//        alert(countBene);
//        alert(countBeneMuni);
//        if(countBene >= countBeneMuni){
//            alert('All Beneficiaries already encoded')
//            return false;
//        }
//
//    }
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Are you sure?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>


        <h1 class="page-title">Beneficiaries</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('foodforwork/viewfood_brgy/'.$foodforwork_idpass->foodforwork_muni_id.'') ?>">Barangay</a></li>
            <li class="active">Beneficiaries</li>
        </ol>


            <header class="panel-heading">
<!--                &nbsp;--><?php //echo $countBene->countBene ; ?>
<!--                &nbsp;--><?php //echo $foodforwork_idpass->no_of_bene_brgy ; ?>
            </header>
            <div class="panel-body">
                <div id="exampleTableAddToolbar">
                    <?php if($countBene->countBene >= $foodforwork_idpass->no_of_bene_brgy ){?>
                    <button id="exampleTableAddBtn" class="btn btn-outline btn-primary"   data-target="#exampleFormModal" data-toggle="modal"disabled>
                        <i class="icon wb-plus" aria-hidden="true"></i> Add Record
                    </button>
                    <?php }else {?>
                        <button id="exampleTableAddBtn" class="btn btn-outline btn-primary"   data-target="#exampleFormModal" data-toggle="modal" >
                            <i class="icon wb-plus" aria-hidden="true"></i> Add Record
                        </button>
                    <?php }?>
                    <button type="submit" onclick = "javascript: window.parent.closeIframe();" id="btn_exit" name="btn_exit" class="btn btn-outline btn-danger " data-toggle="tooltip"
                            data-placement="top" data-original-title="Exit">Exit</button>
<!--                    --><?php //print_r($countBene)?>
<!--                    --><?php //print_r($countBeneMuni)?>
                    <input type="hidden" name = "countBene" id = "countBene"value = "<?php echo $countBene->countBene;?>">
                    <input type="hidden" name = "countBeneMuni" id = "countBeneMuni"value = "<?php echo $countBeneMuni->no_of_bene_muni;?>">
                </div><br>
                <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Beneficiaries</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Beneficiaries</th>
                    </tr>
                    </tfoot>
                    <tbody>
<!--                    <pre>-->
<!--                    --><?php //print_r($food_benelist)?>
<!--                    </pre>-->
                    <?php foreach($food_benelist as $food_benedata): ?>  <!--pagination buttons -->
                        <tr>
                            <td><?php echo $food_benedata->bene_id ?></td>
                            <td><?php echo $food_benedata->bene_fullname; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info btn-outline" data-target="#exampleFormModal1" data-toggle="modal"
                                       href="<?php echo base_url('foodforwork/foodbene_edit/' . $food_benedata->bene_id . '') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Edit"><i class="icon wb-edit" aria-hidden="true" ></i> </a>
                                    <a class="confirmation btn btn-danger btn-outline" id="confirm"
                                       href="<?php echo base_url('foodforwork/deleteBene/' . $food_benedata->foodforwork_brgy_id . '/' . $food_benedata->bene_id .'') ?>" data-toggle="tooltip"
                                       data-placement="top" data-original-title="Delete"><i class="icon wb-close" aria-hidden="true"></i> </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>

<div class="modal fade" id="exampleFormModal1" aria-hidden="false" aria-labelledby="exampleFormModalLabel1" data-keyboard="false" data-backdrop="static"
     role="dialog" tabindex="-1">
    <div class="modal-dialog modal-center">
        <?php
        $attributes = array("class" => "modal-content", "id" => "bene_edit", "name" => "bene_edit" );
        //input here the next location when click insert1
        echo form_open("foodforwork/foodbene_edit/".$food_benedata->bene_id, $attributes);?>

        <?php echo form_close(); ?>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
</div>


<div class="modal fade example-modal-lg" id="exampleFormModal" aria-hidden="false" aria-labelledby="exampleFormModalLabel" data-backdrop="static" data-keyboard="false"
     role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg modal-center">
        <?php
        $attributes = array("class" => "modal-content", "id" => "bene_add", "name" => "bene_add" , );
        //input here the next location when click insert1
        echo form_open("foodforwork/food_addbene/".$foodforwork_brgyidpass, $attributes);?>
        <div class="modal-header">

            <h3 class="modal-title" id="exampleFormModalLabel"><i class="icon wb-plus"></i>Add New</h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-16 form-group">
                    <table class = "class  table-bordered table-striped">
                        <tr>
                            <th><label for="bene_firstname" class="control-label">First Name</label></th>
                            <th><label for="bene_middlename" class="control-label">Middle Name</label></th>
                            <th><label for="bene_lastname" class="control-label">Last Name</label></th>
                            <th><label for="bene_extname" class="control-label">Extension Name</label></th>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control" pattern="[A-Za-z \\s ]*" title="Please input alphabet characters only!" name="bene_firstname" placeholder="First Name" required>
                            </td>
                            <td>
                                <input type="text" class="form-control" pattern="[A-Za-z \\s ]*" title="Please input alphabet characters only!"  name="bene_middlename" placeholder="Middle Name" >
                            </td>
                            <td>
                                <input type="text" class="form-control" pattern="[A-Za-z \\s ]*" title="Please input alphabet characters only!"  name="bene_lastname" placeholder="Last Name" required>
                            </td>
                            <td>
                                <input type="text" class="form-control" pattern="[A-Za-z \\s ]*" title="Please input alphabet characters only!"  name="bene_extname" placeholder="Extension Name" >
                            </td>
                        </tr>



                    </table>

                    <input class="form-control"  type="hidden" name="foodforwork_idpass" value="<?php echo $foodforwork_idpass->foodforwork_id;?>">
                    <input class="form-control"  type="hidden" name="foodforwork_brgyidpass" value="<?php echo $foodforwork_brgyidpass?>">
                    <input class="form-control"  type="hidden" name="foodforwork_muniidpass" value="<?php echo $foodforwork_idpass->foodforwork_muni_id?>">
                </div>
                <div class="col-sm-12 pull-right">
                    <button class="btn btn-success btn-outline"  type="submit" name="btn_add"><i class="icon wb-check" aria-hidden="true"></i>Save</button>
                    <button class="btn btn-danger btn-outline" data-dismiss="modal" type="button"><i class="icon wb-close"></i>Cancel</button>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
</div>
<!--<div class="site-action">-->
<!--    <button type="button" data-target="#exampleFormModal" data-toggle="modal"-->
<!--            class="btn btn-floating btn-danger">-->
<!--        <i class="front-icon wb-plus animation-scale-up" aria-hidden="true"></i>-->
<!--        <i class="back-icon wb-close animation-scale-up" aria-hidden="true"></i>-->
<!--    </button>-->
<!--    <div class="site-action-buttons">-->
<!--        <button type="button" class="btn-raised btn btn-success btn-floating animation-slide-bottom animation-delay-100">-->
<!--            <i class="icon wb-trash" aria-hidden="true"></i>-->
<!--        </button>-->
<!--        <button type="button" class="btn-raised btn btn-success btn-floating animation-slide-bottom">-->
<!--            <i class="icon wb-inbox" aria-hidden="true"></i>-->
<!--        </button>-->
<!--    </div>-->
<!--</div>-->


