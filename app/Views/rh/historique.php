<?= $this->extend('layouts/rh_layout') ?>

<?= $this->section('content') ?>

<section id="page-rh-historique">
    <div class="app-wrap">

        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-logo-icon"><i class="bi bi-person-check"></i></div>
                <div class="sidebar-brand-name">TechMada RH<span>Espace responsable</span></div>
            </div>

            <div class="sidebar-section">Menu</div>

            <ul class="sidebar-nav">
                <li><a href="<?= site_url('rh/demandes') ?>"><i class="bi bi-inbox"></i> Demandes à traiter</a></li>
                <li><a href="<?= site_url('rh/historique') ?>" class="active"><i class="bi bi-archive"></i> Historique</a></li>
                <li><a href="<?= site_url('rh/soldes') ?>"><i class="bi bi-people"></i> Soldes employés</a></li>
            </ul>
        </aside>

        <div class="main">
            <div class="topbar">
                <div>
                    <div class="topbar-title">Historique des demandes</div>
                    <div class="topbar-breadcrumb">RH <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Historique</div>
                </div>
            </div>

            <div class="content">
                <div class="data-card">
                    <div class="data-card-head">
                        <h3>Demandes traitées</h3>
                    </div>

                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>Département</th>
                                <th>Type</th>
                                <th>Période</th>
                                <th>Durée</th>
                                <th>Statut</th>
                                <th>Commentaire RH</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (! empty($demandes)): ?>
                                <?php foreach ($demandes as $demande): ?>
                                    <tr>
                                        <td class="td-name"><?= esc($demande['prenom'] . ' ' . $demande['nom']) ?></td>
                                        <td class="td-muted"><?= esc($demande['departement_nom'] ?? '-') ?></td>
                                        <td><span class="type-badge t-annuel"><?= esc($demande['type_conge']) ?></span></td>
                                        <td class="td-muted"><?= esc($demande['date_debut']) ?> → <?= esc($demande['date_fin']) ?></td>
                                        <td class="td-mono"><?= esc($demande['nb_jours']) ?> j</td>
                                        <td>
                                            <span class="statut s-<?= esc($demande['statut']) ?>">
                                                <?= esc($demande['statut']) ?>
                                            </span>
                                        </td>
                                        <td class="td-muted"><?= esc($demande['commentaire_rh'] ?? '-') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">
                                        <div class="empty">
                                            <i class="bi bi-archive"></i>
                                            <p>Aucune demande traitée pour le moment.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="footer-app">
                <i class="bi bi-c-circle"></i> 2026 <span>TechMada RH</span>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>