//This is you main entry file, Be creative =)

import "../css/app.css"

import "../js/alpine.js"
import "../js/Htmx.js"



/**
 * Select All checkbox for data tables
 * using plain javascript
 */
function toggleSelectAll(checkbox) {
    var table = checkbox.closest('table')
    var checkboxes = table.getElementsByTagName('input')

    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].type == 'checkbox') {
            checkboxes[i].checked = checkbox.checked
        }
    }
}

if (document.querySelector('.select-all')) {
    document.querySelector('.select-all').addEventListener('click', function (e) {
        toggleSelectAll(e.target)
    })
}



// this function does run, due to HTMX's HX-Trigger-After-Swap header
// but cannot change the showDelete paramter above
document.body.addEventListener('deleteConfirmed', function (evt) {
    console.log(evt);
    document.getElementById('recordSelector').dispatchEvent(new CustomEvent('deleteOK'));
    // Alpine.data('showDelete', () => {showDelete = true});
})
