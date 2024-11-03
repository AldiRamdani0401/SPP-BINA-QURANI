function loadDataKelas(callback) {
  fetch('/data-kelas')
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
      }
      return response.json();
    })
    .then(datas => {
      siswa.kelas = [...datas[1]];
      // Memeriksa apakah callback adalah fungsi
      if (typeof callback === 'function') {
        callback(); // Panggil callback
      }
    })
    .catch(error => console.error('Fetch error:', error));
}
