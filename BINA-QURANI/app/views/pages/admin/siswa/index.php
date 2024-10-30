<div id="content" class="container-lg flex flex-col h-full px-0 mx-auto bg-[#BBBBBB]">
  <!-- Form Modal -->
  <div id="container-modal-form" class="relative w-full">
  </div>
  <!-- Banner -->
  <div class="no-select flex flex-col px-5 py-4 items-center bg-[#769B27]">
    <h1 class="title-banner m-0 text-white text-2xl px-4 py-1">
      Master Data - Data Siswa
    </h1>
  </div>
  <!-- Sub Content 1 -->
  <div class="flex py-2 justify-around items-center bg-[#D9D9D9]">
    <!-- Table Configuration -->
    <!-- Search Table -->
    <div id="container-filter-data-table" class="no-select flex justify-center items-center gap-2">
    </div>
    <div id="container-btn-reset-groupby" class="h-full w-16 relative"></div>
    <div id="search-table"
      class="flex flex-column items-center justify-center gap-2 border">
    </div>
    <div id="container-btn-reset-search" class="h-full w-16 relative"></div>
    <div class="no-select flex justify-center gap-1">
      <button class="flex items-center rounded-md bg-blue-900 text-white px-2 py-1 gap-1 hover:bg-blue-600" onclick="loadFormTambahData()">
          <span class="flex items-center text-md">+</span>
          <span class="text-md text-nowrap">Tambah</span>
      </button>
      <button class="flex items-center rounded-md bg-yellow-400 px-2 py-1 gap-1 hover:bg-yellow-300" onclick="loadFormTambahData()">
          <span class="flex items-center text-md">+</span>
          <span class="text-md text-nowrap">Edit</span>
      </button>
      <button class="flex items-center rounded-md bg-red-700 text-white px-2 py-1 gap-1 hover:bg-red-600" onclick="loadFormTambahData()">
          <span class="flex items-center text-md">+</span>
          <span class="text-md text-nowrap">Delete</span>
      </button>
    </div>
  </div>
  <!-- Sub Content 2 -->
  <!-- Interactive Table -->
  <div class="h-full w-full">
    <!-- Table -->
    <div class="mt-2 bg-[#BBBBBB]">
      <div class="container mx-auto p-0 max-w-5xl max-h-[480px] overflow-auto">
        <table class="text-center h-full">
          <thead id="table-head">
          </thead>
          <tbody id="table-body">
          </tbody>
        </table>
      </div>
      <div id="pagination" class="no-select flex justify-center items-center py-2 gap-3">
      </div>
    </div>
  </div>
</div>
<script src="<?= base_url(path: 'assets/js/siswa/table.js') ?>"></script>
<script src="<?= base_url(path: 'assets/js/siswa/form/addForm.js') ?>"></script>