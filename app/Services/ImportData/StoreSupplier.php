<?php


namespace App\Services\ImportData;


class StoreSupplier implements Importable
{

    public function import($records)
    {
        // TODO: Implement import() method.
    }

    private function parseData($record)
    {
        return [
            'name' => $record['Full Name'],
            'email' => $record['Email'],
            'city' => $record['City'],
            'address_line_1' => $record['Contact Address'],
            'country' => $record['Country'],
            'mobile' => $record['Mobile'],
            'note' => $record['Note'],
            'phone' => $record['Phone'],
            'postcode' => $record['Postcode'],
            'state' => $record['State/Division'],
            'primary_contact_person_name' => $record['Contact Person Name'],
            'primary_contact_person_mobile' => $record['Contact Person Mobile'],
            'primary_contact_person_email' => $record['Contact Person Email'],
        ];
    }
}
