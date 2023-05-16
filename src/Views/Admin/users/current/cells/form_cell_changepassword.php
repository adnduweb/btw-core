<div id="changepassword" class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200"><?= lang('Btw.sidebar.changePassword'); ?></h3>



        <?php ''; // print_r($userCurrent); 
        ?>
        <div class="flex flex-wrap  mb-6">
            <div x-data="{ show: true }" class="w-full relative mb-6">

                <div class="relative">
                    <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                        'type' => 'password',
                        'label' => lang('Form.users.currentPassword'),
                        'name' => 'current_password',
                        'value' => "",
                        'xType' => "show ? 'password' : 'text'"
                    ]); ?>
                </div>

            </div>
            <div x-data="{ show: true }" class="w-full relative mb-6">
                <div class="relative">

                    <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                        'type' => 'password',
                        'label' => lang('Form.users.newPassword'),
                        'name' => 'new_password',
                        'value' => "",
                        'xType' => "show ? 'password' : 'text'",
                        'xModel' => "new_password"
                    ]); ?>
                </div>

            </div>

            <div x-data="{ show: true }" class="w-full relative mb-6">
                <div class="w-full ">
                    <div class="relative">
                        <?= view_cell('Btw\Core\Cells\InputCell::renderList', [
                            'type' => 'password',
                            'label' => lang('Form.users.confirmPassword'),
                            'name' => 'pass_confirm',
                            'value' => "",
                            'xType' => "show ? 'password' : 'text'",
                            'xModel' => "pass_confirm"
                        ]); ?>
                    </div>
                    <?php if (isset($validation)) :  ?>
                        <div class="invalid-feedback block">
                            <?= $validation->getError('pass_confirm'); ?>
                        </div>
                    <?php endif ?>

                </div>
            </div>

        </div>

        <div class="flex -mx-1">
            <template x-for="(v,i) in 5">
                <div class="w-1/5 px-1">
                    <div class="h-2 rounded-xl transition-colors" :class="i<passwordScore?(passwordScore<=2?'bg-red-400':(passwordScore<=4?'bg-yellow-400':'bg-green-500')):'bg-gray-200'"></div>
                </div>
            </template>
        </div>
        <hr class="my-5 border border-gray-200">
        <div class="mb-2">
            <label class="block text-xs font-semibold text-gray-500 mb-2"><?= lang('Form.users.passwordLength'); ?></label>
            <input class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="Length" type="number" min="6" max="30" step="1" x-model="charsLength" @input="generatePassword()" />
            <input class="w-full" type="range" x-model="charsLength" min="6" max="30" step="1" @input="generatePassword()">
        </div>
        <div class="flex -mx-2 mb-2">
            <div class="w-1/2 px-2">
                <?= view_cell('Btw\Core\Cells\CheckBoxCell::renderList', ['label' => lang('Form.users.LOWERCASE'), 'name' => 'charsLower', 'value' => "", 'checked' => true, 'disabled' => true, 'xInput' => "generatePassword()", 'class' => "align-middle"]); ?>
            </div>
            <div class="w-1/2 px-2">
                <?= view_cell('Btw\Core\Cells\CheckBoxCell::renderList', ['label' => lang('Form.users.UPPERCASE'), 'name' => 'charsUpper', 'value' => "", 'checked' => true, 'xInput' => "generatePassword()", 'class' => "align-middle"]); ?>
            </div>
        </div>
        <div class="flex -mx-2">
            <div class="w-1/2 px-2">
                <?= view_cell('Btw\Core\Cells\CheckBoxCell::renderList', ['label' => lang('Form.users.NUMBERS'), 'name' => 'charsNumeric', 'value' => "", 'checked' => true, 'xInput' => "generatePassword()", 'class' => "align-middle"]); ?>
            </div>
            <div class="w-1/2 px-2">
                <?= view_cell('Btw\Core\Cells\CheckBoxCell::renderList', ['label' => lang('Form.users.SYMBOLS'), 'name' => 'charsSymbols', 'value' => "", 'checked' => true, 'xInput' => "generatePassword()", 'class' => "align-middle"]); ?>
            </div>
        </div>


    </div>
    <div class="text-right dark:bg-gray-700 border-t border-gray-200 px-4 py-3 sm:px-6 bg-slate-50">
        <x-button-save type="submit" text="<?= lang('Btw.save'); ?>" loading="loadingchangepassword" />
    </div>

</div>

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