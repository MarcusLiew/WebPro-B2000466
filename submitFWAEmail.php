<?php
require '../../php/vendor/autoload.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

// Create an SES client
$client = new SesClient([
    'version' => 'latest',
    'region' => 'ap-southeast-1', // Replace with your own region
    'credentials' => [
        'key' => 'AKIAXBX7J3QXPXPDKXE5',
        'secret' => 'xl27djBkSoCuwrfOJ0+JcQ8qDnBBhfpXNb+k36tB',
    ],
]);

// Set up the email
$to = $email;
$subject = "A New FWA Request to Be Reviewed!";
$message = "Employee " . $employeeID . " has submitted a new FWA request! Be sure to review it when you can.";
$sender = "wrkblservice@gmail.com";

// Send the email
try {
    $result = $client->sendEmail([
        'Destination' => [
            'ToAddresses' => [$to],
        ],
        'Message' => [
            'Body' => [
                'Text' => [
                    'Charset' => 'UTF-8',
                    'Data' => $message,
                ],
            ],
            'Subject' => [
                'Charset' => 'UTF-8',
                'Data' => $subject,
            ],
        ],
        'Source' => $sender,
    ]);

    // Print the message ID if the email was sent
    echo '<script>alert("Email sent to your supervisor!")</script>';
} catch (AwsException $e) {
    // Handle any errors
    echo '<script>alert("Email not sent: ' . $e->getMessage() . ')</script>';
}
