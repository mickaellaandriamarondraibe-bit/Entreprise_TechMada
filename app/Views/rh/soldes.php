<?= $this->extend('layouts/rh_layout') ?>

<?= $this->section('content') ?>

<section id="page-rh-soldes">
    <div class="app-wrap">

        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-logo-icon"><i class="bi bi-person-check"></i></div>
                <div class="sidebar-brand-name">TechMada RH<span>Espace responsable</span></div>
            </div>

            <div class="sidebar-section">Menu</div>

            <ul class="sidebar-nav">
                <li><a href="<?= site_url('rh/demandes') ?>"><i class="bi bi-inbox"></i> Demandes à traiter</a></li>
                <li><a href="<?= site_url('rh/soldes') ?>" class="active"><i class="bi bi-people"></i> Soldes employés</a></li>
            </ul>
        </aside>

        <div class="main">
            <div class="topbar">
                <div>
                    <div class="topbar-title">Soldes des employés</div>
                    <div class="topbar-breadcrumb">RH <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Soldes</div>
                </div>
            </div>

            <div class="content">
                <div class="data-card">
                    <div class="data-card-head">
                        <h3>Soldes de congés</h3>
                    </div>

                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>Département</th>
                                <th>Type congé</th>
                                <th>Année</th>
                                <th>Attribués</th>
                                <th>Pris</th>
                                <th>Restants</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($soldes as $solde): ?>
                                <?php $restants = $solde['jours_attribues'] - $solde['jours_pris']; ?>

                                <tr>
                                    <td class="td-name">
                                        <?= esc($solde['prenom'] . ' ' . $solde['nom']) ?>
                                    </td>
                                    <td class="td-muted">
                                        <?= esc($solde['departement_nom'] ?? '-') ?>
                                    </td>
                                    <td>
                                        <span class="type-badge t-annuel">
                                            <?= esc($solde['type_conge']) ?>
                                        </span>
                                    </td>
                                    <td class="td-mono"><?= esc($solde['annee']) ?></td>
                                    <td class="td-mono"><?= esc($solde['jours_attribues']) ?> j</td>
                                    <td class="td-mono"><?= esc($solde['jours_pris']) ?> j</td>
                                    <td class="td-mono">
                                        <strong><?= esc($restants) ?> j</strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($soldes)): ?>
                                <tr>
                                    <td colspan="7">
                                        <div class="empty">
                                            <i class="bi bi-inbox"></i>
                                            <p>Aucun solde trouvé.</p>
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