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
  selected: [],
  status: 'Loading..',
}, 'data-siswa');

const orangtua = signal({
  datas: [],
  headers: [],
  selected: [],
  load: 0,
  limit: 10,
  offset: 0,
  total:0
}, 'data-orang-tua');

const regions = signal({
  provinsi: [],
  kabupaten: [],
  kecamatan: [],
  desa: [],
  selected: [],
}, 'data-provinsi');