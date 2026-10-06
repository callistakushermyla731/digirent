<?php
require_once '../includes/auth.php';
require_once '../includes/koneksi.php';
$page=max(1,(int)($_GET['page']??1)); $per_page=10; $offset=($page-1)*$per_page;
$total=(int)$pdo->query('select count(*) from pelanggan')->fetchColumn();
$stmt=$pdo->prepare('select id,nama,email,no_hp,alamat from pelanggan order by id desc limit :limit offset :offset');
$stmt->bindValue(':limit',$per_page,PDO::PARAM_INT); $stmt->bindValue(':offset',$offset,PDO::PARAM_INT); $stmt->execute(); $data=$stmt->fetchAll(); $total_pages=max(1,(int)ceil($total/$per_page));
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Daftar Pelanggan - DIGIRENT</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>
<?php include '../includes/header.php'; ?><main class="container">
<?php if(isset($_SESSION['pesan'])):?><div class="alert alert-success"><?=htmlspecialchars($_SESSION['pesan'])?></div><?php unset($_SESSION['pesan']);endif;?>
<?php if(isset($_SESSION['error'])):?><div class="alert alert-danger"><?=htmlspecialchars($_SESSION['error'])?></div><?php unset($_SESSION['error']);endif;?>
<div class="table-card"><div class="table-header"><div><h2>Daftar Pelanggan</h2><p>CRUD lengkap dengan PostgreSQL.</p></div><?php if(isset($_SESSION['user_id'])):?><a href="tambah.php" class="btn-pink">+ Tambah Pelanggan</a><?php endif;?></div>
<div class="table-responsive"><table><thead><tr><th>No</th><th>Nama</th><th>Email</th><th>No. HP</th><th>Alamat</th><th>Aksi</th></tr></thead><tbody>
<?php if($data):$no=$offset+1;foreach($data as $row):?><tr><td><?=$no++?></td><td><?=htmlspecialchars($row['nama'])?></td><td><?=htmlspecialchars($row['email'])?></td><td><?=htmlspecialchars($row['no_hp'])?></td><td><?=htmlspecialchars($row['alamat'])?></td><td class="actions"><?php if(isset($_SESSION['user_id'])):?><a href="edit.php?id=<?=(int)$row['id']?>" class="btn-action btn-edit">Edit</a><form action="hapus.php" method="post" class="inline-form" onsubmit="return confirm('Yakin ingin menghapus data pelanggan ini?');"><input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>"><input type="hidden" name="id" value="<?=(int)$row['id']?>"><button type="submit" class="btn-action btn-delete">Hapus</button></form><?php else:?>-<?php endif;?></td></tr><?php endforeach;else:?><tr><td colspan="6" class="empty-state">Belum ada pelanggan.</td></tr><?php endif;?></tbody></table></div>
<?php if($total_pages>1):?><div class="pagination"><?php for($i=1;$i<=$total_pages;$i++):?><a class="<?=$i===$page?'active':''?>" href="?page=<?=$i?>"><?=$i?></a><?php endfor;?></div><?php endif;?></div></main><?php include '../includes/footer.php';?></body></html>
