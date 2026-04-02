<?php

return [
    /*
     * Namespaces used by the generator.
     */
    'namespace' => [
        /*
         * Base namespace/directory to create the new file.
         * This is appended on default Laravel namespace.
         * Usage: php artisan datatables:make User
         * Output: App\DataTables\UserDataTable
         * With Model: App\User (default model)
         * Export filename: users_timestamp
         */
        'base' => 'DataTables',

        /*
         * Base namespace/directory where your model's are located.
         * This is appended on default Laravel namespace.
         * Usage: php artisan datatables:make Post --model
         * Output: App\DataTables\PostDataTable
         * With Model: App\Post
         * Export filename: posts_timestamp
         */
        'model' => 'App\\Models',
    ],

    /*
     * Set Custom stub folder
     */
    // 'stub' => '/resources/custom_stub',

    /*
     * PDF generator to be used when converting the table to pdf.
     * Available generators: excel, snappy
     * Snappy package: barryvdh/laravel-snappy
     * Excel package: maatwebsite/excel
     */
    'pdf_generator' => 'snappy',

    /*
     * Snappy PDF options.
     */
    'snappy' => [
        'options' => [
            'no-outline' => true,
            'margin-left' => '0',
            'margin-right' => '0',
            'margin-top' => '10mm',
            'margin-bottom' => '10mm',
        ],
        'orientation' => 'landscape',
    ],

    /*
     * Default html builder parameters.
     */
    'parameters' => [
        'dom' => '<"row"<"col-sm-12 col-md-6 col-lg-6 pt-2 pb-2"B><"col-sm-12 col-md-6 col-lg-3 pt-2 pb-2"<"d-flex justify-content-sm-center justify-content-lg-end filter1">><"col-sm-12 col-md-6 col-lg-3 pt-2 pb-2"<"d-flex justify-content-sm-center justify-content-lg-end filter2">>>flrtip',
        'order' => [[0, 'desc']],
        'language' => [
            'search' => 'Search:',
            'lengthMenu' => 'Show _MENU_ entries',
            'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
            'infoFiltered' => '(filtered from _MAX_ total entries)',
            'emptyTable' =>'Data tidak ditemukan',
            'infoEmpty' => '',
            'zeroRecords' => 'Data tidak ditemukan',
        ],
        'drawCallback' => 'function(settings) {
                if (settings._iRecordsDisplay === 0) {
                    $(settings.nTableWrapper).find(".dataTables_paginate").hide();
                } else {
                    $(settings.nTableWrapper).find(".dataTables_paginate").show();
                }
                feather.replace();
            }',
        // ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"]
        'buttons' => [
            // 'excelHtml5',
            // 'export',
            [
                'extend' => 'excel',
                'text' => '<i class="fas fa-file-excel"></i> Export to Excel', // Add icon and custom text
                'className' => 'btn btn-success btn-sm' // Apply specific Bootstrap classes
            ],
        ],
    ],

    /*
     * Generator command default options value.
     */
    'generator' => [
        /*
         * Default columns to generate when not set.
         */
        'columns' => 'id,add your columns,created_at,updated_at',

        /*
         * Default buttons to generate when not set.
         */
        'buttons' => 'excel,csv,pdf,print,reset,reload',

        /*
         * Default DOM to generate when not set.
         */
        'dom' => 'Bfrtp',
    ],
];
