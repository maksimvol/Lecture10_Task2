<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Information Form</title>
</head>
<body>
    <h1>Movie Information Form</h1>
    <form action="" method="POST">
        <label for="movie_id">Movie ID:</label>
        <input type="text" name="movie_id" required><br><br>
        
        <label for="title">Title:</label>
        <input type="text" name="title" required><br><br>
        
        <label for="description">Description:</label><br>
        <textarea name="description" rows="4" cols="50" required></textarea><br><br>
        
        <button type="submit">Submit</button>
    </form>

    <?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $db_name = "movie_database";

    $conn = new mysqli($host, $username, $password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $movie_id = htmlspecialchars($_POST['movie_id']);
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);

        $stmt = $conn->prepare("INSERT INTO movies (movie_id, title, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $movie_id, $title, $description);

        if ($stmt->execute()) {
            echo "<p>Record successfully saved to the database!</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    echo "<h2>All Submitted Movies:</h2>";
    $result = $conn->query("SELECT movie_id, title, description FROM movies");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>Movie ID:</strong> " . htmlspecialchars($row["movie_id"]) . "</p>";
            echo "<p><strong>Title:</strong> " . htmlspecialchars($row["title"]) . "</p>";
            echo "<p><strong>Description:</strong> " . htmlspecialchars($row["description"]) . "</p>";
            echo "<hr>";
        }
    } else {
        echo "<p>No movies found in the database.</p>";
    }

    $conn->close();
    ?>
</body>
</html>