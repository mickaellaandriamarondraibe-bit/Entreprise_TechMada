<?= $this->extend('layouts/rh_layout') ?>
<?= $this->section('content') ?>

<div class="app-wrap">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo-icon"><i class="bi bi-shield-check"></i></div>
            <div class="sidebar-brand-name">TechMada RH<span>Administration</span></div>
        </div>

        <div class="sidebar-section">Gestion</div>
        <ul class="sidebar-nav">
            <li><a href="<?= site_url('admin/dashboard') ?>"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
            <li><a href="<?= site_url('admin/employes') ?>" class="active"><i class="bi bi-people"></i> Employés</a></li>
       <a href="<?= base_url('logout') ?>" title="Déconnexion">
    <i class="bi bi-box-arrow-right"></i>
</a>
        </ul>
    </aside>

    <div class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title">Gestion des employés</div>
                <div class="topbar-breadcrumb">Admin > Employés</div>
            </div>
            <div class="topbar-actions">
                <a href="<?= site_url('admin/employes/create') ?>" class="btn-forest">
                    <i class="bi bi-person-plus"></i> Ajouter
                </a>
            </div>
        </div>

        <div class="content">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="flash flash-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <div class="data-card">
                <div class="data-card-head"><h3>Liste des employés</h3></div>

                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Actif</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employes as $employe): ?>
                            <tr>
                                <td class="td-name"><?= esc($employe['prenom'] . ' ' . $employe['nom']) ?></td>
                                <td><?= esc($employe['email']) ?></td>
                                <td><span class="type-badge t-annuel"><?= esc($employe['role']) ?></span></td>
                                <td><?= $employe['actif'] ? 'Oui' : 'Non' ?></td>
                                <td>
                                    <a href="<?= site_url('admin/employes/edit/' . $employe['id']) ?>" class="btn-sm btn-edit">Modifier</a>
                                    <a href="<?= site_url('admin/employes/delete/' . $employe['id']) ?>" class="btn-sm btn-del">Désactiver</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($employes)): ?>
                            <tr><td colspan="5">Aucun employé.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>