<?php

include 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: voitures.php");
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $annee = $_POST['annee'];
    $couleur = $_POST['couleur'];
    $prix = $_POST['prix'];
    $kilometrage = $_POST['kilometrage'];
    
    $stmt = $pdo->prepare("UPDATE voitures SET marque=?, modele=?, annee=?, couleur=?, prix=?, kilometrage=? WHERE id=?");
    $stmt->execute([$marque, $modele, $annee, $couleur, $prix, $kilometrage, $id]);
    header("Location: voitures.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM voitures WHERE id = ?");
$stmt->execute([$id]);
$voiture = $stmt->fetch();

if (!$voiture) {
    header("Location: voitures.php");
    exit;
}
include 'includes/header.php';
?>

<section id="edit-voiture">
    <h2>Modifier la voiture</h2>
    
    <div class="form-container">
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Marque</label>
                    <input type="text" name="marque" value="<?= $voiture['marque'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Modèle</label>
                    <input type="text" name="modele" value="<?= $voiture['modele'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Année</label>
                    <input type="number" name="annee" value="<?= $voiture['annee'] ?>" min="1990" max="2023" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Couleur</label>
                    <input type="text" name="couleur" value="<?= $voiture['couleur'] ?>">
                </div>
                <div class="form-group">
                    <label>Prix (€)</label>
                    <input type="number" step="0.01" name="prix" value="<?= $voiture['prix'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Kilométrage</label>
                    <input type="number" name="kilometrage" value="<?= $voiture['kilometrage'] ?>">
                </div>
            </div>
            
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
            <a href="voitures.php" class="btn" style="background: var(--light-gray); color: var(--dark);">
                <i class="fas fa-times"></i> Annuler
            </a>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>