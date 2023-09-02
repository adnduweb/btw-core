<?php $params = [
    'label' => '',
    'name' => 'active',
    'value' => '1',
    'checked' => (old('active', $row->active ?? false)), 
] ; ?>


<?php if ((isset($type) && $type == 'user' && user_id() == $row->getIdentifier())) :
    $params['disabled'] = true ;
endif; ?>

<?php if ((isset($type) && $type == 'user' && auth()->user()->inGroup('admin'))) :
    $params['disabled'] = true ;
endif; ?>

<?php if (isset($hxGet)) :
    $params['hxGet'] = $hxGet;
endif; ?>

<?php if (isset($hxSwap)) :
    $params['hxSwap'] = $hxSwap;
endif; ?>

<?= view_cell('Btw\Core\Cells\Forms\SwitchCell::renderList', $params); ?>