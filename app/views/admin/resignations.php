<?php 
    $title = 'Senarai Permohonan Berhenti';
    require_once '../app/views/layouts/header.php';
?>

<div class="container-fluid mt-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0">
            <h5 class="card-title mb-0">
                <i class="bi bi-list-ul me-2"></i>
                Senarai Permohonan Berhenti
            </h5>
        </div>
        <div class="card-body">
            <?php if (empty($resignations)): ?>
                <div class="text-center py-4">
                    <p class="text-muted mb-0">Tiada permohonan berhenti</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Ahli</th>
                                <th>Nama</th>
                                <th>Tarikh Mohon</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resignations as $resignation): ?>
                                <tr>
                                    <td><?= htmlspecialchars($resignation['member_id']) ?></td>
                                    <td><?= htmlspecialchars($resignation['name']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($resignation['resignation_date'])) ?></td>
                                    <td>
                                        <form action="/admin/resignations/approve" method="POST" class="d-inline">
                                            <input type="hidden" name="member_id" value="<?= $resignation['id'] ?>">
                                            <button type="submit" class="btn btn-success btn-sm" 
                                                    onclick="return confirm('Adakah anda pasti untuk meluluskan permohonan ini?')">
                                                <i class="bi bi-check-circle me-2"></i>Lulus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?> 