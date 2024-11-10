 const arrayInputElements = [];
 function getInputElements() {
    const formElement = document.getElementById('form');
    const inputElements = formElement.querySelectorAll('input, select');
        inputElements.forEach((element, index) => {
          element.addEventListener('change', (e) => {handleFillable(e)});
          element.id == 'nama-ayah' ? element.addEventListener('keyup', (e) => {
            loadListAyah();
          }) : '';
          element.id == 'nama-ibu' ? element.addEventListener('keyup', (e) => {
            loadListIbu();
          }) : '';

          arrayInputElements.push(element);
        });
  }

  function handleFillable(element) {
    const selectedElement = element.target;
    const selectedElementValue = selectedElement.value;

    if (selectedElementValue !== '') {
      selectedElement.classList.add('bg-green-100');
      selectedElement.classList.remove('bg-white');

      const key = selectedElement.id;

      // Menambahkan data ke dalam form.datas
      form.datas = { ...form.datas, [key]: selectedElementValue };
      console.log(form.datas);
    } else {
      selectedElement.classList.add('bg-white');
      selectedElement.classList.remove('bg-green-100');
    }
  }

// NANTI PERBAIKI AGAR JADI REUSABLE : only (Ayah, Ibu). Gabung dengan handleSelectedRegion
function handleSelectedList(element) {
  const value = element.innerText;
  const target = element.getAttribute('name');
  const targetContainer = 'container-list-' + element.getAttribute('class');

  const targetInputElement = document.getElementById(target);
        targetInputElement.classList.add('bg-green-100');

  const containerList = document.getElementById(targetContainer);

  const getRelatedElements = Array.from(document.querySelectorAll(`input[id*="${element.getAttribute('class')}"]`));

  const relatedElements = getRelatedElements.filter((relatedElement) => relatedElement != targetInputElement);
  const teleponInput = `nomor-telepon-${element.getAttribute('class')}`;

  form.datas = { ...form.datas, [target]: value };

        relatedElements.forEach((element) => {
          const key = element.getAttribute('id');
          if (element.getAttribute('id') == teleponInput) {
            element.value = orangtua.selected[0].nomor_telepon;
            form.datas = { ...form.datas, [key]: orangtua.selected[0].nomor_telepon };
          } else {
            element.value = orangtua.selected[0].email;
            form.datas = { ...form.datas, [key]: orangtua.selected[0].email };
          }
          element.disabled = false;
          element.classList.remove('bg-white');
          element.classList.remove('bg-slate-300');
          element.classList.add('bg-green-100');
        });
    targetInputElement.value = value;
    containerList.innerHTML = '';
    console.log(form.datas);
}

function handleSelectedRegion(element) {
  console.log("handleSelectedRegion berjalan..");
  const value = element.innerText;
  console.log(element);
  const target = element.getAttribute('name');
  const targetContainer = 'container-list-' + target;
  console.log(target);

  const targetInputElement = document.getElementById(target);
  const containerList = document.getElementById(targetContainer);
    console.log(targetContainer);
    switch (target) {
      case 'provinsi':
        regions.selected[0] = [element.getAttribute('id'), value];
        break;
      case 'kabupaten':
        regions.selected[1] = [element.getAttribute('id'), value];
        break;
      case 'kecamatan':
        regions.selected[2] = [element.getAttribute('id'), value];
        break;
      case 'desa':
        regions.selected[3] = [element.getAttribute('id'), value];
        break;
      }
    const key = target;
    form.datas = { ...form.datas, [key]: value };
    targetInputElement.value = value;
    containerList.innerHTML = '';
    console.log(regions.selected);
    console.log('form : ', form.datas)
}

function loadFormTambahData() {
  const container = document.getElementById('container-modal-form');
  const element = `
    <div class="flex justify-center align-middle p-5 absolute w-fit h-[680px] top-0 bg-black bg-opacity-90 z-10">
      <form id="form" class="no-select flex flex-col justify-center gap-2 mx-auto p-4 h-fit rounded-lg bg-white" autocomplete="off">
        <div class="col-12">
          <h4 class="font-bold text-xl">Form Tambah Data Orang Tua</h4>
          <hr>
        </div>
        <div class="flex flex-row gap-1">
          <div class="flex flex-col gap-2 border rounded-lg p-2">
            <h5 class="font-semibold">Data Diri</h5>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="nama-lengkap" class="text-sm">Nama Lengkap :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="nama-lengkap" placeholder="Nama Lengkap"  required/>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="nomor-identitas-kependudukan" class="flex flex-col py-1">
                  <span class="text-sm text-nowrap">Nomor Identitas Kependudukan :</span>
                </label>
                <span class="text-red-500">*</span>
              </div>
              <input
                  type="number"
                  class="no-adjustment-input border rounded-md text-sm p-2"
                  min="11111"
                  max="99999"
                  id="nomor-identitas-kependudukan"
                  placeholder="Nomor Identitas Kependudukan"
                  oninput="this.value = this.value.slice(0, 16);"
                  required
              />
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="tempat-lahir" class="text-sm">Tempat Lahir :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border p-2 text-sm rounded-md" id="tempat-lahir" placeholder="Tempat Lahir"  required />
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="tanggal-lahir" class="text-sm">Tanggal Lahir :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="date" class="border p-2 rounded-md text-sm" id="tanggal-lahir"  required />
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="jenis-kelamin" class="text-sm">Jenis Kelamin :</label>
                <span class="text-red-500">*</span>
              </div>
              <select id="jenis-kelamin" class="border rounded-md text-sm p-2" >
                <option disabled selected selected="selected" value="">-- Pilih Jenis Kelamin --</option>
                <option class="bg-white" value="L">Laki-Laki</option>
                <option class="bg-white" value="P">Perempuan</option>
              </select>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="hubungan" class="text-sm">Hubungan :</label>
                <span class="text-red-500">*</span>
              </div>
              <select id="hubungan" class="border rounded-md text-sm p-2" >
                <option disabled selected selected="selected" value="">-- Pilih Hubungan --</option>
                <option class="bg-white" value="Ayah">Ayah</option>
                <option class="bg-white" value="Ibu">Ibu</option>
              </select>
            </div>
          </div>
          <div class="flex flex-col gap-2 border rounded-lg px-2">
            <div class="flex flex-col" style="margin-top:40px;">
              <div class="flex flex-row gap-1">
                <label for="pekerjaan" class="text-sm">Pekerjaan :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="pekerjaan" placeholder="Pekerjaan"  required/>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="nomor-telepon" class="flex flex-col py-1">
                  <span class="text-sm text-nowrap">Nomor Telepon :</span>
                </label>
                <span class="text-red-500">*</span>
              </div>
              <input
                  type="number"
                  class="no-adjustment-input border rounded-md text-sm p-2"
                  min="11111"
                  max="99999"
                  id="nomor-telepon"
                  placeholder="Nomor Telepon"
                  oninput="this.value = this.value.slice(0, 16);"
                  required
              />
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="email" class="text-sm">Email :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border p-2 text-sm rounded-md" id="email" placeholder="Email"  required />
            </div>
          </div>
          <div class="flex flex-col gap-2 border rounded-2 p-2">
            <h5 class="font-semibold">Alamat</h5>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="provinsi" class="text-sm">Provinsi :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="provinsi" placeholder="Masukan Provinsi"
                onkeypress="loadListProvinsi()" />
                <div id="container-list-provinsi" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="kabupaten" class="text-sm">Kabupaten :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="kabupaten" placeholder="Masukan Kabupaten"
                onkeypress="loadListKabupaten()" />
                <div id="container-list-kabupaten" class="position w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="kecamatan" class="text-sm">Kecamatan :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="kecamatan" placeholder="Masukan Kecamatan" onkeypress="loadListKecamatan()" />
                <div id="container-list-kecamatan" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="desa" class="text-sm">Desa / Kelurahan :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="desa" placeholder="Masukan Desa / Keluruhan"
                required onkeypress="loadListDesa()" />
                <div id="container-list-desa" class="relative w-full">
                </div>
            </div>
            <div class="row">
              <div class="col-6 flex flex-col">
                <div class="flex flex-row gap-1">
                  <label for="rt" class="text-sm">RT :</label>
                  <span class="text-red-500">*</span>
                </div>
                <input type="number" min="0" max="100" class="col border rounded-md text-sm p-2" id="rt" placeholder="000"  oninput="formatInputNumber('rt')" />
              </div>
              <div class="col-6 flex flex-col">
                <div class="flex flex-row gap-1">
                  <label for="rt" class="text-sm">RW :</label>
                  <span class="text-red-500">*</span>
                </div>
                <input type="number" min="0" max="100" class="col border rounded-md text-sm p-2" id="rw" placeholder="000"
                oninput="formatInputNumber('rw')"  />
              </div>
            </div>
            <div class="flex flex-col">
              <label for="kode-pos" class="text-sm">Kode Pos :</label>
              <input type="number" pattern="[0-9]" class="border rounded-md text-sm p-2" id="kode-pos" placeholder="Masukan Kode Pos" />
            </div>
          </div>
          <div class="flex flex-col gap-2">
            <div class="flex flex-col justify-center gap-1 p-2 border rounded-md">
              <h6 class="font-semibold ">Photo Diri</h6>
              <output id="imageOutput" class="align-center">
                <img src="../assets/images/default-image.png" class="w-full" id="previewImage">
              </output>
              <input type="file" name="fileInput" id="fileInput" accept="image/png, image/jpg, image/jpeg" class="w-full" onchange="inputPhotoSiswa(event)" required>
            </div>
          </div>
        </div>
        <div class="flex flex-row justify-content-end py-1 gap-2">
          <button type="button" class="bg-red-600 py-1 px-2 rounded-md text-white hover:bg-red-500 hover:font-semibold" onclick="cancelForm()">Batal</button>
          <button type="button" class="bg-yellow-500 py-1 px-2 rounded-md hover:bg-yellow-400 hover:font-semibold" onclick="handleReset()">Reset</button>
          <button type="button" class="bg-blue-800 py-1 px-2 text-white rounded-md hover:bg-blue-600 hover:font-semibold" onclick="addDataSiswa()">Tambah</button>
        </div>
      </form>
    </div>
  `;

  // Gunakan innerHTML untuk menambahkan elemen
  container.innerHTML += element;
  getInputElements();
}

function formatInputNumber(id) {
  const input = document.getElementById(id);
  let value = parseInt(input.value, 10);

  // Jika angka berada dalam batas, format menjadi tiga digit
  if (value >= 1 && value <= 100) {
      input.value = value.toString().padStart(3, '0');
  } else {
      input.value = '';
  }
}


function cancelForm() {
  Swal.fire({
    title: 'Oops!',
    text: 'Tambah Data Siswa Dibatalkan, apakah anda yakin?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya',
    cancelButtonText: 'Tidak',
    confirmButtonColor: 'red',
    cancelButtonColor: 'blue',
    backdrop: `
        rgba(0,0,123,0.4)
        left top
        no-repeat
    `
}).then((result) => {
    if (result.isConfirmed) {
        regions.selected = [];
        form.datas = {};
        arrayInputElements.forEach((element) => {
            element.classList.remove('bg-green-100');
            element.value = '';
        });
        previewImage = document.getElementById('previewImage').src = '../assets/images/default-image.png';
        const container = document.getElementById('container-modal-form');
        container.innerHTML = '';
    }
});

}

function handleReset() {
  Swal.fire({
      title: 'Oops!',
      text: 'Form akan dikosongkan, apakah anda yakin?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya',
      cancelButtonText: 'Tidak',
      confirmButtonColor: 'red',
      cancelButtonColor: 'blue',
      backdrop: `
          rgba(0,0,123,0.4)
          left top
          no-repeat
      `
  }).then((result) => {
      if (result.isConfirmed) {
          regions.selected = [];
          form.datas = {};
          arrayInputElements.forEach((element) => {
              element.classList.remove('bg-green-100');
              element.value = '';
          });
          previewImage = document.getElementById('previewImage').src = '../assets/images/default-image.png';
      }
  });
}

function inputPhotoSiswa(event) {
    const fileInput = document.getElementById('fileInput');
    const previewImage = document.getElementById('previewImage');
    const file = event.target.files[0];
    if (file && (file.type === "image/png" || file.type === "image/jpeg" || file.type === "image/jpg")) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        alert("Please select a valid image file (png, jpg, jpeg)");
        fileInput.value = '';
    }
}

document.addEventListener('DOMContentLoaded', () => {
  loadDataOrangTua();
});