<div id="changepassword" class="shadow sm:rounded-md sm:overflow-hidden">
    <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">

        <h3 class="text-base font-medium leading-6 text-gray-900 dark:text-gray-200">Change paswword</h3>



        <?php ''; // print_r($userCurrent); 
        ?>
        <div class="flex flex-wrap  mb-6">
            <div x-data="{ show: true }" class="w-full relative mb-6">

                <x-label for="current_password" label="<?= lang('Btw.Current password'); ?>" />
                <div class="relative">
                    <x-inputs.text type="password" name="current_password" value="" description="false" xType="show ? 'password' : 'text' " />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <svg class="h-6 text-gray-400 dark:text-gray-200" fill="none" @click="show = !show" :class="{'hidden': !show, 'block':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 576 512">
                            <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                            </path>
                        </svg>

                        <svg class="h-6 text-gray-400 dark:text-gray-200" fill="none" @click="show = !show" :class="{'block': !show, 'hidden':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 640 512">
                            <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                            </path>
                        </svg>
                    </div>
                </div>
                <?php if (isset($validation)) :  ?>
                    <div class="invalid-feedback block">
                        <?= $validation->getError('current_password'); ?>
                    </div>
                <?php endif ?>

            </div>
            <div x-data="{ show: true }" class="w-full relative mb-6">
                <x-label for="password" label="<?= lang('Btw.New password'); ?>" />
                <div class="relative">
                    <x-inputs.text name="new_password" value="" description="false" xType="show ? 'password' : 'text' " xModel="new_password" />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <svg class="h-6 text-gray-400 dark:text-gray-200" fill="none" @click="show = !show" :class="{'hidden': !show, 'block':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 576 512">
                            <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                            </path>
                        </svg>

                        <svg class="h-6 text-gray-400 dark:text-gray-200" fill="none" @click="show = !show" :class="{'block': !show, 'hidden':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 640 512">
                            <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                            </path>
                        </svg>
                    </div>
                </div>
                <?php if (isset($validation)) :  ?>
                    <div class="invalid-feedback block">
                        <?= $validation->getError('password'); ?>
                    </div>
                <?php endif ?>

            </div>

            <div x-data="{ show: true }" class="w-full relative mb-6">
                <div class="w-full ">
                    <x-label for="pass_confirm" label="<?= lang('Btw.Confirm password'); ?>" />
                    <div class="relative">
                        <x-inputs.text name="pass_confirm" value="" description="false" xType="show ? 'password' : 'text' " xModel="pass_confirm" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                            <svg class="h-6 text-gray-400 dark:text-gray-200" fill="none" @click="show = !show" :class="{'hidden': !show, 'block':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 576 512">
                                <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                </path>
                            </svg>

                            <svg class="h-6 text-gray-400 dark:text-gray-200" fill="none" @click="show = !show" :class="{'block': !show, 'hidden':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 640 512">
                                <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                </path>
                            </svg>
                        </div>
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
            <label class="block text-xs font-semibold text-gray-500 mb-2">PASSWORD LENGTH</label>
            <input class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="Length" type="number" min="6" max="30" step="1" x-model="charsLength" @input="generatePassword()" />
            <input class="w-full" type="range" x-model="charsLength" min="6" max="30" step="1" @input="generatePassword()">
        </div>
        <div class="flex -mx-2 mb-2">
            <div class="w-1/2 px-2">
                <x-inputs.checkbox label="<?= lang('Btw.LOWERCASE'); ?>" class="align-middle" name="charsLower" checked="true" description="false" xInput="generatePassword()" />
            </div>
            <div class="w-1/2 px-2">
                <x-inputs.checkbox label="<?= lang('Btw.UPPERCASE'); ?>" class="align-middle" name="charsUpper" checked="true" description="false" xInput="generatePassword()" />
            </div>
        </div>
        <div class="flex -mx-2">
            <div class="w-1/2 px-2">
                <x-inputs.checkbox label="<?= lang('Btw.NUMBERS'); ?>" class="align-middle" name="charsNumeric" checked="true" description="false" xInput="generatePassword()" />
            </div>
            <div class="w-1/2 px-2">
                <x-inputs.checkbox label="<?= lang('Btw.SYMBOLS'); ?>" class="align-middle" name="charsSymbols" checked="true" description="false" xInput="generatePassword()" />
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