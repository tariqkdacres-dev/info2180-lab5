<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$country = isset($_GET['country']) ? trim($_GET['country']) : '';
$lookup = isset($_GET['lookup']) ? trim($_GET['lookup']) : '';

if ($lookup === 'cities') {
    if (empty($country)) {
        $stmt = $conn->query("SELECT c.Name as name, c.District as district, c.Population as population FROM cities c JOIN countries cs ON c.country_code = cs.code");
    } else {
        $stmt = $conn->prepare("SELECT c.Name as name, c.District as district, c.Population as population FROM cities c JOIN countries cs ON c.country_code = cs.code WHERE cs.Name LIKE :country");
        $stmt->execute(['country' => '%' . $country . '%']);
    }
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>District</th>
                <th>Population</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name'] ?? ''); ?></td>
                <td><?= htmlspecialchars($row['district'] ?? ''); ?></td>
                <td><?= htmlspecialchars($row['population'] ?? ''); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php
} else {
    if (empty($country)) {
        $stmt = $conn->query("SELECT * FROM countries");
    } else {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => '%' . $country . '%']);
    }
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Continent</th>
                <th>Independence</th>
                <th>Head of State</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name'] ?? ''); ?></td>
                <td><?= htmlspecialchars($row['continent'] ?? ''); ?></td>
                <td><?= htmlspecialchars($row['IndepYear'] ?? $row['indep_year'] ?? $row['indepyear'] ?? 'N/A'); ?></td>
                <td><?= htmlspecialchars($row['head_of_state'] ?? ''); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}
?>