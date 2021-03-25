<?php

declare(strict_types=1);

namespace App;

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\CSV\Sheet;
use Throwable;

class ContactsLoader
{
    public function loadContactsFromFile(string $filePath): array
    {
        $contacts = [];

        try {
            $reader = ReaderEntityFactory::createReaderFromFile($filePath);
            $reader->open($filePath);

            /** @var Sheet $sheet */
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    $cells = $row->getCells();

                    $email = (string)$cells[0];
                    $firstName = (string)$cells[1];
                    $lastName = (string)$cells[2];

                    $contacts[] = new ContactDto($email, $firstName, $lastName);
                }
            }

            $reader->close();
        } catch (Throwable $exception) {
            return [];
        }

        return $contacts;
    }


}
