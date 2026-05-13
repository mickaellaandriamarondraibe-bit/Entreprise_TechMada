<?= $this->extend('layouts/rh_layout') ?>
<?= $this->section('content') ?>

<div class="app-wrap">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo-icon"><i class="bi bi-shield-check"></i></div>
            <div class="sidebar-brand-name">TechMada RH<span>Administration</span></div>
        </div>
        <ul class="sidebar-nav" style="margin-top:1rem">
            <li><a href="<?= site_url('admin/dashboard') ?>"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
            <li><a href="<?= site_url('admin/employes') ?>"><i class="bi bi-people"></i> Employés</a></li>
            <li><a href="<?= site_url('admin/types-conge') ?>" class="active"><i class="bi bi-tags"></i> Types de congé</a></li>
        </ul>
    </aside>

    <div class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title">Types de congé</div>
                <div class="topbar-breadcrumb">Admin > Types de congé</div>
            </div>
            <a href="<?= site_url('admin/types-conge/create') ?>" class="btn-forest">
                <i class="bi bi-plus-lg"></i> Ajouter
            </a>
        </div>

        <div class="content">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="flash flash-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <div class="data-card">
                <div class="data-card-head"><h3>Liste des types</h3></div>
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Libellé</th>
                            <th>Jours annuels</th>
                            <th>Déductible</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($types as $type): ?>
                            <tr>
                                <td class="td-name"><?= esc($type['libelle']) ?></td>
                                <td class="td-mono"><?= esc($type['jours_annuels']) ?> j</td>
                                <td><?= $type['deductible'] ? 'Oui' : 'Non' ?></td>
                                <td>
                                    <a href="<?= site_url('admin/types-conge/edit/' . $type['id']) ?>" class="btn-sm btn-edit">Modifier</a>
                                    <a href="<?= site_url('admin/types-conge/delete/' . $type['id']) ?>" class="btn-sm btn-del">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($types)): ?>
                            <tr><td colspan="4">Aucun type de congé.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>