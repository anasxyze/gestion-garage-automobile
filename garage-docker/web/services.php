<?php

include 'includes/db.php';

// Gestion CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ajouter'])) {
        $nom = $_POST['nom'];
        $description = $_POST['description'];
        $prix = $_POST['prix'];
        $duree = $_POST['duree'];
        
        $stmt = $pdo->prepare("INSERT INTO services (nom, description, prix, duree) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $description, $prix, $duree]);
        header("Location: services.php");
        exit;
    }
}
include 'includes/header.php';
// Récupérer les services
$stmt = $pdo->query("SELECT * FROM services");
$services = $stmt->fetchAll();
?>

<section id="services">
    <h2>Gestion des Services</h2>
    
    <!-- Formulaire Ajout -->
    <div class="form-container">
        <h3>Ajouter un service</h3>
        <form method="POST">
            <div class="form-group">
                <label>Nom du service</label>
                <input type="text" name="nom" placeholder="Nom du service" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" placeholder="Description du service" rows="3"></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Prix (MAD)</label>
                    <input type="number" step="0.01" name="prix" placeholder="Prix" required>
                </div>
                <div class="form-group">
                    <label>Durée (HH:MM)</label>
                    <input type="text" name="duree" placeholder="HH:MM" pattern="[0-9]{1,2}:[0-5][0-9]" required>
                </div>
            </div>
            <button type="submit" name="ajouter" class="btn">
                <i class="fas fa-plus"></i> Ajouter le service
            </button>
        </form>
    </div>

    <!-- Liste des services -->
    <div class="table-container">
        <h3>Liste des services</h3>
        <?php if ($services): ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Durée</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?= $service['id'] ?></td>
                        <td><?= $service['nom'] ?></td>
                        <td><?= $service['description'] ?></td>
                        <td><?= number_format($service['prix'], 2) ?> MAD</td>
                        <td><?= $service['duree'] ?></td>
                        <td class="actions">
                            <a href="edit_service.php?id=<?= $service['id'] ?>" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="delete_service.php?id=<?= $service['id'] ?>" class="btn-delete" onclick="return confirm('Confirmer la suppression?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <p>Aucun service enregistré.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>