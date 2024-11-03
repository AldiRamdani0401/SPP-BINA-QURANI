const { signal, store} = reef;

const siswa = signal({
  datas: [],
  headers: [],
  kelas: [],
  listFilterGroupBy: [],
  reset: [],
  orderBy: 'nomor_induk_siswa',
  filterBy: '',
  keyword: '',
  load: 0,
  limit: 10,
  total: 0,
  offset: 0,
  status: 'Loading..',
}, 'data-siswa');