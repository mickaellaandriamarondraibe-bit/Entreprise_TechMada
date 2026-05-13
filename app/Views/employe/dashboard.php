<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Employé</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<section id="page-dashboard-employe" style="margin-top:3rem">
<div class="app-wrap">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon"><i class="bi bi-briefcase"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Espace employé</span></div>
    </div>
    <ul class="sidebar-nav">
         <li><a href="<?= base_url('logout') ?>" title="Déconnexion">
    <i class="bi bi-box-arrow-right"></i>
</a></li>
      <li><a href="<?= base_url('employe') ?>" class="active"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
      <li><a href="<?= base_url('employe/conges/create') ?>"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
      <li><a href="<?= base_url('employe/conges') ?>"><i class="bi bi-calendar3"></i> Mes demandes</a></li>
   
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
        <a href="<?= base_url('logout') ?>" style="margin-left:auto" title="Déconnexion">
          <i class="bi bi-box-arrow-right"></i>
        </a>
      </div>
    </div>
  </aside>

  <div class="main">
    <div class="topbar">
      <div>
        <div class="topbar-title">Tableau de bord</div>
        <div class="topbar-breadcrumb">Accueil</div>
      </div>
      <div class="topbar-actions">
        <a href="<?= base_url('employe/conges/create') ?>" class="btn-forest">
          <i class="bi bi-plus-lg"></i> Nouvelle demande
        </a>
      </div>
    </div>

    <div class="content">

      <!-- Flash messages -->
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

      <!-- Métriques depuis les vraies données -->
      <div class="metrics">
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div></div>
          <div class="metric-val"><?= $stats['en_attente'] ?></div>
          <div class="metric-label">En attente</div>
        </div>
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-green"><i class="bi bi-check-circle"></i></div></div>
          <div class="metric-val"><?= $stats['approuvee'] ?></div>
          <div class="metric-label">Approuvées</div>
        </div>
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-red"><i class="bi bi-x-circle"></i></div></div>
          <div class="metric-val"><?= $stats['refusee'] ?></div>
          <div class="metric-label">Refusées</div>
        </div>
      </div>

      <!-- Soldes de congés -->
      <div class="data-card">
        <div class="data-card-head"><h3>Mes soldes de congés — <?= date('Y') ?></h3></div>
        <div style="padding:1rem 1.25rem;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem">
          <?php foreach ($soldes as $solde): ?>
          <?php
            $restant  = $solde['jours_attribues'] - $solde['jours_pris'];
            $pourcent = $solde['jours_attribues'] > 0
                        ? round(($restant / $solde['jours_attribues']) * 100)
                        : 0;
          ?>
          <div class="solde-card" style="margin:0">
            <div class="solde-header">
              <span class="solde-type"><?= esc($solde['libelle']) ?></span>
              <span class="solde-nums"><strong><?= $restant ?></strong> / <?= $solde['jours_attribues'] ?> j</span>
            </div>
            <div class="solde-bar">
              <div class="solde-fill <?= $pourcent < 30 ? 'warn' : '' ?>" style="width:<?= $pourcent ?>%"></div>
            </div>
            <div class="solde-label"><?= $restant ?> jours restants · <?= $solde['jours_pris'] ?> pris</div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Dernières demandes -->
      <div class="data-card">
        <div class="data-card-head">
          <h3>Mes dernières demandes</h3>
          <a href="<?= base_url('employe/conges') ?>">Voir tout →</a>
        </div>
        <table class="tbl">
          <thead>
            <tr><th>Type</th><th>Du</th><th>Au</th><th>Durée</th><th>Statut</th><th>Action</th></tr>
          </thead>
          <tbody>
            <?php foreach ($dernieres_demandes as $d): ?>
            <tr>
              <td><?= esc($d['libelle']) ?></td>
              <td class="td-muted"><?= $d['date_debut'] ?></td>
              <td class="td-muted"><?= $d['date_fin'] ?></td>
              <td class="td-mono"><?= $d['nb_jours'] ?> j</td>
              <td><span class="statut s-<?= $d['statut'] ?>"><?= $d['statut'] ?></span></td>
              <td>
                <?php if ($d['statut'] === 'en_attente'): ?>
                <a href="<?= base_url('employe/conges/cancel/' . $d['id']) ?>" class="btn-sm btn-cancel">
                  <i class="bi bi-x"></i> Annuler
                </a>
                <?php else: ?>
                <span class="td-muted">—</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
</section>
</body>
</html>