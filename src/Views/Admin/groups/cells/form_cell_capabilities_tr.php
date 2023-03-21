 <!--begin::Table body-->
 <tbody id="permissions" class="text-gray-600 fw-bold ">

     <?php foreach ($permissions as $permission => $description) : ?>
        <?= $this->setData(['permission' => $permission, 'description' => $description, 'matrix' => $matrix])->include('Btw\Core\Views\Admin\groups\cells\form_cell_capabilities_row'); ?>
        
     <?php endforeach ?>

 </tbody>