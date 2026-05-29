<?php
// read.php - View single contact details
require_once 'core/init.php';

$database = new Database();
$db = $database->getConnection();
$contact = new Contact($db);

// Get ID from URL
$contact->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');

// Get contact data
$contact_data = $contact->readOne();

if (!$contact_data) {
    die('ERROR: Contact not found.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contact - PHP CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Contact Details</h4>
                        <a href="index.php" class="btn btn-secondary">Back to List</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">ID</th>
                                <td><?php echo $contact_data['id']; ?></td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td><?php echo htmlspecialchars($contact_data['name']); ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo htmlspecialchars($contact_data['email']); ?></td>
                            </tr>
                            <tr>
                                <th>Subject</th>
                                <td><?php echo htmlspecialchars($contact_data['subject']); ?></td>
                            </tr>
                            <tr>
                                <th>Message</th>
                                <td><?php echo nl2br(htmlspecialchars($contact_data['message'])); ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo $contact_data['status'] === 'new' ? 'success' : 
                                             ($contact_data['status'] === 'read' ? 'warning' : 'secondary'); 
                                    ?>">
                                        <?php echo ucfirst($contact_data['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td><?php echo date('F j, Y, g:i a', strtotime($contact_data['created_at'])); ?></td>
                            </tr>
                        </table>
                        
                        <div class="mt-3">
                            <a href="update.php?id=<?php echo $contact_data['id']; ?>" class="btn btn-warning">Edit Contact</a>
                            <a href="index.php" class="btn btn-secondary">Back to List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>