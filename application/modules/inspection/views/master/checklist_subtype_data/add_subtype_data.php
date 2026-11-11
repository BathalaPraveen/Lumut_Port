<style>
    .headingStyl{
        margin: 17px 0 0 17px;
        color: #2768ad;
    }
    .card-headprimary{
        border-top: 4px solid #f3b909;
    }
    label.error{
        font-weight:500 !important;
    }
    .with-border{
        background-color:#006eab;
        color:white;
        padding: 8px 0 1px 17px;
    }
    .backBtns{
        float:right !important;
        margin-top:-44px !important;
    }
    .emplDet{
        border: 1px solid #006eab;
    }
    
</style>
<div class="wrapper">


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">


                        <!-- general form elements -->
                        <div class="card card-headprimary">
                            <div class="row headingStyl">
                                <div class="col-md-12">
                                    <h4>ADD CHECKLIST SUBTYPE DATA</h4>
                                    <a href="<?php echo BASE_URL('inspection/insp_clsubtypedata') ?>"><button type="button" class="btn btn-primary backBtns"><i class="fa fa-backward"></i> Back</button></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
//                                
                               $gettypeid = isset($getSubtypedatas[0]->INSP_SUBTYP_DATA_SUBTYPID) && !empty($getSubtypedatas[0]->INSP_SUBTYP_DATA_SUBTYPID) ? $getSubtypedatas[0]->INSP_SUBTYP_DATA_SUBTYPID : '';
                               $getchkid = isset($getSubtypedatas[0]->INSP_SUBTYP_DATA_TYPID) && !empty($getSubtypedatas[0]->INSP_SUBTYP_DATA_TYPID) ? $getSubtypedatas[0]->INSP_SUBTYP_DATA_TYPID : '';
                               if($gettypeid != '' ){
                                   $encTypid = encryptval($gettypeid);
                               }else{
                                   $encTypid = '';
                               }
                               if($getchkid != '' ){
                                   $encChkid = encryptval($getchkid);
                               }else{
                                   $encChkid = '';
                               }
                               ?>
                                <?php echo form_open('inspection/save_insp_subtypedata/' . $encTypid.'/'.$encChkid, 'class="form-horizontal" id="company-profile" novalidate'); ?>

                                <div class="row m-l-10">
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Checklist Type <span class="error"> * </span></label>
                                            <?php
                                            $getchecklisttypname = isset($getSubtypedatas[0]->INSP_SUBTYP_DATA_TYPID) && !empty($getSubtypedatas[0]->INSP_SUBTYP_DATA_TYPID) ? $getSubtypedatas[0]->INSP_SUBTYP_DATA_TYPID : set_value('insp[checklist_type]');
                                            $cNamedatas = [
                                                'id' => 'checklist_type',
                                                'class' => 'form-control select2',
                                                'required' => true,
                                                'autocomplete' => 'off',
                                                'checkSelect' => 'select2',
                                            ];
                                            echo form_dropdown('insp[checklist_type]', $dropInsptype, $getchecklisttypname, $cNamedatas);
                                            ?>
                                            <span class="error"><?php echo form_error('insp[checklist_type]') ?></span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="insp[checklist_typeedit]" value="<?php echo $getchecklisttypname; ?>">
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Checklist Subtype </label>
                                            <?php
                                            $getchecklistsubtypname = isset($getSubtypedatas[0]->INSP_SUBTYP_DATA_SUBTYPID) && !empty($getSubtypedatas[0]->INSP_SUBTYP_DATA_SUBTYPID) ? $getSubtypedatas[0]->INSP_SUBTYP_DATA_SUBTYPID : set_value('insp[checklist_subtype]');
                                            $cSubtypdatas = [
                                                'id' => 'checklist_subtype',
                                                'class' => 'form-control select2',
//                                                'required' => true,
                                                'autocomplete' => 'off',
                                                'checkSelect' => 'select2',
                                            ];
                                            echo form_dropdown('insp[checklist_subtype]', $dropInsptypedata, $getchecklistsubtypname, $cSubtypdatas);
                                            ?>
                                           
                                        </div>
                                    </div>
                                     <input type="hidden" name="insp[checklist_subtypeedit]" value="<?php echo $getchecklistsubtypname; ?>">
                                </div>
                                <div class="row float-right">
                                <div class="col-md-12">
                                    <button type="button " class="btn btn-sm btn-warning addsubtyp"><i class="fa fa-plus-circle"> Add Checklist Subtype Data</i></button>
                                </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="emplDet m-t-10">
                                <div class="row" >
                                    <div class="col-md-12">
                                        <div class="box-header with-border" >
                                            <h5 class=""> Checklist Subtype Data </h5>
                                        </div>

                                    </div>
                                </div>
                                    
                                    <?php
                                    if(!empty($getSubtypedatas)){
                                        foreach($getSubtypedatas as $sbKey => $sbVal){
                                            $inKey = $sbKey+1;
                                           
                                        ?>
                                     <div class="row m-t-10 m-l-10 remRowid" id="remRowid_<?php echo $inKey; ?>" row-id="<?php echo $inKey; ?>">

                                    <div class="col-sm-11">
                                        <div class="form-group">
                                            <!--<label> Checklist Subtype <span class="error"> * </span></label>-->
                                            <?php
                                            $getsubtypeval = isset($sbVal->INSP_SUBTYP_DATA_DESC) && !empty($sbVal->INSP_SUBTYP_DATA_DESC) ? $sbVal->INSP_SUBTYP_DATA_DESC : '';
                                            $getsubtypeid = isset($sbVal->INSP_SUBTYP_DATA_ID) && !empty($sbVal->INSP_SUBTYP_DATA_ID) ? $sbVal->INSP_SUBTYP_DATA_ID : '';
                                            
                                            $allSUbtypids[] = $getsubtypeid;
                                            $cMaildatas = [
                                                'name' => 'insp[subtype][]',
                                                'id' => 'subtype_'.$inKey,
                                                'class' => 'form-control',
                                                'value' => $getsubtypeval,
                                                'required' => true,
                                                'autocomplete' => 'off',
                                                
                                            ];
                                            echo form_input($cMaildatas);
                                            ?>
                                            <span class="error"><?php echo form_error('insp[subtype][]') ?></span>
                                        </div>
                                        <input type="hidden" name="insp[hid_subtyp][]" value="<?php echo $getsubtypeid; ?>">
                                        
                                    </div>
                                    <div class="col-md-1 trashRem" id="trash_<?php echo $inKey; ?>" trash-id="<?php echo $inKey; ?>">
                                        <i class="fa fa-trash"></i>
                                    </div>
             

                                </div>
                                        <?php } ?>
                                       
                                      <?php  }else{ ?>

                                <div class="row m-t-10 m-l-10 remRowid" id="remRowid_1" row-id="1">

                                    <div class="col-sm-11">
                                        <div class="form-group">
                                            <!--<label> Checklist Subtype <span class="error"> * </span></label>-->
                                            <?php
                                           $cMaildatas = [
                                                'name' => 'insp[subtype][]',
                                                'id' => 'subtype_1',
                                                'class' => 'form-control',
                                                'value' => '',
                                                'required' => true,
                                                'autocomplete' => 'off',
                                                
                                            ];
                                            echo form_input($cMaildatas);
                                            ?>
                                            <span class="error"><?php echo form_error('insp[subtype][]') ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-1 trashRem" id="trash_1" trash-id="1">
                                        <i class="fa fa-trash"></i>
                                    </div>


                                </div>
                                    <?php } ?>
                                    <div class="newSubtypes">
                                    </div>
                                     </div>
                                <div class="form-group m-t-10" style="text-align: center;">
                                    <div class="col-sm-offset-2 col-sm-10"> 

<?php
$data = array('id' => 'submit', 'type' => 'submit', 'content' => '<i class="fa fa-save" aria-hidden="true"></i> SUBMIT', 'class' => 'btn btn-primary');
echo form_button($data);
?>
                                    </div>
                                </div>

                                <!-- input states -->
<?php echo form_close(); ?>
                           
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
        
        $.validator.addMethod('alphanumeric', function (value) {
            return /^[A-Za-z0-9/,.()%  ]*$/.test(value);
        }, "Please Enter valid Alphanumeric characters with allowed special charters are /,.()%");


        $("#company-profile").validate({
            success: function (error) {
                error.removeClass("error");
                error.addClass("d-none");
            },

            rules: {
                "insp[checklist_type]": {
                    required: true,
                    
                },
//                "insp[checklist_subtype]": {
//                    required: true,
//                },
                "insp[subtype][]": {
                    required: true,
                    // programming_char : true 
                     alphanumeric : true 
                },
               

            },
            messages: {
                "insp[checklist_type]": {
                    required: "Checklist Type is required"
                },
//                "insp[checklist_subtype]": {
//                    required: "Checklist Subtype is required"
//                },
                "insp[subtype][]": {
                    required: "Checklist Subtype Data is required"
                },
                
            },
            errorPlacement: function(error,element) {
                 
                if(element.attr('checkSelect') == 'select2'){
                    error.insertAfter(element.next('.select2-container'));
                }else{
                    error.insertAfter(element);
                    element.closest(".imgGroup").last().append(error);
                }
            }

        });

$(".addsubtyp").on("click",function(e){
    e.preventDefault();
    var html = '';
   var rowID = $('.row').last().attr('row-id');
   var finalRowid = parseInt(rowID)+1;
    html = '<div class="row m-t-10 m-l-10 remRowid" id="remRowid_'+finalRowid+'" row-id="'+finalRowid+'">\n\
                        <div class="col-sm-11">\n\
                                        <div class="form-group">\n\
                                            <input type="text" name="insp[subtype][]" value="" id="subtype_'+finalRowid+'" class="form-control" required="1" autocomplete="off" >\n\
                                            <span class="error"></span>\n\
                                        </div>\n\
                                    </div>\n\
<div class="col-md-1 trashRem" id="trash_'+finalRowid+'" trash-id="'+finalRowid+'">\n\
<i class="fa fa-trash"></i>\n\
</div>\n\
                    </div>';
    $(".newSubtypes").append(html)
});

$(document).on('click',".trashRem",function(){
   var trashId =  $(this).attr("trash-id");
   var count = $(".emplDet").find('.remRowid').length;
   if(count != 1){
    $("#remRowid_"+trashId).remove();
    }else{
       swal('Sorry','Atleast one Checklist Subtype Data is required','error');
   }
});

$(document).on('change','#checklist_type',function(){
    var checkTypid = $(this).val();
    var url = "<?php echo BASE_URL('inspection/getAjaxChecksubtyp') ?>";
    var data = {checkTypid:checkTypid, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'}
        $.ajax({
            dataType: 'json',
            data: 'ajax',
            method: 'post',
            data: data,
            url: url,
            success: function (resp) {
                var appendCheck = '<option value="">Select Checklist Subtype</option>';
                if(resp.status){
                    $.each(resp.chdatas,function(iKey,iVal){
                        if(iKey != ''){
                        appendCheck += '<option value='+iKey+'>'+iVal+'</option>';
                    }
                    });
                }
               $("#checklist_subtype").html(appendCheck);
            }
        });
});
    });
</script>
