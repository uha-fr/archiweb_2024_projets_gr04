<main class="px-4">
    <section class="col-12">
        <h3>Gestion Utilisateurs</h3>
        <table class="table">
            <thead>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Rôle</th>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $index => $utilisateur) : ?>
                    <tr>
                        <td><?= $utilisateur->getNomUtilisateur() ?></td>
                        <td><?= $utilisateur->getEmail() ?></td>
                        <td>
                            <form action="" method="post" class="role-form">
                                <input type="hidden" name="userId" value="<?= $utilisateur->getId() ?>">
                                <select name="role" onchange="submitForm(this)">
                                    <?php foreach($roles as $role => $roleName): ?>
                                        <?php if($role == $utilisateur->getRole()): ?>
                                            <option value="<?= $role ?>" selected><?= $roleName ?></option>
                                        <?php else: ?>
                                            <option value="<?= $role ?>"><?= $roleName ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
                <li class="page-item <?= ($pageActuelle == 1) ? "disabled" : "" ?>">
                    <a href="?page=<?= $pageActuelle -1 ?>" class="page-link">Page précédente</a>
                </li>
                <?php for($page = 1; $page <= $nbPage; $page++): ?>
                    <li class="page-item <?= ($pageActuelle == $page) ? "active" : "" ?>">
                        <a href="?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                    </li>
                <?php endfor ?>
                
                <li class="page-item">
                    <a href="?page=<?= $pageActuelle + 1 ?>" class="page-link <?= ($pageActuelle == $nbPage) ? "disabled" : "" ?>">Page Suivante</a>
                </li>
            </ul>
        </nav>
    </section>
</main>

<script type="text/javascript" src="/public/js/lib.js"></script>