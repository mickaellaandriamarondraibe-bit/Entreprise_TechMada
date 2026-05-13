<?= $this->extend('layouts/rh_layout') ?>
<?= $this->section('content') ?>

<?php
$isEdit = $mode === 'edit';
$action = $isEdit
    ? site_url('admin/employes/update/' . $employe['id'])
    : site_url('admin/employes/store');
?>

<div class="app-wrap">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo-icon"><i class="bi bi-shield-check"></i></div>
            <div class="sidebar-brand-name">TechMada RH<span>Administration</span></div>
        </div>

        <ul class="sidebar-nav" style="margin-top:1rem">
            <li><a href="<?= site_url('admin/dashboard') ?>"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
            <li><a href="<?= site_url('admin/employes') ?>" class="active"><i class="bi bi-people"></i> Employés</a></li>
        <a href="<?= base_url('logout') ?>" title="Déconnexion">
    <i class="bi bi-box-arrow-right"></i>
</a>
        </ul>
    </aside>

    <div class="main">
        <div class="topbar">
            <div>
                <div class="topbar-title"><?= $isEdit ? 'Modifier employé' : 'Ajouter employé' ?></div>
                <div class="topbar-breadcrumb">Admin > Employés</div>
            </div>
        </div>

        <div class="content">
            <form action="<?= $action ?>" method="post" class="form-section">
                <?= csrf_field() ?>

                <h3>Informations employé</h3>

                <div class="form-grid-2">
                    <div class="f-group">
                        <label class="f-label">Nom</label>
                        <input class="f-input" type="text" name="nom" value="<?= esc($employe['nom'] ?? '') ?>" required>
                    </div>

                    <div class="f-group">
                        <label class="f-label">Prénom</label>
                        <input class="f-input" type="text" name="prenom" value="<?= esc($employe['prenom'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="f-group">
                    <label class="f-label">Email</label>
                    <input class="f-input" type="email" name="email" value="<?= esc($employe['email'] ?? '') ?>" required>
                </div>

                <div class="f-group">
                    <label class="f-label">Mot de passe <?= $isEdit ? '(laisser vide si inchangé)' : '' ?></label>
                    <input class="f-input" type="password" name="password" <?= $isEdit ? '' : 'required' ?>>
                </div>

                <div class="form-grid-2">
                    <div class="f-group">
                        <label class="f-label">Rôle</label>
                        <select class="f-select" name="role" required>
                            <?php $role = $employe['role'] ?? 'employee'; ?>
                            <option value="employee" <?= $role === 'employee' ? 'selected' : '' ?>>Employé</option>
                            <option value="rh" <?= $role === 'rh' ? 'selected' : '' ?>>RH</option>
                            <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>

                    <div class="f-group">
                        <label class="f-label">Département ID</label>
                        <input class="f-input" type="number" name="departement_id" value="<?= esc($employe['departement_id'] ?? 1) ?>" required>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="f-group">
                        <label class="f-label">Date embauche</label>
                        <input class="f-input" type="date" name="date_embauche" value="<?= esc($employe['date_embauche'] ?? date('Y-m-d')) ?>">
                    </div>

                    <div class="f-group">
                        <label class="f-label">Actif</label>
                        <select class="f-select" name="actif">
                            <?php $actif = $employe['actif'] ?? 1; ?>
                            <option value="1" <?= (int)$actif === 1 ? 'selected' : '' ?>>Oui</option>
                            <option value="0" <?= (int)$actif === 0 ? 'selected' : '' ?>>Non</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-forest">
                        <?= $isEdit ? 'Modifier' : 'Créer' ?>
                    </button>
                    <a href="<?= site_url('admin/employes') ?>" class="btn-secondary">Retour</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>