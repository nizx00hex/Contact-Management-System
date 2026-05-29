<?php
// delete.php - Delete contact
require_once 'core/init.php';


$database = new Database();
$db = $database->getConnection();
$contact = new Contact($db);

// Get ID from URL
$contact->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');

// Check if contact exists first
$current_data = $contact->readOne();
if (!$current_data) {
    die('ERROR: Contact not found.');
}

// Delete the contact
if ($contact->delete()) {
    header("Location: index.php?message=Contact deleted successfully&type=success");
    exit();
} else {
    header("Location: index.php?message=Unable to delete contact&type=error");
    exit();
}
?>