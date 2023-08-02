<?php

/*
  * Class: csci303sp23
  * User:  ajshaffer
  * Date:  5/3/23
  * Time:  1:23 PM
*/
session_start();

$pageName = "Search Content";

require_once "header.php";

//Initial variables
$search_term = '';
$no_results = false;

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (!empty($_GET['search'])) {
        $search_term = trim($_GET['search']);
        $sql = "SELECT * FROM content WHERE title LIKE :search_term ORDER BY title ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':search_term', $search_term . '%');
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($results)) {
            $no_results = true;
        }
    }
}

?>

<h1>Search</h1>

<form method="get" action="contentsearch.php">
    <label for="search">Search:</label>
    <input type="text" name="search" value="<?php echo htmlspecialchars($search_term); ?>">
    <input type="submit" value="Search">
</form>

<?php if (!empty($search_term)): ?>

    <?php if ($no_results): ?>
        <p>No results found for '<?php echo htmlspecialchars($search_term); ?>'</p>
    <?php else: ?>
        <p>Showing results for '<?php echo htmlspecialchars($search_term); ?>':</p>

        <ul>
            <?php foreach ($results as $result): ?>
                <li><a href="contentview.php?id=<?php echo $result['ID']; ?>"><?php echo htmlspecialchars($result['title']); ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

<?php endif; ?>

<?php require_once "footer.php"; ?>
