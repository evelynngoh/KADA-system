<?php 
    require_once '../app/views/layouts/header.php';
?>
<link rel="stylesheet" href="/css/director.css">
<div class="container-fluid mt-4">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Stats Cards -->
        <div class="col-12 mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stats-icon bg-warning bg-opacity-10 me-3">
                                <i class="bi bi-clock-history text-warning"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle text-muted mb-1">Menunggu Kelulusan</h6>
                                <div class="d-flex align-items-baseline">
                                    <h3 class="card-title mb-0"><?= $metrics['loan_stats']['pending_count'] ?? 0 ?></h3>
                                    <small class="text-muted ms-2">permohonan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stats-icon bg-success bg-opacity-10 me-3">
                                <i class="bi bi-check-circle text-success"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle text-muted mb-1">Diluluskan</h6>
                                <div class="d-flex align-items-baseline">
                                    <h3 class="card-title mb-0"><?= $metrics['loan_stats']['approved_loans'] ?? 0 ?></h3>
                                    <small class="text-muted ms-2">permohonan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stats-icon bg-danger bg-opacity-10 me-3">
                                <i class="bi bi-x-circle text-danger"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle text-muted mb-1">Ditolak</h6>
                                <div class="d-flex align-items-baseline">
                                    <h3 class="card-title mb-0"><?= $metrics['loan_stats']['rejected_count'] ?? 0 ?></h3>
                                    <small class="text-muted ms-2">permohonan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <h4 class="card-title mb-0">
                                    <i class="bi bi-file-text me-2"></i>Senarai Permohonan
                                </h4>
                                <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary">
                                    <?= count($loans) ?> permohonan
                                </span>
                            </div>
                            <p class="text-muted small mb-0 mt-1">Urus permohonan pembiayaan ahli koperasi</p>
                        </div>
                        <div class="d-flex gap-2">
                            <div class="status-filter">
                                <select class="form-select shadow-sm" id="statusFilter" onchange="filterLoans(this.value)">
                                    <option value="pending" <?= ($_GET['status'] ?? 'pending') === 'pending' ? 'selected' : '' ?>>
                                        <i class="bi bi-clock-history"></i> Menunggu Kelulusan
                                    </option>
                                    <option value="approved" <?= ($_GET['status'] ?? '') === 'approved' ? 'selected' : '' ?>>
                                        <i class="bi bi-check-circle"></i> Diluluskan
                                    </option>
                                    <option value="rejected" <?= ($_GET['status'] ?? '') === 'rejected' ? 'selected' : '' ?>>
                                        <i class="bi bi-x-circle"></i> Ditolak
                                    </option>
                                </select>
                            </div>
                            <a href="/director" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th class="bg-light">No. Rujukan</th>
                                    <th class="bg-light">Nama Pemohon</th>
                                    <th class="bg-light">No. K/P</th>
                                    <th class="bg-light">Jenis</th>
                                    <th class="bg-light">Jumlah (RM)</th>
                                    <th class="bg-light">Tempoh</th>
                                    <th class="bg-light">Tarikh Mohon</th>
                                    <th class="bg-light">Status</th>
                                    <th class="bg-light text-end">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php if (empty($loans)): ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="bi bi-folder2-open display-6 text-muted"></i>
                                                <p class="text-muted mb-0 mt-3">Tiada permohonan pembiayaan baharu</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($loans as $loan): ?>
                                        <tr>
                                            <td>
                                                <span class="fw-medium"><?= htmlspecialchars($loan['reference_no']) ?></span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <span class="fw-medium"><?= htmlspecialchars($loan['member_name']) ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($loan['ic_no']) ?></td>
                                            <td>
                                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                                    <?= htmlspecialchars($loan['loan_type']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">
                                                    <?= number_format($loan['amount'], 2) ?>
                                                </span>
                                            </td>
                                            <td><?= htmlspecialchars($loan['duration']) ?> bulan</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-calendar3 text-muted"></i>
                                                    <span><?= date('d/m/Y', strtotime($loan['date_received'])) ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <?php
                                                $statusBadge = match($loan['status']) {
                                                    'pending' => '<span class="badge bg-warning bg-opacity-10 text-warning">Menunggu Kelulusan</span>',
                                                    'approved' => '<span class="badge bg-success bg-opacity-10 text-success">Diluluskan</span>',
                                                    'rejected' => '<span class="badge bg-danger bg-opacity-10 text-danger">Ditolak</span>',
                                                    default => '<span class="badge bg-secondary bg-opacity-10 text-secondary">-</span>'
                                                };
                                                echo $statusBadge;
                                                ?>
                                            </td>
                                            <td class="text-end">
                                                <?php if ($loan['status'] === 'pending'): ?>
                                                    <button onclick="showLoanDetails(<?= htmlspecialchars(json_encode($loan)) ?>)" 
                                                            class="btn btn-sm btn-light me-1">
                                                        <i class="bi bi-eye me-1"></i>Lihat
                                                    </button>
                                                    <button onclick="showReviewModal(<?= $loan['id'] ?>)" 
                                                            class="btn btn-sm btn-primary">
                                                        <i class="bi bi-pencil-square me-1"></i>Semak
                                                    </button>
                                                <?php else: ?>
                                                    <button onclick="showLoanDetails(<?= htmlspecialchars(json_encode($loan)) ?>)" 
                                                            class="btn btn-sm btn-light">
                                                        <i class="bi bi-eye me-1"></i>Lihat
                                                    </button>
                                                <?php endif; ?>
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
    </div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/director/loans/update-status" method="POST">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Semak Permohonan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="loan_id" id="loanId">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="" disabled>Pilih Status</option>
                            <option value="pending">Dalam Proses</option>
                            <option value="approved">Lulus</option>
                            <option value="rejected">Tolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="remarks" class="form-control" rows="3" placeholder="Masukkan catatan jika ada..."></textarea>
                    </div>
                    <?php if (isset($_SESSION['csrf_token'])): ?>
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <?php endif; ?>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check2 me-1"></i>Hantar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add this after the Review Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="bi bi-file-text me-2"></i>Maklumat Permohonan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Applicant Details -->
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-3 text-muted">Maklumat Pemohon</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">Nama</label>
                                        <span id="memberName" class="fw-medium"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">No. K/P</label>
                                        <span id="memberIC" class="fw-medium"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Loan Details -->
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-3 text-muted">Maklumat Pembiayaan</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">No. Rujukan</label>
                                        <span id="referenceNo" class="fw-medium"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">Jenis Pembiayaan</label>
                                        <span id="loanType" class="badge bg-primary bg-opacity-10 text-primary"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">Jumlah (RM)</label>
                                        <span id="loanAmount" class="fw-medium"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">Tempoh</label>
                                        <span id="duration" class="fw-medium"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">Bayaran Bulanan (RM)</label>
                                        <span id="monthlyPayment" class="fw-medium"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">Tarikh Mohon</label>
                                        <span id="dateReceived" class="fw-medium"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Details -->
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-3 text-muted">Maklumat Bank</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">Nama Bank</label>
                                        <span id="bankName" class="fw-medium"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small text-muted d-block">No. Akaun</label>
                                        <span id="bankAccount" class="fw-medium"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showReviewModal(loanId) {
        document.getElementById('loanId').value = loanId;
        new bootstrap.Modal(document.getElementById('reviewModal')).show();
    }

    function filterLoans(status) {
        window.location.href = `/director/loans?status=${status}`;
    }

    function showLoanDetails(loan) {
        // Update modal fields with loan details
        document.getElementById('memberName').textContent = loan.member_name;
        document.getElementById('memberIC').textContent = loan.ic_no;
        document.getElementById('referenceNo').textContent = loan.reference_no;
        document.getElementById('loanType').textContent = loan.loan_type;
        document.getElementById('loanAmount').textContent = parseFloat(loan.amount).toLocaleString('en-MY', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.getElementById('duration').textContent = loan.duration + ' bulan';
        document.getElementById('monthlyPayment').textContent = parseFloat(loan.monthly_payment).toLocaleString('en-MY', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.getElementById('dateReceived').textContent = new Date(loan.date_received).toLocaleDateString('ms-MY');
        document.getElementById('bankName').textContent = loan.bank_name;
        document.getElementById('bankAccount').textContent = loan.bank_account;

        // Show the modal
        new bootstrap.Modal(document.getElementById('detailsModal')).show();
    }
</script>

<?php require_once '../app/views/layouts/footer.php'; ?>