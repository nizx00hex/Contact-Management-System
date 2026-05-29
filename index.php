<?php
require_once 'core/init.php';

$database = new Database();
$db = $database->getConnection();
$contact = new Contact($db);

$message = '';
$message_type = '';

// Handle GET messages
if (isset($_GET['message']) && isset($_GET['type'])) {
    $message = $_GET['message'];
    $message_type = $_GET['type'];
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $contact->name = $_POST['name'];
    $contact->email = $_POST['email'];
    $contact->subject = $_POST['subject'];
    $contact->message = $_POST['message'];

    if ($contact->create()) {
        // header("Location: index.php");
        header("Location: index.php?message=Contact+created+successfully!&type=success");
        exit;
    } else {
        header("Location: index.php?message=Unable+to+create+contact.&type=error");
        exit;
    }
}

$contacts = $contact->read();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management - PHP CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Contact Management System</h1>
        
        <!-- Display Messages -->
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- CREATE Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Add New Contact</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <input type="hidden" name="create" value="1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject *</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message *</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Contact</button>
                </form>
            </div>
        </div>

        <!-- READ - Contacts List -->
        <div class="card">
            <div class="card-header">
                <h5>All Contact Messages (<?php echo count($contacts); ?>)</h5>
            </div>
            <div class="card-body">
                <?php if (count($contacts) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact_item): ?>
                                    <tr>
                                        <td><?php echo $contact_item['id']; ?></td>
                                        <td><?php echo htmlspecialchars($contact_item['name']); ?></td>
                                        <td><?php echo htmlspecialchars($contact_item['email']); ?></td>
                                        <td><?php echo htmlspecialchars($contact_item['subject']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $contact_item['status'] === 'new' ? 'success' : 
                                                     ($contact_item['status'] === 'read' ? 'warning' : 'secondary'); 
                                            ?>">
                                                <?php echo ucfirst($contact_item['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M j, Y g:i A', strtotime($contact_item['created_at'])); ?></td>
                                        <td>
                                            <!-- VIEW Button -->
                                            <a href="read.php?id=<?php echo $contact_item['id']; ?>" 
                                               class="btn btn-sm btn-info">View</a>
                                            
                                            <!-- EDIT Button -->
                                            <a href="update.php?id=<?php echo $contact_item['id']; ?>" 
                                               class="btn btn-sm btn-warning">Edit</a>
                                            
                                            <!-- DELETE Button -->
                                            <a href="delete.php?id=<?php echo $contact_item['id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted">No contacts found. Add your first contact above!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>