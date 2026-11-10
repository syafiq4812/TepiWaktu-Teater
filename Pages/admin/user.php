<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <p class="section-eyebrow mb-1">Pengguna</p>
        <h5 class="fw-bold mb-0" style="font-family: var(--font-display);">Database Member &amp; Staff</h5>
    </div>
</div>

<?php
$users = $objUser->ShowAllUsers();
if (mysqli_num_rows($users) > 0):
?>
<div class="table-responsive">
    <table class="table table-dark table-hover align-middle mb-0">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Nama Lengkap</th>
                <th>Email Akun</th>
                <th>Hak Akses (Role)</th>
                <th class="text-end" width="18%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($u = mysqli_fetch_assoc($users)): ?>
            <tr>
                <td class="text-secondary small">#<?php echo (int) $u['userid']; ?></td>
                <td class="fw-semibold"><?php echo htmlspecialchars($u['name']); ?></td>
                <td class="text-secondary"><?php echo htmlspecialchars($u['email']); ?></td>
                <td>
                    <?php
                        $badgeColor = 'background: rgba(56,189,248,0.15); color: var(--info);';
                        if ($u['role'] == 'admin') {
                            $badgeColor = 'background: rgba(248,113,113,0.15); color: var(--danger);';
                        } else if ($u['role'] == 'manager') {
                            $badgeColor = 'background: rgba(251,191,36,0.15); color: var(--warning);';
                        } else if ($u['role'] == 'employee') {
                            $badgeColor = 'background: rgba(52,211,153,0.15); color: var(--success);';
                        }
                    ?>
                    <span class="badge" style="<?php echo $badgeColor; ?>">
                        <?php echo htmlspecialchars(strtoupper($u['role'])); ?>
                    </span>
                </td>
                <td class="text-end">
                    <a href="dashboardadmin.php?page=edituser&id=<?php echo (int) $u['userid']; ?>"
                       class="btn btn-sm btn-outline-warning me-1">
                        <i class="bi bi-pencil-square me-1"></i>Edit
                    </a>
                    <a href="dashboardadmin.php?page=hapususer&id=<?php echo (int) $u['userid']; ?>"
                       class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('Peringatan: Yakin ingin menghapus user ini secara permanen?')">
                        <i class="bi bi-trash me-1"></i>Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
<div class="text-center py-5">
    <i class="bi bi-people fs-1 text-secondary opacity-50"></i>
    <p class="text-secondary mt-3 mb-0">Belum ada user terdaftar.</p>
</div>
<?php endif; ?>
