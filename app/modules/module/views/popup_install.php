<form action="<?=PATH?>module/ajax_install_script" data-redirect="<?=PATH?>module" data-type-message="text" data-async role="form" class="actionForm" role="form" method="POST">
<div id="load_popup_modal_contant" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modal-title"><i class="ft-plus-circle"></i> <?=lang('add_new')?></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="tab-content">
                            <div class="form-notify"></div>
                            <div class="form-group">
                                <label class="control-label" for="purchase_code">  <?=lang('purchase_code')?></label>
                                    <input type="text" name="purchase_code" id="purchase_code" class="form-control" id="purchase_code">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?=lang('install')?></button>
            </div>
        </div>
    </div>
</div>
</form>

