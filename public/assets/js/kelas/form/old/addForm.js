// Get Data
function loadDataProvincies() {
  return fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
    .then(response => response.json())
    .catch(error => {
      console.error('Fetch error:', error);
      throw error;
    });
}

function loadDataRegencies(provinceId){
  return fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
  .then(response => response.json())
  .catch(error => {
    console.error('Fetch error:', error);
    throw error;
  });
}

function loadDataDistricts(kabupatenId){
// ID KABUPATEN KARAWANG = 3215
  return fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabupatenId}.json`)
  .then(response => response.json())
  .catch(error => console.error('Fetch error:', error));
}

function loadDataVillages(kecamatanId){
// ID Kecamatan TALAGASARI = 3215100
  return fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatanId}.json`)
  .then(response => response.json())
  .catch(error => console.error('Fetch error:', error));
}

function loadDataOrangTua() {
  return fetch('/data-orang-tua')
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
      }
      return response.json();
    })
    .catch(error => {
      console.error('Fetch error:', error);
      throw error; // Meneruskan kesalahan agar bisa ditangani di tempat lain
    });
}

function loadListAyah() {
  const container = document.getElementById('container-list-ayah');
  const inputElement = document.getElementById('nama-ayah');
  const inputValue = inputElement.value;

  loadDataOrangTua()
    .then(data => {
      const result = nosql.set(data[1]).where('nama_lengkap', 'LIKE', inputValue, false).where('hubungan', '===', 'Ayah').exec();

      // Membuat konten berdasarkan data yang diambil
      let containerList = `
      <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
      <ul class="my-auto" style="list-style-type: none;">
      `;

      // Menambahkan data ke dalam list
      result.forEach(ayah => {
        containerList += `<li id="${ayah.id}" class="list-ayah">${ayah.nama_lengkap}</li>`;
      });

      containerList += `
          </ul>
        </div>
      `;

      // Update kontainer dengan HTML baru
      container.innerHTML = containerList;

      function handleSelectedList(element) {
        const value = element.target.innerText;
        inputElement.value = element.target.innerText;
        inputElement.style.backgroundColor = `#ebffeb`;

        const selectedData = nosql.set(result).where('nama_lengkap', '===', value).exec();

        const containerListNomorTelepon = document.getElementById('container-list-nomor-telepon-ayah');
              containerListNomorTelepon.innerHTML = `
                <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
                  <ul class="my-auto" style="list-style-type: none;">
                    <li id="${selectedData[0].nomor_telepon}">
                      ${selectedData[0].nomor_telepon}
                    </li>
                  </ul>
                </div>
              `;

        const containerListEmail = document.getElementById('container-list-email-ayah');
              containerListEmail.innerHTML = `
                <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
                  <ul class="my-auto" style="list-style-type: none;">
                    <li id="${selectedData[0].email}">
                      ${selectedData[0].email}
                    </li>
                  </ul>
                </div>
              `;
              function fillInput(elementId, inputValue, clearContainerId) {
                document.getElementById(elementId).value = inputValue;
                document.getElementById(elementId).style.backgroundColor = `#ebffeb`;
                document.getElementById(clearContainerId).innerHTML = '';
              }

              // Event pertama: Mengisi nomor telepon
              document.getElementById(selectedData[0].nomor_telepon).addEventListener('click', () => {
                fillInput('nomor-telepon-ayah', selectedData[0].nomor_telepon, 'container-list-nomor-telepon-ayah');

                // Setelah nomor telepon diisi, tampilkan dan aktifkan event untuk email
                document.getElementById(selectedData[0].email).style.display = 'block'; // Tampilkan email
                document.getElementById(selectedData[0].email).addEventListener('click', () => {
                  fillInput('email-ayah', selectedData[0].email, 'container-list-email-ayah');
                });
              });

              // Pastikan elemen email tersembunyi sebelum nomor telepon diklik
              document.getElementById(selectedData[0].email).style.display = 'none';

              // selectedData[0].nomor_telepon
              // inputTelepon.style.backgroundColor = `#ebffeb`;
        // const inputEmail = document.getElementById('email-ayah');
        //       inputEmail.value = selectedData[0].email;
        //       inputEmail.style.backgroundColor = `#ebffeb`;
        container.innerHTML = '';
      }

      let getList = document.querySelectorAll('.list-ayah');
        getList.forEach(list => {
          list.addEventListener('click', (element) => {
            handleSelectedList(element);
          });
        });
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

function loadListIbu() {
  const container = document.getElementById('container-list-ibu');
  const inputElement = document.getElementById('nama-ibu');
  const inputValue = inputElement.value;

  loadDataOrangTua()
    .then(data => {
      const result = nosql.set(data[1]).where('nama_lengkap', 'LIKE', inputValue, false).where('hubungan', '===', 'Ibu').exec();

      // Membuat konten berdasarkan data yang diambil
      let containerList = `
      <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
      <ul class="my-auto" style="list-style-type: none;">
      `;

      // Menambahkan data ke dalam list
      result.forEach(ibu => {
        containerList += `<li id="${ibu.id}" class="list-ibu">${ibu.nama_lengkap}</li>`;
      });

      containerList += `
          </ul>
        </div>
      `;

      // Update kontainer dengan HTML baru
      container.innerHTML = containerList;

      function handleSelectedList(element) {
        const value = element.target.innerText;
        inputElement.value = element.target.innerText;
        inputElement.style.backgroundColor = `#ebffeb`;
        const selectedData = nosql.set(result).where('nama_lengkap', '===', value).exec();
        const inputTelepon = document.getElementById('nomor-telepon-ibu');
              inputTelepon.value = selectedData[0].nomor_telepon;
              inputTelepon.style.backgroundColor = `#ebffeb`;
        const inputEmail = document.getElementById('email-ibu');
              inputEmail.value = selectedData[0].email;
              inputEmail.style.backgroundColor = `#ebffeb`;
        container.innerHTML = '';
      }

      let getList = document.querySelectorAll('.list-ibu');
        getList.forEach(list => {
          list.addEventListener('click', (element) => {
            handleSelectedList(element);
          });
        });
    })
    .catch(error => {
      console.error('Error:', error);
    });
}


let selectedProvinsi = [];

function loadListProvinsi() {
  const container = document.getElementById('container-list-provinsi');
  const inputElement = document.getElementById('provinsi');
  if (!container || !inputElement) {
    console.error('Elemen container atau input tidak ditemukan');
    return;
  }

  inputElement.addEventListener('blur', () => {
    const inputValue = inputElement.value; // Ambil nilai terbaru saat blur
    if (inputValue === '') {
      selectedProvinsi = [];
      inputElement.style.backgroundColor = '#fff';
      container.innerHTML = '';
    } else {
      inputElement.style.backgroundColor = '#eaeaea';
    }
  });

  loadDataProvincies()
    .then(data => {
      // Pastikan data terfilter hanya sesuai yang diinginkan
      const result = nosql.set(data).where('name', 'LIKE', inputElement.value, false).exec();

      // Buat HTML untuk daftar provinsi
      let containerList = `
        <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
          <ul class="my-auto" style="list-style-type: none;">
      `;
      result.forEach(provinsi => {
        containerList += `<li id="${provinsi.id}" class="list-provinsi">${provinsi.name}</li>`;
      });
      containerList += '</ul></div>';

      // Update konten container dengan daftar yang dibuat
      container.innerHTML = containerList;

      // Tambahkan event listener pada setiap item list provinsi
      const listItems = container.querySelectorAll('.list-provinsi');
      listItems.forEach(list => {
        list.addEventListener('click', (event) => {
          handleSelectedList(event);
        });
      });

      // Fungsi untuk menangani pemilihan item dari list
      function handleSelectedList(event) {
        const value = event.target.innerText;
        inputElement.value = value;
        inputElement.style.backgroundColor = '#eaeaea';
        selectedProvinsi.push({ id: event.target.id, name: value });
        container.innerHTML = ''; // Bersihkan container setelah item dipilih
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

let selectedKabupaten = [];
function loadListKabupaten() {
  const container = document.getElementById('container-list-kabupaten');
  const inputElement = document.getElementById('kabupaten');
  const provinsiId = selectedProvinsi[0].id

  if (!container || !inputElement) {
    console.error('Elemen container atau input tidak ditemukan');
    return;
  }

  inputElement.addEventListener('blur', () => {
    const inputValue = inputElement.value;
    if (inputValue === '') {
      selectedKabupaten = [];
      inputElement.style.backgroundColor = '#fff';
      container.innerHTML = '';
    } else {
      inputElement.style.backgroundColor = '#eaeaea';
    }
  });

  loadDataRegencies(provinsiId)
    .then(data => {
      const result = nosql.set(data).where('province_id', '===', provinsiId).where('name', 'LIKE', inputElement.value, false).exec();

      // Membuat konten berdasarkan data yang diambil
      let containerList = `
      <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
      <ul class="my-auto" style="list-style-type: none;">
      `;

      // Menambahkan data ke dalam list
      result.forEach(kabupaten => {
        containerList += `<li id="${kabupaten.id}" class="list-kabupaten">${kabupaten.name}</li>`;
      });

      containerList += `
          </ul>
        </div>
      `;

      container.innerHTML = containerList;

      function handleSelectedList(element) {
        const value = element.target.innerText;
        inputElement.value = element.target.innerText;
        inputElement.style.backgroundColor = `#eaeaea`;
        selectedKabupaten.push({id:element.target.id, name:element.target.innerText});
        container.innerHTML = '';
      }

      let getList = document.querySelectorAll('.list-kabupaten');
        getList.forEach(list => {
          list.addEventListener('click', (element) => {
            handleSelectedList(element);
          });
        });
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

let selectedKecamatan = [];
function loadListKecamatan() {
  const container = document.getElementById('container-list-kecamatan');
  const inputElement = document.getElementById('kecamatan');
  const inputValue = inputElement.value;
  const kabupatenId = selectedKabupaten[0].id

  if (!container || !inputElement) {
    console.error('Elemen container atau input tidak ditemukan');
    return;
  }

  inputElement.addEventListener('blur', () => {
    const inputValue = inputElement.value;
    if (inputValue === '') {
      selectedKecamatan = [];
      inputElement.style.backgroundColor = '#fff';
      container.innerHTML = '';
    } else {
      inputElement.style.backgroundColor = '#eaeaea';
    }
  });

  loadDataDistricts(kabupatenId)
    .then(data => {
      const result = nosql.set(data).where('regency_id', '===', kabupatenId).where('name', 'LIKE', inputValue, false).exec();

      let containerList = `
      <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
      <ul class="my-auto" style="list-style-type: none;">
      `;

      result.forEach(kabupaten => {
        containerList += `<li id="${kabupaten.id}" class="list-kabupaten">${kabupaten.name}</li>`;
      });

      containerList += `
          </ul>
        </div>
      `;

      container.innerHTML = containerList;

      function handleSelectedList(element) {
        const value = element.target.innerText;
        inputElement.value = element.target.innerText;
        inputElement.style.backgroundColor = `#eaeaea`;
        selectedKecamatan.push({id:element.target.id, name:element.target.innerText});
        container.innerHTML = '';
      }

      let getList = document.querySelectorAll('.list-kabupaten');
        getList.forEach(list => {
          list.addEventListener('click', (element) => {
            handleSelectedList(element);
          });
        });
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

let selectedDesa = [];
function loadListDesa() {
  const container = document.getElementById('container-list-desa');
  const inputElement = document.getElementById('desa');
  const kecamatanId = selectedKecamatan[0].id;

  if (!container || !inputElement) {
    console.error('Elemen container atau input tidak ditemukan');
    return;
  }

  inputElement.addEventListener('blur', () => {
    const inputValue = inputElement.value;
    if (inputValue === '') {
      selectedDesa = [];
      inputElement.style.backgroundColor = '#fff';
      container.innerHTML = '';
    } else {
      inputElement.style.backgroundColor = '#eaeaea';
    }
  });

  loadDataVillages(kecamatanId)
    .then(data => {
      const result = nosql.set(data).where('district_id', '===', kecamatanId).where('name', 'LIKE', inputElement.value, false).exec();

      let containerList = `
      <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
      <ul class="my-auto" style="list-style-type: none;">
      `;

      result.forEach(kabupaten => {
        containerList += `<li id="${kabupaten.id}" class="list-kabupaten">${kabupaten.name}</li>`;
      });

      containerList += `
          </ul>
        </div>
      `;

      container.innerHTML = containerList;

      function handleSelectedList(element) {
        const value = element.target.innerText;
        inputElement.value = element.target.innerText;
        inputElement.style.backgroundColor = `#eaeaea`;
        selectedDesa.push({id:element.target.id, name:element.target.innerText});
        container.innerHTML = '';
      }

      let getList = document.querySelectorAll('.list-kabupaten');
        getList.forEach(list => {
          list.addEventListener('click', (element) => {
            handleSelectedList(element);
          });
        });
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

const arrayInputElements = [];

function getInputElements() {
  const formElement = document.getElementById('form');
  const inputElements = formElement.querySelectorAll('input, select');

  inputElements.forEach((input, index) => {
    if (index === 0) {
      input.disabled = false; // Hanya input pertama yang diaktifkan
      input.style.backgroundColor = '#ffffff';
    } else {
      input.disabled = true;  // Input lainnya dinonaktifkan
      input.style.backgroundColor = '#eaeaea';
    }
    arrayInputElements.push(input); // Menyimpan elemen input ke array
  });
}

function handleFillableInput(element) {
  const selectedElement = document.getElementById(element.id);
  const currentIndex = arrayInputElements.indexOf(selectedElement);

  if (selectedElement.value.trim() !== '') {
    // Input yang diisi akan memiliki latar belakang hijau
    selectedElement.style.backgroundColor = '#ebffeb';

    // Jika ada input berikutnya, aktifkan
    if (currentIndex < arrayInputElements.length - 1) {
      const nextElement = arrayInputElements[currentIndex + 1];
      nextElement.disabled = false;  // Aktifkan input berikutnya
      nextElement.style.backgroundColor = '#ffffff';
    }
  } else {
    selectedElement.style.backgroundColor = '#ffffff'; // Jika kosong, kembalikan warna default
  }
}


  function handleReset() {
    getInputElements();
    selectedProvinsi = [];
    selectedKabupaten = [];
    selectedKecamatan = [];
    selectedDesa = [];
  }

  // function enableInputs(element) {
  //   const formElement = element;
  //   const inputElements = formElement.querySelectorAll('input, select'); // Pilih input dan select

  //   // Mengaktifkan elemen pertama kali
  //   inputElements.forEach((input, index) => {
  //     if (index === 0 || (input.value.trim() !== '' && input.value.trim() !== 'null')) {
  //       input.disabled = false; // Hanya elemen pertama yang aktif
  //       input.style.backgroundColor = '#ffffff';
  //     } else {
  //       input.disabled = true;  // Elemen lainnya dinonaktifkan
  //       input.style.backgroundColor = '#eaeaea';
  //     }
  //   });

  //   // Memastikan elemen dapat diaktifkan sesuai urutan
  //   inputElements.forEach((input, index) => {
  //     input.addEventListener('input', () => {
  //       if (input.value.trim() !== '' && index < inputElements.length - 1) {
  //         inputElements[index + 1].disabled = false;  // Aktifkan elemen berikutnya
  //         inputElements[index + 1].style.backgroundColor = '#ffffff';
  //       } else {
  //         inputElements[index + 1].disabled = true;
  //         inputElements[index + 1].style.backgroundColor = '#eaeaea';
  //       }
  //     });

  //     // Khusus untuk elemen dengan atribut '
  //     if (input.getAttribute('set-data') === 'auto') {
  //       input.addEventListener('click', () => {
  //         if (input.value.trim() !== '' && index < inputElements.length - 1) {
  //           inputElements[index + 1].disabled = false;  // Aktifkan elemen berikutnya
  //           if(inputElements[index + 1].value.trim() !== ''){
  //             inputElements[index + 1].style.backgroundColor = '#ebffeb';
  //           } else {
  //             inputElements[index + 1].style.backgroundColor = '#ffffff';
  //           }
  //         } else {
  //           inputElements[index + 1].disabled = true;
  //           inputElements[index + 1].style.backgroundColor = '#eaeaea';
  //         }
  //       });
  //     }

  //     // Khusus untuk elemen select, gunakan 'change' event
  //     if (input.tagName.toLowerCase() === 'select') {
  //       input.addEventListener('change', () => {
  //         if (input.value.trim() !== '' && index < inputElements.length - 1) {
  //           inputElements[index + 1].disabled = false;  // Aktifkan elemen berikutnya
  //           inputElements[index + 1].style.backgroundColor = '#ffffff';
  //         }
  //       });
  //     }
  //   });
  // }

  function loadFormTambahData() {
  const container = document.getElementById('container-modal-form');
  const element = `
    <div class="flex justify-center align-middle p-5 absolute w-fit h-[680px] top-0 bg-black bg-opacity-90 z-10">
      <form id="form" class="no-select flex flex-col justify-center gap-2 mx-auto p-4 h-fit rounded-lg bg-white" autocomplete="off">
        <div class="col-12">
          <h4 class="font-bold text-xl">Form Tambah Data Siswa</h4>
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
              <input type="text" class="border rounded-md text-sm p-2" id="nama-lengkap-siswa" placeholder="Nama Lengkap Siswa" onchange="handleFillableInput(this)" required />
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="nomor-induk-siswa" class="flex flex-col py-1">
                  <span class="text-sm">Nomor Induk Siswa :</span>
                  <span class="text-xs">( <i>maks: 5 digit</i> )</span>
                </label>
                <span class="text-red-500">*</span>
              </div>
              <input type="number" class="no-adjustment-input border rounded-md text-sm p-2" min="00000" max="99999" id="nomor-induk-siswa" placeholder="Nomor Induk Siswa" onchange="handleFillableInput(this)" oninput="if(this.value.length > 5) this.value = this.value.slice(0, 5);" required />
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="tempat-lahir-siswa" class="text-sm">Tempat Lahir :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border p-2 text-sm rounded-md" id="tempat-lahir-siswa" placeholder="Tempat Lahir" onchange="handleFillableInput(this)" required />
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="tanggal-lahir-siswa" class="text-sm">Tanggal Lahir :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="date" class="border p-2 rounded-md text-sm" id="tanggal-lahir-siswa" onchange="handleFillableInput(this)" required />
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="jenis-kelamin" class="text-sm">Jenis Kelamin :</label>
                <span class="text-red-500">*</span>
              </div>
              <select id="jenis-kelamin" class="border rounded-md text-sm p-2" onchange="handleFillableInput(this)">
                <option disabled selected selected="selected" value="null">-- Pilih Jenis Kelamin --</option>
                <option value="L">Laki-Laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="kelas" class="text-sm">Kelas :</label>
                <span class="text-red-500">*</span>
              </div>
              <select id="kelas" class="border p-2 rounded-md text-sm" onchange="handleFillableInput(this)">
                <option disabled selected value="null">-- Pilih Kelas --</option>
                ${main.kelas?.map((kelas) => {
                  return `<option value="${kelas.nama_kelas}">${kelas.nama_kelas}</option>`;
                })}
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
              <input type="text" class="border p-2 rounded-md text-sm" id="nama-ayah" placeholder="Nama Ayah Siswa"
               onkeyup="loadListAyah()" onchange="handleFillableInput(this)" required />
                <div id="container-list-ayah" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="nomor-telepon-ayah" class="text-sm">Nomor Telepon Ayah :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="number" pattern="[0-9]" class="no-adjustment-input border rounded-md text-sm p-2"
                id="nomor-telepon-ayah" placeholder="Nomor Telepon Ayah"
                onchange="handleFillableInput(this)" />
                <div id="container-list-nomor-telepon-ayah" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="email-ayah" class="text-sm">Email Ayah :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="email" class="border rounded-md text-sm p-2" id="email-ayah" placeholder="Masukan Email Ayah" onchange="handleFillableInput(this)"/>
                <div id="container-list-email-ayah" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="nama-ibu" class="text-sm">Nama Ibu :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="nama-ibu" placeholder="Nama Ibu Siswa" onkeyup="loadListIbu()" onchange="handleFillableInput(this)" />
                <div id="container-list-ibu" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="nomor-telepon-ibu" class="text-sm">Nomor Telepon Ibu :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="number" pattern="[0-9]" class="no-adjustment-input border text-sm rounded-md p-2" id="nomor-telepon-ibu" placeholder="Nomor Telepon Ibu" onchange="handleFillableInput(this)" />
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="email-ibu" class="text-sm">Email Ibu :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="email" class="border rounded-md text-sm p-2" id="email-ibu" placeholder="Masukan Email Ibu" onchange="handleFillableInput(this)" />
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
                onkeyup="loadListProvinsi()" onchange="handleFillableInput(this)" />
                <div id="container-list-provinsi" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="kabupaten" class="text-sm">Kabupaten :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="kabupaten" placeholder="Masukan Kabupaten"
                onkeyup="loadListKabupaten()" onchange="handleFillableInput(this)"/>
                <div id="container-list-kabupaten" class="position w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="kecamatan" class="text-sm">Kecamatan :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" pattern="[0-9]" class="border rounded-md text-sm p-2" id="kecamatan" placeholder="Masukan Kecamatan" onkeyup="loadListKecamatan()" onchange="handleFillableInput(this)"/>
                <div id="container-list-kecamatan" class="relative w-full">
                </div>
            </div>
            <div class="flex flex-col">
              <div class="flex flex-row gap-1">
                <label for="desa" class="text-sm">Desa / Kelurahan :</label>
                <span class="text-red-500">*</span>
              </div>
              <input type="text" class="border rounded-md text-sm p-2" id="desa" placeholder="Masukan Desa / Keluruhan"
                required onkeyup="loadListDesa()" onchange="handleFillableInput(this)"/>
                <div id="container-list-desa" class="relative w-full">
                </div>
            </div>
            <div class="row">
              <div class="col-6 flex flex-col">
                <div class="flex flex-row gap-1">
                  <label for="rt" class="text-sm">RT :</label>
                  <span class="text-red-500">*</span>
                </div>
                <input type="number" min="0" max="100" class="col border rounded-md text-sm p-2" id="rt" placeholder="000"  oninput="formatInputNumber('rt')" onchange="handleFillableInput(this)"/>
              </div>
              <div class="col-6 flex flex-col">
                <div class="flex flex-row gap-1">
                  <label for="rt" class="text-sm">RW :</label>
                  <span class="text-red-500">*</span>
                </div>
                <input type="number" min="0" max="100" class="col border rounded-md text-sm p-2" id="rw" placeholder="000"
                oninput="formatInputNumber('rw')" onchange="handleFillableInput(this)" />
              </div>
            </div>
            <div class="flex flex-col">
              <label for="kode-pos" class="text-sm">Kode Pos :</label>
              <input type="number" pattern="[0-9]" class="border rounded-md text-sm p-2" id="kode-pos" placeholder="Masukan Kode Pos" onchange="handleFillableInput(this)"/>
            </div>
          </div>
          <div class="flex flex-col gap-2">
            <div class="flex flex-col justify-center gap-1 p-2 border rounded-md">
              <h6 class="font-semibold ">Photo Siswa</h6>
              <output id="imageOutput" class="align-center">
                <img src="../assets/images/default-image.png" class="w-full" id="previewImage">
              </output>
              <input type="file" name="fileInput" id="fileInput" accept="image/png, image/jpg, image/jpeg" class="w-full" onchange="inputPhotoSiswa(event)">
            </div>
          </div>
        </div>
        <div class="flex flex-row justify-content-end py-1 gap-2">
          <button class="bg-red-600 py-1 px-2 rounded-md text-white hover:bg-red-500 hover:font-semibold" onclick="cancelForm()">Batal</button>
          <button type="reset" class="bg-yellow-500 py-1 px-2 rounded-md hover:bg-yellow-400 hover:font-semibold" onclick="handleReset()">Reset</button>
          <button class="bg-blue-800 py-1 px-2 text-white rounded-md hover:bg-blue-600 hover:font-semibold">Tambah</button>
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
      input.value = ''; // Kosongkan input jika tidak sesuai
  }
}


function cancelForm() {
  const container = document.getElementById('container-modal-form');
  container.innerHTML = '';
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
        fileInput.value = ''; // Reset the file input if the file is not valid
    }
}