<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>
<?= lang('Auth.useMagicLink') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>


<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/" class="h-10">
                <img src="<?= base_url() . 'logo-adn-grey.png'; ?>" alt="Adn du web" class=" h-28 w-full" />
            </a>
        </div>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div
                class="w-full bg-white rounded-lg dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <h5 class="card-title mb-5">
                    <?= lang('Auth.useMagicLink') ?>
                </h5>

                <p><b>
                        <?= lang('Auth.checkYourEmail') ?>
                    </b>!</p>

                <p>
                    <?= lang('Auth.magicLinkDetails', [setting('Auth.magicLinkLifetime') / 60]) ?>
                </p>

                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>