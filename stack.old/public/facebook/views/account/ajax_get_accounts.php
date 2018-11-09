<div class="app-table" style="border-top: 1px solid #e5e5e5">
    <table class="table table-bordered table-datatable mb0" width="100%">
        <thead>
            <tr>
                <th>
                    <div class="pure-checkbox grey mr15">
                        <input type="checkbox" name="id[]" id="checkAll" class="filled-in chk-col-red checkAll">
                        <label class="p0 m0" for="checkAll">&nbsp;</label>
                    </div>
                </th>
                <th>
                    <span class="text"> <?=lang('id')?></span>
                </th>
                <th>
                    <span class="text"> <?=lang('name')?></span>
                </th>
                <th>
                    <span class="text"></span>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($accounts) && !empty($accounts)){
                foreach ($accounts as $key => $row) {
            ?>
            <tr>
                <td>
                    <div class="pure-checkbox grey mr15">
                        <input type="checkbox" name="id[]" id="check_<?=row($row, "ids")?>" class="filled-in chk-col-red checkItem" value="<?=row($row, "pid")?>">
                        <label class="p0 m0" for="check_<?=row($row, "ids")?>">&nbsp;</label>
                    </div>
                </td>
                <td><a target="_blank" href="https://fb.com/<?=row($row, "pid")?>"><?=row($row, "pid")?></a></td>
                <td><a target="_blank" href="https://fb.com/<?=row($row, "pid")?>"><?=row($row, "fullname")?></a></td>
                <td class="ajax_result text-center"></td>
            </tr>
            <?php }}?>
        </tbody>
    </table>
</div>
                