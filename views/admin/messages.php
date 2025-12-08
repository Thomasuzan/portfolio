<style>

    .header--absolute {

        position: relative;

    }

</style>



<section class="container my-5">

    <div class="d-flex justify-content-between align-items-center">

    <h1 class="mb-4">Messages reçus</h1>

    <a href="<?= $router->generate('admin_dashboard') ?>">Retour</a>

    </div>

    <table class="table table-bordered mb-4">

        <thead class="thead-dark">

            <tr>

                <th>Nom</th>

                <th>Email</th>

                <th>Message</th>

                <th>Fichier</th>

                <th>Date</th>

            </tr>

        </thead>

        <tbody>

            <?php foreach ($messages as $message): ?>

            <tr>

                <td><?= htmlspecialchars($message['name']); ?></td>

                <td><?= htmlspecialchars($message['email']); ?></td>

                <td><?= nl2br(htmlspecialchars($message['message'])); ?></td>

                <td>

                    <?php if (!empty($message['file_path'])): ?>

                        <a href="/<?= htmlspecialchars($message['file_path']); ?>" target="_blank" class="btn btn--theme-black btn-sm">Télécharger</a>

                    <?php else: ?>

                        Aucun fichier

                    <?php endif; ?>

                </td>

                <td><?= $message['created_at']; ?></td>

            </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</section>