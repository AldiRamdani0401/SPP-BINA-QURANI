function loadDataProvincies() {
  return fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
    .then(response => {
      return response.json()
    })
    .then((data) => {
      regions.provinsi = [...data];
    })
    .catch(error => {
      console.error('Fetch error:', error);
      throw error;
    });
}

function loadDataRegencies(provinceId){
  console.log(provinceId);
  return fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
  .then(response => {
    return response.json()
  })
  .then((data) => {
    regions.kabupaten = [...data];
  })
  .catch(error => {
    console.error('Fetch error:', error);
    throw error;
  });
}

function loadDataDistricts(kabupatenId){
// ID KABUPATEN KARAWANG = 3215
  return fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabupatenId}.json`)
  .then(response => {
    return response.json()
  })
  .then((data) => {
    regions.kecamatan = [...data];
  })
  .catch(error => console.error('Fetch error:', error));
}

function loadDataVillages(kecamatanId){
// ID Kecamatan TALAGASARI = 3215100
  return fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatanId}.json`)
  .then(response => {
    return response.json()
  })
  .then((data) => {
    regions.desa = [...data];
  })
  .catch(error => console.error('Fetch error:', error));
}
