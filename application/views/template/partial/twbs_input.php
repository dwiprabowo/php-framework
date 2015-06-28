<div class="form-group <?=form_error($data['name'])?'has-error':''?>">
    <label 
        for="<?=$data['id']?>" 
        class="control-label"
        ><?=$data['label']?></label>
    <?=form_input(
        $data
        , $value
        , $extra
    )?>
    <? if (form_error($data['name'])): ?>
        <sub class="control-label bg-danger">
            <?=form_error($data['name'])?>
        </sub>
    <? endif ?>
</div>
