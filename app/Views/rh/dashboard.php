<?= $this->extend('layouts/rh_layout') ?>
<?= $this->section('content') ?>

<section id="page-dashboard-rh">
    <div class="app-wrap">

        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-logo-icon"><i class="bi bi-person-check"></i></div>
                <div class="sidebar-brand-name">TechMada RH<span>Espace responsable</span></div>
            </div>

            <div class="sidebar-section">Menu</div>
            <ul class="sidebar-nav">
                <li><a href="<?= site_url('rh/dashboard') ?>" class="active"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
                <li><a href="<?= site_url('rh/demandes') ?>"><i class="bi bi-inbox"></i> Demandes à traiter</a></li>
                <li><a href="<?= site_url('rh/historique') ?>"><i class="bi bi-archive"></i> Historique</a></li>
                <li><a href="<?= site_url('rh/soldes') ?>"><i class="bi bi-people"></i> Soldes employés</a></li>
            </ul>
        </aside>

        <div class="main">
            <div class="topbar">
                <div>
                    <div class="topbar-title">Tableau de bord RH</div>
                    <div class="topbar-breadcrumb">RH</div>
                </div>
            </div>

            <div class="content">

                <div class="metrics">
                    <div class="metric">
                        <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div></div>
                        <div class="metric-val"><?= esc($nbAttente) ?></div>
                        <div class="metric-label">En attente</div>
                    </div>

                    <div class="metric">
                        <div class="metric-top"><div class="metric-icon mi-green"><i class="bi bi-check-circle"></i></div></div>
                        <div class="metric-val"><?= esc($nbApprouvees) ?></div>
                        <div class="metric-label">Approuvées</div>
                    </div>

                    <div class="metric">
                        <div class="metric-top"><div class="metric-icon mi-red"><i class="bi bi-x-circle"></i></div></div>
                        <div class="metric-val"><?= esc($nbRefusees) ?></div>
                        <div class="metric-label">Refusées</div>
                    </div>

                    <div class="metric">
                        <div class="metric-top"><div class="metric-icon mi-blue"><i class="bi bi-exclamation-triangle"></i></div></div>
                        <div class="metric-val"><?= count($soldesCritiques ?? []) ?></div>
                        <div class="metric-label">Soldes critiques</div>
                    </div>
                </div>

                <div class="data-card">
                    <div class="data-card-head">
                        <h3>Demandes récentes</h3>
                        <a href="<?= site_url('rh/demandes') ?>" style="font-size:.8rem;color:var(--forest);text-decoration:none">Tout voir →</a>
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
                                        <td><span class="statut s-<?= esc($demande['statut']) ?>"><?= esc($demande['statut']) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">
                                        <div class="empty">
                                            <i class="bi bi-inbox"></i>
                                            <p>Aucune demande trouvée.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="data-card">
                    <div class="data-card-head">
                        <h3>Soldes critiques</h3>
                        <a href="<?= site_url('rh/soldes') ?>" style="font-size:.8rem;color:var(--forest);text-decoration:none">Voir les soldes →</a>
                    </div>

                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>Type congé</th>
                                <th>Attribués</th>
                                <th>Pris</th>
                                <th>Restants</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (! empty($soldesCritiques)): ?>
                                <?php foreach ($soldesCritiques as $solde): ?>
                                    <?php $restants = $solde['jours_attribues'] - $solde['jours_pris']; ?>
                                    <tr>
                                        <td class="td-name"><?= esc($solde['prenom'] . ' ' . $solde['nom']) ?></td>
                                        <td><span class="type-badge t-annuel"><?= esc($solde['type_conge']) ?></span></td>
                                        <td class="td-mono"><?= esc($solde['jours_attribues']) ?> j</td>
                                        <td class="td-mono"><?= esc($solde['jours_pris']) ?> j</td>
                                        <td class="td-mono"><strong><?= esc($restants) ?> j</strong></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">
                                        <div class="empty">
                                            <i class="bi bi-check-circle"></i>
                                            <p>Aucun solde critique.</p>
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