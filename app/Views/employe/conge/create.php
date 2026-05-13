<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<section id="page-form-conge" style="margin-top:3rem">
<div class="app-wrap">

  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon"><i class="bi bi-briefcase"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Espace employé</span></div>
    </div>
    <ul class="sidebar-nav" style="margin-top:1rem">
      <li><a href="<?= base_url('employe') ?>"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
      <li><a href="<?= base_url('employe/conges/create') ?>" class="active"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
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
        <a href="<?= base_url('logout') ?>" title="Déconnexion" style="margin-left:auto">
          <i class="bi bi-box-arrow-right"></i>
        </a>
      </div>
    </div>
  </aside>

  <div class="main">
    <div class="topbar">
      <div>
        <div class="topbar-title">Nouvelle demande de congé</div>
        <div class="topbar-breadcrumb">
          <a href="<?= base_url('employe') ?>">Accueil</a> › Nouvelle demande
        </div>
      </div>
    </div>

    <div class="content">

      <?php if (session()->getFlashdata('error')): ?>
      <div class="flash flash-error">
        <i class="bi bi-exclamation-circle-fill"></i>
        <?= session()->getFlashdata('error') ?>
      </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('success')): ?>
      <div class="flash flash-success">
        <i class="bi bi-check-circle-fill"></i>
        <?= session()->getFlashdata('success') ?>
      </div>
      <?php endif; ?>

      <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start">

        <!-- Formulaire principal -->
        <div class="form-section">
          <h3>Détails de la demande</h3>

          <form action="<?= base_url('employe/conges/store') ?>" method="POST" id="formConge">
            <?= csrf_field() ?>

            <!-- Type de congé -->
            <div class="f-group" style="margin-bottom:1rem">
              <label class="f-label">Type de congé <span style="color:var(--danger)">*</span></label>
              <select class="f-select" name="type_conge_id" required>
                <option value="">-- Choisir un type --</option>
                <?php foreach ($types as $type): ?>
                <option value="<?= $type['id'] ?>"
                  <?= old('type_conge_id') == $type['id'] ? 'selected' : '' ?>>
                  <?= esc($type['libelle']) ?> (<?= $type['solde'] ?> j restants)
                </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Dates -->
            <div class="form-grid-2" style="margin-bottom:1rem">
              <div class="f-group">
                <label class="f-label">Date de début <span style="color:var(--danger)">*</span></label>
                <input type="date" class="f-input" name="date_debut" id="date_debut"
                       value="<?= old('date_debut') ?>"
                       min="<?= date('Y-m-d', strtotime('+2 days')) ?>"
                       required/>
                <div class="f-error" id="err_debut" style="display:none">
                  <i class="bi bi-exclamation-circle"></i> Choisir un jour ouvrable (lun-ven).
                </div>
              </div>
              <div class="f-group">
                <label class="f-label">Date de fin <span style="color:var(--danger)">*</span></label>
                <input type="date" class="f-input" name="date_fin" id="date_fin"
                       value="<?= old('date_fin') ?>"
                       min="<?= date('Y-m-d', strtotime('+2 days')) ?>"
                       required/>
                <div class="f-error" id="err_fin" style="display:none">
                  <i class="bi bi-exclamation-circle"></i> Choisir un jour ouvrable (lun-ven).
                </div>
              </div>
            </div>

            <!-- Calcul jours ouvrables dynamique -->
            <div class="f-computed" id="computed_jours" style="display:none">
              <div class="f-computed-num" id="nb_jours_display">0</div>
              <div class="f-computed-label">jours ouvrables calculés</div>
            </div>

            <!-- Motif -->
            <div class="f-group" style="margin-bottom:1rem">
              <label class="f-label">Motif (optionnel)</label>
              <textarea class="f-textarea" name="motif"
                        placeholder="Précisez le motif si nécessaire..."><?= old('motif') ?></textarea>
              <div class="f-hint">Le motif est visible par le responsable RH.</div>
            </div>

            <div class="form-actions">
              <button class="btn-forest" type="submit" id="btnSubmit">
                <i class="bi bi-send"></i> Soumettre la demande
              </button>
              <a href="<?= base_url('employe') ?>" class="btn-secondary">
                <i class="bi bi-x"></i> Annuler
              </a>
            </div>

          </form>
        </div>

        <!-- Panneau latéral : soldes -->
        <div style="display:flex;flex-direction:column;gap:1rem">
          <div class="data-card" style="margin:0">
            <div class="data-card-head">
              <h3><i class="bi bi-piggy-bank" style="color:var(--forest);margin-right:5px"></i>Vos soldes actuels</h3>
            </div>
            <div style="padding:.75rem 1.1rem;display:flex;flex-direction:column;gap:.75rem">
              <?php foreach ($soldes as $solde): ?>
              <?php
                $restant  = $solde['jours_attribues'] - $solde['jours_pris'];
                $pourcent = $solde['jours_attribues'] > 0
                            ? round(($restant / $solde['jours_attribues']) * 100)
                            : 0;
              ?>
              <div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                  <span style="font-size:.8rem;color:var(--ink)"><?= esc($solde['libelle']) ?></span>
                  <span style="font-size:.8rem;color:var(--forest);font-weight:500"><?= $restant ?> j</span>
                </div>
                <div class="solde-bar">
                  <div class="solde-fill <?= $pourcent < 30 ? 'warn' : '' ?>"
                       style="width:<?= $pourcent ?>%"></div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="flash flash-info" style="margin:0">
            <i class="bi bi-info-circle-fill"></i>
            <span style="font-size:.8rem">Le solde est déduit uniquement à l'approbation.</span>
          </div>

          <div style="background:var(--cream);border:1px solid var(--border);border-radius:8px;padding:.85rem 1rem">
            <div style="font-size:.78rem;font-weight:500;color:var(--ink);margin-bottom:.5rem">
              <i class="bi bi-clipboard-check" style="color:var(--forest);margin-right:5px"></i>Règles
            </div>
            <ul style="margin:0;padding-left:1rem;font-size:.75rem;color:var(--muted);line-height:1.7">
              <li>Préavis minimum : 48h avant le début</li>
              <li>Pas de chevauchement avec une demande en cours</li>
              <li>Solde insuffisant = demande refusée</li>
              <li>Weekends non comptabilisés</li>
            </ul>
          </div>
        </div>

      </div>
    </div>
    <div class="footer-app"><i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span></div>
  </div>

</div>
</section>

<script>
function isWeekend(dateStr) {
    const d = new Date(dateStr);
    const jour = d.getDay(); // 0=dim, 6=sam
    return jour === 0 || jour === 6;
}

function joursOuvrables(debut, fin) {
    let d = new Date(debut);
    let f = new Date(fin);
    let jours = 0;
    while (d <= f) {
        const j = d.getDay();
        if (j !== 0 && j !== 6) jours++;
        d.setDate(d.getDate() + 1);
    }
    return jours;
}

function validerDates() {
    const debut = document.getElementById('date_debut').value;
    const fin   = document.getElementById('date_fin').value;
    const errDebut = document.getElementById('err_debut');
    const errFin   = document.getElementById('err_fin');
    const computed = document.getElementById('computed_jours');
    const nbDisplay = document.getElementById('nb_jours_display');
    let ok = true;

    // Vérifier weekend début
    if (debut && isWeekend(debut)) {
        errDebut.style.display = 'block';
        document.getElementById('date_debut').value = '';
        ok = false;
    } else {
        errDebut.style.display = 'none';
    }

    // Vérifier weekend fin
    if (fin && isWeekend(fin)) {
        errFin.style.display = 'block';
        document.getElementById('date_fin').value = '';
        ok = false;
    } else {
        errFin.style.display = 'none';
    }

    // Calculer et afficher jours ouvrables
    if (debut && fin && ok && fin >= debut) {
        const nb = joursOuvrables(debut, fin);
        nbDisplay.textContent = nb;
        computed.style.display = 'flex';
    } else {
        computed.style.display = 'none';
    }
}

document.getElementById('date_debut').addEventListener('change', validerDates);
document.getElementById('date_fin').addEventListener('change',   validerDates);
</script>

</body>
</html>