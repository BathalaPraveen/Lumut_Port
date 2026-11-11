<style>
    #map {

        height:360px;
        width: 100%;
    }
    .keyContdetails{
        border: 2px solid #1e6dab;
    }

</style>
<div class="wrapper">


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <section class=" content">
            <div class="container-fluid">

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">


                        <!-- general form elements -->
                        <div class="card card-headprimary">
                            <div class="row headingStyl">
                                <div class="col-md-12">
                                    <h4>ADD PORT SECURITY ACCESS</h4>
                                    <a href="<?php echo BASE_URL('psa/psa_report/psa_guard') ?>"><button type="button" class="btn btn-primary backBtns">Back</button></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                $gethazid = isset($getPsadatas->AUTO_ID) && !empty($getPsadatas->AUTO_ID) ? $getPsadatas->AUTO_ID : '';
                                $ID_TYPE = postData($getPsadatas, 'ID_TYPE');
    if ($ID_TYPE == '1') {
        $idval = 'IC';
    } elseif ($ID_TYPE == '2') {
        $idval = 'PassPort';
    }
                                ?>
                                <?php echo form_open('psa/psa_report/save_psa_guard/' . encryptval($gethazid), 'class="form-horizontal" id="port_submit" novalidate'); ?>

                                <div class="emplDet m-t-10">
                                    <div class="row" >
                                        <div class="col-md-12">
                                            <div class="box-header with-border" >
                                                <h5 class=""> Port Security Access </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 m-t-10">
                                        <table class="table table-bordered">
                                            <tbody>
                                            <thead>
                                            <th colspan="4" class="text-center">Port Access Details</th>
                                            </thead>
                                            <tr>
                                                <td><label>Name</label></td>  
                                                <td><?php echo isset($getPsadatas->NAME) && !empty($getPsadatas->NAME) ? $getPsadatas->NAME : ''; ?></td>  
                                                <td><label>ID Type</label></td>  
                                                <td><?php echo $idval; ?></td>  
                                            </tr>
                                            <tr>
                                                <td><label>IC/Passport No.</label></td>  
                                                <td><?php echo isset($getPsadatas->PASS_NO) && !empty($getPsadatas->PASS_NO) ? $getPsadatas->PASS_NO : ''; ?></td>  
                                                <td><label>Company Name </label></td>  
                                                <td><?php echo isset($getPsadatas->COMP_NAME) && !empty($getPsadatas->COMP_NAME) ? $getPsadatas->COMP_NAME : ''; ?></td>  
                                            </tr>
                                            <tr>
                                                <td><label>Designation</label></td>  
                                                <td><?php echo isset($getPsadatas->DESIG) && !empty($getPsadatas->DESIG) ? $getPsadatas->DESIG : ''; ?></td>  
                                                <td><label>Terminal</label></td>  
                                                <td><?php echo isset($getPsadatas->TERMINAL_NAME) && !empty($getPsadatas->TERMINAL_NAME) ? $getPsadatas->TERMINAL_NAME : ''; ?></td>  
                                            </tr>
                                            <tr>
                                                <td><label>Induction Date</label></td>  
                                                <td><?php echo isset($getPsadatas->IND_DATE) && !empty($getPsadatas->IND_DATE) ? convertDate($getPsadatas->IND_DATE, 'd-m-Y') : ''; ?></td>  
                                                <td><label>Induction Due Date</label></td>  
                                                <td><?php echo isset($getPsadatas->IND_DUE_DATE) && !empty($getPsadatas->IND_DUE_DATE) ? convertDate($getPsadatas->IND_DUE_DATE, 'd-m-Y') : ''; ?></td>  
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    
                                    <div class="row" >
                                        <div class="col-md-12" >
                                            <div class="box-header with-border" style="background-color:#8fb4ec !important;">
                                                <h5 class=""> Certificate Details </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 m-t-10" style="border-bottom: 1px solid #8fb4ec;">
                                        <table class="table table-bordered">
                                            <thead style="background: #ababa7;font-weight: bold;color:#ffff;text-align:center;">
                                                        <tr>
                                                            <td style="width:20%">S/No</td>
                                                            <td style="width:20%">Certificate Name</td>
                                                            <td style="width:10%">Start Date</td>
                                                            <td style="width:10%">End Date</td>
                                                            <td style="width:40%">Certificate</td>
                                                        </tr>
                                                    </thead>

                                                     
                                                <?php
                                                $i = 1;
                                                $checkData='';
//                                                echo "<pre>";
//                                                print_R($getOthercertdet);
//                                                exit;
                                                if(isset($getOthercertdet) && !empty($getOthercertdet)){
                                                foreach ($getOthercertdet as $insDKey => $InsData) {
                                                    $fileExtn = postData($InsData,'CERT_EXT');
                                                   $bfrKeyval = $insDKey-1;
                                                  
                                                    ?>
                                                <tbody style="text-align:center;">
                                                   
                                                        <tr>
                                                            <td style="width:20%"><?php echo $i++; ?></td>
                                                            <td style="width:20%;"><?php echo $InsData->CERT_NAME; ?></td>
                                                            <td style="width:10%"><?php echo date("d-m-Y",strtotime($InsData->CERT_START_DATE)); ?></td>
                                                            <td style="width:10%"><?php echo date("d-m-Y",strtotime($InsData->CERT_END_DATE)); ?></td>
                                                           <?php if($InsData->CERT_FILE_NAME != ''){ ?>
                                                            <td style="width:40%">
                                                                <?php if($fileExtn != '.pdf'){ ?>
                                                                <img src="<?php echo BASE_URL.$InsData->CERT_PATH.''.$InsData->CERT_FILE_NAME; ?>" style="height:15%" alt="<?php echo $InsData->CERT_FILE_NAME; ?>">
                                                                <?php }else{ ?>
                                                                <a href="<?php echo BASE_URL.$InsData->CERT_PATH.''.$InsData->CERT_FILE_NAME; ?>" target="blank"><?php echo $InsData->CERT_FILE_NAME; ?></a>
                                                                <?php } ?>
                                                            </td>
                                                           <?php }else{ ?>
                                                            <td style="width:40%"> - </td>
                                                           <?php } ?>
                                                        </tr>
                                                        
                                                    
                                                <?php }}else{ ?>
                                                       <tr style="text-align:center"> <td  colspan="4">No data Available<td> </tr>
                                                <?php } ?>
                                                     </tbody>
                                        </table>
                                    </div>
                                    
                                    
                                    <div class="row col-md-12  m-t-10">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Vehicle Type <span class="error">*</span></label>
                                                <?php
                                                $getTerId = isset($getPsadatas->VEC_TYPE) && !empty($getPsadatas->VEC_TYPE) ? $getPsadatas->VEC_TYPE : set_value('port[VEC_TYPE]');
                                                $termdata = array(
                                                    'id' => 'VEC_TYPE',
                                                    'class' => 'form-control select2 ',
                                                    'required' => true,
                                                    'checkselect' => 'select2'
                                                );
                                                echo form_dropdown('port[VEC_TYPE]', $vechical_type, $getTerId, $termdata);
                                                ?>
                                                <label class="error"><?php echo form_error('port[VEC_TYPE]'); ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 vec d-none">
                                            <div class="form-group">
                                                <label>Vechical Other <span class="error">*</span></label>
                                                <?php
                                                $cMaildatas = [
                                                    'name' => 'port[VEC_OTHER]',
                                                    'id' => 'VEC_OTHER',
                                                    'class' => 'form-control',
                                                    'autocomplete' => 'off',
                                                    'value' => isset($getPsadatas->VEC_OTHER) && !empty($getPsadatas->VEC_OTHER) ? $getPsadatas->VEC_OTHER : ''
                                                ];
                                                echo form_input($cMaildatas);
                                                ?>
                                                <span class="error"><?php echo form_error('port[VEC_TYPE]') ?></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 vec_num">
                                            <div class="form-group">
                                                <label>Vehicle Number <span class="error">*</span></label>
                                                <?php
                                                $cMaildatas = [
                                                    'name' => 'port[VEC_NO]',
                                                    'id' => 'VEC_OTHER',
                                                    'class' => 'form-control',
                                                    'autocomplete' => 'off',
                                                    'value' => isset($getPsadatas->VEC_NO) && !empty($getPsadatas->VEC_NO) ? $getPsadatas->VEC_NO : ''
                                                ];
                                                echo form_input($cMaildatas);
                                                ?>
                                                <label class="error"><?php echo form_error('port[VEC_NO]'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Purpose</label>
                                            <?php
                                            $cMaildatas = [
                                                'name' => 'port[PURPOSE]',
                                                'id' => 'PURPOSE',
                                                'class' => 'form-control',
                                                'autocomplete' => 'off',
                                                'cols' => 4,
                                                'rows' => 4,
                                                'value' => isset($getPsadatas->PURPOSE) && !empty($getPsadatas->PURPOSE) ? $getPsadatas->PURPOSE : ''
                                            ];
                                            echo form_textarea($cMaildatas);
                                            ?>
                                            <span class="error"><?php echo form_error('port[PURPOSE]') ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-t-10" style="text-align: center;">
                                    <div class="col-sm-offset-2 col-sm-10"> 
                                        <?php
                                        $data = array('id' => 'submit', 'type' => 'submit','value' => '1', 'name' => 'vec_sub','content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Entry', 'class' => 'btn btn-primary');
                                        echo form_button($data);
                                        ?>
                                        <?php
                                        $data = array('id' => 'submit', 'type' => 'submit','value' => '2', 'name' => 'vec_sub','content' => '<i class="fa fa-floppy-o" aria-hidden="true"></i> Exit', 'class' => 'btn btn-warning');
                                        echo form_button($data);
                                        ?>
                                    </div>
                                </div>

                                <!-- input states -->
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                        <!-- /.card -->

                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#VEC_TYPE').on('change',function(){
           var vec_val = $(this).val();
           if(vec_val == '5') {
               $('.vec').removeClass('d-none');
               $('.vec_num').addClass('d-none');
           }else if(vec_val == '4') {
                $('.vec_num').addClass('d-none');
                $('.vec').addClass('d-none');
           }  else {
                $('.vec_num').removeClass('d-none');
                $('.vec').addClass('d-none');
           }
        }).trigger('change');
        $.validator.addMethod('alphanumeric', function (value) {
            return /^[A-Za-z0-9 ]*$/.test(value);
        }, "Please Enter only Alphanumeric characters");

        $.validator.addMethod('alphanospace', function (value) {
            return /^[A-Za-z]*$/.test(value);
        }, "Please Enter only Alphabetic characters.No spaces allowed");

        $.validator.addMethod('alphaspace', function (value) {
            return /^[A-Za-z ]*$/.test(value);
        }, "Please Enter only Alphabetic characters");

 

        $("#port_submit").validate({
            //            ignore: [],
            //            success: function (error) {
            //                error.removeClass("error");
            //            },

            rules: {
                "port[VEC_TYPE]": {
                    required: true
                },
                "port[VEC_OTHER]": {
                    required: true,
                    alphanumeric: true
                },
                "port[VEC_NO]": {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                "port[PURPOSE]": {
                    minlength: 3,
                    maxlength: 255,
                    alphaspace: true,
                    alphanumeric: true
                }
            },
            messages: {
                "port[VEC_TYPE]": {
                    required: "vechical Type is required",
                }
            },
            errorPlacement: function (error, element) {

                if (element.attr('checkSelect') == 'select2') {
                    error.insertAfter(element.next('.select2-container'));
                } else {
                    error.insertAfter(element);
                    element.closest(".imgGroup").last().append(error);
                }
            }

        });
        $(".addsubtyp").on("click", function (e) {
            e.preventDefault();
            var html = '';
            var rowID = $('.row').last().attr('row-id');
            var finalRowid = parseInt(rowID) + 1;
            html = '<div class="row m-t-10 m-l-10 remRowid" id="remRowid_' + finalRowid + '" row-id="' + finalRowid + '">\n\
                        <div class="col-sm-11">\n\
                                        <div class="form-group">\n\
                                            <input type="text" name="risk[contr_name][]" value="" id="hazId_' + finalRowid + '" class="form-control" required autocomplete="off" >\n\
                                            <span class="error"></span>\n\
                                        </div>\n\
                                    </div>\n\
<div class="col-md-1 trashRem" id="trash_' + finalRowid + '" trash-id="' + finalRowid + '">\n\
<i class="fa fa-trash"></i>\n\
</div>\n\
                    </div>';
            $(".newSubtypes").append(html)
        });

        $(document).on('click', ".trashRem", function () {
            var trashId = $(this).attr("trash-id");
            var count = $(".emplDet").find('.remRowid').length;
            if (count != 1) {
                $("#remRowid_" + trashId).remove();
            } else {
                swal('Sorry', 'Atleast one Existing Risk Control is required', 'error');
            }
        });
    });
</script>
