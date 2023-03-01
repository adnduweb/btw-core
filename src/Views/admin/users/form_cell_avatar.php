<div id="avatar" class="shadow sm:rounded-md sm:overflow-hidden">
    <div x-data="{useGravatar: <?= old('useGravatar', setting('Users.useGravatar')) ? true : '0' ?>}" class="px-4 py-5 bg-white space-y-6 sm:p-6">
        <h6 class="text-slate-400 text-sm mt-5 mb-6 font-bold uppercase">Avatars</h6>

        <!-- Name Basis -->
        <div class="row mb-3">
            <div class="col-12 col-sm-4">
                <label class="form-check-label" for="avatarNameBasis">Display initials based on:</label>
                <select name="avatarNameBasis" class="border-0 px-3 py-3 placeholder-gray-300 text-gray-600 bg-gray-300 rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                    <option value="name" <?= old('avatarNameBasis', setting('Users.avatarNameBasis')) === 'name' ? 'selected' : '' ?>>Full Name</option>
                    <option value="username" <?= old('avatarNameBasis', setting('Users.avatarNameBasis')) === 'username' ? 'selected' : '' ?>>Username</option>
                </select>
            </div>
            <div class="col px-5 pt-4">
                <p class="text-muted small text-sm text-gray-500">Will use either the user's full name or their username to display the
                    initials within their avatar if no image exists.</p>
            </div>
        </div>

        <!-- Use Gravatar -->
        <div class="relative w-full mb-3">
            <div class="col-12 col-sm-4">
                <div class="form-check">
                    <input class="form-check-input form-checkbox border-0 rounded text-blueGray-700 ml-1 w-5 h-5 bg-gray-300 ease-linear transition-all duration-150" type="checkbox" name="useGravatar" value="1" id="use-gravatar" @change="useGravatar = ! useGravatar" <?php if (old('useGravatar', setting('Users.useGravatar'))) : ?> checked <?php endif ?>>
                    <label class="form-check-label" for="use-gravatar">
                        Use Gravatar for avatars
                    </label>
                </div>
            </div>
            <div class="col px-5">
                <p class="text-muted small text-sm text-gray-500">Will use <a href="http://en.gravatar.com/" target="_blank">Gravatar</a>
                    to provide portable use avatars. This would be used if a user has not uploaded an avatar locally.</p>
            </div>
        </div>

        <!-- Gravatar Default -->
        <div class="relative w-full mb-3" x-show="useGravatar">
            <div class="col-12 col-sm-4">
                <label for="gravatarDefault" class="form-label">Gravatar default style</label>
                <select name="gravatarDefault" class="border-0 px-3 py-3 placeholder-gray-300 text-gray-600 bg-gray-300 rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150">
                    <option value="">Select default style....</option>
                    <option value="mp" <?= old('gravatarDefault', setting('Users.gravatarDefault')) === 'mp' ? 'selected' : '' ?>>mystery person</option>
                    <option value="identicon" <?= old('gravatarDefault', setting('Users.gravatarDefault')) === 'identicon' ? 'selected' : '' ?>>identicon</option>
                    <option value="monsterid" <?= old('gravatarDefault', setting('Users.gravatarDefault')) === 'monsterid' ? 'selected' : '' ?>>monsterid</option>
                    <option value="wavatar" <?= old('gravatarDefault', setting('Users.gravatarDefault')) === 'wavatar' ? 'selected' : '' ?>>wavatar</option>
                    <option value="retro" <?= old('gravatarDefault', setting('Users.gravatarDefault')) === 'retro' ? 'selected' : '' ?>>retro</option>
                    <option value="robohash" <?= old('gravatarDefault', setting('Users.gravatarDefault')) === 'robohash' ? 'selected' : '' ?>>robohash</option>
                    <option value="blank" <?= old('gravatarDefault', setting('Users.gravatarDefault')) === 'blank' ? 'selected' : '' ?>>blank</option>
                </select>
            </div>
            <div class="col px-5 pt-2">
                <p class="text-muted small text-sm text-gray-500">
                    Visit <a href="http://en.gravatar.com/site/implement/images/" target="_blank">gravatar.com</a> for image examples.
                </p>
            </div>
        </div>
    </div>
    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <x-inputs.button type="submit" text="<?= lang('Btw.save'); ?>" />
    </div>

</div>