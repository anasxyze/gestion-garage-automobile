<?php

include 'includes/db.php';

// Gestion CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ajouter'])) {
        $marque = $_POST['marque'];
        $modele = $_POST['modele'];
        $annee = $_POST['annee'];
        $couleur = $_POST['couleur'];
        $prix = $_POST['prix'];
        $kilometrage = $_POST['kilometrage'];
        
        $stmt = $pdo->prepare("INSERT INTO voitures (marque, modele, annee, couleur, prix, kilometrage) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$marque, $modele, $annee, $couleur, $prix, $kilometrage]);
        header("Location: voitures.php");
        exit;
    }
}
include 'includes/header.php';

// Récupérer les voitures
$stmt = $pdo->query("SELECT * FROM voitures");
$voitures = $stmt->fetchAll();
?>

<section id="voitures">
    <h2>Gestion des Voitures</h2>
    
    <!-- Formulaire Ajout -->
    <div class="form-container">
        <h3>Ajouter une voiture</h3>
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Marque</label>
                    <input type="text" name="marque" placeholder="Marque" required>
                </div>
                <div class="form-group">
                    <label>Modèle</label>
                    <input type="text" name="modele" placeholder="Modèle" required>
                </div>
                <div class="form-group">
                    <label>Année</label>
                    <input type="number" name="annee" placeholder="Année" min="1990" max="2025" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Couleur</label>
                    <input type="text" name="couleur" placeholder="Couleur">
                </div>
                <div class="form-group">
                    <label>Prix (MAD)</label>
                    <input type="number" step="0.01" name="prix" placeholder="Prix" required>
                </div>
                <div class="form-group">
                    <label>Kilométrage</label>
                    <input type="number" name="kilometrage" placeholder="Kilométrage">
                </div>
            </div>
            
            <button type="submit" name="ajouter" class="btn">
                <i class="fas fa-plus"></i> Ajouter la voiture
            </button>
        </form>
    </div>

    <!-- Liste des voitures -->
    <div class="table-container">
        <h3>Liste des voitures</h3>
        <?php if ($voitures): ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marque</th>
                        <th>Modèle</th>
                        <th>Année</th>
                        <th>Couleur</th>
                        <th>Prix</th>
                        <th>KM</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($voitures as $voiture): ?>
                    <tr>
                        <td><?= $voiture['id'] ?></td>
                        <td><?= $voiture['marque'] ?></td>
                        <td><?= $voiture['modele'] ?></td>
                        <td><?= $voiture['annee'] ?></td>
                        <td><?= $voiture['couleur'] ?></td>
                        <td><?= number_format($voiture['prix'], 2) ?> MAD</td>
                        <td><?= number_format($voiture['kilometrage'], 0) ?> km</td>
                        <td class="actions">
                            <a href="edit_voiture.php?id=<?= $voiture['id'] ?>" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="delete_voiture.php?id=<?= $voiture['id'] ?>" class="btn-delete" onclick="return confirm('Confirmer la suppression?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <p>Aucune voiture enregistrée.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>