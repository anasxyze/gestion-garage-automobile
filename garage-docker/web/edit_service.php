<?php

include 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: services.php");
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $duree = $_POST['duree'];
    
    $stmt = $pdo->prepare("UPDATE services SET nom=?, description=?, prix=?, duree=? WHERE id=?");
    $stmt->execute([$nom, $description, $prix, $duree, $id]);
    header("Location: services.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
$stmt->execute([$id]);
$service = $stmt->fetch();

if (!$service) {
    header("Location: services.php");
    exit;
}
include 'includes/header.php';
?>

<section id="edit-service">
    <h2>Modifier le service</h2>
    
    <div class="form-container">
        <form method="POST">
            <div class="form-group">
                <label>Nom du service</label>
                <input type="text" name="nom" value="<?= $service['nom'] ?>" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3"><?= $service['description'] ?></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Prix (€)</label>
                    <input type="number" step="0.01" name="prix" value="<?= $service['prix'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Durée (HH:MM)</label>
                    <input type="text" name="duree" value="<?= $service['duree'] ?>" pattern="[0-9]{1,2}:[0-5][0-9]" required>
                </div>
            </div>
            
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
            <a href="services.php" class="btn" style="background: var(--light-gray); color: var(--dark);">
                <i class="fas fa-times"></i> Annuler
            </a>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>