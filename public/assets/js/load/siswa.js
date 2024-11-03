function loadDataSiswa(callback) {
  const offset = siswa.offset;
  const limit = siswa.limit;
  const orderBy = siswa.orderBy;
  const filterBy = siswa.filterBy;

  console.log({
    limit: limit,
    offset: offset,
    orderBy: orderBy,
    filterBy: filterBy
  });
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