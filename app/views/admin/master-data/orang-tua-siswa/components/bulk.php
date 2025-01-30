<!-- Form Tambah Banyak Data Orang Tua Siswa -->
<div class="flex flex-col gap-1 py-2 px-4 bg-white w-full h-full rounded-xl shadow-xl">
  <div class="">
    <h1 class="text-2xl text-slate-700 px-2 py-2 font-semibold">Form Tambah Data Orang Tua - Many</h1>
  </div>
  <!-- Form Modal -->
  <form id="form-modal-tambah-banyak" class="flex flex-col max-h-[80%] xl:max-h-[82%] h-full bg-slate-50 border border-slate-100 rounded-md" method="POST" action="/master-data/orang-tua/create" enctype="multipart/form-data">
    <!-- Table Toolbars -->
    <div class="p-2 bg-blue-600 rounded-t-md"></div>
    <!-- List Table -->
    <div id="wrapper-table-body-tb" class="max-w-auto max-h-[92%] pb-[0.6px] overflow-auto">
      <table class="table-fixed w-full">
        <thead>
          <tr class="text-nowrap bg-blue-100 sticky top-[-2px]">
            <th class="border py-1 px-2 w-12 text-sm font-semibold">No</th>
            <th class="border py-1 px-2 w-64 text-sm font-semibold">Nama Lengkap</th>
            <th class="border py-1 px-2 w-64 text-sm font-semibold">Nomor Identitas Kependudukan</th>
            <th class="border py-1 px-2 w-48 text-sm font-semibold">Jenis Kelamin</th>
            <th class="border py-1 px-2 w-64 text-sm font-semibold">Tempat Lahir</th>
            <th class="border py-1 px-2 w-64 text-sm font-semibold">Tanggal Lahir</th>
            <th class="border py-1 px-2 w-64 text-sm font-semibold">Pekerjaan</th>
            <th class="border py-1 px-2 w-64 text-sm font-semibold">Hubungan</th>
            <th class="border py-1 px-2 w-64 text-sm font-semibold">Email</th>
            <th class="border py-1 px-2 w-64 text-sm font-semibold">Nomor Telepon</th>
            <th class="border py-1 px-2 w-64 text-sm font-semibold">Provinsi</th>
            <th class="border py-1 px-2 w-64 text-sm font-semibold">Kabupaten</th>
            <th class="border py-1 px-2 w-64 text-sm font-semibold">Kecamatan</th>
            <th class="border py-1 px-2 w-64 text-sm font-semibold">Desa</th>
            <th class="border py-1 px-2 w-20 text-sm font-semibold">RT</th>
            <th class="border py-1 px-2 w-20 text-sm font-semibold">RW</th>
            <th class="border py-1 px-2 w-56 text-sm font-semibold">Kode Pos</th>
            <th class="border py-1 px-2 w-64 text-sm font-semibold">Photo</th>
            <th class="border py-1 px-2 w-28 text-sm font-semibold">Action</th>
          </tr>
        </thead>
        <tbody id="table-body-tb">
          <!-- Table form rows -->
        </tbody>
      </table>
    </div>
    <!-- Add row -->
    <button type="button" class="bg-blue-600 self-end mt-2 mr-2 px-1 text-white rounded-sm" onclick="addRow()">+ Tambah</button>
  </form>
  <div class="flex flex-row gap-5 justify-between mb-2 px-3 border">
    <button type="button"
      class="bg-red-600 hover:bg-red-400 hover:font-semibold text-white px-10 py-2 text-lg  rounded-md" onclick="closeModalTambah()">Batal</button>
    <div class="flex flex-row gap-5">
      <button type="reset"
        class="bg-yellow-400 hover:bg-yellow-300 hover:font-semibold text-white px-10 py-2 text-lg  rounded-md"
        onclick="handlerResetFormTambahBanyak()">Reset</button>
      <button
        class="bg-blue-600 hover:bg-blue-400 hover:font-semibold text-white px-12 py-2 text-lg  rounded-md">Submit</button>
    </div>
  </div>
</div>

<script>
  // * Note: md_ayah & md_ibu in admin/header.php

  // === RESET === //
  // ** Reset : Row
  function resetRow(id){
    const row = document.getElementById(`row-id-${id}`);
    // Nama Lengkap
    const inputNamaLengkap = row.querySelector(`[id='nama-lengkap-${id}']`);
    inputNamaLengkap.value = '';
    // NIK
    const inputNIK = row.querySelector(`[id='nik-${id}']`);
    inputNIK.value = '';
    // Jenis Kelamin
    const selectJenisKelamin = row.querySelector(`[id='jenis-kelamin-${id}']`);
    selectJenisKelamin.value = '-- Jenis Kelamin --';
    // Tempat lahir
    const inputTempatLahir = row.querySelector(`[id='tempat-lahir-${id}']`);
    inputTempatLahir.value = '';
    // Tanggal lahir
    const inputTanggalLahir = row.querySelector(`[id='tanggal-lahir-${id}']`);
    inputTanggalLahir.value = '';
    // Pekerjaan
    const inputPekerjaan = row.querySelector(`[id='pekerjaan-${id}']`);
    inputPekerjaan.value = '';
    // Hubungan
    const selectHubungan = row.querySelector(`[id='hubungan-${id}']`);
    selectHubungan.value = '-- Hubungan --';
    // Email
    const inputEmail = row.querySelector(`[id='email-${id}']`);
    inputEmail.value = '';
    // Nomor Telepon
    const inputNomorTelepon = row.querySelector(`[id='nomor-telepon-${id}']`);
    inputNomorTelepon.value = '';
    // Provinsi
    const inputProvinsi = row.querySelector(`[id='provinsi-${id}']`);
    inputProvinsi.value = '';
    // Kabupaten
    const inputKabupaten = row.querySelector(`[id='kabupaten-${id}']`);
    inputKabupaten.value = '';
    // Kecamatan
    const inputKecamatan = row.querySelector(`[id='kecamatan-${id}']`);
    inputKecamatan.value = '';
    // Desa
    const inputDesa = row.querySelector(`[id='desa-${id}']`);
    inputDesa.value = '';
    // RT
    const inputRT = row.querySelector(`[id='rt-${id}']`);
    inputRT.value = '';
    // RW
    const inputRW = row.querySelector(`[id='rw-${id}']`);
    inputRW.value = '';
    // Kode Pos
    const inputKodePos = row.querySelector(`[id='kode-pos-${id}']`);
    inputKodePos.value = '';
    // Photo
    const inputPhoto = row.querySelector(`[id='photo-${id}']`);
    inputPhoto.value = '';
  }

  // ** Reset : Form
  function handlerResetFormTambahBanyak() {
    const rows = document.querySelectorAll("[name='row-input']");
    Array.from(rows).map((row) => {
      if (row.id !== 'row-id-1') {
        row.remove();
      }
    });
  }

  // === MODALS === //
  // ** Modals Tambah Banyak : Open
  function loadModalTambahBanyak() {
    const elements = document.getElementById('container-modal-tambah-banyak');
      elements.classList.remove('hidden');
      elements.classList.add('absolute');
    const swalMask = document.getElementById('swal-mask');
    if (swalMask) {
      elements.removeChild(swalMask);
    }
  }
  // ** Modals Tambah : Close
  function closeModalTambah() {
    const targetElement = document.getElementById('container-modal-tambah-banyak');
    const inputElements = targetElement.getElementsByTagName('input');

    // Cek apakah ada input yang tidak kosong
    const isNotEmpty = Array.from(inputElements).some((input) => input.value !== '');

    if (isNotEmpty) {
      // Jika ada input yang terisi (tidak kosong)
      Swal.fire({
        title: "Batal Tambah Data Orang Tua,<br> Anda Yakin?",
        showConfirmButton: false,
        showDenyButton: true,
        showCancelButton: true,
        cancelButtonColor: 'orange',
        denyButtonText: `Ya, Saya Yakin`,
        customClass: {
          popup: 'swal-absolute',
        },
        backdrop: false,
        didOpen: () => {
          const element = document.createElement('div');
          element.setAttribute('id', 'swal-mask');
          element.classList.add('h-full', 'w-full', 'bg-black', 'bg-opacity-60', 'absolute');
          targetElement.appendChild(element);
        },
        didClose: () => {
          const swalMask = document.getElementById('swal-mask');
          if (swalMask) {
            targetElement.removeChild(swalMask);
          }
        }
      }).then((result) => {
        if (result.isDenied) {
          targetElement.classList.remove('absolute');
          targetElement.classList.add('hidden');
          // Reset Form
          handlerResetFormTambahBanyak();
        }
      });
    } else {
      // Jika semua input kosong
      targetElement.classList.remove('absolute');
      targetElement.classList.add('hidden');
      // Reset Form
      handlerResetFormTambahBanyak();
    }
  }

  // === TABLE === //

  // ** ROW ACTION ** //
  const row = {
    id: 1,
    count: 1,
  }

  // $$ ADD ROW $$ //
  function addRow() {
    renderFormTable(row.id++);

    const wrapper = document.getElementById("wrapper-table-body-tb");
    const rows = document.querySelectorAll("[name='row-number']");

    // Update nomor urut
    Array.from(rows).map((row, index) => {
      row.innerText = index + 1;
    });

    // Scroll ke bagian bawah tabel
    wrapper.scrollTop = wrapper.scrollHeight;
  }

  // $$ DELETE ROW $$ //
  function deleteRow(id) {
    const rowId = `row-id-${id}`;
    const row = document.getElementById(rowId);
    if (row && id != 1) {
      row.remove();  // Menghapus elemen dari DOM
    } else {
      console.log(`Row dengan id ${rowId} tidak ditemukan.`);
    }
    const rows = document.querySelectorAll("[name='row-number']");
    Array.from(rows).map((row, index) => {
      row.innerText = index + 1;
    })
  }


  // Render Form Row
  function renderFormRow() {
    // Button Delete
    const btnDelete = row.id != 1 ? `<button type="button" class="bg-red-400 hover:bg-red-600 text-sm px-[2.5px] py-[0.5px] rounded-sm text-white" onclick="deleteRow(${row.id})">Delete</button>` : '';

    return `
      <tr id="row-id-${row.id}" name="row-input" class="bg-white border">
        <td name="row-number" class="border px-1 text-center h-full text-sm">${row.count}</td>
        <!-- Nama Lengkap -->
        <td class="border">
          <input type="text" id="nama-lengkap-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="Nama Lengkap">
        </td>
        <!-- NIK -->
        <td class="border">
          <input type="text" id="nik-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="Nomor Identitias Kependudukan">
        </td>
        <!-- Jenis Kelamin -->
        <td class="border w-64">
          <select name="jenis_kelamin" id="jenis-kelamin-${row.id}" class="px-1 text-center w-full h-full text-slate-400 text-sm">
            <option selected="selected" disabled>-- Jenis Kelamin --</option>
            <option class="text-slate-600" value="L">Laki-Laki</option>
            <option class="text-slate-600" value="P">Perempuan</option>
          </select>
        </td>
        <!-- Tempat Lahir -->
        <td class="border">
          <input type="text" id="tempat-lahir-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="Tempat Lahir">
        </td>
        <!-- Tanggal Lahir -->
        <td class="border">
          <input type="date" id="tanggal-lahir-${row.id}" class="px-1 text-center w-full h-full text-sm">
        </td>
        <!-- Pekerjaan -->
        <td class="border">
          <input type="text" id="pekerjaan-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="Pekerjaan">
        </td>
        <!-- Hubungan -->
        <td class="border">
          <select name="hubungan" id="hubungan-${row.id}" class="px-1 text-center w-full h-full text-slate-400 text-sm">
            <option selected="selected" disabled>-- Hubungan --</option>
            <option class="text-slate-600" value="ayah">Ayah</option>
            <option class="text-slate-600" value="ibu">Ibu</option>
            <option class="text-slate-600" value="wali">Wali</option>
          </select>
        </td>
        <!-- Email -->
        <td class="border">
          <input type="text" name="email" id="email-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="Email">
        </td>
        <!-- Nomor Telepon -->
        <td class="border">
          <input type="text" name="nomor-telepon" id="nomor-telepon-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="Nomor Telepon">
        </td>
        <!-- Provinsi -->
        <td class="border">
          <input type="text" name="provinsi" id="provinsi-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="Provinsi">
        </td>
        <!-- Kabupaten -->
        <td class="border">
          <input type="text" name="kabupaten" id="kabupaten-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="Kabupaten">
        </td>
        <!-- Kecamatan -->
        <td class="border">
          <input type="text" name="kecamatan" id="kecamatan-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="Kecamatan">
        </td>
        <!-- Desa -->
        <td class="border">
          <input type="text" name="desa" id="desa-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="Desa">
        </td>
        <!-- RT -->
        <td class="border">
          <input type="text" name="rt" id="rt-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="RT">
        </td>
        <!-- RW -->
        <td class="border">
          <input type="text" name="rw" id="rw-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="RW">
        </td>
        <!-- Kode Pos -->
        <td class="border">
          <input type="text" name="kode-pos" id="kode-pos-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="Kode Pos">
        </td>
        <!-- Photo -->
        <td class="border">
          <input type="file" accept="jpg,jpeg,png" id="photo-${row.id}" class="px-1 text-center w-full h-full text-sm" placeholder="Kode Pos">
        </td>
        <!-- Action -->
        <td class="border h-full">
          <div class="flex px-2 items-center justify-center gap-2 h-full">
            <button type="button" class="bg-yellow-400 hover:bg-yellow-600 text-sm px-[2.5px] py-[0.5px] rounded-sm text-white" onclick="resetRow(${row.id})">
              Reset
            </button>
            ${btnDelete}
          </div>
        </td>
      </tr>
    `;
  }

  // Render Form Table
  function renderFormTable(id) {
    const tableBodyElement = document.getElementById("table-body-tb");
    tableBodyElement.insertAdjacentHTML("beforeend", renderFormRow(id));
  }

  // ONLOAD
    renderFormTable(row.id);
</script>