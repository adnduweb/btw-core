<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    <div>
        <a href="/" class="h-10">
            <img src="<?= base_url() . 'logo-adn-grey.png'; ?>" alt="Adn du web" class=" h-28 w-full" />
        </a>
    </div>
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="w-full bg-white rounded-lg dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"><?= lang('Auth.login') ?></h5>

            <?php if (session('error') !== null) : ?>
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert"><?= session('error') ?></div>
            <?php elseif (session('errors') !== null) : ?>
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <?php if (is_array(session('errors'))) : ?>
                        <?php foreach (session('errors') as $error) : ?>
                            <?= $error ?>
                            <br>
                        <?php endforeach ?>
                    <?php else : ?>
                        <?= session('errors') ?>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <?php if (session('message') !== null) : ?>
                <div class="alert alert-success" role="alert"><?= session('message') ?></div>
            <?php endif ?>

            <form class="space-y-4 md:space-y-6" action="<?= url_to('login') ?>" method="post">
                <?= csrf_field() ?>

                <!-- Email -->
                <div class="mb-2">
                    <input type="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required />
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <input type="password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="password" inputmode="text" autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>" required />
                </div>



                <div class="flex items-center justify-between">

                    <!-- Remember me -->
                    <?php if (setting('Auth.sessionConfig')['allowRemembering']) : ?>

                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="remember" class="form-check-input w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" <?php if (old('remember')) : ?> checked<?php endif ?>>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remember" class="text-gray-500 dark:text-gray-300"><?= lang('Auth.rememberMe') ?></label>
                            </div>
                        </div>


                    <?php endif; ?>

                    <?php if (setting('Auth.allowMagicLinkLogins')) : ?>

                        <a class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500" href="<?= url_to('magic-link') ?>">
                            <?= lang('Auth.forgotPassword') ?>
                        </a>
                    <?php endif ?>

                </div>


                <div class="d-grid col-12 col-md-8 mx-auto m-3">
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><?= lang('Auth.login') ?></button>
                </div>


                <?php if (setting('Auth.allowRegistration')) : ?>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400"><?= lang('Auth.needAccount') ?>
                        <a class="font-medium text-blue-600 hover:underline dark:text-blue-500" href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a>
                    </p>
                <?php endif ?>

            </form>
        </div>

        {{ShieldOAuthButtonForLoginPage}}

    </div>
</div>

<?= $this->endSection() ?>