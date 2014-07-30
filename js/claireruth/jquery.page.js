

/**
 * app structure
 * simply jumps into if statements and boots functionality where required
 */
var Page = function () {
	if (system.page.hasClass('mode-select')) {
		this.modeSelect(this);
	};
	if (system.page.hasClass('scanning')) {
		var scanner = new Scanner();
	};
	if (system.page.hasClass('stocktake')) {
		var stockTake = new Stocktake();
	};
	if (system.page.hasClass('purchase-order-edit')) {
		this.purchaseOrderCreate(this);
		var note = new Note();
	};
	if (system.page.hasClass('purchase-order-create-2')) {
		this.purchaseOrderCreate(this);
	};
	if (system.page.hasClass('user-crud')) {
		this.userCrud(this);
	};
	if (system.page.hasClass('items-grid')) {
		this.items(this);
	};
};


Page.prototype.items = function(data) {

	// setup grid
	$("#list").jqGrid({
		url:'./index.php?m=Grid_Module_Item_Load',
		datatype: 'xml',
		cellEdit: true,
		altRows: true,
		height: '600',
		cellsubmit: 'remote',
		cellurl: './index.php?m=Grid_Module_Item_Save',  
		editurl: './index.php?m=Grid_Module_Item_AddDel',
		loadError: function(xhr,status,error) {
			alert(xhr.statusText);
		},
		gridComplete: function() {

			// print barcode button
			$('.js-print-barcodes')
				.off('click')
				.on('click', function(event) {
					event.preventDefault();
					$('.js-dialog-print-barcodes-product-id').val($(this).data('product-id'));
					$('.js-dialog-print-barcodes').dialog('open');
				});			
		},
		mtype: 'GET',
		colNames: [
			'ID',
			'SKU',
			'Barcode',
			'MPN',
			'Name',
			'Stock',
			'Min Stock',
			'Location',
			'Status',
			'Supplier',
			'Cost Price',
			'Req Count',
			'Print'
		],
		colModel:[
			{
				name: 'id',
				index: 'id',
				align: 'right',
				width: 60
			},
			{
				name: 'sku',
				index: 'sku',
				editable: true,
				editrules: {
					required: true
				},
				width: 90
			},  
	     	{
	     		name: 'barcode',
	     		index: 'barcode',
	     		editable: true,
	     		editrules: {
	     			required: true
	     		},
	     		width: 150
	     	},   		
			{
				name: 'mpn',
				index: 'mpn',
				editable: true,
				width: 90
			},
			{
				name: 'name',
				index: 'name',
				width: 350,
				editable: true,
				editrules: {
					required: true
				}
			},  
			{
				name: 'stock',
				index: 'stock',
				width: 60,
				editable: false
			},
			{
				name: 'user_min_stock',
				index: 'user_min_stock',
				width: 60,
				editable: true,
				editrules: {
					integer: true
				}
			},
			{
				name: 'location',
				index: 'location',
				width: 100,
				search: true,
				stype: 'select',
				searchoptions: {
					value: ':;<?php echo $locations ?>'
				},
				editable: true,
				edittype:'select',
				editoptions: {
					value:'<?php echo $locations ?>'
				},
				sortable: false
			},
			{
				name:'status',
				index:'status',
				width: 60,
				stype: 'select',
				searchoptions:{
					value: ':;Current:Current;Discontinued:Discontinued'
				},
				editable: true,
				edittype: 'select',
				editoptions: {
					value: 'Current:Current;Discontinued:Discontinued'
				}
			}, 		
			{
				name: 'supplier',
				index: 'supplier',
				width: 100,
				search: true,
				stype: 'select',
				searchoptions: {
					value:':;' + $('.js-grid-suppliers').html()
				},
				editable: true,
				edittype: 'select',
				editoptions: {
					value: $('.js-grid-suppliers').html()
				},
				sortable: false
			},
			{
				name: 'cost_price',
				index: 'cost_price',
				width: 60,
				editable: true,
				editrules: {
					number: true
				}
			}, 
			{
				name: 'requires_count',
				index: 'requires_count',
				width: 90, align: 'right',
				search: true,
				stype: 'select',
				searchoptions: {
					value: ':;Yes:Yes;No:No'
				},
				editable: true,
				edittype:'select',
				editoptions: {
					value:'Yes:Yes;No:No'
				}
			},
			{
				name: 'control',
				index: 'control',
				width: 100,
				align: 'right',
				search: false,
				editable: false,
				sortable: false
			}
		],
		pager: '#pager',
		rowNum:25,
		rowList: [10, 25, 50, 100, 200],
		sortname: 'name',
		sortorder: 'asc',
		viewrecords: true,
		caption: 'Product Inventory',
	}).navGrid('#pager', {
		add: true,
		edit: false,
		del: true,
		search: false
	});
	$("#list")
		.jqGrid()
		.filterToolbar();

	// dialog for printing barcodes
	var val;
	var inputQuantity = $('.js-dialog-print-barcodes-quantity');
	$('.js-dialog-print-barcodes').dialog({
		autoOpen: false,
		height: 350,
		width: 300,
		modal: true,
		buttons: {
			Print: function() {
				val = parseInt(inputQuantity.val());
				inputQuantity.val('');
				url = "./?m=Ajax_Module_PrintBarcode&item_id=" + $('.js-dialog-print-barcodes-product-id').val() + "&quantity=" + val;
				if (val > 0) {
					$.ajax({
						// TODO: make results pretty.
						url: url,
						statusCode: {
							400 : function() {
								alert("Printing Failed - Bad Request");
    							},
							500 : function() {
								alert("Printing Failed - Server Error");
							}
						}
					}).done(function() {
						alert("Data sent for printing");
					});
				}
				$(this).dialog('close');
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		},
		close: function() {},
		open: function(type, data) {
			inputQuantity.focus();
		}
	});
};


Page.prototype.modeSelect = function(data) {

	//Barcode lookup. Encodes data before request.
	function lookup() {
		barcode = $('#barcode').val();
		qty = $('#qty_value').val();
		if(barcode.length < 1) {
			return;
		}
		//Place barcode into wrapper
		$('#last_barcode_wrapper').html('<li>' + barcode + '</li>');
		//Clear for next entry.
		$('#barcode').val('');
		$('#qty_value').val('1');
		
		//Make ajax request.
		request = $.ajax({
			url: "./index.php?m=Ajax_Module_Scan&mode=" + encodeURIComponent(mode) + '&barcode=' + encodeURIComponent(barcode) + '&qty=' + encodeURIComponent(qty),
			type: "GET",
			dataType: "html"
		}).done(function(msg) {
			//Display returned text to user.
			show_results(msg);
		}).fail(function() {
			alert('Scan Operation Failed');	
		});
	}


	// Display success message, or errors.
	function show_results(message) {
		var icon = '<?xml version="1.0" encoding="utf-8"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><polygon id="x-mark-icon" points="438.393,374.595 319.757,255.977 438.378,137.348 374.595,73.607 255.995,192.225 137.375,73.622 73.607,137.352 192.246,255.983 73.622,374.625 137.352,438.393 256.002,319.734 374.652,438.378 "/></svg>';
		previous = $.trim($('#results_wrapper').html())
		if(previous.length > 0) {
			$('#history_wrapper').prepend(previous);
		}
		$('#results_wrapper').html('<li>' + message + '</li>');
		// Add void buttons for in/out operations.
		added = $('#results_wrapper').find('div');
		log_id = added.attr('log_id');
		if(added.attr('log_id') != 'none' && added.attr('log_id') > 0) {
			var void_control = $('<span class="void-control js-void-control" log_id="' + log_id + '"><span class="void-control-cross">' + icon + '</span>Undo</span>');
			added.append(void_control);
			setEvents();
		}
	}

	// On focus of quantity input, show dialog to update it.
	$('#qty_value').focus(function(e) {
		$('.js-scanner-quantity-area').trigger('click');
		$('#qty_dialog').dialog("open");	
	});

	// hotkeys
	$(document).on('keydown', function(event) {

		// f1
		if (event.keyCode == 112) {
			event.preventDefault();
			window.location.href = window.location.origin + window.location.pathname + '?m=Admin_Module_Scanning';
		};
	});
};


Page.prototype.userCrud = function(data) {
	// $(".js-user-form").validate({
	// 	rules: {
	// 		username: {
	// 			required: true,
	// 			minlength: 3
	// 		},
	// 		password: {
	// 			required: true,
	// 			minlength: 8
	// 		},
	// 		password2: {
	// 			required: true,
	// 			minlength: 8,
	// 			equalTo: "#password"
	// 		}
	// 	},
	// 	messages: {
	// 		username: {
	// 			required: "Please enter a username",
	// 			minlength: "Username must be at least 3 characters"
	// 		},
	// 		password: {
	// 			required: "Please provide a password",
	// 			minlength: "Password must be at least 8 characters long"
	// 		},
	// 		password2: {
	// 			required: "Please provide a password",
	// 			minlength: "Password must be at least 8 characters long",
	// 			equalTo: "Passwords do not match"
	// 		}
	// 	}
	// });
};


Page.prototype.purchaseOrderEdit = function(data) {
	$('.js-purchase-create-action-bottom').scrollToFixed({
		bottom: 0
    });
	$('.main-flexnav').scrollToFixed({
		bottom: 0
    });
};


Page.prototype.purchaseOrderCreate = function(data) {
	setEvents();
	update_total();


	function setEvents() {
		var close = $('.js-purchase-order-row-close');

		// class for delete button display
		var table = $('.js-purchase-order-product-table');
		table
			.removeClass('delete-disabled')
			.removeClass('delete-enabled');
		if (close.length < 2) {
			table.addClass('delete-disabled');
		} else {
			table.addClass('delete-enabled');
		};

		// event for deleting a row
		close.off('click').on('click', function(event) {
			if (close.length < 2) {
				return;
			};
			$(this).closest('.js-order-item-grid').remove();
			update_total();
			setEvents();
		});
	}


	// print
	$('.js-purchase-order-button-print').on('click', function(event) {
		window.print();
	});
	
	$('#notes_toggle').click(function() {
		$('#notes_wrapper').toggle();		
	});

	// Auto complete for items
	$('#item_lookup').blur(function() {
		$(this).removeClass('ui-autocomplete-loading');
	});
	var global_cache = {},
	lastXhr;
	$("#item_lookup").autocomplete({
		minLength: 3,
		source: function( request, response ) {
			var term = request.term;
			if (term in global_cache) {
				response(global_cache[ term ]);
				return;
			}
			supplier_id = $('#supplier_id').val()
			lastXhr = $.getJSON("./index.php?m=Ajax_Module_PurchaseOrderSearch&sid=" + supplier_id, request, function( data, status, xhr ) {
				global_cache[ term ] = data;
				if ( xhr === lastXhr ) {
					response( data );
				}
			});
		},

		// On select insert item empty basket fields, creating new fields afterwards
		select: function(event, ui) {
			row = get_next_empty_row();
			row.find('.order_item_sku').val(ui.item.sku);
			row.find('.order_item_mpn').val(ui.item.mpn);
			row.find('.order_item_name').val(ui.item.name);
			row.find('.order_item_cost_price').val(ui.item.cost_price);
			row.find('.order_item_quantity').val('1');
			// Finally ensure at least one empty row is available for free-text input
			row = get_next_empty_row();

			update_total();
		},
		close: function(event, ui) { 
		}

	});

	$.ui.autocomplete.prototype._renderItem = function( ul, item ) {
		var link;
		link = "<a>" + item.sku + " - " + item.name + " (&pound;" + item.cost_price + ") " + item.mpn + "</a>";
		return $( "<li></li>" )
			.data( "item.autocomplete", item )
			.append( link )
			.appendTo( ul );
	};

	// Returns a new empty basket row for use, and removes any other empty ones
	function get_next_empty_row() {

		// dont if edit page
		if (system.page.hasClass('purchase-order-edit')) {
			return;
		};
		
		rows = $('.item_list');
		var new_row;
		var empty_fields;
		if (rows.length > 1) {
			$(rows).each(function() {
				empty_fields = true;
				//Check for all empty inputs.
				$(this).find(':input').each(function() {
					if ($(this).val().length > 0) {
						empty_fields = false;
					}
				});
				if (empty_fields && !new_row) {
					// Move blank row to end.
					$(this).appendTo($('#item_list_wrapper'));
					new_row = $('.item_list').last()
				} else if (empty_fields) {
					$(this).remove();
				}
			});
		}

		// Create a row, empty it and return it.
		if (!new_row) {
			$('.item_list').first().clone().appendTo($('#item_list_wrapper'));
			new_row = $('.item_list').last()
			new_row.on('change', function() {
				do_updates();	
			});
			new_row.find('input').each(function() {
				$(this).val('');
			});
		}
		return new_row;
	}

	// Call to calculate and display basket total.
	function update_total() {
		var total = 0;
		var total_items = 0;
		var ok = true;
		var itemList = $('.item_list');
		var item;
		for (var i = itemList.length - 1; i >= 0; i--) {
			item = $(itemList[i]);
			item.find(':input').removeClass('list_errors');

			// Trim whitespace in all inputs
			// needed?
			item.find(':input').each(function() {
				item.val(item.val().trim());
			});
			cost_price = item.find('.order_item_cost_price').val();
			quantity = item.find('.order_item_quantity').val();

			// Enforce min quantity. 
			if (quantity == '0' || quantity < 0) {
				quantity = '1';
				item.find('.order_item_quantity').val('1');
			}
			name = item.find('.order_item_name').val();
			sku = item.find('.order_item_sku').val();
			mpn = item.find('.order_item_mpn').val();
			if (cost_price.length > 0 && isNumber(cost_price) && quantity.length > 0 && parseInt(quantity) > 0 && sku.length > 0 && mpn.length > 0 && name.length > 0) {
				total = total + parseFloat(cost_price) * parseInt(quantity);
				total_items = total_items + parseInt(quantity);

			// Highlight imcomplete (but not empty) rows.
			} else if (cost_price.length > 0 || quantity.length > 0 || sku.length > 0 || name.length > 0) {
				item.find(':input').filter(function() {
    					return !item.val();
				}).addClass('basket_errors');
				ok = false;

				// Enforce price as a number.
				if (cost_price.length > 0 && !isNumber(cost_price)) {
					item.find('.order_item_cost_price').addClass('list_errors');
				}
			} 
		};
		if (ok) {
			enable_submit();
		} else {
			disable_submit('Please correct errors in the basket above');
		}
		total = total.toFixed(2);
		$('#grand_total').val('£' + total);
		$('#total_items').val(total_items);
	}

	
	// Update total on any change. Binds to appended rows.
	$(':input').on('change', function() {
		do_updates();
	});


	function do_updates() {
		get_next_empty_row();
		update_total();
		setEvents();
	}


	$('.back_one_page').click(function(e) {
		e.preventDefault();
		window.history.go(-1);
	});

	
	function disable_submit(msg) {
		$('.error_msg').html(msg);
		$('.send_order').attr('disabled','disabled');
	}


	function enable_submit() {
		$('.error_msg').html('');
		$('.send_order').removeAttr('disabled','disabled');
	}
	

	function isNumber(n) {
  		return !isNaN(parseFloat(n)) && isFinite(n);
	}


	//Disable on page load
	disable_submit('Please complete order details above');


	//Trigger loading of suggested item
	$.getJSON("./index.php?m=Ajax_Module_PurchaseOrderSuggest&sid=" + $('#supplier_id').val(), function(data) {
		var items = [];
		$.each(data, function(key, item) {
			suggested_stock = Math.max((item.user_min_stock - item.stock), (item.auto_min_stock - item.stock));
			items.push("<li class='suggested_item_line suggested-item-line'>" +
				"<span class='suggested_item_sku'>" + item.sku + "</span> - " +
				"<span class='suggested_item_name'>" + item.name + "</span> " +
				"(&pound;<span class='suggested_item_cost_price'>" + item.cost_price + "</span>) - " +
				"<span class='suggested_item_mpn'>" + item.mpn + "</span> " +
				"Order: <span class='suggested_item_quantity'>" + suggested_stock + "</span></li>");
		});
		if (items.length) {
			$('#suggested_items_wrapper').html("<ul>" + items.join("") + "</ul>");
		} else {
			$('#suggested_items_wrapper').html("No suggestions at this time.");
		}

		// Update event handlers to allow adding of lines.
		$(document).on('click', '.suggested_item_line', function() {
			row = get_next_empty_row();
			row.find('.order_item_sku').val($(this).find('.suggested_item_sku').html());
			row.find('.order_item_mpn').val($(this).find('.suggested_item_mpn').html());
			row.find('.order_item_name').val($(this).find('.suggested_item_name').html());
			row.find('.order_item_cost_price').val($(this).find('.suggested_item_cost_price').html());
			row.find('.order_item_quantity').val($(this).find('.suggested_item_quantity').html());
			// Finally ensure at least one empty row is available for free-text input
			row = get_next_empty_row();
			$(this).remove();
			update_total();
			if ($('.suggested_item_line').length < 1) {
				$('#suggested_items_wrapper').html("No suggestions at this time.");
			}
		});
	});	
};
