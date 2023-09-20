<div id="formmagiclink">
    <p class="text-muted mb-4"><?= lang('Btw.MagicLinkInfo'); ?></p>

    <p class="text-muted text-sm text-gray-500"><?= lang('Btw.ForgoYourPasswordNoProblem'); ?></p>

    <!-- Email -->
    <div class="mb-5">
        <input type="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email', auth()->user()->email ?? null) ?>" required />
    </div>

    <div class="d-grid col-8 mx-auto m-3">
        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><?= lang('Auth.useMagicLink') ?></button>
    </div>

    <div class="d-grid col-8 mx-auto m-3">
        <a href="<?= route_to('login'); ?>" type="submit" class="w-full bg-gray-700 hover:bg-gray-800 active:bg-gray-600 text-white focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><?= lang('Btw.back') ?></a>
    </div>
</div>