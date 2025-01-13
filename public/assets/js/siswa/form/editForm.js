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

let photoSiswa = null;
let nikSiswa = null;
let urutan = 0;
function loadFormEditData(id) {
  const data = nosql.set(siswa.datas)
              .where('nomor_induk_siswa', '===', id)
              .exec();

  const data_ayah = nosql.set(orangtua.datas)
                    .where('nama_lengkap', '===', data[0].nama_ayah)
                    .exec();

  const data_ibu = nosql.set(orangtua.datas)
                  .where('nama_lengkap', '===', data[0].nama_ibu)
                  .exec();

  if (data[0].length && data_ayah[0].length && data_ibu[0].length) return;

  const container = document.getElementById('container-modal-form');

  nikSiswa = id;
  photoSiswa = data[0].photo_siswa;

  let element = `
    <div class="flex justify-center align-middle p-5 absolute w-fi)t h-[680px] top-0 bg-black bg-opacity-90 z-10">
      <form id="form" class="no-select flex flex-col justify-center gap-2 mx-auto p-4 h-fit rounded-lg bg-white" autocomplete="off">
        <div class="col-12">
          <h4 class="font-bold text-xl">Form Edit Data Siswa</h4>
          <hr>
        </div>
        <div class="flex flex-row gap-1">
          <div class="flex flex-col gap-2 border rounded-lg p-2">
            <h5 class="font-semibold">Data Diri Siswa</h5>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="nama-lengkap-siswa" class="text-sm">Nama Lengkap Siswa :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="nama-lengkap-siswa" placeholder="Nama Lengkap Siswa" value="${data[0].nama_lengkap}"  required/>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="nomor-induk-siswa" class="flex flex-col py-1">
                  <span class="text-sm">Nomor Induk Siswa :</span>
                  <span class="text-xs">( <i>maks: 5 digit</i> )</span>
                </label>
                <span class="text-red-500">*</span>
              </div>
              <input
                  type="number"
                  class="no-adjustment-input border rounded-md text-sm p-2"
                  min="11111"
                  max="99999"
                  id="nomor-induk-siswa"
                  placeholder="Nomor Induk Siswa"
                  pattern="\d{5}"
                  oninput="this.value = this.value.slice(0, 5);"
                  value="${data[0].nomor_induk_siswa}"
                  required
              />
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="tempat-lahir-siswa" class="text-sm">Tempat Lahir :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border p-2 text-sm rounded-md" id="tempat-lahir-siswa" placeholder="Tempat Lahir" value="${data[0].tempat_lahir}"  required />
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="tanggal-lahir-siswa" class="text-sm">Tanggal Lahir :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="date" class="border p-2 rounded-md text-sm" id="tanggal-lahir-siswa" value="${data[0].tanggal_lahir}" required />
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="jenis-kelamin" class="text-sm">Jenis Kelamin :</label>
                <span class="text-red-500">*</span>
              </div>
              <select id="jenis-kelamin" class="border rounded-md text-sm p-2">
              `
                optionValues = ''
                if (data[0].jenis_kelamin == 'L') {
                  optionValues += `
                    <option disabled value="">-- Pilih Jenis Kelamin --</option>
                    <option class="bg-white" value="L" selected>Laki-Laki</option>
                    <option class="bg-white" value="P" >Perempuan</option>
                  `;
                } else if (data[0].jenis_kelamin == 'P') {
                  optionValues += `
                    <option disabled value="">-- Pilih Jenis Kelamin --</option>
                    <option class="bg-white" value="L">Laki-Laki</option>
                    <option class="bg-white" value="P" selected>Perempuan</option>
                  `;
                } else {
                  optionValues += `
                  <option disabled selected value="">-- Pilih Jenis Kelamin --</option>
                  <option class="bg-white" value="L" >Laki-Laki</option>
                  <option class="bg-white" value="P" >Perempuan</option>
                `;
                }

              element += optionValues;

              element += `
              </select>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="kelas" class="text-sm">Kelas :</label>
                <span class="text-red-500">*</span>
              </div>
              <select id="kelas" class="border p-2 rounded-md text-sm" onfocus='this.size=3;' onblur='this.size=1;' onchange='this.size=1; this.blur();' >
              </select>
            </div>
          </div>
          <div class="flex flex-col gap-2 border rounded-lg p-2">
            <h5 class="font-semibold">Data Orang Tua</h5>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="nama-ayah" class="text-sm">Nama Ayah :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border p-2 rounded-md text-sm" id="nama-ayah" placeholder="Nama Ayah Siswa" value="${data_ayah[0].nama_lengkap}" required />
                <div id="container-list-ayah" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="nomor-telepon-ayah" class="text-sm">Nomor Telepon Ayah :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="number" pattern="[0-9]" class="no-adjustment-input border rounded-md text-sm p-2"
                id="nomor-telepon-ayah" placeholder="Nomor Telepon Ayah" value="${data_ayah[0].nomor_telepon}" required
                 />
                <div id="container-list-nomor-telepon-ayah" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="email-ayah" class="text-sm">Email Ayah :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="email" class="border rounded-md text-sm p-2" id="email-ayah" placeholder="Masukan Email Ayah" value="${data_ayah[0].email}" required/>
                <div id="container-list-email-ayah" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="nama-ibu" class="text-sm">Nama Ibu :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="nama-ibu" placeholder="Nama Ibu Siswa" value="${data_ibu[0].nama_lengkap}" required/>
                <div id="container-list-ibu" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="nomor-telepon-ibu" class="text-sm">Nomor Telepon Ibu :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="number" pattern="[0-9]" class="no-adjustment-input border text-sm rounded-md p-2" id="nomor-telepon-ibu" placeholder="Nomor Telepon Ibu" value="${data_ibu[0].nomor_telepon}" required  />
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="email-ibu" class="text-sm">Email Ibu :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="email" class="border rounded-md text-sm p-2" id="email-ibu" placeholder="Masukan Email Ibu" value="${data_ibu[0].email}" required/>
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
                onkeypress="loadListProvinsi()" value="${data[0].provinsi}" required />
                <div id="container-list-provinsi" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="kabupaten" class="text-sm">Kabupaten :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="kabupaten" placeholder="Masukan Kabupaten"
                onkeypress="loadListKabupaten()" value="${data[0].kabupaten}" required/>
                <div id="container-list-kabupaten" class="position w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="kecamatan" class="text-sm">Kecamatan :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="kecamatan" placeholder="Masukan Kecamatan" onkeypress="loadListKecamatan()" value="${data[0].kecamatan}" required/>
                <div id="container-list-kecamatan" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="desa" class="text-sm">Desa / Kelurahan :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="desa" placeholder="Masukan Desa / Keluruhan"
                required onkeypress="loadListDesa()" value="${data[0].desa}" required/>
                <div id="container-list-desa" class="relative w-full">
                </div>
            </div>
            <div class="row">
              <div class="col-6 flex flex-col">
                <div class="flex flex-row gap-1">
                  <label for="rt" class="text-sm">RT :</label>
                  <span class="text-red-500">*</span>
                </div>
                <input type="number" min="0" max="100" class="col border rounded-md text-sm p-2" id="rt" placeholder="000" oninput="formatInputNumber('rt')" value="${data[0].rt}" required/>
              </div>
              <div class="col-6 flex flex-col">
                <div class="flex flex-row gap-1">
                  <label for="rt" class="text-sm">RW :</label>
                  <span class="text-red-500">*</span>
                </div>
                <input type="number" min="0" max="100" class="col border rounded-md text-sm p-2" id="rw" placeholder="000"
                oninput="formatInputNumber('rw')" value="${data[0].rw}" required/>
              </div>
            </div>
            <div class="flex flex-col">
              <label for="kode-pos" class="text-sm">Kode Pos :</label>
              <input type="number" pattern="[0-9]" class="border rounded-md text-sm p-2" id="kode-pos" placeholder="Masukan Kode Pos" value="${data[0].kode_pos}"  />
            </div>
          </div>
          <div class="flex flex-col gap-2">
            <div class="flex flex-col justify-center gap-1 p-2 border rounded-md">
              <h6 class="font-semibold ">Photo Siswa</h6>
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
          <button type="button" class="bg-blue-800 py-1 px-2 text-white rounded-md hover:bg-blue-600 hover:font-semibold" onclick="addDataSiswa()">Update</button>
        </div>
      </form>
    </div>
  `
    setTimeout(() => {
      loadImage(photoSiswa);
      console.log(++urutan);
    }, 1000);
  ;

  // Gunakan innerHTML untuk menambahkan elemen
  container.innerHTML += element;
  getInputElements();
  render('#kelas',
    `<option disabled selected value="">-- Pilih Kelas --</option>
      ${siswa.kelas?.map((kelas) => {
        return `<option class="bg-white" value="${kelas.nama_kelas}">${kelas.nama_kelas}</option>`;
      })}
    `
  , {signals: ['main-table-data']});
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
    text: 'Edit Data Siswa Dibatalkan, apakah anda yakin?',
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
        previewImage = document.getElementById('imageOutput').src = '../assets/images/default-image.png';
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
          // arrayInputElements.forEach((element) => {
          //     element.classList.remove('bg-green-100');
          //     element.value = '';
          // });
          loadFormEditData(nikSiswa);
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

function loadImage(imageName) {
  const imagePath = `/assets/${imageName}`;
  const imgElement = document.createElement('img');
  imgElement.src = imagePath;
  imgElement.alt = 'Gambar Siswa';
  imgElement.classList.add('w-full');
  imgElement.style.maxHeight = '100%';

  const imageOutput = document.getElementById('imageOutput');

  imageOutput.innerHTML = '';
  imageOutput.appendChild(imgElement);
}

document.addEventListener('DOMContentLoaded', () => {
  loadDataOrangTua();
});