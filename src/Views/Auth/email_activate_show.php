<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.emailActivateTitle') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="container d-flex justify-content-center p-5">
    <div class="card col-12 col-md-5 shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-5"><?= lang('Auth.emailActivateTitle') ?></h5>

            <?php if (session('error')) : ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif ?>

            <p><?= lang('Auth.emailActivateBody') ?></p>

            <?= form_open(url_to('auth/a/verify'), [
                'id' => 'kt_form_auth_a_verify',
                'class' => 'space-y-4 md:space-y-6',
                'hx-post' => url_to('auth/a/verify'),
                'hx-target' => '#formauthaverify',
                'hx-swap' => 'none',
                'hx-ext' => "event-header",
                'novalidate' => false,
            ]); ?>
            <input type="hidden" name="section" value="formauthaverify" />
            <?= $this->include('Btw\Core\Views\Auth\cells\form_cell_email_activate_show'); ?>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>