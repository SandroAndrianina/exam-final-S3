<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of gifts</title>
    <link rel="stylesheet" href="/assets/css/table.css">
</head>
<body>
    
    <main>
        <h1>List of gifts</h1>

        <section class="donations-list">
    <?php if(!empty($gifts)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Article ID</th>
                    <th>Total Quantity</th>
                    <th>Donation Date</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($gifts as $gift) : ?>
                <tr>
                    <td><?= $gift->getArticleId(); ?></td>
                    <td><?= $gift->getTotalQuantity(); ?></td>
                    <td><?= $gift->getDonationDate(); ?></td>
                    <td><?= $gift->getDescription() ?: 'No description'; ?></td>
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