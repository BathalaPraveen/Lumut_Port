<div class="wrapper">
    <div class="content-wrapper">
        <section class="content">
            <div style="margin-top:10px;">
                <?php
                echo $this->session->flashdata('assessmentflash');
                $this->session->unset_userdata('assessmentflash');
                ?>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">QUESTION LIST</h3>
                            <a href="<?php echo BASE_URL('hse_induction/master/addQuestion') ?>" class="btn btn-sm btn-primary float-right m-r-10"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Question</a>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Question</th>
                                        <th>Created on</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="modal modal-info fade" id="respmodal" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';

        $(document).on("click", ".deleteQuestion", function(e) {
            e.preventDefault();
            var url = '<?php echo BASE_URL("hse_induction/master/delete_assessment_master"); ?>';
            var deletId = $(this).attr("delt-id");
            deleteDatas(url, deletId, csrfName, csrfToken);
        });
    });
</script>

