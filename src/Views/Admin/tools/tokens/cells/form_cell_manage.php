<div id="tokens" class="shadow sm:rounded-md sm:overflow-hidden" hx-trigger="load">
    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-base font-semiæbold leading-6 text-gray-900">Applicant Information</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and application.</p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <?php foreach ($tokens as $token) : ?>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500"><?= empty($token->name) ? 'not' : $token->name; ?></dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0"><?= $token->created_at ?? 'not'; ?></dd>
                        <dd class="mt-1 text-sm text-red-700 sm:mt-0"><?= lang('Btw.delete'); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </div>
</div>


<?php


foreach ($tokens as $token) {
    // print_r($token);
}

?>