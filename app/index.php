<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supermarket Course List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .center-box {
            width: 400px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="d-flex vh-100 justify-content-center align-items-center">
    <?php
        try {
            $db = new PDO('mysql:host=database;dbname=db', 'root', 'root');

            if(isset($_POST['action'])) {
                switch($_POST['action']) {
                    case 'addItem':
                        // Create an item
                        $statement = $db->prepare("INSERT INTO courses (name) VALUES (:name)");
                        $statement->bindValue(':name', $_POST['name']);
                        $statement->execute();
                        break;
                    case 'deleteItem':
                        // Delete an item
                        $statement = $db->prepare("DELETE FROM courses WHERE id = :id");
                        $statement->bindValue(':id', $_POST['id']);
                        $statement->execute();
                        break;
                    default:
                        break;
                }
            }
        
            // Get all items
            $statement = $db->query("SELECT * FROM courses");
        
            $courses = $statement->fetchAll(PDO::FETCH_ASSOC);

            ?>
            <div class="center-box text-center">
                <h5>Supermarket Course List</h5>
                <form class="d-flex gap-2 mb-3" action="index.php" method="POST">
                    <input type="hidden" name="action" value="addItem">
                    <input type="text" id="itemInput" name="name" class="form-control" placeholder="Enter item name">
                    <button class="btn btn-primary" type="submit">Add</button>
                </form>
                <ul id="itemList" class="list-group">
                    <?php
                        foreach($courses as $item)
                        {
                            ?>  
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= $item['name'] ?>
                                <form action="index.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="action" value="deleteItem">
                                    <button class='btn btn-danger btn-sm' type="submit">Remove</button>
                                </form>
                            </li>
                            <?php
                        }
                    ?>
                </ul>
            </div>
            <?php
        } catch(Exception $e) {
            ?>
            <div class="center-box text-center bg-warning">
                <h3>Erreur pendant la connexion à la base de donnée</h1>
                <h6>Si vous avez lancer la base, attendez quelques instants que le serveur démarre puis rechargez cette page</h3>
            </div>
            <?php
        }
    ?>
</body>
</html>
