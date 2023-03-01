<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>


<x-page-head>Dashboard </x-page-head>
<x-admin-box>



    <div class="mt-5 table-body-container" x-data="datatables()" x-cloak>
        <div x-show="selectedUsers.length" class="bg-indigo-200 fixed top-4 right-4 z-40 w-1/4 shadow">
            <div class="container mx-auto px-4 py-4">
                <div class="flex md:items-center">
                    <div class="mr-4 flex-shrink-0">
                        <svg class="h-8 w-8 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div x-html="selectedUsers.length + ' rows are selected'" class="text-indigo-800 text-lg"></div>
                </div>
            </div>
        </div>

        <div class="mb-4 flex justify-between items-center ">

            <div class="flex-1 pr-4">
                <div class="relative md:w-1/3">
                    <input type="search" x-model="search" class="w-full pl-10 pr-4 py-2 rounded-lg border-0 shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Search...">
                    <div class="absolute top-0 left-0 inline-flex items-center p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                            <circle cx="10" cy="10" r="7" />
                            <line x1="21" y1="21" x2="15" y2="15" />
                        </svg>
                    </div>
                </div>
            </div>
            <div>
                <div class=" flex">

                    <div x-show="selectedUsers.length" class="relative shadow rounded-lg" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                        <div @click="open = ! open">
                            <button class="inline-flex items-center justify-center px-2 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-blue-100 text-blue-700 hover:bg-blue-200 focus:border-blue-300 focus:ring-blue-200 active:bg-blue-300 sm:text-sm" type="button">
                                <div x-html="selectedUsers.length + ' rows are selected'" class="text-indigo-800 text-lg"></div>
                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0" style="display: none;" @click="open = false" wfd-invisible="true">
                            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                                <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" href="#" hx-post="/api/records/78453/delete" role="button">Delete</a>
                                <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" wire:click="$set('selected', [])" role="button">Deselect</a>
                            </div>
                        </div>
                    </div>

                    <div class="relative shadow rounded-lg">
                        <button @click.prevent="open = !open" class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <path d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5" />
                            </svg>
                            <span class="hidden md:block">Display</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <polyline points="6 9 12 15 18 9" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="z-40 absolute top-0 right-0 w-40 bg-white rounded-lg shadow-lg mt-12 -mr-1 block py-1 overflow-hidden">
                            <template x-for="heading in headings">
                                <label class="flex justify-start items-center text-truncate hover:bg-gray-100 px-4 py-2">
                                    <div class="text-blue-600 mr-3">
                                        <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline" checked @click="toggleColumn(heading.key)">
                                    </div>
                                    <div class="select-none text-gray-700" x-text="heading.value"></div>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative" hx-get="/admin/groups-list/multicol" hx-target=".table-body-container" hx-trigger="input, select, sort-initiated, pagination-initiated" hx-swap="outerHTML"  hx-indicator=".progress">
                <thead>
                    <tr class="text-left">
                        <th class="py-2 px-3 sticky top-0 border-b border-indigo-200 bg-indigo-100">
                            <label class="text-indigo-500 inline-flex justify-between items-center hover:bg-gray-300 px-2 py-2 rounded-lg cursor-pointer">
                                <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline" @click="selectAllCheckbox($event);">
                            </label>
                        </th>
                        <template x-for="heading in headings">
                            <th class="bg-indigo-100 sticky top-0 border-b border-indigo-200 px-6 py-2 text-gray-700 font-bold tracking-wider uppercase text-xs" x-text="heading.value" x-show="columns.includes(heading.key)"></th>
                        </template>
                        <th class="bg-indigo-100 sticky top-0 border-b border-indigo-200 px-6 py-2 text-gray-700 font-bold tracking-wider uppercase text-xs"></th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="user in filtered(users, 'firstName', 'lastName','emailAddress', 'phoneNumber')" :key="user.userId">
                        <tr>
                            <td class="border-dashed border-t border-gray-300 px-3">
                                <label class="text-blue-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                    <input type="checkbox" x-model="user.selected" class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline" name="selected[]" :value="user.userId">
                                </label>
                            </td>
                            <td class="border-dashed border-t border-gray-300" x-show="columns.includes('userId')">
                                <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.userId"></span>
                            </td>
                            <td class="border-dashed border-t border-gray-300" x-show="columns.includes('firstName')">
                                <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.firstName"></span>
                            </td>
                            <td class="border-dashed border-t border-gray-300" x-show="columns.includes('lastName')">
                                <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.lastName"></span>
                            </td>
                            <td class="border-dashed border-t border-gray-300" x-show="columns.includes('emailAddress')">
                                <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.emailAddress"></span>
                            </td>
                            <td class="border-dashed border-t border-gray-300" x-show="columns.includes('gender')">
                                <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.gender"></span>
                            </td>
                            <td class="border-dashed border-t border-gray-300" x-show="columns.includes('phoneNumber')">
                                <span class="text-gray-700 px-6 py-3 flex items-center" x-text="user.phoneNumber"></span>
                            </td>
                            <td class="relative border-dashed border-t border-gray-300 px-3">
                                <div class="flex justify-end overflow-visible">
                                    <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                                        <div @click="open = ! open">
                                            <button class="block text-gray-600 hover:text-gray-500">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                </svg> </button>
                                        </div>

                                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute z-50 mt-2 w-48 rounded-md shadow-lg origin-top-right right-0" @click="open = false" style="display: none;" wfd-invisible="true">
                                            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                                                <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" wire:click="$emitTo('admin.shipping-rate-form', 'edit', '1')" role="button">Edit rate</a>
                                                <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" wire:click="$emitTo('admin.shipping-rate-form', 'delete', '1')" role="button"><span class="text-red-600">Delete</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>


</x-admin-box>

<?= $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    //https://dev.to/mithicher/table-ui-with-tailwindcss-alpinejs-2i87
    // https://codepen.io/Salmi/pen/NWjvMRY
    //https://www.raymondcamden.com/2022/05/02/building-table-sorting-and-pagination-in-alpinejs
    function datatables() {
        return {
            headings: [{
                    key: "userId",
                    value: "User ID"
                },
                {
                    key: "firstName",
                    value: "Firstname"
                },
                {
                    key: "lastName",
                    value: "Lastname"
                },
                {
                    key: "emailAddress",
                    value: "Email"
                },
                {
                    key: "gender",
                    value: "Gender"
                },
                {
                    key: "phoneNumber",
                    value: "Phone"
                }
            ],
            users: [{
                    selected: false,
                    userId: 1,
                    firstName: "Cort",
                    lastName: "Tosh",
                    emailAddress: "ctosh0@github.com",
                    gender: "Male",
                    phoneNumber: "327-626-5542"
                },
                {
                    selected: false,
                    userId: 2,
                    firstName: "Brianne",
                    lastName: "Dzeniskevich",
                    emailAddress: "bdzeniskevich1@hostgator.com",
                    gender: "Female",
                    phoneNumber: "144-190-8956"
                },
                {
                    selected: false,
                    userId: 3,
                    firstName: "Isadore",
                    lastName: "Botler",
                    emailAddress: "ibotler2@gmpg.org",
                    gender: "Male",
                    phoneNumber: "350-937-0792"
                },
                {
                    selected: false,
                    userId: 4,
                    firstName: "Janaya",
                    lastName: "Klosges",
                    emailAddress: "jklosges3@amazon.de",
                    gender: "Female",
                    phoneNumber: "502-438-7799"
                },
                {
                    selected: false,
                    userId: 5,
                    firstName: "Freddi",
                    lastName: "Di Claudio",
                    emailAddress: "fdiclaudio4@phoca.cz",
                    gender: "Female",
                    phoneNumber: "265-448-9627"
                },
                {
                    selected: false,
                    userId: 6,
                    firstName: "Oliy",
                    lastName: "Mairs",
                    emailAddress: "omairs5@fda.gov",
                    gender: "Female",
                    phoneNumber: "221-516-2295"
                },
                {
                    selected: false,
                    userId: 7,
                    firstName: "Tabb",
                    lastName: "Wiseman",
                    emailAddress: "twiseman6@friendfeed.com",
                    gender: "Male",
                    phoneNumber: "171-817-5020"
                },
                {
                    selected: false,
                    userId: 8,
                    firstName: "Joela",
                    lastName: "Betteriss",
                    emailAddress: "jbetteriss7@msu.edu",
                    gender: "Female",
                    phoneNumber: "481-100-9345"
                },
                {
                    selected: false,
                    userId: 9,
                    firstName: "Alistair",
                    lastName: "Vasyagin",
                    emailAddress: "avasyagin8@gnu.org",
                    gender: "Male",
                    phoneNumber: "520-669-8364"
                },
                {
                    selected: false,
                    userId: 10,
                    firstName: "Nealon",
                    lastName: "Ratray",
                    emailAddress: "nratray9@typepad.com",
                    gender: "Male",
                    phoneNumber: "993-654-9793"
                },
                {
                    selected: false,
                    userId: 11,
                    firstName: "Annissa",
                    lastName: "Kissick",
                    emailAddress: "akissicka@deliciousdays.com",
                    gender: "Female",
                    phoneNumber: "283-425-2705"
                },
                {
                    selected: false,
                    userId: 12,
                    firstName: "Nissie",
                    lastName: "Sidnell",
                    emailAddress: "nsidnellb@freewebs.com",
                    gender: "Female",
                    phoneNumber: "754-391-3116"
                },
                {
                    selected: false,
                    userId: 13,
                    firstName: "Madalena",
                    lastName: "Fouch",
                    emailAddress: "mfouchc@mozilla.org",
                    gender: "Female",
                    phoneNumber: "584-300-9004"
                },
                {
                    selected: false,
                    userId: 14,
                    firstName: "Rozina",
                    lastName: "Atkins",
                    emailAddress: "ratkinsd@japanpost.jp",
                    gender: "Female",
                    phoneNumber: "792-856-0845"
                },
                {
                    selected: false,
                    userId: 15,
                    firstName: "Lorelle",
                    lastName: "Sandcroft",
                    emailAddress: "lsandcrofte@google.nl",
                    gender: "Female",
                    phoneNumber: "882-911-7241"
                }
            ],

            open: false,

            search: '',

            columns: [],

            get selectedUsers() {
                console.log('fdgsdgfsdgsd');
                return this.users.filter(
                    (user) => user.selected,
                    (user) => console.log(user.userId)
                );
            },

            init() {
                this.columns = this.headings.map((h) => {
                    return h.key;
                });
            },

            toggleColumn(key) {
                this.columns.includes(key) ?
                    (this.columns = this.columns.filter((i) => i !== key)) :
                    this.columns.push(key);
            },

            selectAllCheckbox() {
                let filteredUsers = this.filtered(this.users);
                if (filteredUsers.length === this.selectedUsers.length) {
                    return filteredUsers.map((user) => (user.selected = false));
                }
                filteredUsers.map((user) => (user.selected = true));
            },

            filtered(...items) {
                // Search filter Function for any Array of Objects !

                // You can pass only the Array of Objects, 
                // it will search all props of every Object except "ID"
                // Example : filtered(users)

                // OR you can pass additional props, it will only search passed props
                // Example : filtered(users, 'firstName', 'lastName','emailAddress', 'phoneNumber')

                values = items.shift(); // get the list of objects
                props = items.length ? items : null; // get list of props

                return values.filter((i) => {
                    y = Object.assign({}, i);
                    delete y['userId']; // Specifie the id prop to remove from object
                    if (props) {
                        okeys = Object.keys(y).filter((b) => !props.includes(b));
                        okeys.map((d) => delete y[d]);
                    }
                    itemToSearch = Object.values(y).join(); // Object to array, then join to String
                    return itemToSearch.toLowerCase().includes(this.search.toLowerCase()); // Return filtred Object
                });
            }
        };
    }
</script>
<?php $this->endSection() ?>