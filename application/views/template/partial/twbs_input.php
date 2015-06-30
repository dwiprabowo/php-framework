<div class="form-group <?=form_error($data['name'])?'has-error':''?>">
    <label 
        for="<?=$data['id']?>" 
        class="control-label<?= isset($horizontal)?' col-sm-'.$horizontal['label']:'' ?>"
        ><?=$data['label']?></label>
    <?php if(isset($horizontal)): ?>
        <div class="col-sm-<?=$horizontal['input']?>">
    <?php endif ?>
        <?=form_input(
            $data
            , $value
            , $extra
        )?>
        <?php if(form_error($data['name'])): ?>
            <sub 
                class="bg-danger text-danger"
                ><?=form_error($data['name'])?></sub>
        <?php endif ?>
    <?php if(isset($horizontal)): ?>
        </div>
    <?php endif ?>
</div>
