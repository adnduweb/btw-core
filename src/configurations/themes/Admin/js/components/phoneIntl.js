import intlTelInput from "intl-tel-input";

export function SetPhoneIntl(){
    const phoneintl = document.querySelectorAll(".phoneintl");
    const country = document.querySelector('[name="country"]');

    if (country) {
        // country.addEventListener("change", function(e) {
			$('.select2-country').on('select2:select', function (e) {
            console.info(country.value);
            // iti.destroy();

            if (phoneintl) {
                phoneintl.forEach(function(e) {
                    // iti.destroy();
                    var iti = intlTelInput(e, {
                        // separateDialCode: true,
                        initialCountry: country.value,
                        allowDropdown: false,
                        localizedCountries: country.value,
                        autoPlaceholder: "aggressive",
                        placeholderNumberType: "FIXED_LINE",
                        nationalMode: false,

                        // utilsScript: "/intl-tel-input/js/utils.js?1684676252775",
                        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
                    });

                    iti.setCountry(country.value);

                    e.addEventListener("countrychange", function() {
                        // do something with iti.getSelectedCountryData()
                        //  console.log(iti.getSelectedCountryData().iso2);
                        // iti.selectCountry(country.value);

                        var country = document.querySelector('[name="country"]');

                        if (country) {
                            // country.value = iti.getSelectedCountryData().iso2.toUpperCase();
                            country.value = iti.getSelectedCountryData().dialCode;
                            /// console.info(country.value);
                        }
                    });

                    e.addEventListener("open:countrydropdown", function() {
                        // triggered when the user opens the dropdown
                    });

                    e.addEventListener("close:countrydropdown", function() {
                        // triggered when the user closes the dropdown
                    });
                });
            }
        });
    }

    if (phoneintl) {
        phoneintl.forEach(function(e) {
            var iti = intlTelInput(e, {
                initialCountry: country.value ?? "US",
                // separateDialCode: true,
                allowDropdown: false,
                localizedCountries: country.value,
                autoPlaceholder: "aggressive",
                placeholderNumberType: "FIXED_LINE",
                nationalMode: false,

                // utilsScript: "/intl-tel-input/js/utils.js?1684676252775",
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
            });

            e.addEventListener("countrychange", function() {
                // do something with iti.getSelectedCountryData()
                //   console.log(iti.getSelectedCountryData().iso2);

                var country = document.querySelector('[name="country"]');

                if (country) {
                    country.value = iti.getSelectedCountryData().iso2.toUpperCase();
                    // console.info("fafa");
                    // console.info(country.value);
                }
            });

            e.addEventListener("open:countrydropdown", function() {
                // triggered when the user opens the dropdown
            });

            e.addEventListener("close:countrydropdown", function() {
                // triggered when the user closes the dropdown
            });
        });

        //   input.addEventListener('telchange', function(e) {
        //     console.log(e.detail.valid); // Boolean: Validation status of the number
        //     console.log(e.detail.validNumber); // Returns internationally formatted number if number is valid and empty string if invalid
        //     console.log(e.detail.number); // Returns the user entered number, maybe auto-formatted internationally
        //     console.log(e.detail.country); // Returns the phone country iso2
        //     console.log(e.detail.countryName); // Returns the phone country name
        //     console.log(e.detail.dialCode); // Returns the dial code
        // });
    }
}
