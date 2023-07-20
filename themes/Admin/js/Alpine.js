export const SettingAlpine = () => {
  //Prefix alpine special attributes to pass W3C validation
  // Alpine.prefix('data-x-')
  document.addEventListener("alpine:init", () => {
    Alpine.data("listen", () => ({
      confirmationModal: false,
      emitTo(link, action, attributes) {
        console.log(link);
        console.log(action);
        console.log(attributes);
        this.confirmationModal = true;
      },
    }));

    Alpine.store("config", {
      userIsAuthenticated: true,
    });

    Alpine.store("toasts", {
      counter: 0,
      list: [],
      createToast(message, type = "info") {
        const index = this.list.length;
        let totalVisible =
          this.list.filter((toast) => {
            return toast.visible;
          }).length + 1;
        this.list.push({
          id: this.counter++,
          message,
          type,
          visible: true,
        });
        setTimeout(() => {
          this.destroyToast(index);
        }, 4000 * totalVisible);
      },
      destroyToast(index) {
        this.list[index].visible = false;
      },
    });

    // Stores variable globally
    Alpine.store("sidebar", {
      full: false,
      active: "home",
      navOpen: false,
    });
    // Creating component Dropdown
    Alpine.data("dropdown", () => ({
      open: false,
      toggle(tab) {
        this.open = !this.open;
        Alpine.store("sidebar").active = tab;
      },
      activeClass: "bg-gray-800 text-gray-200",
      expandedClass: "border-l border-gray-400 ml-4 pl-4",
      shrinkedClass:
        "sm:absolute top-0 left-20 sm:shadow-md sm:z-10 sm:bg-gray-900 sm:rounded-md sm:p-4 border-l sm:border-none border-gray-400 ml-4 pl-4 sm:ml-0 w-28",
    }));
    // Creating component Sub Dropdown
    Alpine.data("sub_dropdown", () => ({
      sub_open: false,
      sub_toggle() {
        this.sub_open = !this.sub_open;
      },
      sub_expandedClass: "border-l border-gray-400 ml-4 pl-4",
      sub_shrinkedClass:
        "sm:absolute top-0 left-28 sm:shadow-md sm:z-10 sm:bg-gray-900 sm:rounded-md sm:p-4 border-l sm:border-none border-gray-400 ml-4 pl-4 sm:ml-0 w-28",
    }));
    // Creating tooltip
    Alpine.data("tooltip", () => ({
      show: false,
      visibleClass:
        "block sm:absolute -top-7 sm:border border-gray-800 left-5 sm:text-sm sm:bg-gray-900 sm:px-2 sm:py-1 sm:rounded-md",
    }));

    Alpine.data("noticesHandler", () => ({
      notices: [],
      visible: [],
      add(notice) {
        notice.id = Date.now();
        this.notices.push(notice);
        this.fire(notice.id);
      },
      fire(id) {
        this.visible.push(this.notices.find((notice) => notice.id == id));
        const timeShown = 4500 * this.visible.length;
        setTimeout(() => {
          this.remove(id);
        }, timeShown);
      },
      remove(id) {
        const notice = this.visible.find((notice) => notice.id == id);
        const index = this.visible.indexOf(notice);
        this.visible.splice(index, 1);
      },
      getIcon(notice) {
        if (notice.type == "success")
          return "<div class='text-green-500 rounded-full bg-white float-left ml-3'><svg width='1.8em' height='1.8em' viewBox='0 0 16 16' class='bi bi-check' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z'/></svg></div>";
        else if (notice.type == "info")
          return "<div class='text-blue-500 rounded-full bg-white float-left ml-3'><svg width='1.8em' height='1.8em' viewBox='0 0 16 16' class='bi bi-info' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path d='M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z'/><circle cx='8' cy='4.5' r='1'/></svg></div>";
        else if (notice.type == "warning")
          return "<div class='text-orange-500 rounded-full bg-white float-left ml-3'><svg width='1.8em' height='1.8em' viewBox='0 0 16 16' class='bi bi-exclamation' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path d='M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z'/></svg></div>";
        else if (notice.type == "error")
          return "<div class='text-red-500 rounded-full bg-white float-left ml-3'><svg width='1.8em' height='1.8em' viewBox='0 0 16 16' class='bi bi-x' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z'/><path fill-rule='evenodd' d='M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z'/></svg></div>";
      },
    }));
    Alpine.data("appGeneratePassword", () => ({
      showPasswordField: true,
      passwordScore: 0,
      new_password: "",
      pass_confirm: "",
      chars: {
        lower: "abcdefghijklmnopqrstuvwxyz",
        upper: "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
        numeric: "0123456789",
        symbols: "!\"#$%&'()*+,-./:;<=>?@[\\]^_`{|}~",
      },
      init() {
        console.log("changePassword loaded");
        this.generatePassword();
      },
      charsLength: 12,
      checkStrength: function () {
        if (!this.new_password) return (this.passwordScore = 0);
        this.passwordScore = zxcvbn(this.new_password).score + 1;
      },
      generatePassword: function () {
        console.log(document.getElementById("charsSymbols").checked);
        var _pass = this.shuffleArray(
          (
            (document.getElementById("charsLower").checked
              ? this.chars.lower
              : "") +
            (document.getElementById("charsUpper").checked
              ? this.chars.upper
              : "") +
            (document.getElementById("charsNumeric").checked
              ? this.chars.numeric
              : "") +
            (document.getElementById("charsSymbols").checked
              ? this.chars.symbols
              : "")
          ).split("")
        )
          .join("")
          .substring(0, this.charsLength);
        this.new_password = _pass;
        this.pass_confirm = _pass;
        this.checkStrength();
      },
      shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
          const j = Math.floor(Math.random() * (i + 1));
          [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
      },
    }));

    Alpine.data("initDatePickerRange", () => ({
      // value: ["02/01/2022", "02/05/2022"],

      init() {
        // moment.locale('fr');
        // console.log(moment().format('MMMM Do YYYY, h:mm:ss a')); // works fine in here only
        // console.log(moment());
        let todaylang = _LANG_.today;
        var yesterdaLang = _LANG_.yesterday;

        // console.log(todaylang);

        $(this.$refs.picker).daterangepicker(
          {
            autoUpdateInput: $(this).attr('data-kt-datatable-autoupdateinput') ?? false,
            // startDate: this.value[0],
            // endDate: this.value[1],
            locale: {
              applyLabel: _LANG_.appliquer,
              format: moment.localeData().longDateFormat("L"),
              cancelLabel: _LANG_.annuler,
              weekLabel: "W",
              customRangeLabel: _LANG_.custom,
              daysOfWeek: moment.weekdaysMin(),
              monthNames: moment.monthsShort(),
              firstDay: moment.localeData().firstDayOfWeek(),
            },

            ranges: {
              todaylang: [moment(), moment()],
              yesterdaLang: [
                moment().subtract(1, "days"),
                moment().subtract(1, "days"),
              ],
              "Last 7 Days": [moment().subtract(6, "days"), moment()],
              "Last 30 Days": [moment().subtract(29, "days"), moment()],
              "This Month": [
                moment().startOf("month"),
                moment().endOf("month"),
              ],
              "Last Month": [
                moment().subtract(1, "month").startOf("month"),
                moment().subtract(1, "month").endOf("month"),
              ],
            },
          }
          // (start, end) => {
          //   this.value[0] = start.format("DD/MM/YYYY");
          //   this.value[1] = end.format("DD/MM/YYYY");
          // }
        );

        // this.$watch("value", () => {
        //   $(this.$refs.picker)
        //     .data("daterangepicker")
        //     .setStartDate(this.value[0]);
        //   $(this.$refs.picker)
        //     .data("daterangepicker")
        //     .setEndDate(this.value[1]);
        // });
      },
    }));

    Alpine.data("select", (config) => ({
      data: config.data,
      emptyOptionsMessage:
        config.emptyOptionsMessage ?? "No results match your search.",
      focusedOptionIndex: null,
      name: config.name,
      open: true,
      options: {},
      placeholder: config.placeholder ?? "Select an option",
      search: "",
      value: config.value,

      closeListbox: function () {
        this.open = false;

        this.focusedOptionIndex = null;

        this.search = "";
      },

      focusNextOption: function () {
        if (this.focusedOptionIndex === null)
          return (this.focusedOptionIndex =
            Object.keys(this.options).length - 1);

        if (this.focusedOptionIndex + 1 >= Object.keys(this.options).length)
          return;

        this.focusedOptionIndex++;

        this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
          block: "center",
        });
      },

      focusPreviousOption: function () {
        if (this.focusedOptionIndex === null)
          return (this.focusedOptionIndex = 0);

        if (this.focusedOptionIndex <= 0) return;

        this.focusedOptionIndex--;

        this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
          block: "center",
        });
      },

      init: function () {
        this.options = this.data;

        if (!(this.value in this.options)) this.value = null;

        this.$watch("search", (value) => {
          if (!this.open || !value) return (this.options = this.data);

          this.options = Object.keys(this.data)
            .filter((key) =>
              this.data[key].toLowerCase().includes(value.toLowerCase())
            )
            .reduce((options, key) => {
              options[key] = this.data[key];
              return options;
            }, {});
        });
      },

      selectOption: function () {
        if (!this.open) return this.toggleListboxVisibility();

        this.value = Object.keys(this.options)[this.focusedOptionIndex];

        this.closeListbox();
      },

      toggleListboxVisibility: function () {
        if (this.open) return this.closeListbox();

        this.focusedOptionIndex = Object.keys(this.options).indexOf(this.value);

        if (this.focusedOptionIndex < 0) this.focusedOptionIndex = 0;

        this.open = true;

        this.$nextTick(() => {
          this.$refs.search.focus();

          this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
            block: "center",
          });
        });
      },
    }));
  });
};
export default SettingAlpine;

// Alpine.morph(el, newHtml, {
//     updating(el, toEl, childrenOnly, skip) {
//         //
//         console.log('updating');
//     },

//     updated(el, toEl) {
//         //
//         console.log('updated');
//     },

//     removing(el, skip) {
//         //
//     },

//     removed(el) {
//         //
//     },

//     adding(el, skip) {
//         //
//     },

//     added(el) {
//         //
//     },

//     key(el) {
//         // By default Alpine uses the `key=""` HTML attribute.
//         return el.id
//     },

//     lookahead: true, // Default: false
// })
