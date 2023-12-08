<?php

if(isset($qrcode_image)) : ?>
<img src="data:image/png;base64, <?php echo $qrcode_image; ?> " alt="">

<?php else: ?>

    <?php if (service('settings')->get('Auth.activateG2Factor', 'user:' . user_id()) == true) : ?>
    <table class="table table-hover">
        <tbody>
            <tr>
                <td class="left"><strong>Statut</strong></td>
                <td class="left">
                    <strong style="color:green">ACTIVÉ</strong>                                    
                </td>
            </tr>
            <tr>
                <td class="left"><strong>Confirmation de votre mot de passe</strong></td>
                <td class="left">
                        <input name="password" id="password" type="password" value="" class="field appearance-none block px-4 py-3 w-full rounded-md bg-gray-100 border-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0 text-sm leading-tight focus:outline-none dark:text-gray-200 dark:bg-gray-900 dark:border-gray-800 dark:focus:border-gray-700 ">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="delete_google_key" class="inline-flex justify-center cursor-pointer bg-red-500 text-white active:bg-red-600 dark:bg-gray-900 font-bold px-4 py-2 text-sm rounded-md shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-in-out duration-1200 transition-all ">Supprimer</button>
                </td>
            </tr>
        </tbody>
    </table>
    <?php endif; ?>
<?php endif; ?>