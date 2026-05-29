<?php
// update.php - Update contact information
require_once 'core/init.php';


$database = new Database();
$db = $database->getConnection();
$contact = new Contact($db);

// Get ID from URL
$contact->id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Missing ID.');

// Get current contact data
$current_data = $contact->readOne();

if (!$current_data) {
    die('ERROR: Contact not found.');
}

$message = '';
$message_type = '';

// Handle form submission
if ($_POST) {
    $contact->name = $_POST['name'];
    $contact->email = $_POST['email'];
    $contact->subject = $_POST['subject'];
    $contact->message = $_POST['message'];
    $contact->status = $_POST['status'];
    
    if ($contact->update()) {
        $message = "Contact updated successfully!";
        $message_type = "success";
        // Refresh current data
        $current_data = $contact->readOne();
    } else {
        $message = "Unable to update contact.";
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact - PHP CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Edit Contact</h4>
                        <a href="index.php" class="btn btn-secondary">Back to List</a>
                    </div>
                    <div class="card-body">
                        
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?>">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?php echo htmlspecialchars($current_data['name']); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                               value="<?php echo htmlspecialchars($current_data['email']); ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject *</label>
                                <input type="text" class="form-control" id="subject" name="subject" 
                                       value="<?php echo htmlspecialchars($current_data['subject']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control" id="message" name="message" rows="4" required><?php 
                                    echo htmlspecialchars($current_data['message']); 
                                ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="new" <?php echo $current_data['status'] === 'new' ? 'selected' : ''; ?>>New</option>
                                    <option value="read" <?php echo $current_data['status'] === 'read' ? 'selected' : ''; ?>>Read</option>
                                    <option value="replied" <?php echo $current_data['status'] === 'replied' ? 'selected' : ''; ?>>Replied</option>
                                </select>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="index.php" class="btn btn-secondary me-md-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Contact</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>