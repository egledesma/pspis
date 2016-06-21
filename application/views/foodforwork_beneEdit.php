
<div class="modal-header">
    <!--    <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
    <!--        <span aria-hidden="true">×</span>-->
    <!--    </button>-->
    <h3 class="modal-title" id="exampleFormModalLabel1"><i class="icon wb-edit"></i>Edit Beneficiaries</h3>
</div>
<div class="modal-body" >
    <div class="row">
        <div class="col-lg-12 form-group">
            <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
            <input class="form-control"  type="hidden" name="bene_idpass" value="<?php echo $bene_details->bene_id ?>">
            <input class="form-control"  type="hidden" name="foodforwork_idpass" value="<?php echo $bene_details->foodforwork_id ?>">

            <table class = "class  table-bordered table-striped">
                <tr>
                    <th><label for="bene_firstname" class="control-label">First Name</label></th>
                    <th><label for="bene_middlename" class="control-label">Middle Name</label></th>
                    <th><label for="bene_lastname" class="control-label">Last Name</label></th>
                    <th><label for="bene_extname" class="control-label">Extension Name</label></th>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" pattern="[A-Za-z \\s ]*" title="Please input alphabet characters only!" name="bene_firstname" placeholder="First Name" value="<?php echo $bene_details->first_name ?>"required>
                    </td>
                    <td>
                        <input type="text" class="form-control" pattern="[A-Za-z \\s ]*" title="Please input alphabet characters only!"  name="bene_middlename" placeholder="Middle Name" value="<?php echo $bene_details->middle_name ?>">
                    </td>
                    <td>
                        <input type="text" class="form-control" pattern="[A-Za-z \\s ]*" title="Please input alphabet characters only!"  name="bene_lastname" placeholder="Last Name" value="<?php echo $bene_details->last_name ?>"required>
                    </td>
                    <td>
                        <input type="text" class="form-control" pattern="[A-Za-z \\s ]*" title="Please input alphabet characters only!"  name="bene_extname" placeholder="Extension Name" value="<?php echo $bene_details->ext_name ?>">
                    </td>
                </tr>



            </table>
        </div>
        <div class="col-sm-12 pull-right">
            <button class="btn btn-success btn-outline" type="submit" name="btn_add"><i class="icon wb-check" aria-hidden="true"></i>Update</button>
            <button class="btn btn-danger btn-outline" data-dismiss="modal" type="button" onclick="document.location.reload(true)"><i class="icon wb-close"></i>Cancel</button>
        </div>
    </div>
</div>