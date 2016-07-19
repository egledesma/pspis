<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/29/2016
 * Time: 9:41 AM
 */$region_code = $this->session->userdata('uregion');
?>
<?php echo $form_message ?>
<table class = "table">
    <h2>
    <tr>
            <td>
              <?php echo $proj_prov->city_name?>
            </td>
            <td>
                <button type="submit" onclick = "javascript: window.parent.closeIframe();" id="btn_exit" name="btn_exit" class="btn btn-outline btn-danger " data-toggle="tooltip"
                        data-placement="top" data-original-title="Exit">Exit</button>
            </td>
        </tr>
    </h2>
</table>
                    <table class="table table-hover table-bordered dataTable table-striped width-full" id="exampleTableSearch">
                        <thead>
                        <tr>
                            <th>Action</th>
                            <th>Barangay</th>
                            <th>Number of Beneficiaries</th>
                            <th>Cost of Assistance</th>
                            <!-- <th>Status</th> -->
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Action</th>
                            <th>Barangay</th>
                            <th>Number of Beneficiaries</th>
                            <th>Cost of Assistance</th>

                        </tr>
                        </tfoot>
                        <tbody  data-plugin="scrollable" data-direction="horizontal">

                        <?php foreach($cashbrgy_list as $cashbrgy_listData): ?>
                            <tr>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
<!--                                        <a class="btn btn-dark btn-outline" id="confirm"-->
<!--                                           href="--><?php //echo base_url('cashforwork/view/'.$cashbrgy_listData->cash_brgy_id.'') ?><!--" data-toggle="tooltip"-->
<!--                                           data-placement="top" data-original-title="View Project"><i class="icon wb-search" aria-hidden="true"></i></a>-->
                                        <a class="btn btn-info btn-outline" id="confirm"
                                           href="<?php echo base_url('cashforwork/updateCashforwork_brgy/'.$cashbrgy_listData->cash_brgy_id.'/2') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Edit Project"><i class="icon wb-edit" aria-hidden="true"></i> </a>
                                        <a class="confirmation btn btn-danger btn-outline" id="confirm"
                                           href="<?php echo base_url('cashforwork/deleteCashforwork_brgy/'.$cashbrgy_listData->cash_brgy_id.'/3') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Delete Project"><i class="icon wb-close" aria-hidden="true"></i> </a>
                                        <a class="confirmation btn btn-success btn-outline" id="confirm"
                                           href="<?php echo base_url('cashforwork/cash_benelist/'.$cashbrgy_listData->cash_brgy_id.'/0') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Add Beneficiaries"><i class="icon wb-user-add" aria-hidden="true"></i> </a>
                                    </div>

                                </td>
                                <td><?php echo $cashbrgy_listData->brgy_name; ?></td>
                                <td><?php echo  $cashbrgy_listData->no_of_bene_brgy; ?></td>
                                <td><?php echo '₱ '. number_format($cashbrgy_listData->cost_of_assistance_brgy,2); ?></td>

                                <!-- <td><?php // echo $projectData->status; ?></td> -->

                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>

<!--            </div>-->
<!--        </div>-->
<!---->
<!--    </div>-->