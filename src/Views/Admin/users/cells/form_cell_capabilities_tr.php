 <!--begin::Table body-->
 <tbody id="permissions" class="text-gray-600 fw-bold ">

     <?php foreach ($permissions as $permission => $description) : ?>
        <?= $this->setVar('rowPermission', [$permission, $description])->include('Btw\Core\Views\Admin\users\cells\form_cell_capabilities_row'); ?>
        
     <?php endforeach ?>

 </tbody>