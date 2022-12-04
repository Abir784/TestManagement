<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithProperties;

class StudentSampleExport implements WithProperties
{
    public function properties(): array
    {
        return [
            'creator'        => 'Patrick Brouwers',
            'lastModifiedBy' => 'Patrick Brouwers',
            'title'          => 'Invoices Export',
            'description'    => 'Latest Invoices',
            'subject'        => 'Invoices',
            'keywords'       => 'invoices,export,spreadsheet',
            'category'       => 'Invoices',
            'manager'        => 'Patrick Brouwers',
            'company'        => 'Maatwebsite',
        ];

    }
}


