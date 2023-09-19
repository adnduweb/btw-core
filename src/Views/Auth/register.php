<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.register') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    <div>
        <a href="/login" class="h-10">
            <img src="<?= base_url() . 'logo-adn-grey.png'; ?>" alt="Adn du web" class=" h-28 w-full" />
        </a>
    </div>
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="w-full bg-white rounded-lg dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="card-title mb-5"><?= lang('Auth.register') ?></h5>

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

            <?= form_open(url_to('register'), [
                'id' => 'kt_form_login',
                'class' => 'space-y-4 md:space-y-6"',
                'hx-post' => url_to('register'),
                'hx-target' => '#formregisterback',
                'hx-swap' => 'none',
                'hx-ext' => "event-header",
                'novalidate' => false
            ]); ?>
            <input type="hidden" name="section" value="formregisterback" />
            <?= $this->include('Btw\Core\Views\Auth\cells\form_cell_register'); ?>
            <?= form_close(); ?>

            <p hx-boost="true" class="text-sm font-light text-gray-500 dark:text-gray-400"><?= lang('Auth.haveAccount') ?>
                <a class="font-medium text-blue-600 hover:underline dark:text-blue-500" href="<?= url_to('login') ?>"><?= lang('Auth.login') ?></a>
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>