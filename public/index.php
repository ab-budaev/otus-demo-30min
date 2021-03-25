<?php
/** @noinspection PhpUndefinedConstantInspection */

/** @noinspection PhpUndefinedFunctionInspection */

use App\ContactDto;
use App\ContactsLoader;
use App\ContactValidator;
use App\Exceptions\InvalidEmailException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

tideways_xhprof_enable(TIDEWAYS_XHPROF_FLAGS_MEMORY | TIDEWAYS_XHPROF_FLAGS_CPU);

require __DIR__ . '/../vendor/autoload.php';

// Setup
$logger = (new Logger('test'))->pushHandler(new StreamHandler('php://stdout', Logger::INFO));

// Let's go
$contactsFilePath = __DIR__ . '/../files/contacts.csv';

/** @var ContactDto[] $contacts */
$contacts = (new ContactsLoader())->loadContactsFromFile($contactsFilePath);

$validator = new ContactValidator();

$validEmails = [];
$invalidEmails = [];

foreach ($contacts as $contact) {
    try {
        $validator->validateEmail($contact->getEmail());

        file_put_contents('../files/valid_emails.txt', $contact->getEmail() . PHP_EOL, FILE_APPEND);
    } catch (InvalidEmailException $exception) {
        $logger->notice('[Contact] Validation error', [
            'email'     => $contact->getEmail(),
            'exception' => $exception,
        ]);

        file_put_contents('../files/invalid_emails.txt', $contact->getEmail() . PHP_EOL, FILE_APPEND);

        continue;
    } catch (Throwable $exception) {
        $logger->error('[Contact] Error occurred', [
            'email'     => $contact->getEmail(),
            'exception' => $exception,
        ]);

        continue;
    }
}

echo "All contacts processed";

file_put_contents(
    sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid() . '.otus-demo.xhprof',
    serialize(tideways_xhprof_disable())
);