<header class="absolute top-0 left-0 w-full z-10 bg-transparent md:flex-row md:flex-nowrap md:justify-start flex items-center p-4">
    <div class="w-full mx-autp items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4">
        <button class="navbar-toggler d-sm-none collapsed mx-2 border-none" type="button" @click="open = ! open">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Search Form -->
        <form action="<?= route_to('search') ?>" method="post" class="flex-grow-1">
            <?= csrf_field() ?>

            <input class="form-control form-control bg-light w-100" type="text" name="search_term" placeholder="Search" aria-label="Search" value="<?= old('search_term', $searchTerm ?? '') ?>">
        </form>

        <!-- User Menu -->
        <?php if (auth()->user()) : ?>
            <ul class="flex-col md:flex-row list-none items-center hidden md:flex"><a class="text-blueGray-500 block" href="#pablo">
                    <div class="items-center flex"><span class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full"> <?= auth()->user()->renderAvatar(32) ?></span></div>
                </a>
                <div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48">
                    <a href="/<?= ADMIN_AREA ?>/users/<?= auth()->id() ?>" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">My account</a>
                    <a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Another action</a>
                    <a href="#pablo" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Something else here</a>
                    <div class="h-0 my-2 border border-solid border-blueGray-100"></div>
                    <a href="<?= route_to('logout') ?>" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Sign out</a>
                </div>
            </ul>
        <?php endif ?>
    </div>
</header>