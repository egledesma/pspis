<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

?>
<script type="text/javascript">
    function get_natureofwork() {
        var assistance_id = $('#assistancelist').val();

        if(assistance_id > 0) {
            $.ajax({
                url: "<?php echo base_url('communities/populate_natureofwork'); ?>",
                async: false,
                type: "POST",
                data: "assistance_id="+assistance_id,
                dataType: "html",
                success: function(data) {
                    $('#natureofworkID').html(data);
                }
            });
        } else {
            $('#natureofworklist option:gt(0)').remove().end();
        }
    }
</script>


<div class="page ">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Add</h1>
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

                <?php
                $attributes = array("class" => "form-horizontal", "id" => "projectformadd", "name" => "projectformadd");
                //input here the next location when click insert

                echo form_open("communities/addCommunities", $attributes);?>
                <table class="table table-bordered table-striped">
                    <br>
                    <tr>
                        <td><label for="project_title" class="control-label">Project Title:</label></td>
                    </tr>
                    <tr>
                        <td>
                            <input id="project_title" name="project_title" placeholder="Project Title" type="text"  class="form-control"  value="<?php echo set_value('project_title'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('project_title'); ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="assistancelist" class="control-label">Assistance Type:</label></td>
                    </tr>
                    <tr>
                        <td>
                            <select name="assistancelist" id="assistancelist" class="form-control" onChange="get_natureofwork();">
                                <option value="0">Choose Assistance</option>
                                <?php foreach($assistancelist as $assistanceselect): ?>
                                    <option value="<?php echo $assistanceselect->assistance_id; ?>"
                                        <?php if(isset($_SESSION['assistance'])) {
                                            if($assistanceselect->assistance_id == $_SESSION['assistance']) {
                                                echo " selected";
                                            }
                                        } ?>
                                    >
                                        <?php echo $assistanceselect->assistance_name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="natureofworklist" class="control-label">Nature of Work:</label></td>
                    </tr>
                    <tr>
                        <td id = "natureofworkID">
                            <select required id="natureofworklist" name="natureofworklist" class="form-control" required>
                                <?php if(isset($_SESSION['natureofwork']) or isset($_SESSION['assistance'])) {
                                    ?>
                                    <option value="">Choose Nature of work</option>
                                    <?php
                                    foreach ($natureofworklist as $natureofworkselect) { ?>
                                        <option value="<?php echo $natureofworkselect->nature_id; ?>"
                                            <?php
                                            if (isset($_SESSION['natureofwork']) and $natureofworkselect->nature_id== $_SESSION['natureofwork']) {
                                                echo " selected";
                                            } ?>
                                        >
                                            <?php echo $natureofworkselect->work_nature; ?></option>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <option value="">Select Assistance First</option>
                                    <?php
                                } ?>
                            </select>
                        </td>

                    </tr>
                    <tr>
                        <td><label for="fundsourcelist" class="control-label">Fund Source:</label></td>
                    </tr>
                    <tr>
                        <td>
                            <select name="fundsourcelist" id="fundsourcelist" class="form-control">
                                <option value="0">Choose Fund Source</option>
                                <?php foreach($fundsourcelist as $fundsourceselect): ?>
                                    <option value="<?php echo $fundsourceselect->fundsource_id; ?>">
                                        <?php echo $fundsourceselect->fund_source; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="lgucounterpartlist" class="control-label">LGU counterpart:</label></td>
                    </tr>
                    <tr>
                        <td>
                            <select name="lgucounterpartlist" id="lgucounterpartlist" class="form-control">
                                <option value="0">Choose LGU counterpart</option>
                                <?php foreach($lgucounterpartlist as $lgucounterpartselect): ?>
                                    <option value="<?php echo $lgucounterpartselect->lgucounterpart_id; ?>">
                                        <?php echo $lgucounterpartselect->lgu_counterpart; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>

                    </tr>

                    <tr>
                        <td><label for="lgu_fundsource" class="control-label">LGU fundsource:</label></td>
                    </tr>
                    <tr>
                        <td>
                            <input id="lgu_fundsource" name="lgu_fundsource" placeholder="LGU fund source" type="text"  class="form-control"  value="<?php echo set_value('lgu_fundsource'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('lgu_fundsource'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="lgu_amount" class="control-label">LGU amount:</label></td>
                    </tr>
                    <tr>
                        <td>
                            <input id="lgu_amount" name="lgu_amount" placeholder="LGU amount" type="text"  class="form-control"  value="<?php echo set_value('lgu_amount'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('lgu_amount'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="project_cost" class="control-label">Project Cost:</label></td>
                    </tr>
                    <tr>
                        <td>
                            <input id="project_cost" name="project_cost" placeholder="Project Cost" type="text"  class="form-control"  value="<?php echo set_value('project_cost'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('project_cost'); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="project_amount" class="control-label">Project Amount:</label></td>
                    </tr>
                    <tr>
                        <td>
                            <input id="project_amount" name="project_amount" placeholder="Project amount" type="text"  class="form-control"  value="<?php echo set_value('project_amount'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('project_amount'); ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="implementing_agency" class="control-label">Implementing Agency:</label></td>
                    </tr>
                    <tr>
                        <td>
                            <select name="implementing_agency" id="implementing_agency" class="form-control">
                                <option value="0">Choose Implementing Agency</option>
                                <?php foreach($fundsourcelist as $fundsourceselect): ?>
                                    <option value="<?php echo $fundsourceselect->fundsource_id; ?>">
                                        <?php echo $fundsourceselect->fund_source; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="project_amount" class="control-label">Status:</label></td>
                    </tr>
                    <tr>
                        <td>
                            <input id="status" name="status" placeholder="Status" type="text"  class="form-control"  value="<?php echo set_value('status'); ?>" required autofocus/>
                            <span class="text-danger"><?php echo form_error('status'); ?></span>
                        </td>
                    </tr>
                    </table>
                <div class="btn-group">

                    <input id="btn_add" name="btn_add" type="submit" class="btn btn-primary" value="Save"/>
                </div>
                <div class="btn-group">
                    <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger" value="Reset" />
                </div>
                <?php echo form_close(); ?>

            </div>
        </div>
    </div>

</div>