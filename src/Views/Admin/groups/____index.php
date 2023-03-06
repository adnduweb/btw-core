<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.login') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>


<x-page-head>Dashboard </x-page-head>
<x-admin-box>

    <div class="bg-gray-200 py-24 min-h-screen">
        <div class="container mx-auto w-full h-full">
            <div class="max-w-screen-lg mx-auto w-full h-full flex flex-col items-center justify-center">
                <div x-data="dataTable()" x-init="
        initData()
        $watch('searchInput', value => {
          search(value)
        })" class="bg-white p-5 shadow-md w-full flex flex-col">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2 items-center">
                            <p>Show</p>
                            <select x-model="view" @change="changeView()">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div x-show="selectedItems.length" class="relative shadow rounded-lg" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                            <div @click="open = ! open">
                                <button class="inline-flex items-center justify-center px-2 py-2 text-sm border border-transparent rounded-md font-medium focus:outline-none focus:ring disabled:opacity-25 disabled:cursor-not-allowed transition bg-blue-100 text-blue-700 hover:bg-blue-200 focus:border-blue-300 focus:ring-blue-200 active:bg-blue-300 sm:text-sm" type="button">
                                    <div x-html="selectedItems.length + ' rows are selected'" class="text-indigo-800 text-lg"></div>
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


                        <div>
                            <input x-model="searchInput" type="text" class="px-2 py-1 border rounded focus:outline-none" placeholder="Search...">
                        </div>
                    </div>
                    <table class="mt-5">
                        <thead class="border-b-2">

                            <th width="20%">
                                <div class="flex space-x-2">
                                    <span>

                                        <label class="text-indigo-500 inline-flex justify-between items-center hover:bg-gray-300 px-2 py-2 rounded-lg cursor-pointer">
                                            <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline" @click="selectAllCheckbox($event);">
                                        </label>
                                    </span>
                                </div>
                                </td>

                            <th width="20%">
                                <div class="flex space-x-2">
                                    <span>
                                        Name
                                    </span>
                                    <div class="flex flex-col">
                                        <svg @click="sort('name', 'asc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer text-gray-500 fill-current" x-bind:class="{'text-blue-500': sorted.field === 'name' && sorted.rule === 'asc'}">
                                            <path d="M5 15l7-7 7 7"></path>
                                        </svg>
                                        <svg @click="sort('name', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="h-3 w-3 cursor-pointer text-gray-500 fill-current" x-bind:class="{'text-blue-500': sorted.field === 'name' && sorted.rule === 'desc'}">
                                            <path d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th width="20%">
                                <div class="flex items-center space-x-2">
                                    <span class="">
                                        Job
                                    </span>
                                    <div class="flex flex-col">
                                        <svg @click="sort('job', 'asc')" fill="none" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-3 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'job' && sorted.rule === 'asc'}">
                                            <path d="M5 15l7-7 7 7"></path>
                                        </svg>
                                        <svg @click="sort('job', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-3 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'job' && sorted.rule === 'desc'}">
                                            <path d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th width="30%">
                                <div class="flex items-center space-x-2">
                                    <span class="">
                                        Email
                                    </span>
                                    <div class="flex flex-col">
                                        <svg @click="sort('email', 'asc')" fill="none" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-3 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'email' && sorted.rule === 'asc'}">
                                            <path d="M5 15l7-7 7 7"></path>
                                        </svg>
                                        <svg @click="sort('email', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-3 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'email' && sorted.rule === 'desc'}">
                                            <path d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th width="10%">
                                <div class="flex items-center space-x-2">
                                    <span>
                                        Year
                                    </span>
                                    <div class="flex flex-col">
                                        <svg @click="sort('year', 'asc')" fill="none" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-3 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'year' && sorted.rule === 'asc'}">
                                            <path d="M5 15l7-7 7 7"></path>
                                        </svg>
                                        <svg @click="sort('year', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-3 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'year' && sorted.rule === 'desc'}">
                                            <path d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th width="15%">
                                <div class="flex items-center space-x-2">
                                    <span class="">
                                        Country
                                    </span>
                                    <div class="flex flex-col">
                                        <svg @click="sort('country', 'asc')" fill="none" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-3 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'country' && sorted.rule === 'asc'}">
                                            <path d="M5 15l7-7 7 7"></path>
                                        </svg>
                                        <svg @click="sort('country', 'desc')" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-500 h-3 w-3 cursor-pointer fill-current" x-bind:class="{'text-blue-500': sorted.field === 'country' && sorted.rule === 'desc'}">
                                            <path d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </th>
                        </thead>
                        <tbody>
                            <template x-for="(item, index) in items" :key="index">
                                <tr x-show="checkView(index + 1)" class="hover:bg-gray-200 text-gray-900 text-xs">
                                    <td class="py-3">
                                        <label class="text-blue-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                            <input type="checkbox" x-model="item.selected" class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline" :name="item.year">
                                        </label>
                                    </td>
                                    <td class="py-3">
                                        <span x-text="item.name"></span>
                                    </td>
                                    <td class="py-3">
                                        <span x-text="item.job"></span>
                                    </td>
                                    <td class="py-3">
                                        <span x-text="item.email"></span>
                                    </td>
                                    <td class="py-3">
                                        <span x-text="item.year"></span>
                                    </td>
                                    <td class="py-3">
                                        <span x-text="item.country"></span>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="isEmpty()">
                                <td colspan="5" class="text-center py-3 text-gray-900 text-sm">No matching records found.</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex mt-5">
                        <div class="border px-2 cursor-pointer" @click.prevent="changePage(1)">
                            <span class="text-gray-700">First</span>
                        </div>
                        <div class="border px-2 cursor-pointer" @click="changePage(currentPage - 1)">
                            <span class="text-gray-700">
                                << /span>
                        </div>
                        <template x-for="item in pages">
                            <div @click="changePage(item)" class="border px-2 cursor-pointer" x-bind:class="{ 'bg-gray-300': currentPage === item }">
                                <span class="text-gray-700" x-text="item"></span>
                            </div>
                        </template>
                        <div class="border px-2 cursor-pointer" @click="changePage(currentPage + 1)">
                            <span class="text-gray-700">></span>
                        </div>
                        <div class="border px-2 cursor-pointer" @click.prevent="changePage(pagination.lastPage)">
                            <span class="text-gray-700">Last</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let data = [{
            "selected": false,
            "userId": 1,
            "name": "Brielle Kuphal",
            "email": "Brielle31@gmail.com",
            "job": "Global Metrics Developer",
            "country": "Tunisia",
            "year": 1969
        }, {
            "selected": false,
            "userId": 1,
            "name": "Barney Murray",
            "email": "Barney75@gmail.com",
            "job": "Product Solutions Executive",
            "country": "Haiti",
            "year": 1970
        }, {
            "selected": false,
            "userId": 1,
            "name": "Ressie Ruecker",
            "email": "Ressie.Ruecker30@gmail.com",
            "job": "Forward Factors Orchestrator",
            "country": "Georgia",
            "year": 1967
        }, {
            "selected": false,
            "userId": 1,
            "name": "Teresa Mertz",
            "email": "Teresa_Mertz@hotmail.com",
            "job": "Dynamic Division Director",
            "country": "Bahrain",
            "year": 1953
        }, {
            "selected": false,
            "userId": 1,
            "name": "Chelsey Hackett",
            "email": "Chelsey_Hackett@gmail.com",
            "job": "Senior Accountability Architect",
            "country": "Malta",
            "year": 1962
        }, {
            "selected": false,
            "userId": 1,
            "name": "Tatyana Metz",
            "email": "Tatyana_Metz91@gmail.com",
            "job": "Regional Metrics Coordinator",
            "country": "Sierra Leone",
            "year": 1983
        }, {
            "selected": false,
            "userId": 1,
            "name": "Oleta Harvey",
            "email": "Oleta_Harvey@yahoo.com",
            "job": "District Usability Producer",
            "country": "Swaziland",
            "year": 1963
        }, {
            "selected": false,
            "userId": 1,
            "name": "Bette Haag",
            "email": "Bette.Haag99@gmail.com",
            "job": "Dynamic Program Orchestrator",
            "country": "Guyana",
            "year": 1974
        }, {
            "selected": false,
            "userId": 1,
            "name": "Meda Ebert",
            "email": "Meda_Ebert8@yahoo.com",
            "job": "Product Division Orchestrator",
            "country": "Saint Kitts and Nevis",
            "year": 1954
        }, {
            "selected": false,
            "userId": 1,
            "name": "Elissa Stroman",
            "email": "Elissa.Stroman6@yahoo.com",
            "job": "Dynamic Applications Developer",
            "country": "Andorra",
            "year": 1978
        }, {
            "selected": false,
            "userId": 1,
            "name": "Sid Swaniawski",
            "email": "Sid_Swaniawski@hotmail.com",
            "job": "Forward Interactions Designer",
            "country": "Gibraltar",
            "year": 1979
        }, {
            "selected": false,
            "userId": 1,
            "name": "Madonna Hahn",
            "email": "Madonna10@gmail.com",
            "job": "Customer Configuration Specialist",
            "country": "Pakistan",
            "year": 1948
        }, {
            "selected": false,
            "userId": 1,
            "name": "Waylon Kihn",
            "email": "Waylon27@yahoo.com",
            "job": "National Security Facilitator",
            "country": "China",
            "year": 1958
        }, {
            "selected": false,
            "userId": 1,
            "name": "Jaunita Lindgren",
            "email": "Jaunita_Lindgren@yahoo.com",
            "job": "Senior Identity Consultant",
            "country": "Sweden",
            "year": 1958
        }, {
            "selected": false,
            "userId": 1,
            "name": "Lenora MacGyver",
            "email": "Lenora_MacGyver@yahoo.com",
            "job": "Corporate Factors Manager",
            "country": "Vietnam",
            "year": 1951
        }, {
            "selected": false,
            "userId": 1,
            "name": "Ole Collier",
            "email": "Ole51@hotmail.com",
            "job": "Corporate Factors Assistant",
            "country": "Cape Verde",
            "year": 1967
        }, {
            "selected": false,
            "userId": 1,
            "name": "Taurean Koelpin",
            "email": "Taurean.Koelpin@gmail.com",
            "job": "District Intranet Officer",
            "country": "Northern Mariana Islands",
            "year": 1980
        }, {
            "selected": false,
            "userId": 1,
            "name": "Thalia Yost",
            "email": "Thalia73@gmail.com",
            "job": "Dynamic Usability Director",
            "country": "French Southern Territories",
            "year": 1948
        }, {
            "selected": false,
            "userId": 1,
            "name": "Okey Kling",
            "email": "Okey84@gmail.com",
            "job": "District Metrics Manager",
            "country": "Poland",
            "year": 1953
        }, {
            "selected": false,
            "userId": 1,
            "name": "Darrick Ortiz",
            "email": "Darrick73@yahoo.com",
            "job": "Chief Metrics Agent",
            "country": "Tajikistan",
            "year": 1990
        }, {
            "selected": false,
            "userId": 1,
            "name": "Eulalia Vandervort",
            "email": "Eulalia.Vandervort63@gmail.com",
            "job": "Future Creative Manager",
            "country": "Spain",
            "year": 1990
        }, {
            "selected": false,
            "userId": 1,
            "name": "Genevieve Pouros",
            "email": "Genevieve29@hotmail.com",
            "job": "Investor Identity Facilitator",
            "country": "British Indian Ocean Territory (Chagos Archipelago)",
            "year": 1983
        }, {
            "selected": false,
            "userId": 1,
            "name": "Horacio Purdy",
            "email": "Horacio65@yahoo.com",
            "job": "Direct Accountability Producer",
            "country": "Slovakia (Slovak Republic)",
            "year": 1968
        }, {
            "selected": false,
            "userId": 1,
            "name": "Eleazar Konopelski",
            "email": "Eleazar_Konopelski@hotmail.com",
            "job": "National Usability Engineer",
            "country": "Cayman Islands",
            "year": 1954
        }, {
            "selected": false,
            "userId": 1,
            "name": "Herminia Effertz",
            "email": "Herminia.Effertz78@gmail.com",
            "job": "Central Usability Manager",
            "country": "Saudi Arabia",
            "year": 1954
        }, {
            "selected": false,
            "userId": 1,
            "name": "Brian Hermann",
            "email": "Brian12@hotmail.com",
            "job": "Central Optimization Coordinator",
            "country": "Papua New Guinea",
            "year": 1952
        }, {
            "selected": false,
            "userId": 1,
            "name": "Wellington Barrows",
            "email": "Wellington.Barrows@gmail.com",
            "job": "Customer Identity Engineer",
            "country": "Zimbabwe",
            "year": 1957
        }, {
            "selected": false,
            "userId": 1,
            "name": "David Rosenbaum",
            "email": "David75@hotmail.com",
            "job": "Global Research Administrator",
            "country": "Mayotte",
            "year": 1958
        }, {
            "selected": false,
            "userId": 1,
            "name": "Pinkie Reilly",
            "email": "Pinkie.Reilly67@gmail.com",
            "job": "Internal Data Director",
            "country": "Isle of Man",
            "year": 1973
        }, {
            "selected": false,
            "userId": 1,
            "name": "Asha Bartell",
            "email": "Asha82@gmail.com",
            "job": "Global Security Associate",
            "country": "Tonga",
            "year": 1991
        }, {
            "selected": false,
            "userId": 1,
            "name": "Alexane Bode",
            "email": "Alexane_Bode30@yahoo.com",
            "job": "Product Integration Planner",
            "country": "Honduras",
            "year": 1959
        }, {
            "selected": false,
            "userId": 1,
            "name": "Estelle Bode",
            "email": "Estelle_Bode@yahoo.com",
            "job": "Lead Marketing Producer",
            "country": "Dominica",
            "year": 1962
        }, {
            "selected": false,
            "userId": 1,
            "name": "Jeromy Mayer",
            "email": "Jeromy39@yahoo.com",
            "job": "Direct Accountability Director",
            "country": "Maldives",
            "year": 1973
        }, {
            "selected": false,
            "userId": 1,
            "name": "Ephraim Wiegand",
            "email": "Ephraim88@gmail.com",
            "job": "Direct Identity Administrator",
            "country": "Australia",
            "year": 1946
        }, {
            "selected": false,
            "userId": 1,
            "name": "Jarrett Grimes",
            "email": "Jarrett.Grimes99@gmail.com",
            "job": "International Web Strategist",
            "country": "Tunisia",
            "year": 1986
        }, {
            "selected": false,
            "userId": 1,
            "name": "Jeffry Macejkovic",
            "email": "Jeffry_Macejkovic40@hotmail.com",
            "job": "National Paradigm Specialist",
            "country": "Taiwan",
            "year": 1959
        }, {
            "selected": false,
            "userId": 1,
            "name": "Janelle Stroman",
            "email": "Janelle_Stroman@yahoo.com",
            "job": "National Accounts Engineer",
            "country": "Denmark",
            "year": 1974
        }, {
            "selected": false,
            "userId": 1,
            "name": "Camille Considine",
            "email": "Camille79@gmail.com",
            "job": "Central Solutions Planner",
            "country": "Chile",
            "year": 1975
        }, {
            "selected": false,
            "userId": 1,
            "name": "Amani Schinner",
            "email": "Amani.Schinner@yahoo.com",
            "job": "Corporate Metrics Manager",
            "country": "Sri Lanka",
            "year": 1981
        }, {
            "selected": false,
            "userId": 1,
            "name": "Dustin Bahringer",
            "email": "Dustin76@hotmail.com",
            "job": "Regional Research Designer",
            "country": "Russian Federation",
            "year": 1988
        }, {
            "selected": false,
            "userId": 1,
            "name": "Mary Sanford",
            "email": "Mary44@yahoo.com",
            "job": "Chief Applications Consultant",
            "country": "Isle of Man",
            "year": 1959
        }, {
            "selected": false,
            "userId": 1,
            "name": "Itzel Skiles",
            "email": "Itzel32@gmail.com",
            "job": "Dynamic Factors Strategist",
            "country": "Western Sahara",
            "year": 1981
        }, {
            "selected": false,
            "userId": 1,
            "name": "Melyssa Denesik",
            "email": "Melyssa_Denesik@hotmail.com",
            "job": "Customer Security Consultant",
            "country": "Libyan Arab Jamahiriya",
            "year": 1960
        }, {
            "selected": false,
            "userId": 1,
            "name": "Elenora McLaughlin",
            "email": "Elenora_McLaughlin@yahoo.com",
            "job": "Legacy Paradigm Engineer",
            "country": "Swaziland",
            "year": 1954
        }, {
            "selected": false,
            "userId": 1,
            "name": "Chet Lueilwitz",
            "email": "Chet_Lueilwitz98@yahoo.com",
            "job": "Chief Implementation Producer",
            "country": "Togo",
            "year": 1947
        }, {
            "selected": false,
            "userId": 1,
            "name": "Adrian Ondricka",
            "email": "Adrian.Ondricka@hotmail.com",
            "job": "National Optimization Orchestrator",
            "country": "Monaco",
            "year": 1991
        }, {
            "selected": false,
            "userId": 1,
            "name": "Quincy West",
            "email": "Quincy.West@yahoo.com",
            "job": "Regional Paradigm Developer",
            "country": "Qatar",
            "year": 1979
        }, {
            "selected": false,
            "userId": 1,
            "name": "Bernardo Krajcik",
            "email": "Bernardo_Krajcik81@hotmail.com",
            "job": "Lead Intranet Architect",
            "country": "Japan",
            "year": 1959
        }, {
            "selected": false,
            "userId": 1,
            "name": "Aiyana Kshlerin",
            "email": "Aiyana64@hotmail.com",
            "job": "Forward Optimization Orchestrator",
            "country": "Netherlands",
            "year": 1971
        }, {
            "selected": false,
            "userId": 1,
            "name": "Ambrose Anderson",
            "email": "Ambrose32@yahoo.com",
            "job": "Central Solutions Executive",
            "country": "Moldova",
            "year": 1986
        }, {
            "selected": false,
            "userId": 1,
            "name": "Cassandre Volkman",
            "email": "Cassandre.Volkman@yahoo.com",
            "job": "Lead Quality Director",
            "country": "Israel",
            "year": 1975
        }, {
            "selected": false,
            "userId": 1,
            "name": "Vivien Hettinger",
            "email": "Vivien50@yahoo.com",
            "job": "Investor Assurance Producer",
            "country": "Suriname",
            "year": 1992
        }, {
            "selected": false,
            "userId": 1,
            "name": "Dejuan Auer",
            "email": "Dejuan92@gmail.com",
            "job": "Principal Functionality Architect",
            "country": "Venezuela",
            "year": 1949
        }, {
            "selected": false,
            "userId": 1,
            "name": "Freddy Wunsch",
            "email": "Freddy1@hotmail.com",
            "job": "Direct Usability Designer",
            "country": "Guinea-Bissau",
            "year": 1951
        }, {
            "selected": false,
            "userId": 1,
            "name": "Ole Will",
            "email": "Ole_Will@gmail.com",
            "job": "Future Operations Director",
            "country": "Greece",
            "year": 1969
        }, {
            "selected": false,
            "userId": 1,
            "name": "Margie Kreiger",
            "email": "Margie_Kreiger@gmail.com",
            "job": "Corporate Paradigm Analyst",
            "country": "India",
            "year": 1943
        }, {
            "selected": false,
            "userId": 1,
            "name": "Adrianna Heller",
            "email": "Adrianna.Heller23@yahoo.com",
            "job": "Future Directives Developer",
            "country": "Democratic People's Republic of Korea",
            "year": 1962
        }, {
            "selected": false,
            "userId": 1,
            "name": "Helena Wuckert",
            "email": "Helena.Wuckert34@hotmail.com",
            "job": "Dynamic Metrics Executive",
            "country": "Palestinian Territory",
            "year": 1962
        }, {
            "selected": false,
            "userId": 1,
            "name": "Boyd Bruen",
            "email": "Boyd22@gmail.com",
            "job": "Future Division Assistant",
            "country": "United States Minor Outlying Islands",
            "year": 1947
        }, {
            "selected": false,
            "userId": 1,
            "name": "Herbert Gutkowski",
            "email": "Herbert_Gutkowski@gmail.com",
            "job": "Chief Mobility Specialist",
            "country": "Lebanon",
            "year": 1954
        }, {
            "selected": false,
            "userId": 1,
            "name": "Jodie Jakubowski",
            "email": "Jodie11@yahoo.com",
            "job": "Forward Assurance Analyst",
            "country": "India",
            "year": 1956
        }, {
            "selected": false,
            "userId": 1,
            "name": "Kathleen Mohr",
            "email": "Kathleen.Mohr98@hotmail.com",
            "job": "Senior Configuration Developer",
            "country": "Singapore",
            "year": 1946
        }, {
            "selected": false,
            "userId": 1,
            "name": "Spencer Zieme",
            "email": "Spencer.Zieme@yahoo.com",
            "job": "Corporate Web Assistant",
            "country": "Martinique",
            "year": 1957
        }, {
            "selected": false,
            "userId": 1,
            "name": "Marge Abshire",
            "email": "Marge_Abshire40@hotmail.com",
            "job": "Senior Applications Planner",
            "country": "Albania",
            "year": 1982
        }, {
            "selected": false,
            "userId": 1,
            "name": "Kamron Muller",
            "email": "Kamron3@yahoo.com",
            "job": "Customer Response Strategist",
            "country": "Dominican Republic",
            "year": 1969
        }, {
            "selected": false,
            "userId": 1,
            "name": "Betsy Wiegand",
            "email": "Betsy.Wiegand@gmail.com",
            "job": "Regional Implementation Assistant",
            "country": "Finland",
            "year": 1985
        }, {
            "selected": false,
            "userId": 1,
            "name": "Tressa Hettinger",
            "email": "Tressa.Hettinger@hotmail.com",
            "job": "Lead Mobility Representative",
            "country": "Montenegro",
            "year": 1986
        }, {
            "selected": false,
            "userId": 1,
            "name": "Bella Kunze",
            "email": "Bella.Kunze@hotmail.com",
            "job": "District Branding Designer",
            "country": "Syrian Arab Republic",
            "year": 1975
        }, {
            "selected": false,
            "userId": 1,
            "name": "Bradford Quitzon",
            "email": "Bradford3@yahoo.com",
            "job": "Chief Solutions Facilitator",
            "country": "Vanuatu",
            "year": 1992
        }, {
            "selected": false,
            "userId": 1,
            "name": "Adrien Gerhold",
            "email": "Adrien73@yahoo.com",
            "job": "Dynamic Infrastructure Supervisor",
            "country": "Australia",
            "year": 1978
        }, {
            "selected": false,
            "userId": 1,
            "name": "Micheal Walter",
            "email": "Micheal.Walter62@gmail.com",
            "job": "Regional Communications Coordinator",
            "country": "Saint Kitts and Nevis",
            "year": 1992
        }, {
            "selected": false,
            "userId": 1,
            "name": "Alberto Glover",
            "email": "Alberto14@hotmail.com",
            "job": "Product Web Liaison",
            "country": "Saint Lucia",
            "year": 1962
        }, {
            "selected": false,
            "userId": 1,
            "name": "Quinn Stark",
            "email": "Quinn.Stark46@hotmail.com",
            "job": "District Markets Analyst",
            "country": "Kyrgyz Republic",
            "year": 1977
        }, {
            "selected": false,
            "userId": 1,
            "name": "Carey Lemke",
            "email": "Carey32@gmail.com",
            "job": "Corporate Tactics Director",
            "country": "Vanuatu",
            "year": 1944
        }, {
            "selected": false,
            "userId": 1,
            "name": "Meggie OConnell",
            "email": "Meggie90@gmail.com",
            "job": "Direct Usability Officer",
            "country": "Thailand",
            "year": 1978
        }, {
            "selected": false,
            "userId": 1,
            "name": "Deven Stark",
            "email": "Deven_Stark@hotmail.com",
            "job": "Senior Tactics Facilitator",
            "country": "Serbia",
            "year": 1991
        }, {
            "selected": false,
            "userId": 1,
            "name": "Clare Hickle",
            "email": "Clare59@gmail.com",
            "job": "Global Configuration Planner",
            "country": "Kenya",
            "year": 1985
        }, {
            "selected": false,
            "userId": 1,
            "name": "Kendall DAmore",
            "email": "Kendall77@yahoo.com",
            "job": "Corporate Metrics Consultant",
            "country": "Czech Republic",
            "year": 1962
        }, {
            "selected": false,
            "userId": 1,
            "name": "Keeley Gleichner",
            "email": "Keeley_Gleichner@yahoo.com",
            "job": "Direct Intranet Officer",
            "country": "Moldova",
            "year": 1965
        }, {
            "selected": false,
            "userId": 1,
            "name": "Nikita Fahey",
            "email": "Nikita_Fahey@gmail.com",
            "job": "Investor Infrastructure Analyst",
            "country": "Vanuatu",
            "year": 1972
        }, {
            "selected": false,
            "userId": 1,
            "name": "Kassandra Kuvalis",
            "email": "Kassandra1@yahoo.com",
            "job": "Legacy Mobility Facilitator",
            "country": "Ireland",
            "year": 1972
        }, {
            "selected": false,
            "userId": 1,
            "name": "Melody Connelly",
            "email": "Melody16@yahoo.com",
            "job": "Global Implementation Agent",
            "country": "Australia",
            "year": 1978
        }, {
            "selected": false,
            "userId": 1,
            "name": "Augusta Huel",
            "email": "Augusta.Huel90@hotmail.com",
            "job": "Human Configuration Planner",
            "country": "United Kingdom",
            "year": 1982
        }, {
            "selected": false,
            "userId": 1,
            "name": "Edwin Willms",
            "email": "Edwin30@yahoo.com",
            "job": "Global Creative Facilitator",
            "country": "Greenland",
            "year": 1949
        }, {
            "selected": false,
            "userId": 1,
            "name": "Lila Glover",
            "email": "Lila.Glover@gmail.com",
            "job": "Senior Intranet Supervisor",
            "country": "Angola",
            "year": 1944
        }, {
            "selected": false,
            "userId": 1,
            "name": "Kelley Price",
            "email": "Kelley.Price@hotmail.com",
            "job": "District Brand Supervisor",
            "country": "Benin",
            "year": 1942
        }, {
            "selected": false,
            "userId": 1,
            "name": "Ernestine Skiles",
            "email": "Ernestine92@gmail.com",
            "job": "Chief Directives Planner",
            "country": "Kenya",
            "year": 1963
        }, {
            "selected": false,
            "userId": 1,
            "name": "Jaylan Yundt",
            "email": "Jaylan_Yundt@gmail.com",
            "job": "Dynamic Paradigm Designer",
            "country": "Sweden",
            "year": 1972
        }, {
            "selected": false,
            "userId": 1,
            "name": "Claudie Heidenreich",
            "email": "Claudie.Heidenreich20@yahoo.com",
            "job": "Regional Implementation Director",
            "country": "Angola",
            "year": 1990
        }, {
            "selected": false,
            "userId": 1,
            "name": "Vernice Mann",
            "email": "Vernice61@yahoo.com",
            "job": "Investor Functionality Officer",
            "country": "Micronesia",
            "year": 1959
        }, {
            "selected": false,
            "userId": 1,
            "name": "Isabella Christiansen",
            "email": "Isabella_Christiansen56@hotmail.com",
            "job": "Corporate Usability Architect",
            "country": "Thailand",
            "year": 1973
        }, {
            "selected": false,
            "userId": 1,
            "name": "Ronny Dietrich",
            "email": "Ronny.Dietrich@hotmail.com",
            "job": "Investor Metrics Administrator",
            "country": "Congo",
            "year": 1985
        }, {
            "selected": false,
            "userId": 1,
            "name": "Trey Ritchie",
            "email": "Trey.Ritchie0@gmail.com",
            "job": "Forward Mobility Officer",
            "country": "Azerbaijan",
            "year": 1988
        }, {
            "selected": false,
            "userId": 1,
            "name": "Jarvis Bauch",
            "email": "Jarvis77@gmail.com",
            "job": "Investor Group Administrator",
            "country": "Egypt",
            "year": 1991
        }, {
            "selected": false,
            "userId": 1,
            "name": "Alanis Torp",
            "email": "Alanis61@hotmail.com",
            "job": "Dynamic Intranet Administrator",
            "country": "Tokelau",
            "year": 1966
        }, {
            "selected": false,
            "userId": 1,
            "name": "Rogers Stanton",
            "email": "Rogers_Stanton20@gmail.com",
            "job": "Internal Program Consultant",
            "country": "Cook Islands",
            "year": 1953
        }, {
            "selected": false,
            "userId": 1,
            "name": "Logan Kiehn",
            "email": "Logan68@hotmail.com",
            "job": "Legacy Interactions Designer",
            "country": "Latvia",
            "year": 1956
        }, {
            "selected": false,
            "userId": 1,
            "name": "Katelynn Reichert",
            "email": "Katelynn.Reichert38@gmail.com",
            "job": "Customer Brand Designer",
            "country": "Chad",
            "year": 1972
        }, {
            "selected": false,
            "userId": 1,
            "name": "Ibrahim Stroman",
            "email": "Ibrahim_Stroman@hotmail.com",
            "job": "Direct Marketing Planner",
            "country": "Qatar",
            "year": 1984
        }, {
            "selected": false,
            "userId": 1,
            "name": "Edyth McCullough",
            "email": "Edyth_McCullough12@hotmail.com",
            "job": "Human Integration Manager",
            "country": "Turks and Caicos Islands",
            "year": 1992
        }]
    </script>
    </body>

</x-admin-box>

<?= $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    window.dataTable = function() {
        return {
            items: [],
            view: 5,
            searchInput: '',
            pages: [],
            offset: 5,
            pagination: {
                total: data.length,
                lastPage: Math.ceil(data.length / 5),
                perPage: 5,
                currentPage: 1,
                from: 1,
                to: 1 * 5
            },
            currentPage: 1,
            sorted: {
                field: 'name',
                rule: 'asc'
            },
            search: '',
            initData() {
                this.items = data.sort(this.compareOnKey('name', 'asc'))
                this.showPages()
            },
            compareOnKey(key, rule) {
                return function(a, b) {
                    if (key === 'name' || key === 'job' || key === 'email' || key === 'country') {
                        let comparison = 0
                        const fieldA = a[key].toUpperCase()
                        const fieldB = b[key].toUpperCase()
                        if (rule === 'asc') {
                            if (fieldA > fieldB) {
                                comparison = 1;
                            } else if (fieldA < fieldB) {
                                comparison = -1;
                            }
                        } else {
                            if (fieldA < fieldB) {
                                comparison = 1;
                            } else if (fieldA > fieldB) {
                                comparison = -1;
                            }
                        }
                        return comparison
                    } else {
                        if (rule === 'asc') {
                            return a.year - b.year
                        } else {
                            return b.year - a.year
                        }
                    }
                }
            },
            checkView(index) {
                return index > this.pagination.to || index < this.pagination.from ? false : true
            },
            checkPage(item) {
                if (item <= this.currentPage + 5) {
                    return true
                }
                return false
            },
            // search(value) {
            //     if (value.length > 1) {
            //         const options = {
            //             shouldSort: true,
            //             keys: ['name', 'job'],
            //             threshold: 0
            //         }
            //         const fuse = new Fuse(data, options)
            //         this.items = fuse.search(value).map(elem => elem.item)
            //     } else {
            //         this.items = data
            //     }
            //     // console.log(this.items.length)

            //     this.changePage(1)
            //     this.showPages()
            // },
            sort(field, rule) {
                this.items = this.items.sort(this.compareOnKey(field, rule))
                this.sorted.field = field
                this.sorted.rule = rule
            },
            changePage(page) {
                if (page >= 1 && page <= this.pagination.lastPage) {
                    this.currentPage = page
                    const total = this.items.length
                    const lastPage = Math.ceil(total / this.view) || 1
                    const from = (page - 1) * this.view + 1
                    let to = page * this.view
                    if (page === lastPage) {
                        to = total
                    }
                    this.pagination.total = total
                    this.pagination.lastPage = lastPage
                    this.pagination.perPage = this.view
                    this.pagination.currentPage = page
                    this.pagination.from = from
                    this.pagination.to = to
                    this.showPages()
                }
            },
            showPages() {
                const pages = []
                let from = this.pagination.currentPage - Math.ceil(this.offset / 2)
                if (from < 1) {
                    from = 1
                }
                let to = from + this.offset - 1
                if (to > this.pagination.lastPage) {
                    to = this.pagination.lastPage
                }
                while (from <= to) {
                    pages.push(from)
                    from++
                }
                this.pages = pages
            },
            changeView() {
                this.changePage(1)
                this.showPages()
            },
            isEmpty() {
                return this.pagination.total ? false : true
            },
            get selectedItems() {
                console.log(this.items);
                return this.items.filter(
                    (item) => item.selected,
                    (item) => console.log(item.itemId)
                );
            },
            selectAllCheckbox() {
                let filteredItems = this.filtered(this.items);
                if (filteredItems.length === this.selectedItems.length) {
                    return filteredItems.map((item) => (item.selected = false));
                }
                filteredItems.map((item) => (item.selected = true));
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
                    delete y['year']; // Specifie the id prop to remove from object
                    if (props) {
                        okeys = Object.keys(y).filter((b) => !props.includes(b));
                        okeys.map((d) => delete y[d]);
                    }
                    itemToSearch = Object.values(y).join(); // Object to array, then join to String
                    return itemToSearch.toLowerCase().includes(this.search.toLowerCase()); // Return filtred Object
                });
            }
        }
    }
</script>
<?php $this->endSection() ?>