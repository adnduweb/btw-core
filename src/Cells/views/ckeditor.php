<textarea id="<?= $params['name']; ?>"  x-data="{ value: '<?=  $params['value'] ; ?>' }" name="<?= $params['name']; ?>" x-init="
        ClassicEditor.create( $refs.<?= $params['name']; ?> )
         .then( function( editor ){
                 editor.model.document.on( 'change:data', () => {
                    //$dispatch( 'input', editor.getData() )
                    value = editor.getData();
                 });
                 // On reinit, destroy the old instance and create a new one
                 document.body.addEventListener('reinit', function (ev) {
                 console.log('fafa');
                 console.log(ev);
                 editor.setData('');
                 editor.destroy()
                     .catch(error => {
                         console.log(error);
                     });
                  ClassicEditor.create( $refs.<?= $params['name']; ?> );
             });
         })
         .catch( error => {
             console.error( error );
         } );
     " x-model="value"  x-ref="<?= $params['name']; ?>" class="hidden"> <?=  $params['value'] ; ?></textarea>