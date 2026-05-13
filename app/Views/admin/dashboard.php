<?= $this->extend('layouts/rh_layout') ?>
<?= $this->section('content') ?>

<section id="page-dashboard-admin">
    <div class="app-wrap">

        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-logo-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="sidebar-brand-name">
                    TechMada RH
                    <span>Administration</span>
                </div>
            </div>

            <div class="sidebar-section">Gestion</div>

            <ul class="sidebar-nav">
                <li><a href="<?= site_url('admin/dashboard') ?>" class="active"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
                <li><a href="<?= site_url('admin/employes') ?>"><i class="bi bi-people"></i> Employés</a></li>
                <li><a href="<?= site_url('admin/soldes') ?>"><i class="bi bi-sliders"></i> Soldes annuels</a></li>
                <li><a href="<?= site_url('admin/departements') ?>"><i class="bi bi-sliders"></i> Departements</a></li>
            </ul>
        </aside>

        <div class="main">
            <div class="topbar">
                <div>
                    <div class="topbar-title">Vue d'ensemble</div>
                    <div class="topbar-breadcrumb">Administration</div>
                </div>
            </div>

            <div class="content">

                <div class="metrics">
                    <div class="metric">
                        <div class="metric-top">
                            <div class="metric-icon mi-forest"><i class="bi bi-people"></i></div>
                        </div>
                        <div class="metric-val"><?= esc($nbEmployes) ?></div>
                        <div class="metric-label">Employés actifs</div>
                    </div>

                    <div class="metric">
                        <div class="metric-top">
                            <div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div>
                        </div>
                        <div class="metric-val"><?= esc($nbAttente) ?></div>
                        <div class="metric-label">Demandes en attente</div>
                    </div>

                    <div class="metric">
                        <div class="metric-top">
                            <div class="metric-icon mi-green"><i class="bi bi-check-circle"></i></div>
                        </div>
                        <div class="metric-val"><?= esc($nbApprouvees) ?></div>
                        <div class="metric-label">Demandes approuvées</div>
                    </div>

                    <div class="metric">
                        <div class="metric-top">
                            <div class="metric-icon mi-red"><i class="bi bi-x-circle"></i></div>
                        </div>
                        <div class="metric-val"><?= esc($nbRefusees) ?></div>
                        <div class="metric-label">Demandes refusées</div>
                    </div>
                </div>

                <div class="data-card">
                    <div class="data-card-head">
                        <h3>Demandes récentes</h3>
                    </div>

                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>Type</th>
                                <th>Période</th>
                                <th>Durée</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (! empty($demandesRecentes)): ?>
                                <?php foreach ($demandesRecentes as $demande): ?>
                                    <tr>
                                        <td class="td-name"><?= esc($demande['prenom'] . ' ' . $demande['nom']) ?></td>
                                        <td><span class="type-badge t-annuel"><?= esc($demande['type_conge']) ?></span></td>
                                        <td class="td-muted"><?= esc($demande['date_debut']) ?> → <?= esc($demande['date_fin']) ?></td>
                                        <td class="td-mono"><?= esc($demande['nb_jours']) ?> j</td>
                                        <td>
                                            <span class="statut s-<?= esc($demande['statut']) ?>">
                                                <?= esc($demande['statut']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">
                                        <div class="empty">
                                            <i class="bi bi-inbox"></i>
                                            <p>Aucune demande récente.</p>
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