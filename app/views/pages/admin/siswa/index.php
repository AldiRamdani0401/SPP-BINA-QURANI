<div id="content" class="d-flex flex-column h-100 flex-md-grow-1 px-0 mx-auto"
  style="background:#BBBBBB;">
  <!-- Form Modal -->
  <div id="container-modal-form" class="position-relative w-100">
  </div>
  <!-- Banner -->
  <div class="no-select d-flex flex-column flex-md-row px-5 align-items-center" style="background:#769B27;">
    <div class="d-flex justify-content-center flex-column px-0 px-md-5 gap-3" style="width:100%;">
      <div class="mx-auto py-3">
        <h1 class="title-banner m-0 text-white px-4 py-1" style="font-weight:500;white-space:nowrap;width:fit-content;">
          Master Data - Data Siswa
        </h1>
      </div>
    </div>
  </div>
  <!-- Sub Content 1 -->
  <!-- Tab Section -->
  <!-- <div id="tab-container" class="no-select d-flex justify-content-start align-items-end gap-2 pt-5 px-3"
      style="background:#576834; overflow-x:scroll; overflow-y:hidden;width:1000px;">
  </div> -->
  <div class="d-flex py-2 px-4 gap-2 justify-content-between align-items-center" style="background:#D9D9D9;">
    <!-- Table Configuration -->
    <!-- Search Table -->
    <div id="container-filter-data-table-1" class="no-select d-flex justify-content-center gap-3">
    </div>
    <div id="container-filter-data-table-2" class="no-select d-flex justify-content-center gap-3">
    </div>
    <div id="search-table"
      class="d-flex flex-sm-column flex-md-row align-items-center justify-content-center gap-2 d-none d-sm-flex">
    </div>
    <div class="no-select d-flex justify-content-center gap-1">
      <button class="btn btn-primary d-flex align-items-center gap-1" onclick="loadFormTambahData()">
          <span class="d-flex align-items-center" style="font-size:20px;">+</span>
          <span style="font-size:14px; white-space: nowrap;">Tambah</span>
      </button>
      <button class="btn btn-danger d-flex align-items-center gap-1" onclick="loadFormTambahData()">
          <span class="d-flex align-items-center" style="font-size:20px;">-</span>
          <span style="font-size:14px; white-space: nowrap;">Hapus</span>
      </button>
      <button class="btn btn-warning d-flex align-items-center gap-1" onclick="loadFormTambahData()">
          <span class="d-flex align-items-center" style="font-size:20px;">-</span>
          <span style="font-size:14px; white-space: nowrap;">Edit</span>
      </button>
    </div>
  </div>
  <!-- Sub Content 2 -->
  <!-- Interactive Table -->
  <div class="d-flex flex-column h-100" style="width:100%;">
    <!-- Table -->
    <div class="container-fluid px-2 py-2" style="background:#BBBBBB;">
      <div class="container p-0 w-100 h-100"
        style="background:#BBBBBB;max-width:1100px;max-height:450px;overflow:auto;">
        <table class="text-center h-100">
          <thead id="table-head">
          </thead>
          <tbody id="table-body">
          </tbody>
        </table>
      </div>
      <div id="pagination" class="no-select d-flex justify-content-center align-items-center py-2 gap-3">
      </div>
    </div>
  </div>
</div>
<script src="<?= base_url(path: 'assets/js/siswa/table.js') ?>"></script>
<script src="<?= base_url(path: 'assets/js/siswa/form/addForm.js') ?>"></script>