<?= $this->extend(config('Themes')->views['layout_admin']) ?>
<?= $this->section('title') ?>
<?= lang('Btw.users.userCreate'); ?>
<?= $this->endSection() ?>
<?= $this->section('main') ?>


<x-page-head>
    <?= lang('Btw.users.userCreate'); ?>
</x-page-head>
<x-admin-box>

    <div class="max-w-3xl mx-auto">

        <div class="mt-5 md:mt-0 md:col-span-2 mb-5" data-loading-states x-data="appGeneratePassword()" x-init="generatePassword()">
            <?= form_open(route_to('user-only-create'), [
                'id' => 'kt_users_form_information',
                'hx-post' => route_to('user-only-create'),
                'hx-target' => '#general',
                'hx-ext' => "loading-states",
                'novalidate' => false,
                'data-loading-target' => "#loadinginformation",
                'data-loading-class-remove' => "hidden"
            ]); ?>
            <?= '' //csrf_field() 
            ?>
            <input type="hidden" name="section" value="general" />
            <?= $this->include('Btw\Core\Views\Admin\users\only\cells\form_cell_create'); ?>
            <?= form_close(); ?>
        </div>

    </div>
 
</x-admin-box>

<?= $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    function app() {
        return {
            showPasswordField: true,
            passwordScore: 0,
            new_password: '',
            pass_confirm: '',
            chars: {
                lower: 'abcdefghijklmnopqrstuvwxyz',
                upper: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
                numeric: '0123456789',
                symbols: '!"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~'
            },
            init() {
                console.log('changePassword loaded');
                this.generatePassword();
            },
            charsLength: 12,
            checkStrength: function() {
                if (!this.new_password) return this.passwordScore = 0;
                this.passwordScore = zxcvbn(this.new_password).score + 1;
            },
            generatePassword: function() {
                console.log(document.getElementById('charsSymbols').checked);
                var _pass = this.shuffleArray(
                    ((document.getElementById('charsLower').checked ? this.chars.lower : '') + (document.getElementById('charsUpper').checked ? this.chars.upper : '') + (document.getElementById('charsNumeric').checked ? this.chars.numeric : '') + (document.getElementById('charsSymbols').checked ? this.chars.symbols : '')).split('')
                ).join('').substring(0, this.charsLength);
                this.new_password = _pass;
                this.pass_confirm = _pass;
                this.checkStrength();
            },
            shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
                return array;
            }
        }
    }
</script>
<?php $this->endSection() ?>