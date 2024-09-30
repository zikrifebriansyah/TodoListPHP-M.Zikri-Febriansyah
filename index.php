<?php
session_start();

if (!isset($_SESSION['todos'])) {
  $_SESSION['todos'] = array();
}

if (isset($_POST['add_todo'])) {
  $todo = array(
    'nama' => $_POST['nama'],
    'prioritas' => $_POST['prioritas'],
    'keterangan' => $_POST['keterangan'],
    'status' => 'Belum Selesai'
  );
  $_SESSION['todos'][] = $todo;
  header('Location: index.php');
}

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  unset($_SESSION['todos'][$id]);
  header('Location: index.php');
}

if (isset($_POST['edit_todo'])) {
  $id = $_POST['id'];
  $todo = array(
    'nama' => $_POST['nama'],
    'prioritas' => $_POST['prioritas'],
    'keterangan' => $_POST['keterangan'],
    'status' => $_POST['status']
  );
  $_SESSION['todos'][$id] = $todo;
  header('Location: index.php');
}

if (isset($_GET['selesai'])) {
  $id = $_GET['selesai'];
  $_SESSION['todos'][$id]['status'] = 'Selesai';
  header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Todo List</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1><strong>TO-DO LIST</strong></h1>
    <form action="" method="post">
      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
      </div>
      <div class="form-group">
        <label for="prioritas">Prioritas</label>
        <select class="form-control" id="prioritas" name="prioritas" required>
          <option value="Tinggi">Tinggi</option>
          <option value="Sedang">Sedang</option>
          <option value="Rendah">Rendah</option>
        </select>
      </div>
      <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
      </div>
      <button type="submit" name="add_todo" class="btn btn-primary">Tambah</button>
    </form>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Prioritas</th>
          <th>Keterangan</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($_SESSION['todos'] as $id => $todo) { ?>
          <tr>
            <td><?php echo $todo['nama']; ?></td>
            <td><?php echo $todo['prioritas']; ?></td>
            <td><?php echo $todo['keterangan']; ?></td>
            <td><?php echo $todo['status']; ?></td>
            <td>
              <a href="?selesai=<?php echo $id; ?>" class="btn btn-success">Selesai</a>
              <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#editModal<?php echo $id; ?>">Edit</a>
              <a href="?delete=<?php echo $id; ?>" class="btn btn-danger">Hapus</a>
            </td>
          </tr>
          <!-- Modal Edit -->
          <div class="modal fade" id="editModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel"><strong>EDIT<strong></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="" method="post">
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $todo['nama']; ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="prioritas">Tingkat Prioritas</label>
                      <select class="form-control" id="prioritas" name="prioritas" required>
                        <option value="Tinggi" <?php if ($todo['prioritas'] == 'Tinggi') echo 'selected'; ?>>Tinggi</option>
                        <option value="Sedang" <?php if ($todo['prioritas'] == 'Sedang') echo 'selected'; ?>>Sedang</option>
                        <option value="Rendah" <?php if ($todo['prioritas'] == 'Rendah') echo 'selected'; ?>>Rendah</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="keterangan">Keterangan</label>
                      <textarea class="form-control" id="keterangan" name="keterangan" required><?php echo $todo['keterangan']; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="status">Status</label>
                      <select class="form-control" id="status" name="status" required>
                        <option value="Belum Selesai" <?php if ($todo['status'] == 'Belum Selesai') echo 'selected'; ?>>Belum Selesai</option>
                        <option value="Selesai" <?php if ($todo['status'] == 'Selesai') echo 'selected'; ?>>Selesai</option>
                      </select>
                    </div>
                    <button type="submit" name="edit_todo" class="btn btn-primary">Simpan</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>