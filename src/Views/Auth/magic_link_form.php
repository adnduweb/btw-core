<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>



<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/" class="h-10">
                <img src="<?= base_url() . 'logo-adn-grey.png'; ?>" alt="Adn du web" class=" h-28 w-full" />
            </a>
        </div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="w-full bg-white rounded-lg dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">

                <h5 class="card-title mb-4"><?= lang('Auth.useMagicLink') ?></h5>

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

                <form class="space-y-4 md:space-y-6" action="<?= route_to('magic-link') ?>" method="post">
                    <?= csrf_field() ?>

                    <p class="text-muted mb-4"><?= lang('Btw.MagicLinkInfo'); ?></p>


                    <p class="text-muted text-sm text-gray-500"><?= lang('Btw.ForgoYourPasswordNoProblem'); ?></p>

                    <!-- Email -->
                    <div class="mb-5">
                        <input type="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email', auth()->user()->email ?? null) ?>" required />
                    </div>

                    <div class="d-grid col-8 mx-auto m-3">
                        <button type="submit" class="w-full text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800"><?= lang('Auth.useMagicLink') ?></button>
                    </div>

                    <div class="d-grid col-8 mx-auto m-3">
                        <a href="<?= route_to('login'); ?>" type="submit" class="w-full bg-gray-700 hover:bg-gray-800 active:bg-gray-600 text-white focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800"><?= lang('Btw.back') ?></a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>