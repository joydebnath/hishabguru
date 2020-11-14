<?php


namespace App\Services\ImportData;


class StoreClient implements Importable
{

    public function import($records)
    {
        return array_map([$this, 'parseData'], $records);
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
        ];
    }
}
