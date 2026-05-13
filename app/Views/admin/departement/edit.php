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
    </ul>
  </aside>
  <div class="main">
    <div class="topbar">
      <div>
        <div class="topbar-title">Modifier un département</div>
        <div class="topbar-breadcrumb">
          <a href="<?= site_url('admin/departements') ?>">Départements</a> › Modifier
        </div>
      </div>
    </div>
    <div class="content">

      <?php if (session()->getFlashdata('error')): ?>
      <div class="flash flash-error"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <div class="data-card" style="max-width:500px">
        <div class="data-card-head"><h3>Modifier — <?= esc($departement['nom']) ?></h3></div>
        <div style="padding:1.25rem">
          <form action="<?= site_url('admin/departements/update/' . $departement['id']) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="f-group" style="margin-bottom:1rem">
              <label class="f-label">Nom du département <span style="color:var(--danger)">*</span></label>
              <input type="text" class="f-input" name="nom"
                     value="<?= old('nom', esc($departement['nom'])) ?>"
                     required/>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn-forest">
                <i class="bi bi-check-lg"></i> Enregistrer
              </button>
              <a href="<?= site_url('admin/departements') ?>" class="btn-secondary">
                <i class="bi bi-x"></i> Annuler
              </a>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<?= $this->endSection() ?>