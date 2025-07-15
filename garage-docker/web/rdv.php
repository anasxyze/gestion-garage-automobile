<?php

include 'includes/db.php';

// Gestion CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ajouter'])) {
        $client_id = $_POST['client_id'];
        $voiture_id = $_POST['voiture_id'];
        $service_id = $_POST['service_id'];
        $date_heure = $_POST['date_heure'];
        $notes = $_POST['notes'];
        
        $stmt = $pdo->prepare("INSERT INTO rdv (client_id, voiture_id, service_id, date_heure, notes) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$client_id, $voiture_id, $service_id, $date_heure, $notes]);
        header("Location: rdv.php");
        exit;
    }
}
include 'includes/header.php';

// Récupérer les rendez-vous
$stmt = $pdo->query("
    SELECT r.id, c.nom AS client_nom, c.prenom AS client_prenom, 
           v.marque, v.modele, s.nom AS service_nom, 
           r.date_heure, r.notes
    FROM rdv r
    JOIN clients c ON r.client_id = c.id
    JOIN voitures v ON r.voiture_id = v.id
    JOIN services s ON r.service_id = s.id
    ORDER BY r.date_heure DESC
");
$rdvs = $stmt->fetchAll();

// Récupérer les clients, voitures et services pour les listes déroulantes
$clients = $pdo->query("SELECT id, nom, prenom FROM clients")->fetchAll();
$voitures = $pdo->query("SELECT id, marque, modele FROM voitures")->fetchAll();
$services = $pdo->query("SELECT id, nom FROM services")->fetchAll();
?>

<section id="rdv">
    <h2>Gestion des Rendez-vous</h2>
    
    <!-- Formulaire Ajout -->
    <div class="form-container">
        <h3>Prendre un rendez-vous</h3>
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Client</label>
                    <select name="client_id" required>
                        <option value="">Sélectionnez un client</option>
                        <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['id'] ?>">
                            <?= $client['prenom'] . ' ' . $client['nom'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Voiture</label>
                    <select name="voiture_id" required>
                        <option value="">Sélectionnez une voiture</option>
                        <?php foreach ($voitures as $voiture): ?>
                        <option value="<?= $voiture['id'] ?>">
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
                        <option value="">Sélectionnez un service</option>
                        <?php foreach ($services as $service): ?>
                        <option value="<?= $service['id'] ?>"><?= $service['nom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date et Heure</label>
                    <input type="datetime-local" name="date_heure" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Notes (optionnel)</label>
                <textarea name="notes" placeholder="Notes supplémentaires" rows="3"></textarea>
            </div>
            
            <button type="submit" name="ajouter" class="btn">
                <i class="fas fa-calendar-plus"></i> Ajouter le rendez-vous
            </button>
        </form>
    </div>

    <!-- Liste des rendez-vous -->
    <div class="table-container">
        <h3>Liste des rendez-vous</h3>
        <?php if ($rdvs): ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Voiture</th>
                        <th>Service</th>
                        <th>Date/Heure</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rdvs as $rdv): ?>
                    <tr>
                        <td><?= $rdv['id'] ?></td>
                        <td><?= $rdv['client_prenom'] . ' ' . $rdv['client_nom'] ?></td>
                        <td><?= $rdv['marque'] . ' ' . $rdv['modele'] ?></td>
                        <td><?= $rdv['service_nom'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($rdv['date_heure'])) ?></td>
                        <td><?= $rdv['notes'] ?></td>
                        <td class="actions">
                            <a href="edit_rdv.php?id=<?= $rdv['id'] ?>" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="delete_rdv.php?id=<?= $rdv['id'] ?>" class="btn-delete" onclick="return confirm('Confirmer la suppression?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <p>Aucun rendez-vous enregistré.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>