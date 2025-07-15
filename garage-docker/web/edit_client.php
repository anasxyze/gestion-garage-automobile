<?php

include 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: clients.php");
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    
    $stmt = $pdo->prepare("UPDATE clients SET nom=?, prenom=?, email=?, telephone=? WHERE id=?");
    $stmt->execute([$nom, $prenom, $email, $telephone, $id]);
    header("Location: clients.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
$stmt->execute([$id]);
$client = $stmt->fetch();

if (!$client) {
    header("Location: clients.php");
    exit;
}
include 'includes/header.php';
?>

<section id="edit-client">
    <h2>Modifier le client</h2>
    
    <div class="form-container">
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="nom" value="<?= $client['nom'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" value="<?= $client['prenom'] ?>" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= $client['email'] ?>">
                </div>
                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="text" name="telephone" value="<?= $client['telephone'] ?>" required>
                </div>
            </div>
            
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
            <a href="clients.php" class="btn" style="background: var(--light-gray); color: var(--dark);">
                <i class="fas fa-times"></i> Annuler
            </a>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>