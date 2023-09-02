<?= $this->extend(setting('Auth.views')['email_layout']) ?>

<?= $this->section('message') ?>

<!-- START CENTERED WHITE CONTAINER -->
<table role="presentation" class="main">

    <!-- START MAIN CONTENT AREA -->
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <p>Hi there,</p>
                        <p>Sometimes you just want to send a simple HTML email with a simple design and clear call to action. This is it.</p>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                            <tbody>
                                <tr>
                                    <td align="left">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a href="<?= site_url(route_to('verify-magic-link')) ?>?token=<?= $token ?>">
                                                            <?= lang('Auth.login') ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

<?= $this->endSection() ?>