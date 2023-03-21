<?= $this->extend(config('Auth')->views['layout_email']) ?>

<?= $this->section('main') ?>


<span class="preheader">This is preheader text. Some clients will show this text as a preview.</span>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
    <tr>
        <td>&nbsp;</td>
        <td class="container">
            <div class="content">

                <!-- START CENTERED WHITE CONTAINER -->
                <table role="presentation" class="main">

                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class="wrapper">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>


                                        <p><?= lang('Auth.email2FAMailBody') ?> <b><?= $code ?></b></p>

                                        <p>This is a really simple email template. Its sole purpose is to get the recipient to click the button with no distractions.</p>
                                        <p>Good luck! Hope it works.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- END MAIN CONTENT AREA -->
                </table>
                <!-- END CENTERED WHITE CONTAINER -->

            </div>
            <!-- END FOOTER -->

            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
<?= $this->endSection() ?>