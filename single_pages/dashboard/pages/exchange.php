<?php  defined('C5_EXECUTE') or die("Access Denied.");

?>

<form action="<?php  echo $this->action('import')?>" method="post" class="form-horizontal">

    <?php  echo $this->controller->token->output('import')?>
    <fieldset>
        <legend><?php  echo t('Select XML (cif) file to import contents'); ?></legend>
        <textarea name="cif" style="width:100%; height:150px"></textarea>
        <div class="control-group">
            <?php  echo $form->label('fID', t('Select XML File')); ?>
            <div class="controls">
                <?php  $al = Core::make('helper/concrete/asset_library'); ?>
                <?php  echo $al->text('fID', 'fID', 'Select File', $f); ?>
            </div>
        </div>
        <button class="pull-right btn btn-success" type="submit" ><?php  echo t('Import')?></button>
    </fieldset>
  </form>

    <!--  Export -->
<form action="<?php  echo $this->action('export')?>" method="post" class="form-horizontal">
  <?php  echo $this->controller->token->output('export')?>
  <fieldset>
    <legend><?php  echo t('Select a page to create a XML'); ?></legend>
    <div class="control-group">
        <?php  echo $form->label('cID', t('Select a page')); ?>
        <div class="controls">
            <?php  $al = Core::make('helper/form/page_selector'); ?>
            <?php  echo $al->selectPage('cID'); ?>
        </div>
    </div>
    <?php if (isset($outputContent)) : ?>
      <textarea name="cif" style="width:100%; height:100px">
        <?php echo $outputContent ?>
      </textarea>
    <?php endif ?>
    <button class="pull-right btn btn-success" type="submit" ><?php  echo t('Export')?></button>
  </fieldset>
</form>
