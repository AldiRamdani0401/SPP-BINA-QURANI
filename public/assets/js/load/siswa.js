function loadDataSiswa(callback) {
  const offset = siswa.offset;
  const limit = siswa.limit;
  const orderBy = siswa.orderBy;
  const filterBy = siswa.filterBy;

  fetch('/data-siswa', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      limit: limit,
      offset: offset,
      orderBy: orderBy,
      filterBy: filterBy
    })
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok: ' + response.statusText);
    }
    return response.json();
  })
  .then(datas => {
    siswa.datas = [...datas.data];
    siswa.headers = [...Object.keys(datas?.data[0])];
    siswa.load = datas.data.length;
    siswa.total = datas.total;

    if (typeof callback === 'function') {
      callback(datas);
    }
  })
  .catch(error => {
    siswa.load = 0;
    siswa.total = 0;
    siswa.status = 'Data Not Found';
  });
}

// Add Data Siswa
function addDataSiswa() {
  if (!form || !form.datas) {
    console.error('Data form tidak tersedia');
    return;
  }

  console.log('form: ', form.datas);
  fetch('/data-siswa/add', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      // pastikan data yang dikirim ada dan valid
      "nama-lengkap-siswa": form.datas['nama-lengkap-siswa'] || '',
      "nomor-induk-siswa": form.datas['nomor-induk-siswa'] || '',
      "jenis-kelamin": form.datas['jenis-kelamin'] || '',
      "tanggal-lahir-siswa": form.datas['tanggal-lahir-siswa'] || '',
      "tempat-lahir-siswa": form.datas['tempat-lahir-siswa'] || '',
      "kelas": form.datas.kelas || '',
      "nama-ayah": form.datas['nama-ayah'] || '',
      "nomor-telepon-ayah": form.datas['nomor-telepon-ayah'] || '',
      "email-ayah": form.datas['email-ayah'] || '',
      "nama-ibu": form.datas['nama-ibu'] || '',
      "nomor-telepon-ibu": form.datas['nomor-telepon-ibu'] || '',
      "email-ibu": form.datas['email-ibu'] || '',
      "rt": form.datas.rt || '',
      "rw": form.datas.rw || '',
      "provinsi": form.datas.provinsi || '',
      "kabupaten": form.datas.kabupaten || '',
      "kecamatan": form.datas.kecamatan || '',
      "desa": form.datas.desa || '',
      "kode-pos": form.datas['kode-pos'] || ''
    })
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok: ' + response.statusText);
    }
    return response.json();
  })
  .then(data => {
    console.log('Response data: ', data);
  })
  .catch(error => {
    console.error('Terjadi kesalahan: ', error);
  });
}
