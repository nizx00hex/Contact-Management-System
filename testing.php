<?php
require_once 'core/init.php';



$database = new Database();
$conn = $database->getConnection();
$contact = new Contact($conn);

// if(!$conn) {
//     echo "401";
// } else {
//     echo '200';
// }

//SHOW ALL.
// $contact->Contact($conn);

$contact->id = 3;

// $outputAll = $contact->read();
$output = $contact->readOne();
?>
    <pre>
        <?php
            print_r($output);
        ?>
    </pre>
<?php

//INSERT SUCCESS.
// $contact->name = 'nisath';
// $contact->email = 'nisathnisath606@gmail.com';
// $contact->subject = 'BufferOverflow';
// $contact->message = 'Overflow - It is a most Dangerous vulnerability.';


// if ($contact->create()) {
//     $message = "Contact created successfully!";
//     $message_type = "success";
// } else {
//     $message = "Unable to create contact.";
//     $message_type = "error";
// }



//UPDATE SUCCESS.
// $contact->id = 3;

// $contact->name = 'Hacker0x01';
// $contact->email = 'nisathnisath606@gmail.com';
// $contact->subject = 'BufferOverflow';
// $contact->message = 'Overflow - It is a most Dangerous vulnerability.';
// $contact->status = 'new';


// if ($contact->update()) {
//     $message = "Contact updated successfully!";
//     $message_type = "success";
//     // Refresh current data
//     $current_data = $contact->readOne();
// } else {
//     $message = "Unable to update contact.";
//     $message_type = "error";
// }


//DELETE SUCCESS.
// $contact->id = 1;
// $contact->delete();