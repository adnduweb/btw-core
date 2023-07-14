<textarea id="<?= $params['name']; ?>" name="<?= $params['name']; ?>" x-data="{
        value: '<?= $params['value']; ?>',
        init() {

            let editor = new EasyMDE({ element: this.$refs.editor })
            editor.codemirror.refresh();
            editor.value(this.value)
 
            editor.codemirror.on('change', () => {
                this.value = editor.value()
            })
        },
    }" x-model="value" x-ref="editor" class="hidden"> <?= $params['value']; ?> </textarea>