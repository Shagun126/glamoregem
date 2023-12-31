jQuery( document ).ready( function( $ ) {
	'use strict';

	// create namespace to avoid any possible conflicts
	$.wc_product_vendors_admin = {

		init: function() {
			$( '#your-profile tr.show-admin-bar' ).remove();

			// check if vendor is pending - show pending message
			if ( wcpv_admin_local.isPendingVendor ) {
				$( '#dashboard-widgets' ).html( '<p class="wcpv-pending-vendor-message">' + wcpv_admin_local.pending_vendor_message + '</p>' );
			}

			$( '.taxonomy-wcpv_product_vendors, .toplevel_page_wcpv-vendor-settings' ).on( 'click', '.wcpv-upload-logo', function( e ) {
				e.preventDefault();

				// create the media frame
				var i18n = wcpv_admin_local,
					inputField = $( this ).parents( '.form-field' ).find( 'input[name="vendor_data[logo]"]' ),
					previewField = $( this ).parents( '.form-field' ).find( '.wcpv-logo-preview-image' ),
					mediaFrame = wp.media.frames.mediaFrame = wp.media({

						title: i18n.modalLogoTitle,

						button: {
							text: i18n.buttonLogoText
						},

						// only images
						library: {
							type: 'image'
						},

						multiple: false
					});

				// after a file has been selected
				mediaFrame.on( 'select', function() {
					var selection = mediaFrame.state().get( 'selection' );

					selection.map( function( attachment ) {

						attachment = attachment.toJSON();

						if ( attachment.id ) {

							// add attachment id to input field
							inputField.val( attachment.id );

							// show preview image
							previewField.prop( 'src', attachment.url ).removeClass( 'hide' );

							// show remove image icon
							$( inputField ).parents( '.form-field' ).find( '.wcpv-remove-image' ).show();
						}
					});
				});

				// open the modal frame
				mediaFrame.open();
			});

			$( '.taxonomy-wcpv_product_vendors, .toplevel_page_wcpv-vendor-settings' ).on( 'click', '.wcpv-remove-image', function( e ) {
				e.preventDefault();

				$( this ).hide();
				$( this ).parents( '.form-field' ).find( '.wcpv-logo-preview-image' ).prop( 'src', '' ).addClass( 'hide' );
				$( 'input[name="vendor_data[logo]"]' ).val( '' );
			});

			// variations bulk edit commissions
			$( document.body ).on( 'variable_vendor_commission', function( bulk_edit ) {
				var value = window.prompt( woocommerce_admin_meta_boxes_variations.i18n_enter_a_value );

				if ( value != null ) {
					$( ':input[name^="_wcpv_product_variation_commission"]' ).val( value ).trigger( 'change' );
				}
			});

			// only if widget is on page
			if ( $( '.chart-widget .wcpv-vendor-search' ).length ) {

				var formatString = {
					formatMatches: function( matches ) {
						if ( 1 === matches ) {
							return wcpv_admin_local.i18n_matches_1;
						}

						return wcpv_admin_local.i18n_matches_n.replace( '%qty%', matches );
					},
					formatNoMatches: function() {
						return wcpv_admin_local.i18n_no_matches;
					},
					formatAjaxError: function() {
						return wcpv_admin_local.i18n_ajax_error;
					},
					formatInputTooShort: function( input, min ) {
						var number = min - input.length;

						if ( 1 === number ) {
							return wcpv_admin_local.i18n_input_too_short_1;
						}

						return wcpv_admin_local.i18n_input_too_short_n.replace( '%qty%', number );
					},
					formatInputTooLong: function( input, max ) {
						var number = input.length - max;

						if ( 1 === number ) {
							return wcpv_admin_local.i18n_input_too_long_1;
						}

						return wcpv_admin_local.i18n_input_too_long_n.replace( '%qty%', number );
					},
					formatSelectionTooBig: function( limit ) {
						if ( 1 === limit ) {
							return wcpv_admin_local.i18n_selection_too_long_1;
						}

						return wcpv_admin_local.i18n_selection_too_long_n.replace( '%qty%', limit );
					},
					formatLoadMore: function() {
						return wcpv_admin_local.i18n_load_more;
					},
					formatSearching: function() {
						return wcpv_admin_local.i18n_searching;
					}
				};

				$( '.wcpv-vendor-search-bar' ).filter( ':not(.enhanced)' ).each( function() {
					var select2_args = {
						allowClear:  $( this ).data( 'allow_clear' ) ? true : false,
						placeholder: $( this ).data( 'placeholder' ),
						minimumInputLength: $( this ).data( 'minimum_input_length' ) ? $( this ).data( 'minimum_input_length' ) : '3',
						escapeMarkup: function( m ) {
							return m;
						},
						ajax: {
					        url:         wcpv_admin_local.ajaxurl,
					        dataType:    'json',
					        quietMillis: 250,
					        data: function( term ) {
					            return {
									term:     term,
									action:   'wcpv_vendor_search_ajax',
									security: wcpv_admin_local.vendor_search_nonce
					            };
					        },
					        processResults: function( data ) {
					        	var terms = [];
						        if ( data ) {
									$.each( data, function( id, text ) {
										terms.push({
											id: id,
											text: text
										});
									});
								}
					            return { results: terms };
					        },
					        cache: true
					    }
					};

					if ( $( this ).data( 'multiple' ) === true ) {
						select2_args.multiple = true;
						select2_args.initSelection = function( element, callback ) {
							var data     = JSON.parse( element.attr( 'data-selected' ) );
							var selected = [];

							$( element.val().split( ',' ) ).each( function( i, val ) {
								selected.push({
									id: val,
									text: data[ val ] || element.data( 'placeholder' )
								});
							});
							return callback( selected );
						};
						select2_args.formatSelection = function( data ) {
							return '<div class="selected-option" data-id="' + data.id + '">' + data.text + '</div>';
						};
					} else {
						select2_args.multiple = false;
						select2_args.initSelection = function( element, callback ) {
							var data = {
								id: element.val(),
								text: element.attr( 'data-selected' ) || element.data( 'placeholder' )
							};
							return callback( data );
						};
					}

					select2_args = $.extend( select2_args, formatString );

					$( this ).select2( select2_args ).addClass( 'enhanced' );
				});
			}

			// js link download does not work in safari so we need to hide
			// the export buttons.
			var testLink = document.createElement( 'a' );

			if ( typeof testLink.download === 'undefined' ) {
				$( '.wcpv-export-commissions-button' ).hide();
				$( '.wcpv-export-unpaid-commissions-button' ).hide();
				$( testLink ).remove();
			}

			function downloadCSV( fileName, urlData ) {

				var aLink = document.createElement( 'a' );

				aLink.download = fileName;
				aLink.href = urlData;
				$( aLink ).hide();
				$( aLink ).addClass( 'pv-temp-download' );
				$( 'body' ).append( aLink );
				aLink.click();
			}

			// Export commissions for current view
			$( document.body ).on( 'click', '.wcpv-export-commissions-button', function( e ) {
				e.preventDefault();

				// clear any appended download links first
				$( '.pv-temp-download' ).remove();

				// get the data to be rendered
				var	data = {
					'action': 'wcpv_export_commissions_ajax',
					'nonce': $( this ).data( 'nonce' ),
					'order_id': $( this ).data( 'order_id' ),
					'year': $( this ).data( 'year' ),
					'month': $( this ).data( 'month' ),
					'vendor': $( this ).data( 'vendor' ),
					'commission_status': $( this ).data( 'commission_status' )
					},
					filename = $( this ).prop( 'download' );

				$.post( wcpv_admin_local.ajaxurl, data ).done( function( response ) {
					downloadCSV( filename, 'data:application/csv;charset=utf-8,' + encodeURIComponent( response ) );
				});
			});

			// Exports all unpaid commissions
			$( document.body ).on( 'click', '.wcpv-export-unpaid-commissions-button', function( e ) {
				e.preventDefault();

				// clear any appended download links first
				$( '.pv-temp-download' ).remove();

				// get the data to be rendered
				var	data = {
					'action': 'wcpv_export_unpaid_commissions_ajax',
					'nonce': $( this ).data( 'nonce' )
					},
					filename = $( this ).prop( 'download' );

				$.post( wcpv_admin_local.ajaxurl, data ).done( function( response ) {
					downloadCSV( filename, 'data:application/csv;charset=utf-8,' + encodeURIComponent( response ) );
				});
			});

			// PayPal Mass Payments sandbox/live credential toggle
			$( '#wcpv_vendor_settings_paypal_masspay_environment' ).on( 'change', function() {
				var clientIDLive = $( '#wcpv_vendor_settings_paypal_masspay_client_id_live' ).parents( 'tr' ).eq(0),
					clientSecretLive = $( '#wcpv_vendor_settings_paypal_masspay_client_secret_live' ).parents( 'tr' ).eq(0),
					clientIDSandbox = $( '#wcpv_vendor_settings_paypal_masspay_client_id_sandbox' ).parents( 'tr' ).eq(0),
					clientSecretSandbox = $( '#wcpv_vendor_settings_paypal_masspay_client_secret_sandbox' ).parents( 'tr' ).eq(0);

				if ( 'sandbox' === $( this ).val() ) {
					clientIDLive.hide();
					clientSecretLive.hide();
					clientIDSandbox.show();
					clientSecretSandbox.show();
				} else {
					clientIDLive.show();
					clientSecretLive.show();
					clientIDSandbox.hide();
					clientSecretSandbox.hide();
				}
			}).trigger( 'change' );

			// show/hide additional settings for taxonomy create page
			$( document.body ).on( 'click', '.wcpv-term-additional-settings-link', function( e ) {
				e.preventDefault();
				$( '.wcpv-term-additional-settings' ).slideToggle();
			});

			// Enable tax handling radio input fields
			if ( $( '#wcpv-product-vendor-terms-select' ).length ) {
				$( '#wcpv-product-vendor-terms-select' ).change( function () {
					var vendor_id = $( this ).val();
					var selected_vendor = $( this ).children().filter( '[value="' + vendor_id + '"]' );
					var tax_type = selected_vendor.data( 'taxes' );
					var pass_shipping = selected_vendor.data( 'pass-shipping' );

					var general_setting = $( '#wcpv-product-vendor-tax-general-settings' );
					var can_customize_vendor_settings = general_setting
						.find( 'input[name="_wcpv_customize_product_vendor_settings"' )
						.prop( 'checked' )
					var notice = general_setting.find( '.wcpv-vendor-selection-notice' );


					if ( vendor_id ) {
						notice.hide()
					} else {
						notice.show();
					}

					// Set product vendor settings default values to global vendor settings when customisation is off.
					// So that admin always override global vendor settings default values in product and by default, unedited settings have global values.
					if ( !can_customize_vendor_settings ) {
						tax_type && general_setting
							.find( `input[name="_wcpv_product_taxes"][value="${tax_type}"]` )
							.prop( 'checked', true )
						pass_shipping && general_setting
							.find( `input[name="_wcpv_product_pass_shipping"]` )
							.prop( 'checked', pass_shipping === 'yes' )
					}
				} ).change();
			}

			// Toggle product vendor settings on prodict edit page.
			if ( $( '#wcpv-product-vendor-tax-general-settings .wcpv_customize_settings_field' ).length ) {
				var checkbox = $( '#wcpv-product-vendor-tax-general-settings .wcpv_customize_settings_field input' );

				checkbox.change( function () {
					var can_customse_settings = $( this ).prop( 'checked' ),
						setting_fields = $(
							'#wcpv-product-vendor-tax-general-settings > *:not(.wcpv_customize_settings_field):not(h2:nth-child(1)):not(.wcpv-vendor-selection-notice)' );

					if ( can_customse_settings ) {
						setting_fields.show()
					} else {
						setting_fields.hide()
					}
				} ).change();
			}

			// Store Vendor Profile details as they are updated.
			if ( $( '#wcpv_vendor_info' ).length && window.tinymce != null ) {
				var editor = tinymce.get( 'wcpv_vendor_info' );
				editor.on( 'change', function ( el ) {
					$( '#wcpv_vendor_info' ).val( editor.getContent() );
				});
			}

			if ( $( '.js-import-csv-override' ).length ) {
				var import_cv_override_button = $( '.js-import-csv-override' );

				import_cv_override_button.on( 'click', function ( event ) {
					if ( !window.confirm( wcpv_admin_local.i18n_import_csv_override_confirmation_text ) ) {
						return false;
					}

					return true;
				} );
			}
		}
	}; // close namespace

	$.wc_product_vendors_admin.init();
// end document ready
});
