<?php $title_page = 'Dashboard | Portfolio';
$description_page = 'Connexion au back-office';
?>

<style>
    .header--absolute {
        position: relative;
    }
</style>

<section class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>Back-office</h1><br>
        <a href="<?= $router->generate('admin_messages') ?>">Voir mes messages</a>
    </div>

    <h2>Mes projets</h2>
    <p><a href="<?= $router->generate('add_project') ?>">Ajouter un projet</a></p>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
          <?php echo $_SESSION['success']; ?>
          <?php unset($_SESSION['success']); // Pour éviter qu'il apparaisse plusieurs fois 
          ?>
        </div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
          <?php echo $_SESSION['error']; ?>
          <?php unset($_SESSION['error']); // Pour éviter qu'il apparaisse plusieurs fois 
          ?>
        </div>
    <?php endif; ?>

    <table class="table table-bordered mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Titre</th>
                <th>Photo</th>
                <th>Description</th>
                <th>Contenu</th>
                <th>Date</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <?php foreach ($projects as $project): ?>
            <tr>
                <td><?= $project['title']; ?></td>
                <td>
                <img src="/<?= $project['thumbnail']; ?>" alt="Image du projet" style="width: 100px; height: auto;">
                </td>
                <td><?= $project['description']; ?></td>
                <td><?= htmlspecialchars_decode($project['content']); ?></td>
                <td><?= $project['created_at']; ?></td>
                <td>
                    <a href="<?= $router->generate('edit_project', ['id' => $project['id']]) ?>">modifier</a>
                    <a href="<?= $router->generate('delete_project', ['id' => $project['id']]) ?>">supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>