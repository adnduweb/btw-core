export const initDatatable = () => {

	var defaults = {
		language: {
			info: _LANG_.Showing +
				" _START_ " +
				_LANG_.to +
				" _END_ " +
				_LANG_.of +
				" _TOTAL_ ",
			infoEmpty: _LANG_.ShowingNoRecords,
			emptyTable: _LANG_.NoDataAvailableInTable,
			lengthMenu: "_MENU_",
			paginate: {
				first: '<i class="first"></i>',
				last: '<i class="last"></i>',
				next: '<i class="next"></i>',
				previous: '<i class="previous"></i>',
			},
			zeroRecords: _LANG_.sZeroRecords,
			infoFiltered: "(Affichage de _MAX_ ligne(s))",
		},
	};
	$.extend(true, $.fn.dataTable.defaults, defaults);

	var DataTable = $.fn.dataTable;

	/* Set the defaults for DataTables initialisation */
	$.extend(true, DataTable.defaults, {
		dom: "<'table-responsive'tr>" +
			"<'flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0'" +
			"<'text-sm font-normal text-gray-500 dark:text-gray-400 flex flex-row items-center justify-between'li>" +
			"<'inline-flex items-stretch -space-x-px'p>" +
			">",

		renderer: "bootstrap",
	});

	/* Default class modification */
	$.extend(DataTable.ext.classes, {
		sWrapper: "dataTables_wrapper dt-tailwindcss",
		sFilterInput: "form-control form-control-sm form-control-solid",
		sLengthSelect: "form-select form-select-sm form-select-solid",
		sProcessing: "dataTables_processing card",
		sPageButton: "paginate_button page-item",
	});

	/* Bootstrap paging button renderer */
	DataTable.ext.renderer.pageButton.bootstrap = function(
		settings,
		host,
		idx,
		buttons,
		page,
		pages
	) {
		var api = new DataTable.Api(settings);
		var classes = settings.oClasses;
		var lang = settings.oLanguage.oPaginate;
		var aria = settings.oLanguage.oAria.paginate || {};
		var btnDisplay,
			btnClass,
			counter = 0;

		var attach = function(container, buttons) {
			var i, ien, node, button;
			var clickHandler = function(e) {
				e.preventDefault();
				if (
					!$(e.currentTarget).hasClass("disabled") &&
					api.page() != e.data.action
				) {
					api.page(e.data.action).draw("page");
				}
			};

			for (i = 0, ien = buttons.length; i < ien; i++) {
				button = buttons[i];

				if (Array.isArray(button)) {
					attach(container, button);
				} else {
					btnDisplay = "";
					btnClass = "";

					switch (button) {
						case "ellipsis":
							btnDisplay = "&#x2026;";
							btnClass = "disabled";
							break;

						case "first":
							btnDisplay = lang.sFirst;
							btnClass = button + (page > 0 ? "" : " disabled");
							break;

						case "previous":
							btnDisplay = lang.sPrevious;
							btnClass = button + (page > 0 ? "" : " disabled");
							break;

						case "next":
							btnDisplay = lang.sNext;
							btnClass = button + (page < pages - 1 ? "" : " disabled");
							break;

						case "last":
							btnDisplay = lang.sLast;
							btnClass = button + (page < pages - 1 ? "" : " disabled");
							break;

						default:
							btnDisplay = button + 1;
							btnClass = page === button ? "active" : "";
							break;
					}

					if (btnDisplay) {
						node = $("<li>", {
								class: classes.sPageButton + " " + btnClass,
								id: idx === 0 && typeof button === "string" ?
									settings.sTableId + "_" + button : null,
							})
							.append(
								$("<a>", {
									href: "#",
									"aria-controls": settings.sTableId,
									"aria-label": aria[button],
									"data-dt-idx": counter,
									tabindex: settings.iTabIndex,
									class: "page-link",
								}).html(btnDisplay)
							)
							.appendTo(container);

						settings.oApi._fnBindAction(
							node, {
								action: button,
							},
							clickHandler
						);

						counter++;
					}
				}
			}
		};

		// // console.log(api);
		// // console.log(api.rows(':nth-child(even)').nodes());
		// // console.log(settings);
		// // console.log(settings.sInstance)

		// let sInstance = document.querySelector("#" + settings.sInstance);
		// // console.log(sInstance);

		// // List checkbox all click 
		// const allCheck = sInstance.querySelector('.allCheck');
		// if(allCheck){
		//     allCheck.addEventListener('click', function() {
		//         if (allCheck.checked) {
		//             const checkboxes = sInstance.querySelectorAll('tbody .selection [type="checkbox"]');
		//             checkboxes.forEach(c => {
		//                 c.closest('tr').classList.add('selected');
		//             });
		//         } else {
		//             const checkboxes = sInstance.querySelectorAll('tbody .selection [type="checkbox"]');
		//             checkboxes.forEach(c => {
		//                 c.closest('tr').classList.remove('selected');
		//             });
		//         }
		//     });
		// }
		// toggleToolbars();
		// const checkboxes = sInstance.querySelectorAll('tbody .selection [type="checkbox"]');
		// //console.log(checkboxes);
		// if(checkboxes){

		//     //  // Select elements
		//     //  toolbarBase = document.querySelector('[data-kt-datatable-toolbar="base"]');
		//     //  toolbarSelected = document.querySelector('[data-kt-datatable-toolbar="selected"]');
		//     //  rowSelected = document.querySelector('[data-kt-datatable-row="selected"]');
		//     //  selectedCount = document.querySelector('[data-kt-datatable-select="selected_count"]');

		//     checkboxes.forEach(c => {
		//         // Checkbox on click event
		//         c.addEventListener('click', function() {
		//             console.log('initToggleToolbarssss');
		//             setTimeout(function() {
		//                 toggleToolbars();
		//             }, 50);
		//         });
		//     });
		// }

		// // Toggle toolbars
		// var toggleToolbars = () => {

		//     console.log('jy suis');

		//     // Select refreshed checkbox DOM elements 
		//     const allCheckboxes = sInstance.querySelectorAll('tbody .selection [type="checkbox"]');

		//     // Detect checkboxes state & count
		//     let checkedState = false;
		//     let count = 0;

		//     // Count checked boxes
		//     //console.log(allCheckboxes);
		//     allCheckboxes.forEach(c => {
		//         if (c.checked) {
		//             checkedState = true;
		//             count++;
		//         }
		//     });

		//     // Toggle toolbars
		//     if (checkedState) {
		//         selectedCount.innerHTML = count;
		//         toolbarBase.classList.add('hidden');
		//         toolbarSelected.classList.remove('hidden');
		//         rowSelected.classList.remove('hidden');

		//         var firstRow = sInstance.rows[0];
		//         firstRow.parentNode.insertBefore(rowSelected, firstRow.rows);

		//     } else {
		//         sInstance.querySelector('.allCheck').checked = false;
		//         toolbarBase.classList.remove('hidden');
		//         toolbarSelected.classList.add('hidden');
		//         rowSelected.classList.add('hidden');
		//     }

		//     // Select filter options
		//     const groupCheckable = sInstance.querySelectorAll('.group-checkable');
		//     var score = 1;
		//     // console.log(selectedCount.innerHTML);
		//     groupCheckable.forEach(c => {
		//         c.addEventListener('click', function() {
		//             var countNew = countSelected();
		//             if (c.closest('tr').classList.contains('selected')) {
		//                 console.log(c.closest('tr'));
		//                 c.closest('tr').classList.remove('selected');
		//                 console.log(c.closest('tr').classList);
		//                 console.log(countSelected());

		//                 selectedCount.innerHTML = countNew;
		//                 if (selectedCount.innerHTML == 1) {
		//                     rowSelected.classList.add('hidden');
		//                     toolbarSelected.classList.add('hidden');
		//                 } else {
		//                     var firstRow = sInstance.rows[0];
		//                     firstRow.parentNode.insertBefore(rowSelected, firstRow.rows);
		//                 }
		//             } else {
		//                 console.log('dfgdsfgsdfgsdfg');
		//                 selectedCount.innerHTML = countNew++;
		//                 c.closest('tr').classList.add('selected');
		//                 rowSelected.classList.remove('hidden');
		//                 toolbarSelected.classList.remove('hidden');

		//                 var firstRow = sInstance.rows[0];
		//                 firstRow.parentNode.insertBefore(rowSelected, firstRow.rows);
		//             }
		//         });
		//     });

		// }



		// IE9 throws an 'unknown error' if document.activeElement is used
		// inside an iframe or frame.
		var activeEl;

		try {
			// Because this approach is destroying and recreating the paging
			// elements, focus is lost on the select button which is bad for
			// accessibility. So we want to restore focus once the draw has
			// completed
			activeEl = $(host).find(document.activeElement).data("dt-idx");
			//console.log(activeEl);
		} catch (e) {}

		attach(
			$(host).empty().html('<ul class="pagination"/>').children("ul"),
			buttons
		);

		if (activeEl !== undefined) {
			$(host)
				.find("[data-dt-idx=" + activeEl + "]")
				.trigger("focus");
		}


	};

	// htmx.onLoad(function(content) {
	// 	if (DataTable.settings) {

	// 		let SettingsDatatable = DataTable.settings;

	// 		// Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
	// 		var handleSearchDatatable = (datatableOnly) => {
	// 			const filterSearch = document.querySelector('[data-kt-datatable-filter="search"]');
    //             if(filterSearch){
    //                 filterSearch.addEventListener('change', function(e) {
    //                     Ci4DataTables[datatableOnly.sInstance].search(e.target.value).draw();
    //                 });
    //             }
	// 		}
	// 		const countSelected = (datatableOnly, init = false) => {
	// 			let sInstance = document.querySelector("#" + datatableOnly.sInstance);
	// 			const allCheckboxes = sInstance.querySelectorAll('tbody .selection [type="checkbox"]');

	// 			let checkedState = false;
	// 			let count = 0;
	// 			allCheckboxes.forEach(c => {
	// 				if (c.checked) {
	// 					checkedState = true;
	// 					count++;
	// 				}
	// 			});

	// 			// Select elements
	// 			let toolbarBase = document.querySelector('[data-kt-datatable-toolbar="base"]');
	// 			let toolbarSelected = document.querySelector('[data-kt-datatable-toolbar="selected"]');
	// 			let rowSelected = document.querySelector('[data-kt-datatable-row="selected"]');
	// 			let selectedCount = document.querySelector('[data-kt-datatable-select="selected_count"]');

	// 			//  // Toggle toolbars
	// 			if (checkedState) {
	// 				selectedCount.innerHTML = count;
	// 				toolbarBase.classList.add('hidden');
	// 				toolbarSelected.classList.remove('hidden');
	// 				rowSelected.classList.remove('hidden');

	// 				var firstRow = sInstance.rows[0];
	// 				firstRow.parentNode.insertBefore(rowSelected, firstRow.rows);

	// 			} else {
	// 				toolbarBase.classList.remove('hidden');
	// 				toolbarSelected.classList.add('hidden');
	// 				rowSelected.classList.add('hidden');
	// 			}
	// 			return count;
	// 		}

	// 		const initDatatable = (datatableOnly) => {

	// 			let sInstance = document.querySelector("#" + datatableOnly.sInstance);

	// 			// List checkbox all click 
	// 			const allCheck = sInstance.querySelector('.allCheck');
	// 			if (allCheck) {
	// 				// Select elements
	// 				let toolbarBase = document.querySelector('[data-kt-datatable-toolbar="base"]');
	// 				let toolbarSelected = document.querySelector('[data-kt-datatable-toolbar="selected"]');
	// 				let rowSelected = document.querySelector('[data-kt-datatable-row="selected"]');
	// 				let selectedCount = document.querySelector('[data-kt-datatable-select="selected_count"]');


	// 				allCheck.addEventListener('click', function() {
	// 					if (allCheck.checked) {
	// 						const checkboxes = sInstance.querySelectorAll('tbody .selection [type="checkbox"]');
	// 						checkboxes.forEach((c, i) => {
	// 							c.closest('tr').classList.add('selected');
	// 							selectedCount.innerHTML = (i++) + 1;
	// 							toolbarBase.classList.add('hidden');
	// 							toolbarSelected.classList.remove('hidden');
	// 							rowSelected.classList.remove('hidden');

	// 							var firstRow = sInstance.rows[0];
	// 							firstRow.parentNode.insertBefore(rowSelected, firstRow.rows);
	// 						});
	// 					} else {
	// 						const checkboxes = sInstance.querySelectorAll('tbody .selection [type="checkbox"]');
	// 						checkboxes.forEach(c => {
	// 							c.closest('tr').classList.remove('selected');
	// 							toolbarBase.classList.remove('hidden');
	// 							toolbarSelected.classList.add('hidden');
	// 							rowSelected.classList.add('hidden');

	// 						});
	// 					}
	// 				});

	// 			}

	// 			// Select filter options
	// 			const groupCheckable = sInstance.querySelectorAll('.group-checkable');
	// 			if (groupCheckable) {
	// 				groupCheckable.forEach(c => {
	// 					c.addEventListener('click', function() {
	// 						if (c.closest('tr').classList.contains('selected')) {
	// 							c.closest('tr').classList.remove('selected');
	// 							countSelected(datatableOnly);
	// 						} else {
	// 							c.closest('tr').classList.add('selected');
	// 							countSelected(datatableOnly);
	// 						}
	// 					});
	// 				});
	// 			}
	// 		}

	// 		SettingsDatatable.forEach(datatableOnly => {
	// 			let sInstance = document.querySelector("#" + datatableOnly.sInstance);

 	// 			// Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
	// 			Ci4DataTables[datatableOnly.sInstance].on('draw', function(jqXHR, settings) {
	// 				initDatatable(datatableOnly);
	// 				htmx.process(sInstance);
	// 			});

    //             handleSearchDatatable(datatableOnly);

	// 		})

	// 	}
	// });


};

export default initDatatable;