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
      <li><a href="<?= site_url('admin/employes') ?>"><i class="bi bi-people"></i> Employés</a></li>
      <li><a href="<?= site_url('admin/departements') ?>" class="active"><i class="bi bi-diagram-3"></i> Départements</a></li>
      <a href="<?= base_url('logout') ?>" title="Déconnexion">
    <i class="bi bi-box-arrow-right"></i>
</a>
    </ul>
  </aside>
  <div class="main">
    <div class="topbar">
      <div>
        <div class="topbar-title">Gestion des départements</div>
        <div class="topbar-breadcrumb">Admin › Départements</div>
      </div>
      <div class="topbar-actions">
        <a href="<?= site_url('admin/departements/create') ?>" class="btn-forest">
          <i class="bi bi-plus-lg"></i> Ajouter
        </a>
      </div>
    </div>
    <div class="content">

      <?php if (session()->getFlashdata('success')): ?>
      <div class="flash flash-success"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')): ?>
      <div class="flash flash-error"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <div class="data-card">
        <div class="data-card-head"><h3>Liste des départements</h3></div>
        <table class="tbl">
          <thead>
            <tr><th>ID</th><th>Nom</th><th>Actions</th></tr>
          </thead>
          <tbody>
            <?php if (empty($departements)): ?>
            <tr><td colspan="3">Aucun département.</td></tr>
            <?php else: ?>
            <?php foreach ($departements as $dep): ?>
            <tr>
              <td class="td-mono"><?= $dep['id'] ?></td>
              <td><?= esc($dep['nom']) ?></td>
              <td>
                <a href="<?= site_url('admin/departements/edit/' . $dep['id']) ?>" class="btn-sm btn-edit">
                  <i class="bi bi-pencil"></i> Modifier
                </a>
                <a href="<?= site_url('admin/departements/delete/' . $dep['id']) ?>"
                   class="btn-sm btn-del"
                   onclick="return confirm('Supprimer ce département ?')">
                  <i class="bi bi-trash"></i> Supprimer
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
<?= $this->endSection() ?>