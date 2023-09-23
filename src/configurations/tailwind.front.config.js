// Set flag to include Preflight conditionally based on the build target.
//const includePreflight = ('editor' === process.env._TW_TARGET) ? false : true;

module.exports = {
    darkMode: 'class',
    presets: [
        // Manage Tailwind Typography's configuration in a separate file.
        //require('./tailwind-typography.config.js'),
    ],

    corePlugins: {
        //container: false
    },

    content: [
        // https://tailwindcss.com/docs/content-configuration
        './*.php',
        './inc/*.php',
        './template-parts/*/*.php',
        './template-parts/*/*/*.php',
        './theme.json',
        './node_modules/tw-elements/dist/js/**/*.js',
        "./node_modules/flowbite/**/*.js"
        //'./**/*.php', // recursive search for *.php (be aware on every file change it will go even through /node_modules which can be slow, read doc)
    ],
    safelist: [
        'text-center'
        //{
        //  pattern: /text-(white|black)-(200|500|800)/
        //}
    ],
    theme: {
        container: {

            center: true,

            padding: {
                DEFAULT: '1rem',
                sm: '2rem',
                lg: '2rem',
                xl: '2rem',
                xl2: '2rem',
            },
        },
        screens: {
            //         'sm': '480px',
            //   'md': '768px',
            //   'lg': '976px',
            //   'xl': '1440px',
            'xxs': '100%',
            'xs': '480px',
            'sm': '640px',// portrait
            'md': '960px',
            'lg': '1024px', // TABLETTE
            'xl': '1280px',
            '2xl': '1600px',
            '3xl': '1980px'
        },
        fontSize: {
            'sm': '0.8rem',
            'xs': ['0.9rem', '1.1rem'], //22px
            'xst': ['1.08rem', '1.3rem'], //22px // Témoignages
            'base': '1.2rem',
            
            'xl': ['1.375rem', '1.7rem'], //22px
            '2xl': ['1.563rem', '2.0rem'],
            '3xl': ['1.875rem', '2.2rem'], //30px
            '4xl': ['2.5rem', '2.8rem'], //40px
            '5xl': ['3.125rem', '3.3rem'], //50px
            '6xl': ['4.375rem', '5rem'], //70px
            '7xl': ['7.1rem', '6.2rem'],
            '8xl': ['11.25rem', '6.2rem']
        },
        backgroundSize: {
            'auto': 'auto',
            'cover': 'cover',
            'contain': 'contain',
            '50%': '50%',
            '20%': '20%',
            '16': '4rem',
        },
        // Extend the default Tailwind theme.
        extend: {

            fontFamily: {
                'roboto': ['Roboto', 'sans-serif'],
            },
            minHeight: {
                '128': '32rem',
            },
            keyframes: {
                wiggle: {
                    '0%, 100%': { transform: 'rotate(-15deg)' },
                    '50%': { transform: 'rotate(15deg)' }
                },
                swing: {
                    '20%': {
                        transform: 'rotate3d(0, 0, 1, 15deg)',
                    },

                    '40%': {
                        transform: 'rotate3d(0, 0, 1, -10deg)',
                    },

                    '60%': {
                        transform: 'rotate3d(0, 0, 1, 5deg)',
                    },

                    '80%': {
                        transform: 'rotate3d(0, 0, 1, -5deg)',
                    },
                    to: {
                        transform: 'rotate3d(0, 0, 1, 0deg)',
                    },
                },
            },
            animation: {
                'spin-slow': 'spin 3s linear infinite',
                'wiggle': 'wiggle 1s ease-in-out infinite',
                'swing': 'swing 2s ease-out infinite',
            }
            //https://play.tailwindcss.com/IU44IlYAxk

        },
    },
    // corePlugins: {
    //     // Disable Preflight base styles in CSS targeting the editor.
    //     preflight: includePreflight,
    // },
    plugins: [

        require('flowbite/plugin'),

        require('tw-elements/dist/plugin'),

        // Add Tailwind Typography.
        require('@tailwindcss/typography'),

    ],
    daisyui: {
        themes: ["light", "dark", "cupcake"],
      },
}