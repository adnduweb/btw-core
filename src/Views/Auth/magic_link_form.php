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

                <?= form_open(url_to('magic-link'), [
                    'id' => 'kt_form_magic-link',
                    'class' => 'space-y-4 md:space-y-6',
                    'hx-post' => url_to('magic-link'),
                    'hx-target' => '#formmagiclink',
                    'hx-swap' => 'none',
                    'hx-ext' => "event-header",
                    'novalidate' => false,
                ]); ?>
                <input type="hidden" name="section" value="formmagiclink" />
                <?= $this->include('Btw\Core\Views\Auth\cells\form_cell_magic_link'); ?>
                <?= form_close(); ?>

            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>