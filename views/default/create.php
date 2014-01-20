<h1>
    <?php echo Yii::t('app', 'Create Migration'); ?>
</h1>
<?php
echo CHtml::link('Admin', array('admin'));
?>
<?php
echo CHtml::beginForm('', 'POST');
?>

<?php
echo CHtml::label(Yii::t('app', 'Name'), "Migrate[name]");
echo CHtml::textField("Migrate[name]", '');
?>

<?php
echo CHtml::submitButton(Yii::t('app', 'Create'), array(
    'class' => 'btn btn-success'
))
?>

<?php
echo CHtml::endForm();
?>