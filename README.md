# btw-core
module core Ci4

# Installation

composer create-project codeigniter4/appstarter my-app

    "minimum-stability": "dev",
    "prefer-stable": true

composer require adnduweb/btw-core:dev-develop

    php spark btw:install
    php spark vite:init
    npm install

# Installation Tailwind css
    npm install -D tailwindcss postcss autoprefixer
    npx tailwindcss init -p
    npm install flowbite && npm install tw-elements && npm install -D @tailwindcss/typography && npm install vite-plugin-live-reload 

# Installation Alpine js
    npm i alpinejs
    npm install @alpinejs/persist

# Installation Htmx js
    npm i htmx.org

# Modification du Chargement des fichiers
import liveReload from 'vite-plugin-live-reload'
liveReload([__dirname + '/**/*.php', __dirname + '/app/Modules/**/*.php'])

# Lancement de l'application
    php spark serve
    npm run dev


# Inspirations
https://demo.cartify.dev/admin/settings
https://www.patreon.com/lonnieezell/posts
https://demo.ticksify.com/agent/login
https://viewi.net/docs/integrations-code-igniter4