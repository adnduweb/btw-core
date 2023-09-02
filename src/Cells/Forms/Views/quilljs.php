<div
    x-data="{
        value: '<?= $params['value']; ?>',
        init() {
            let quill = new Quill(this.$refs.quill, { theme: 'snow' })
 
            quill.root.innerHTML = this.value

            quill.on('text-change', () => {
                <!-- this.value = quill.root.innerHTML -->
                //$dispatch('hiddenInput', quill.root.innerHTML);
                this.$refs.ed1value.value = this.$refs.quill.__quill.root.innerHTML;
            })
        },
    }"
    class="max-w-full w-full bg-white"
>
    <div x-ref="quill" class="w-full max-w-full"
    ></div>


<textarea x-ref="ed1value" id="<?= $params['name']; ?>" name="<?= $params['name']; ?>" class="hidden"> </textarea>
</div>