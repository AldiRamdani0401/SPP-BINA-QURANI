const form = signal({
  datas: {}
}, 'data-form');

function loadListAyah() {
  const container = document.getElementById('container-list-ayah');
  const inputElement = document.getElementById('nama-ayah');
  const keyword = inputElement.value;

  if (keyword.length > 3) {
        const result = nosql.set(orangtua.datas)
              .where('nama_lengkap', 'LIKE', keyword, false)
              .where('hubungan', '===', 'Ayah').exec();

        orangtua.selected = [...result];

        // Membuat konten berdasarkan data yang diambil
        let containerList = `
        <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
        <ul class="my-auto" style="list-style-type: none;">
        `;

        // Menambahkan data ke dalam list
        result.forEach(ayah => {
          containerList += `<li id="${ayah.id}" name="nama-ayah" class="ayah" onclick="
            handleSelectedList(this)">${ayah.nama_lengkap}</li>`;
        });

        containerList += `
            </ul>
          </div>
        `;

        // Update kontainer dengan HTML baru
        container.innerHTML = containerList;
  }
}

function loadListIbu() {
  const container = document.getElementById('container-list-ibu');
  const inputElement = document.getElementById('nama-ibu');
  const keyword = inputElement.value;

  if (keyword.length > 3) {
        const result = nosql.set(orangtua.datas)
              .where('nama_lengkap', 'LIKE', keyword, false)
              .where('hubungan', '===', 'Ibu').exec();

        orangtua.selected = [...result];

        // Membuat konten berdasarkan data yang diambil
        let containerList = `
        <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
        <ul class="my-auto" style="list-style-type: none;">
        `;

        // Menambahkan data ke dalam list
        result.forEach(ibu => {
          containerList += `<li id="${ibu.id}" name="nama-ibu" class="ibu" onclick="
            handleSelectedList(this)">${ibu.nama_lengkap}</li>`;
        });

        containerList += `
            </ul>
          </div>
        `;

        // Update kontainer dengan HTML baru
        container.innerHTML = containerList;
  }
}

function loadListProvinsi() {
  const container = document.getElementById('container-list-provinsi');
  const inputElement = document.getElementById('provinsi');
  if (!container || !inputElement) {
    console.error('Elemen container atau input tidak ditemukan');
    return;
  }

  if (regions.provinsi.length == 0) {
    loadDataProvincies();
  }

  const keyword = inputElement.value;

  inputElement.addEventListener('blur', () => {
    if (keyword === '') {
      inputElement.classList.remove('bg-green-100');
      inputElement.classList.add('bg-white');
    } else {
      inputElement.classList.remove('bg-white');
      inputElement.classList.add('bg-green-100');
    }
  });

  if (keyword.length > 3 && regions.provinsi.length > 0) {
    const result = nosql.set(regions.provinsi)
          .where('name', 'LIKE', keyword, false).exec();

    // Membuat konten berdasarkan data yang diambil
    let containerList = `
    <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
    <ul class="my-auto" style="list-style-type: none;">
    `;

    // Menambahkan data ke dalam list
    result.forEach(provinsi => {
      containerList += `<li id="${provinsi.id}" name="provinsi" class="provinsi" onclick="handleSelectedRegion(this)">${provinsi.name}</li>`;
    });

    containerList += `
        </ul>
      </div>
    `;

    // Update kontainer dengan HTML baru
    container.innerHTML = containerList;
  }
}

function loadListKabupaten() {
  const container = document.getElementById('container-list-kabupaten');
  const inputElement = document.getElementById('kabupaten');
  if (!container || !inputElement) {
    console.error('Elemen container atau input tidak ditemukan');
    return;
  }

  if (regions.kabupaten.length == 0) {
    loadDataRegencies(regions.selected[0][0]);
    console.log(regions.kabupaten);
  }

  const keyword = inputElement.value;

  inputElement.addEventListener('blur', () => {
    if (keyword === '') {
      inputElement.classList.remove('bg-green-100');
      inputElement.classList.add('bg-white');
    } else {
      inputElement.classList.remove('bg-white');
      inputElement.classList.add('bg-green-100');
    }
  });

  if (keyword.length > 3 && regions.kabupaten.length > 0) {
    const result = nosql.set(regions.kabupaten)
          .where('name', 'LIKE', keyword, false).exec();

    // Membuat konten berdasarkan data yang diambil
    let containerList = `
    <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
    <ul class="my-auto" style="list-style-type: none;">
    `;

    // Menambahkan data ke dalam list
    result.forEach(kabupaten => {
      containerList += `<li id="${kabupaten.id}" name="kabupaten" class="kabupaten" onclick="handleSelectedRegion(this)">${kabupaten.name}</li>`;
    });

    containerList += `
        </ul>
      </div>
    `;

    // Update kontainer dengan HTML baru
    container.innerHTML = containerList;
  }
}

function loadListKecamatan() {
  const container = document.getElementById('container-list-kecamatan');
  const inputElement = document.getElementById('kecamatan');
  if (!container || !inputElement) {
    console.error('Elemen container atau input tidak ditemukan');
    return;
  }

  if (regions.kecamatan.length == 0) {
    loadDataDistricts(regions.selected[1][0]);
    console.log(regions.kecamatan);
  }

  const keyword = inputElement.value;

  inputElement.addEventListener('blur', () => {
    if (keyword === '') {
      inputElement.classList.remove('bg-green-100');
      inputElement.classList.add('bg-white');
    } else {
      inputElement.classList.remove('bg-white');
      inputElement.classList.add('bg-green-100');
    }
  });

  if (keyword.length > 3 && regions.kecamatan.length > 0) {
    const result = nosql.set(regions.kecamatan)
          .where('name', 'LIKE', keyword, false).exec();

    // Membuat konten berdasarkan data yang diambil
    let containerList = `
    <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
    <ul class="my-auto" style="list-style-type: none;">
    `;

    // Menambahkan data ke dalam list
    result.forEach(kecamatan => {
      containerList += `<li id="${kecamatan.id}" name="kecamatan" class="kecamatan" onclick="handleSelectedRegion(this)">${kecamatan.name}</li>`;
    });

    containerList += `
        </ul>
      </div>
    `;

    // Update kontainer dengan HTML baru
    container.innerHTML = containerList;
  }
}

function loadListDesa() {
  const container = document.getElementById('container-list-desa');
  const inputElement = document.getElementById('desa');
  if (!container || !inputElement) {
    console.error('Elemen container atau input tidak ditemukan');
    return;
  }

  if (regions.desa.length == 0) {
    loadDataVillages(regions.selected[2][0]);
    console.log(regions.desa);
  }

  const keyword = inputElement.value;

  inputElement.addEventListener('blur', () => {
    if (keyword === '') {
      inputElement.classList.remove('bg-green-100');
      inputElement.classList.add('bg-white');
    } else {
      inputElement.classList.remove('bg-white');
      inputElement.classList.add('bg-green-100');
    }
  });

  if (keyword.length > 3 && regions.desa.length > 0) {
    const result = nosql.set(regions.desa)
          .where('name', 'LIKE', keyword, false).exec();

    // Membuat konten berdasarkan data yang diambil
    let containerList = `
    <div style="max-height:200px;width:215px;position:absolute;background:#eaeaea;top:0px;overflow:auto;">
    <ul class="my-auto" style="list-style-type: none;">
    `;

    // Menambahkan data ke dalam list
    result.forEach(desa => {
      containerList += `<li id="${desa.id}" name="desa" class="desa" onclick="handleSelectedRegion(this)">${desa.name}</li>`;
    });

    containerList += `
        </ul>
      </div>
    `;

    // Update kontainer dengan HTML baru
    container.innerHTML = containerList;
  }
}


const arrayInputElements = [];
