<div class="form-group<?=form_error($name)?' has-error':''?>">
    <label 
        for="<?=$id?>" 
        class="control-label<?=isset($horizontal)?' col-sm-'.$horizontal['label']:''?>"
        ><?=$label?></label>
    <?php if(isset($horizontal)): ?>
        <div class="col-sm-<?=$horizontal['input']?>">
    <?php endif ?>
        <?=$view?>
        <?php if(form_error($name)): ?>
            <sub 
                class="bg-danger text-danger"
                ><?=form_error($name)?></sub>
        <?php endif ?>
    <?php if(isset($horizontal)): ?>
        </div>
    <?php endif ?>
</div>
