<?php $params = [
    'label' => '',
    'name' => 'active',
    'value' => '1',
    'checked' => (old('active', $row->active ?? false)), 
] ; ?>


<?php if (isset($hxGet)) :
    $params['hxGet'] = $hxGet;
endif; ?>

<?php if (isset($hxSwap)) :
    $params['hxSwap'] = $hxSwap;
endif; ?>

<?= view_cell('Btw\Core\Cells\SwitchCell::renderList', $params); ?>