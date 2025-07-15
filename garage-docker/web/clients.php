<?php

include 'includes/db.php';

// Gestion CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ajouter'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        
        $stmt = $pdo->prepare("INSERT INTO clients (nom, prenom, email, telephone) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $email, $telephone]);
        header("Location: clients.php");
        exit;
    }
}
include 'includes/header.php';

// Récupérer les clients
$stmt = $pdo->query("SELECT * FROM clients");
$clients = $stmt->fetchAll();
?>

<section id="clients">
    <h2>Gestion des Clients</h2>
    
    <!-- Formulaire Ajout -->
    <div class="form-container">
        <h3>Ajouter un client</h3>
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="nom" placeholder="Nom" required>
                </div>
                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" placeholder="Prénom" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="text" name="telephone" placeholder="Téléphone" required>
                </div>
            </div>
            
            <button type="submit" name="ajouter" class="btn">
                <i class="fas fa-user-plus"></i> Ajouter le client
            </button>
        </form>
    </div>

    <!-- Liste des clients -->
    <div class="table-container">
        <h3>Liste des clients</h3>
        <?php if ($clients): ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= $client['id'] ?></td>
                        <td><?= $client['nom'] ?></td>
                        <td><?= $client['prenom'] ?></td>
                        <td><?= $client['email'] ?></td>
                        <td><?= $client['telephone'] ?></td>
                        <td class="actions">
                            <a href="edit_client.php?id=<?= $client['id'] ?>" class="btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="delete_client.php?id=<?= $client['id'] ?>" class="btn-delete" onclick="return confirm('Confirmer la suppression?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <p>Aucun client enregistré.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>