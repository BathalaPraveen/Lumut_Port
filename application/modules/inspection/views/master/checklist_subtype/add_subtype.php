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
                                    <h4>ADD CHECKLIST SUBTYPE</h4>
                                    <a href="<?php echo BASE_URL('inspection/insp_clsubtype') ?>"><button type="button" class="btn btn-sm btn-primary backBtns"><i class="fa fa-backward"></i> Back</button></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                               $gettypeid = isset($getSubtypedatas[0]->INSP_CHECK_SUBTYP_TYPID) && !empty($getSubtypedatas[0]->INSP_CHECK_SUBTYP_TYPID) ? $getSubtypedatas[0]->INSP_CHECK_SUBTYP_TYPID : '';
                                ?>
                                <?php echo form_open('inspection/save_insp_subtype/' . encryptval($gettypeid), 'class="form-horizontal" id="company-profile" novalidate'); ?>

                                <div class="row m-l-10">
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Checklist Type <span class="error"> * </span></label>
                                            <?php
                                            $getchecklisttypname = isset($getSubtypedatas[0]->INSP_CHECK_SUBTYP_TYPID) && !empty($getSubtypedatas[0]->INSP_CHECK_SUBTYP_TYPID) ? $getSubtypedatas[0]->INSP_CHECK_SUBTYP_TYPID : set_value('insp[checklist_type]');
                                            $cNamedatas = [
                                                'id' => 'checklist_type',
                                                'class' => 'form-control select2',
                                                'required' => true,
                                                'autocomplete' => 'off',
                                                'checkSelect' => 'select2'
                                            ];
                                            echo form_dropdown('insp[checklist_type]', $dropInsptype, $getchecklisttypname, $cNamedatas);
                                            ?>
                                            <span class="error"><?php echo form_error('insp[checklist_type]') ?></span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="insp[checklist_typeedit]" value="<?php echo $getchecklisttypname; ?>">
                                </div>
                                <div class="row float-right">
                                <div class="col-md-12">
                                    <button type="button " class="btn btn-sm btn-warning addsubtyp"><i class="fa fa-plus-circle"></i> Add Checklist Subtype</button>
                                </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="emplDet m-t-10">
                                <div class="row" >
                                    <div class="col-md-12">
                                        <div class="box-header with-border" >
                                            <h5 class=""> Checklist Subtype </h5>
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
                                            $getsubtypeval = isset($sbVal->INSP_CHECK_SUBTYP_NAME) && !empty($sbVal->INSP_CHECK_SUBTYP_NAME) ? $sbVal->INSP_CHECK_SUBTYP_NAME : '';
                                            $getsubtypeid = isset($sbVal->INSP_CHECK_SUBTYP_ID) && !empty($sbVal->INSP_CHECK_SUBTYP_ID) ? $sbVal->INSP_CHECK_SUBTYP_ID : '';
                                            
                                            $cMaildatas = [
                                                'name' => 'insp[subtype][]',
                                                'id' => 'subtype_'.$inKey,
                                                'class' => 'form-control inspe_subtyp',
                                                'value' => $getsubtypeval,
                                                'required' => true,
                                                'autocomplete' => 'off',
                                                
                                            ];
                                            echo form_input($cMaildatas);
                                            ?>
                                          
                                        </div>
                                        <input type="hidden" name="insp[hid_subtyp][]" value="<?php echo $getsubtypeid; ?>">
                                    </div>
                                    <div class="col-md-1 trashRem" id="trash_<?php echo $inKey; ?>" trash-id="<?php echo $inKey; ?>">
                                        <i class="fa fa-trash"></i>
                                    </div>


                                </div>
                                        <?php }}else{ ?>

                                <div class="row m-t-10 m-l-10 remRowid" id="remRowid_1" row-id="1">

                                    <div class="col-sm-11">
                                        <div class="form-group">
                                            <!--<label> Checklist Subtype <span class="error"> * </span></label>-->
                                            <?php
                                            $getUnitID = isset($getSubtypedatas->UNIT_ID) && !empty($getSubtypedatas->UNIT_ID) ? $getSubtypedatas->UNIT_ID : '';
                                            $cMaildatas = [
                                                'name' => 'insp[subtype][]',
                                                'id' => 'subtype_1',
                                                'class' => 'form-control inspe_subtyp',
                                                'value' => $getUnitID,
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
           
//            success: function (error) {
//                error.removeClass("error");
//                error.addClass("d-none");
//            },
            ignore: [],
            rules: {
                "insp[checklist_type]": {
                    required: true,
                    
                },
                "insp[subtype][]": {
                    required: true,
                  //  programming_char : true,
                     alphanumeric: true

                },
               

            },
            messages: {
                "insp[checklist_type]": {
                    required: "Checklist type is required"
                },
                "insp[subtype][]": {
                    required: "Checklist Subtype is required",
                    
                },
                
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
        
$(".addsubtyp").on("click",function(e){
    e.preventDefault();
    var html = '';
   var rowID = $('.row').last().attr('row-id');
   var finalRowid = parseInt(rowID)+1;
    html = '<div class="row m-t-10 m-l-10 remRowid" id="remRowid_'+finalRowid+'" row-id="'+finalRowid+'">\n\
                        <div class="col-sm-11">\n\
                                        <div class="form-group">\n\
                                            <input type="text" name="insp[subtype][]" value="" id="subtype_'+finalRowid+'" class="form-control inspe_subtyp" required autocomplete="off" >\n\
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
       swal('Sorry','Atleast one Checklist Subtype is required','error');
   }
});


    });
</script>
