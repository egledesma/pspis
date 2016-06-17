<?php
/**
 * Created by PhpStorm.
 * User: mblejano
 * Date: 4/29/2016
 * Time: 9:41 AM
 */$region_code = $this->session->userdata('uregion');
?>
<!---->
<!---->
<!---->
<!--                        <div class="form-group row">-->
<!--                            <div id="project_title" class="col-sm-6">-->
<!--                                <label for="project_title" class="control-label">Project Title:</label>-->
<!--                                <input id="project_title" name="project_title" placeholder="Project Title" type="text"  class="form-control"   value="--><?php //echo $proj_prov->project_title ?><!--" readonly/>-->
<!--                                <span class="text-danger">--><?php //echo form_error('project_title'); ?><!--</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--<!--                        <input class="form-control"  type="hidden" name="myid" value="--><?php ////echo $this->session->userdata('uid')?><!--<!--">-->
<!--                        <label  class="control-label">Project Location:</label>-->
<!---->
<!--                        <div class="form-group row">-->
<!--                            <div id="regionlist" class="col-sm-4">-->
<!--                                <label for="regionlist" class="control-label">Region:</label>-->
<!--                                <input id="regionlist" name="regionlist" placeholder="Region" type="text"  class="form-control"   value="--><?php //echo $proj_prov->region_name ?><!--" readonly/>-->
<!--                                <span class="text-danger">--><?php //echo form_error('regionlist'); ?><!--</span>-->
<!--                            </div>-->
<!---->
<!--                            <div id="provlist" class="col-sm-4">-->
<!--                                <label for="provlist" class="control-label">Province:</label>-->
<!--                                <input id="provlist" name="provlist" placeholder="Province" type="text"  class="form-control"   value="--><?php //echo $proj_prov->prov_name ?><!--" readonly/>-->
<!--                                <span class="text-danger">--><?php //echo form_error('provlist'); ?><!--</span>-->
<!--                            </div>-->
<!---->
<!--                            <div id="munilist" class="col-sm-4">-->
<!--                                <label for="munilist" class="control-label">City/Municipality:</label>-->
<!--                                <input id="munilist" name="munilist" placeholder="City/Municipality:" type="text"  class="form-control"   value="--><?php //echo $proj_prov->city_name ?><!--" readonly/>-->
<!--                                <span class="text-danger">--><?php //echo form_error('munilist'); ?><!--</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="form-group row">-->
<!--                            <div >-->
<!--                                <div id="natureofworklist" class="col-sm-4">-->
<!--                                    <label for="natureofworklist" class="control-label">Nature of Work:</label>-->
<!--                                    <input id="natureofworklist" name="natureofworklist" placeholder="Nature of Work" type="text"  class="form-control"   value="--><?php //echo $proj_prov->work_nature ?><!--" readonly/>-->
<!--                                    <span class="text-danger">--><?php //echo form_error('natureofworklist'); ?><!--</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="form-group row">-->
<!--                            <div class="col-sm-4">-->
<!--                                <label for="number_days" class="control-label">Number of Days:</label>-->
<!--                                <input id="number_days" name="number_days" placeholder="Number of Days" type="number" min="0"  class="form-control"   value="--><?php //echo $proj_prov->no_of_days ?><!--" readonly>-->
<!--                                <span class="text-danger">--><?php //echo form_error('number_days'); ?><!--</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-4">-->
<!--                                <label for="daily_payment" class="control-label">Daily Payment Amount:</label>-->
<!--                                <input id="daily_payment" name="daily_payment" placeholder="Daily Payment Amount" type="number"  class="form-control"  value="--><?php //echo $proj_prov->daily_payment ?><!--" readonly/>-->
<!--                                <span class="text-danger">--><?php //echo form_error('daily_payment'); ?><!--</span>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--<!--                    --><?php ////endforeach ?>



<!--    <a class= "btn btn-outline btn-danger "onclick = "javascript: window.parent.closeIframe();" ><i class="icon wb-close" aria-hidden="true"></i> Cancel</a>-->


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
                                           href="<?php echo base_url('cashforwork/updateCashforwork_brgy/'.$cashbrgy_listData->cash_brgy_id.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Edit Project"><i class="icon wb-edit" aria-hidden="true"></i> </a>
                                        <a class="confirmation btn btn-danger btn-outline" id="confirm"
                                           href="<?php echo base_url('cashforwork/deleteCashforwork_brgy/'.$cashbrgy_listData->cash_brgy_id.'') ?>" data-toggle="tooltip"
                                           data-placement="top" data-original-title="Delete Project"><i class="icon wb-close" aria-hidden="true"></i> </a>
                                        <a class="confirmation btn btn-success btn-outline" id="confirm"
                                           href="<?php echo base_url('cashforwork/cash_benelist/'.$cashbrgy_listData->cash_brgy_id.'') ?>" data-toggle="tooltip"
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