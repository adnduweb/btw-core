<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.email2FATitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/login" class="h-10">
                <img src="<?= base_url() . 'admin/img/logo-adn-grey.png'; ?>" alt="Adn du web" class=" h-28 w-full" />
            </a>
        </div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="w-full bg-white rounded-lg dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">


                <h5 class="ctext-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"><?= lang('Auth.email2FATitle') ?></h5>

                <p><?= lang('Auth.confirmEmailAddress') ?></p>

                <?php if (session('error')) : ?>
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"><?= session('error') ?></div>
                <?php endif ?>

                <?= form_open(url_to('auth-action-handle'), [
                    'id' => 'kt_form_auth_action_handle',
                    'class' => 'space-y-4 md:space-y-6',
                    'hx-post' => url_to('auth-action-handle'),
                    'hx-target' => '#formauthactionhandle',
                    'hx-swap' => 'none',
                    'hx-ext' => "event-header",
                    'novalidate' => false,
                ]); ?>
                <input type="hidden" name="section" value="formauthactionhandle" />
                <?= $this->include('Btw\Core\Views\Auth\cells\form_cell_email_2fa_show'); ?>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>