<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <span class="brand-text font-weight-light">AdminLTE 2</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url('assets/img/nopalpoto.jpg'); ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Ahmad Noval Fahmi</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Gudang
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<div class="content-wrapper px-4 py-2" style="min-height: 525px;">
<div class="content-header">
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Barang List</h3>
    <div class="card-tools">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <span class="badge badge-primary">Label</span>
    </div>
    <!-- /.card-tools -->
  </div>
  <button id="add_barang">Add Barang</button>
    <table class="table table-bordered" id="barang_table">
        <thead>
            <tr>
                <th style="width: 10px;">No</th>
                <th>Kategori</th>
                <th>Barang</th>
                <th>Stok</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


    <!-- Modal for Add/Edit -->
<div id="modal_form" style="display: none;">
    <input type="hidden" id="id_barang">
    <label>Kategori ID</label><br>
    <input type="text" id="kategori_id"><br>
    <label>Barang</label><br>
    <input type="text" id="barang"><br>
    <label>Stok</label><br>
    <input type="number" id="stok"><br>
    <button id="save">Save</button>
    <button id="close">Close</button>
</div>

<script>
$(document).ready(function() {
    fetchAllBarang();

    function fetchAllBarang() {
        $.ajax({
            url: '<?php echo site_url('BarangController/barang'); ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let rows = '';
                let no = 1;
                data.forEach(function(item) {
                    rows += `<tr>
                                <td>${no++}.</td>
                                <td>${item.kategori}</td>
                                <td>${item.barang}</td>
                                <td>${item.stok}</td>
                                <td>
                                    <button class="edit_barang" data-id="${item.id_barang}">Edit</button>
                                    <button class="delete_barang" data-id="${item.id_barang}">Delete</button>
                                </td>
                             </tr>`;
                });
                $('#barang_table tbody').html(rows);
            }
        });
    }

    $('#add_barang').on('click', function() {
        $('#modal_form').show();
        $('#id_barang').val('');
        $('#kategori_id').val('');
        $('#barang').val('');
        $('#stok').val('');
    });

    // Create / Update
    $('#save').on('click', function() {
        const id = $('#id_barang').val();
        const kategori_id = $('#kategori_id').val();
        const barang = $('#barang').val();
        const stok = $('#stok').val();
        const url = id ? '<?php echo site_url('BarangController/update_barang'); ?>' : '<?php echo site_url('BarangController/create_barang'); ?>';

        $.ajax({
            url: url,
            type: 'POST',
            data: { id_barang: id, kategori_id: kategori_id, barang: barang, stok: stok },
            dataType: 'json',
            success: function(response) {
                $('#modal_form').hide();
                fetchAllBarang(); // Refresh the table
            }
        });
    });

    // Edit
    $(document).on('click', '.edit_barang', function() {
        const id = $(this).data('id');
        $.ajax({
            url: '<?php echo site_url('BarangController/get_barang'); ?>',
            type: 'POST',
            data: { id_barang: id },
            dataType: 'json',
            success: function(data) {
                $('#modal_form').show();
                $('#id_barang').val(data.id_barang);
                $('#kategori_id').val(data.kategori_id);
                $('#barang').val(data.barang);
                $('#stok').val(data.stok);
            }
        });
    });

    // Delete
    $(document).on('click', '.delete_barang', function() {
        const id = $(this).data('id');
        if (confirm('Are you sure you want to delete this barang?')) {
            $.ajax({
                url: '<?php echo site_url('BarangController/delete_barang'); ?>',
                type: 'POST',
                data: { id_barang: id },
                dataType: 'json',
                success: function(response) {
                    fetchAllBarang(); // Refresh the table
                }
            });
        }
    });

    $('#close').on('click', function() {
        $('#modal_form').hide();
    });
});
</script>
</div>
</div>
