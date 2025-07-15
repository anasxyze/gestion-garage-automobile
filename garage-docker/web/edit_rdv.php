<?php

include 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: rdv.php");
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'];
    $voiture_id = $_POST['voiture_id'];
    $service_id = $_POST['service_id'];
    $date_heure = $_POST['date_heure'];
    $notes = $_POST['notes'];
    
    $stmt = $pdo->prepare("UPDATE rdv SET client_id=?, voiture_id=?, service_id=?, date_heure=?, notes=? WHERE id=?");
    $stmt->execute([$client_id, $voiture_id, $service_id, $date_heure, $notes, $id]);
    header("Location: rdv.php");
    exit;
}

// Récupérer le rendez-vous
$stmt = $pdo->prepare("
    SELECT * FROM rdv WHERE id = ?
");
$stmt->execute([$id]);
$rdv = $stmt->fetch();

if (!$rdv) {
    header("Location: rdv.php");
    exit;
}
include 'includes/header.php';

// Récupérer les clients, voitures et services
$clients = $pdo->query("SELECT id, nom, prenom FROM clients")->fetchAll();
$voitures = $pdo->query("SELECT id, marque, modele FROM voitures")->fetchAll();
$services = $pdo->query("SELECT id, nom FROM services")->fetchAll();
?>

<section id="edit-rdv">
    <h2>Modifier le rendez-vous</h2>
    
    <div class="form-container">
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Client</label>
                    <select name="client_id" required>
                        <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['id'] ?>" <?= $client['id'] == $rdv['client_id'] ? 'selected' : '' ?>>
                            <?= $client['prenom'] . ' ' . $client['nom'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Voiture</label>
                    <select name="voiture_id" required>
                        <?php foreach ($voitures as $voiture): ?>
                        <option value="<?= $voiture['id'] ?>" <?= $voiture['id'] == $rdv['voiture_id'] ? 'selected' : '' ?>>
                            <?= $voiture['marque'] . ' ' . $voiture['modele'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Service</label>
                    <select name="service_id" required>
                        <?php foreach ($services as $service): ?>
                        <option value="<?= $service['id'] ?>" <?= $service['id'] == $rdv['service_id'] ? 'selected' : '' ?>>
                            <?= $service['nom'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date et Heure</label>
                    <input type="datetime-local" name="date_heure" value="<?= date('Y-m-d\TH:i', strtotime($rdv['date_heure'])) ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Notes (optionnel)</label>
                <textarea name="notes" rows="3"><?= $rdv['notes'] ?></textarea>
            </div>
            
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
            <a href="rdv.php" class="btn" style="background: var(--light-gray); color: var(--dark);">
                <i class="fas fa-times"></i> Annuler
            </a>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>