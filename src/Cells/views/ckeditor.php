<textarea id="<?= $params['name']; ?>" ci4:key="ckEditor" name="<?= $params['name']; ?>" x-data x-init="
        ClassicEditor.create( document.querySelector('#<?= $params['name']; ?>'))
         .then( function( editor ){
                 editor.model.document.on( 'change:data', () => {
                    $dispatch( 'input', editor.getData() )
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
                  ClassicEditor.create( document.querySelector('#<?= $params['name']; ?>'));
             });
         })
         .catch( error => {
             console.error( error );
         } );
     " x-ref="ckEditor" class="hidden"> <?=  $params['value'] ; ?></textarea>