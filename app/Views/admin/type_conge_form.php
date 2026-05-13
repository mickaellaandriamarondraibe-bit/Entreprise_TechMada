<?= $this->extend('layouts/rh_layout') ?>
<?= $this->section('content') ?>

<?php
$isEdit = $mode === 'edit';
$action = $isEdit
    ? site_url('admin/types-conge/update/' . $type['id'])
    : site_url('admin/types-conge/store');
?>

<div class="app-wrap">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo-icon"><i class="bi bi-shield-check"></i></div>
            <div class="sidebar-brand-name">TechMada RH<span>Administration</span></div>
        </div>
        <ul class="sidebar-nav" style="margin-top:1rem">
            <li><a href="<?= site_url('admin/dashboard') ?>"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
            <li><a href="<?= site_url('admin/employes') ?>"><i class="bi bi-people"></i> Employés</a></li>
            <li><a href="<?= site_url('admin/types-conge') ?>" class="active"><i class="bi bi-tags"></i> Types de congé</a></li>
        </ul>
    </aside>

    <div class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title"><?= $isEdit ? 'Modifier type de congé' : 'Ajouter type de congé' ?></div>
                <div class="topbar-breadcrumb">Admin > Types de congé</div>
            </div>
        </div>

        <div class="content">
            <form action="<?= $action ?>" method="post" class="form-section">
                <?= csrf_field() ?>

                <h3>Informations du type de congé</h3>

                <div class="f-group">
                    <label class="f-label">Libellé</label>
                    <input class="f-input" type="text" name="libelle" value="<?= esc($type['libelle'] ?? '') ?>" required>
                </div>

                <div class="f-group">
                    <label class="f-label">Jours annuels</label>
                    <input class="f-input" type="number" name="jours_annuels" value="<?= esc($type['jours_annuels'] ?? 0) ?>" required>
                </div>

                <div class="f-group">
                    <label class="f-label">Déductible du solde ?</label>
                    <?php $deductible = $type['deductible'] ?? 1; ?>
                    <select class="f-select" name="deductible">
                        <option value="1" <?= (int)$deductible === 1 ? 'selected' : '' ?>>Oui</option>
                        <option value="0" <?= (int)$deductible === 0 ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-forest"><?= $isEdit ? 'Modifier' : 'Créer' ?></button>
                    <a href="<?= site_url('admin/types-conge') ?>" class="btn-secondary">Retour</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>