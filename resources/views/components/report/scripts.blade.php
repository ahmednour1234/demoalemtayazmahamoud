{{-- XLSX --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    window.exportTableToExcel = function(tableId, filename = 'export.xlsx') {
        const table = document.getElementById(tableId);
        if (!table) return;

        const workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
        XLSX.writeFile(workbook, filename);
    }

    window.printDiv = function(divId) {
        const el = document.getElementById(divId);
        if (!el) return;

        const content = el.innerHTML;
        const printWindow = window.open('', '', 'height=700,width=900');

        printWindow.document.open();
        printWindow.document.write(`
            <html>
            <head>
                <title>طباعة</title>
                <style>
                    body{font-family:Arial,sans-serif;margin:20px;direction:rtl}
                    table{width:100%;border-collapse:collapse}
                    table,th,td{border:1px solid #333}
                    th,td{padding:10px;text-align:right}
                    .print-only{display:block !important}
                    .no-print{display:none !important}
                </style>
            </head>
            <body>
                ${content}
            </body>
            </html>
        `);
        printWindow.document.close();

        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }
</script>

