<?php
/** @noinspection PhpUndefinedConstantInspection */

/** @noinspection PhpUndefinedFunctionInspection */

use App\ContactDto;
use App\ContactsLoader;
use App\ContactValidator;
use App\Exceptions\InvalidEmailException;

tideways_xhprof_enable(TIDEWAYS_XHPROF_FLAGS_MEMORY | TIDEWAYS_XHPROF_FLAGS_CPU | TIDEWAYS_XHPROF_FLAGS_NO_BUILTINS);

require __DIR__ . '/vendor/autoload.php';

$contactsFilePath = __DIR__ . '/files/contacts.csv';

/** @var ContactDto[] $contacts */
$contacts = (new ContactsLoader())->loadContactsFromFile($contactsFilePath);

$validator = new ContactValidator();

$validContacts = [];
$invalidContacts = [];

foreach ($contacts as $contact) {
    try {
        $validator->validateEmail($contact->getEmail());

        $validContacts[] = $contact;
    } catch (InvalidEmailException $exception) {
        $invalidContacts[] = $contact;
    }
}

var_dump($invalidContacts);

file_put_contents(
    sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid() . '.otus-demo.xhprof',
    serialize(tideways_xhprof_disable())
);