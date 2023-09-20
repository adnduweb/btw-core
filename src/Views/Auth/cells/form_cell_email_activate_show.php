<div class="mb-2">
    <input type="text" class="form-control" name="token" placeholder="000000" inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" value="<?= old('token') ?>" required />
</div>

<div class="d-grid col-8 mx-auto m-3">
    <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.send') ?></button>
</div>