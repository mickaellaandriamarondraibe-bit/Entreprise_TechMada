<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes demandes</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<section id="page-mes-conges" style="margin-top:3rem">
<div class="app-wrap">

  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon"><i class="bi bi-briefcase"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Espace employé</span></div>
    </div>
    <ul class="sidebar-nav" style="margin-top:1rem">
      <li><a href="<?= base_url('employe') ?>"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
      <li><a href="<?= base_url('employe/conges/create') ?>"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
      <li><a href="<?= base_url('employe/conges') ?>" class="active"><i class="bi bi-calendar3"></i> Mes demandes</a></li>
    </ul>
    <div class="sidebar-user">
      <div class="s-user-row">
        <div class="avatar av-green">
          <?= strtoupper(substr(session()->get('prenom'), 0, 1)) . strtoupper(substr(session()->get('nom'), 0, 1)) ?>
        </div>
        <div>
          <div class="user-name"><?= session()->get('prenom') ?> <?= session()->get('nom') ?></div>
          <div class="user-role">Employé</div>
        </div>
        <a href="<?= base_url('logout') ?>" title="Déconnexion" style="margin-left:auto">
          <i class="bi bi-box-arrow-right"></i>
        </a>
      </div>
    </div>
  </aside>

  <div class="main">
    <div class="topbar">
      <div>
        <div class="topbar-title">Mes demandes de congé</div>
        <div class="topbar-breadcrumb">
          <a href="<?= base_url('employe') ?>">Accueil</a> › Mes demandes
        </div>
      </div>
      <div class="topbar-actions">
        <a href="<?= base_url('employe/conges/create') ?>" class="btn-forest">
          <i class="bi bi-plus-lg"></i> Nouvelle demande
        </a>
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

      <div class="data-card">
        <div class="data-card-head">
          <h3>Toutes mes demandes</h3>
        </div>
        <table class="tbl">
          <thead>
            <tr>
              <th>Type</th><th>Début</th><th>Fin</th>
              <th>Durée</th><th>Statut</th><th>Commentaire RH</th><th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($demandes)): ?>
            <tr>
              <td colspan="7" style="text-align:center;color:var(--muted)">
                Aucune demande pour l'instant.
              </td>
            </tr>
            <?php else: ?>
            <?php foreach ($demandes as $d): ?>
            <tr>
              <td><span class="type-badge"><?= esc($d['libelle']) ?></span></td>
              <td class="td-muted"><?= esc($d['date_debut']) ?></td>
              <td class="td-muted"><?= esc($d['date_fin']) ?></td>
              <td class="td-mono"><?= $d['nb_jours'] ?> j</td>
              <td><span class="statut s-<?= $d['statut'] ?>"><?= $d['statut'] ?></span></td>
              <td style="font-size:.78rem">
                <?= $d['commentaire_rh'] ? esc($d['commentaire_rh']) : '—' ?>
              </td>
              <td>
                <?php if ($d['statut'] === 'en_attente'): ?>
                <a href="<?= base_url('employe/conges/cancel/' . $d['id']) ?>"
                   class="btn-sm btn-cancel"
                   onclick="return confirm('Annuler cette demande ?')">
                  <i class="bi bi-x"></i> Annuler
                </a>
                <?php else: ?>
                <span class="td-muted">—</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>
    <div class="footer-app"><i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span></div>
  </div>

</div>
</section>
</body>
</html>