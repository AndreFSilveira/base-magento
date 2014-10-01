/**
 * Create by buzzthemes developers
 */
jQuery(document).ready(function() {
if (jQuery('.products-grid').length) {

        var alignProductGridActions = function () {
            var gridRows = []; // This will store an array per row
            var tempRow = [];
            productGridElements = jQuery('.products-grid > li');
            productGridElements.each(function (index) {
                // The JS ought to be agnostic of the specific CSS breakpoints, so we are dynamically checking to find
                // each row by grouping all cells (eg, li elements) up until we find an element that is cleared.
                // We are ignoring the first cell since it will always be cleared.
                if (jQuery(this).css('clear') != 'none' && index != 0) {
                    gridRows.push(tempRow); // Add the previous set of rows to the main array
                    tempRow = []; // Reset the array since we're on a new row
                }
                tempRow.push(this);

                // The last row will not contain any cells that clear that row, so we check to see if this is the last cell
                // in the grid, and if so, we add its row to the array
                if (productGridElements.length == index + 1) {
                    gridRows.push(tempRow);
                }
            });

            jQuery.each(gridRows, function () {
                var tallestHeight = 0;
                jQuery.each(this, function () {
                    // Since this function is called every time the page is resized, we need to remove the min-height
                    // so each cell can return to its natural size before being measured.
                    jQuery(this).find('.product_info').css('min-height', '');
                    // We are checking the height of .product-info (rather than the entire li), because the images
                    // will not be loaded when this JS is run.
                    elHeight = parseInt(jQuery(this).find('.product_info').css('height'));
                    if (elHeight > tallestHeight) {
                        tallestHeight = elHeight;
                    }
                });
                // Set the height of all .product-info elements in a row to the tallest height
                jQuery.each(this, function () {
                    jQuery(this).find('.product_info').css('minHeight', tallestHeight+15);
                });
            });
        }
        alignProductGridActions();

        // Since the height of each cell and the number of columns per page may change when the page is resized, we are
        // going to run the alignment function each time the page is resized.
        jQuery(window).on('delayed-resize', function (e, resizeEvent) {
            alignProductGridActions();
        });
    }
	var resizeTimer;
    jQuery(window).resize(function (e) {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            jQuery(window).trigger('delayed-resize', e);
        }, 250);
    });
});
