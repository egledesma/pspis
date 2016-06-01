
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <h3 class="modal-title" id="exampleFormModalLabel1"><i class="icon wb-edit"></i>Edit Central Office Funds</h3>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12 form-group">
                    <input class="form-control"  type="hidden" name="myid" value="<?php echo $this->session->userdata('uid')?>">
                    <input class="form-control"  type="hidden" name="cfid" value="<?php echo $cofunds_details->co_funds_id ?>">
                    <input type="text" class="form-control" name="co_funds" placeholder="Funds Amount" value="<?php echo $cofunds_details->co_funds ?>" required>
                </div>
                <div class="col-sm-12 pull-right">
                    <button class="btn btn-success btn-outline" type="submit" name="btn_add"><i class="icon wb-check" aria-hidden="true"></i>Update</button>
                    <button class="btn btn-danger btn-outline" data-dismiss="modal" type="button" onclick="document.location.reload(true)"><i class="icon wb-close"></i>Cancel</button>
                </div>
            </div>
        </div>