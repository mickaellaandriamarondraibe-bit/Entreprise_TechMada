<?= $this->extend('layouts/rh_layout') ?>

<?= $this->section('content') ?>

<section id="page-liste-rh">
    <div class="app-wrap">

        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-logo-icon">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="sidebar-brand-name">
                    TechMada RH
                    <span>Espace responsable</span>
                </div>
            </div>

            <div class="sidebar-section">Menu</div>

            <ul class="sidebar-nav">
                <li>
                    <a href="<?= site_url('rh/dashboard') ?>">
                        <i class="bi bi-grid-1x2"></i> Tableau de bord
                    </a>
                </li>

                <li>
                    <a href="<?= site_url('rh/demandes') ?>" class="active">
                        <i class="bi bi-inbox"></i> Demandes à traiter
                        <span class="nav-badge alert"><?= count($demandes ?? []) ?></span>
                    </a>
                </li>

                <li>
                    <a href="<?= site_url('rh/historique') ?>">
                        <i class="bi bi-archive"></i> Historique
                    </a>
                </li>

                <li>
                    <a href="<?= site_url('rh/soldes') ?>">
                        <i class="bi bi-people"></i> Soldes employés
                    </a>
                </li>
            </ul>

            <div class="sidebar-user">
                <div class="s-user-row">
                    <div class="avatar av-blue">RH</div>
                    <div>
                        <div class="user-name">Responsable RH</div>
                        <div class="user-role">RH</div>
                    </div>
                    <a href="<?= site_url('logout') ?>" style="margin-left:auto;color:rgba(255,255,255,.25);font-size:1.1rem">
                        <i class="bi bi-box-arrow-right"></i>
                    </a>
                </div>
            </div>
        </aside>

        <div class="main">
            <div class="topbar">
                <div>
                    <div class="topbar-title">Demandes à traiter</div>
                    <div class="topbar-breadcrumb">
                        <a href="<?= site_url('rh/dashboard') ?>">Accueil</a>
                        <i class="bi bi-chevron-right" style="font-size:.6rem"></i>
                        Demandes
                    </div>
                </div>

                <div class="topbar-actions">
                    <span style="font-size:.8rem;background:var(--warn-bg);border:1px solid var(--warn-br);border-radius:6px;padding:5px 10px;display:flex;align-items:center;gap:5px;color:var(--warn)">
                        <i class="bi bi-hourglass-split"></i>
                        <?= count($demandes ?? []) ?> en attente
                    </span>
                </div>
            </div>

            <div class="content">

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="flash flash-success">
                        <i class="bi bi-check-circle-fill"></i>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="flash flash-error">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div style="display:flex;gap:8px;margin-bottom:1.25rem;flex-wrap:wrap">
                    <a href="<?= site_url('rh/demandes') ?>"
   class="<?= ($statutActif ?? 'tous') === 'tous' ? 'btn-forest' : 'btn-secondary' ?>"
   style="border-radius:20px;font-size:.8rem">
    Tous
</a>

<a href="<?= site_url('rh/demandes?statut=en_attente') ?>"
   class="<?= ($statutActif ?? '') === 'en_attente' ? 'btn-forest' : 'btn-secondary' ?>"
   style="border-radius:20px;font-size:.8rem">
    En attente
</a>

<a href="<?= site_url('rh/demandes?statut=approuvee') ?>"
   class="<?= ($statutActif ?? '') === 'approuvee' ? 'btn-forest' : 'btn-secondary' ?>"
   style="border-radius:20px;font-size:.8rem">
    Approuvées
</a>

<a href="<?= site_url('rh/demandes?statut=refusee') ?>"
   class="<?= ($statutActif ?? '') === 'refusee' ? 'btn-forest' : 'btn-secondary' ?>"
   style="border-radius:20px;font-size:.8rem">
    Refusées
</a>
                </div>

                <div class="data-card">
                    <div class="data-card-head">
                        <h3>Toutes les demandes</h3>
                    </div>

                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Employé</th>
                                <th>Type</th>
                                <th>Période</th>
                                <th>Durée</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (! empty($demandes)): ?>
                                <?php foreach ($demandes as $demande): ?>
                                    <tr>
                                        <td>
                                            <div class="profile-row">
                                                <div class="avatar av-green" style="width:32px;height:32px;font-size:.7rem">
                                                    <?= strtoupper(substr($demande['prenom'], 0, 1) . substr($demande['nom'], 0, 1)) ?>
                                                </div>
                                                <div class="profile-info">
                                                    <div class="pname">
                                                        <?= esc($demande['prenom'] . ' ' . $demande['nom']) ?>
                                                    </div>
                                                    <div class="pdept">
                                                        <?= esc($demande['departement_nom'] ?? 'Département') ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="type-badge t-annuel">
                                                <?= esc($demande['type_conge']) ?>
                                            </span>
                                        </td>

                                        <td class="td-muted" style="font-size:.8rem">
                                            <?= esc($demande['date_debut']) ?> → <?= esc($demande['date_fin']) ?>
                                        </td>

                                        <td class="td-mono">
                                            <?= esc($demande['nb_jours']) ?> j
                                        </td>

                                        <td>
                                            <span class="statut s-attente">
                                                <?= esc($demande['statut']) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <?php if ($demande['statut'] === 'en_attente'): ?>
                                                <div class="action-btns">
                                                    <a href="<?= site_url('rh/approuver/' . $demande['id']) ?>" class="btn-sm btn-approve">
                                                        <i class="bi bi-check-lg"></i> Approuver
                                                    </a>

                                                    <form action="<?= site_url('rh/refuser/' . $demande['id']) ?>" method="post" style="display:inline">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="commentaire_rh" value="Demande refusée par le responsable RH">
                                                        <button type="submit" class="btn-sm btn-refuse">
                                                            <i class="bi bi-x-lg"></i> Refuser
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <span class="td-muted" style="font-size:.75rem">
                                                    Déjà traité
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="empty">
                                            <i class="bi bi-inbox"></i>
                                            <p>Aucune demande à traiter pour le moment.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="footer-app">
                <i class="bi bi-c-circle"></i>
                2026 <span>TechMada RH</span> — Projet CodeIgniter 4
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>  