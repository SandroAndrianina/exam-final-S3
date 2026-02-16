<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of cities</title>
    <link rel="stylesheet" href="/assets/css/table.css">
</head>
<body>
    
    <main>
        <h1>List of cities</h1>

        <section class="cities-list">
    <?php if(!empty($cities)) : ?>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($cities as $city) : ?>
                <tr>
                <td><?php echo $city->getId(); ?></td>
                <td><?php echo $city->getName(); ?></td>
                <td>
                    <a href="/bngrc/city/<?= $city->getId() ?>/details" class="btn-more">More</a>
                </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No city found.</p>
    <?php endif; ?>
</section>

    </main>
  
</body>
</html>