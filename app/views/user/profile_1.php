<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <h1>User Profile</h1>

    <p><strong>ID:</strong> <?php echo htmlspecialchars($data['id']); ?></p>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($data['name']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($data['email']); ?></p>
    <p><strong>Role:</strong> <?php echo htmlspecialchars($data['role']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($data['phone']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($data['address']); ?></p>
    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($data['date_of_birth']); ?></p>
    <p><strong>Profile Picture:</strong> <img src="<?php echo htmlspecialchars($data['profile_picture']); ?>" alt="Profile Picture"></p>
    <p><strong>Active:</strong> <?php echo $data['is_active'] ? 'Yes' : 'No'; ?></p>
    <p><strong>Last Login:</strong> <?php echo $data['last_login'] ? htmlspecialchars($data['last_login']) : 'Never'; ?></p>
    <p><strong>Created At:</strong> <?php echo htmlspecialchars($data['created_at']); ?></p>
    <p><strong>Updated At:</strong> <?php echo htmlspecialchars($data['updated_at']); ?></p>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($data['gender']); ?></p>
</body>
</html>
