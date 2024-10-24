<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

$query = "SELECT jegy.*, diak.nev AS diak_nev, targy.nev AS targy_nev 
          FROM jegy 
          JOIN diak ON jegy.diakid = diak.id 
          JOIN targy ON jegy.targyid = targy.id";
$result = $conn->query($query);
?>

<h1>Jegyek</h1>
<table>
    <thead>
        <tr>
            <th>Diák Név</th>
            <th>Tantárgy</th>
            <th>Érték</th>
            <th>Dátum</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['diak_nev']; ?></td>
            <td><?php echo $row['targy_nev']; ?></td>
            <td><?php echo $row['ertek']; ?></td>
            <td><?php echo date('Y-m-d', strtotime($row['datum'])); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>
