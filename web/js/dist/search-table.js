$(document).ready(function() {
    // When something is typed in search
    $('#system-search').keyup( function() {
        let that = this;
        let tableBody = $('.list-table tbody');
        let tableRow = $('.list-table tbody tr');
        $('.search-nothing').remove();

        tableRow.each(function(i, val) {

            //Lower text for case sensitive
            let rowText = $(val).text().toLowerCase();
            let inputText = $(that).val().toLowerCase();

            if (inputText !== '') {
                $('.search-value').remove();
            } else {
                $('.search-value').remove();
            }

            if ( rowText.indexOf( inputText ) === -1 ) {
                // Hide rows
                tableRow.eq(i).hide();
            } else {
                $('.search-nothing').remove();
                tableRow.eq(i).show();
            }
        });

        // Hide all rows
        if (tableRow.children(':visible').length === 0) {
            tableBody.append('<tr class="search-nothing"><td class="text-muted">Aucun résultat trouvé.</td></tr>');
        }
    });
});