
<div class="modal-header">
    <!--    <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
    <!--        <span aria-hidden="true">×</span>-->
    <!--    </button>-->
    <h3 class="modal-title" id="exampleFormModalLabel1"><i class="icon wb-edit"></i>Edit Beneficiaries</h3>
</div>
<div class="modal-body" >
    <div class="row">
<!--        --><?php //print_r($bene_details)?>
        <div class="col-lg-12 form-group">
            <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
            <input class="form-control"  type="hidden" name="bene_idpass" value="<?php echo $bene_details->food_bene_id ?>">
            <input class="form-control"  type="hidden" name="cashforwork_idpass" value="<?php echo $bene_details->foodforwork_id ?>">
            <input type="text" class="form-control" name="bene_fullname" placeholder="Full Name" value="<?php echo $bene_details->bene_fullname ?>" required>
        </div>
        <div class="col-sm-12 pull-right">
            <button class="btn btn-success btn-outline" type="submit" name="btn_add"><i class="icon wb-check" aria-hidden="true"></i>Update</button>
            <button class="btn btn-danger btn-outline" data-dismiss="modal" type="button" onclick="document.location.reload(true)"><i class="icon wb-close"></i>Cancel</button>
        </div>
    </div>
</div>