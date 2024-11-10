  // Library
  const { component, render } = reef;
  const nosql = new FlyJson();

  const SPP = signal({
    datas: [],
    headers: [],
    load: 10,
    total: 20
  }, 'data-biaya-spp');

  SPP.datas = [
    {
        kode_spp: '001',
        biaya: 'Pembangunan',
        nominal: 300000,
        jatuh_tempo: 'per bulan',
        keterangan: ''
    },
    {
        kode_spp: '002',
        biaya: 'Operasional Sekolah',
        nominal: 200000,
        jatuh_tempo: 'per bulan',
        keterangan: 'Biaya untuk keperluan operasional harian'
    },
    {
        kode_spp: '003',
        biaya: 'Kegiatan Ekstrakurikuler',
        nominal: 100000,
        jatuh_tempo: 'per semester',
        keterangan: 'Termasuk biaya kegiatan klub dan pelatihan'
    },
    {
        kode_spp: '004',
        biaya: 'Seragam Sekolah',
        nominal: 500000,
        jatuh_tempo: 'sekali pembayaran',
        keterangan: 'Biaya untuk seragam sekolah lengkap'
    },
    {
        kode_spp: '005',
        biaya: 'Buku Pelajaran',
        nominal: 150000,
        jatuh_tempo: 'per semester',
        keterangan: 'Pembelian buku pelajaran wajib'
    },
    {
        kode_spp: '006',
        biaya: 'Perawatan Gedung',
        nominal: 250000,
        jatuh_tempo: 'per tahun',
        keterangan: 'Biaya untuk pemeliharaan gedung sekolah'
    },
    {
        kode_spp: '007',
        biaya: 'Transportasi Sekolah',
        nominal: 400000,
        jatuh_tempo: 'per bulan',
        keterangan: 'Untuk layanan antar-jemput siswa'
    },
    {
        kode_spp: '008',
        biaya: 'Uang Praktikum',
        nominal: 200000,
        jatuh_tempo: 'per bulan',
        keterangan: 'Untuk keperluan alat dan bahan praktikum'
    },
    {
        kode_spp: '009',
        biaya: 'Uang Kegiatan Akhir Tahun',
        nominal: 600000,
        jatuh_tempo: 'sekali pembayaran',
        keterangan: 'Biaya acara perpisahan dan kegiatan akhir tahun'
    },
    {
        kode_spp: '010',
        biaya: 'Asuransi Kesehatan',
        nominal: 100000,
        jatuh_tempo: 'per bulan',
        keterangan: 'Asuransi kesehatan siswa'
    }
];


  SPP.headers = ['Kode SPP', 'Biaya', 'Nominal', 'Jatuh Tempo', 'Keterangan'];

  // function loadDataKelas(callback) {
  //   fetch('/data-biaya-spp')
  //     .then(response => {
  //       if (!response.ok) {
  //         throw new Error('Network response was not ok: ' + response.statusText);
  //       }
  //       return response.json();
  //     })
  //     .then(datas => {
  //       siswa.kelas = [...datas[1]];
  //       // Memeriksa apakah callback adalah fungsi
  //       if (typeof callback === 'function') {
  //         callback(); // Panggil callback
  //       }
  //     })
  //     .catch(error => console.error('Fetch error:', error));
  // }

  // Helper Function Store Data
  const reset = [];
  const helperReset = {
    add(data) {
      siswa.reset.push(data);
    },

    delete(index, amount) {
      siswa.reset.splice(index, amount)
    }
  }


  // Get Tab Labels
  function getListGroupBy() {
    let jenisKelamin = nosql.set(siswa.datas).select(['jenis_kelamin']).exec();
        jenisKelamin = [...new Set(jenisKelamin.map(item => item.jenis_kelamin))].sort((a, b) => a - b);

    let kelas = nosql.set(siswa.kelas).select(['nama_kelas']).exec();
        kelas = [...new Set(kelas.map(item => item.nama_kelas))].sort((a, b) => a - b); // Ascending

    siswa.listFilterGroupBy = [...jenisKelamin, ...kelas];
  }

  // Table Component

  // ## Reset Button
  function templateBtnReset(name, containerId, callback) {
    const existingBtnReset = document.getElementById(`btn-reset-${name}`);
    if (existingBtnReset) {
      return false;
    }

    const container = document.getElementById(containerId);

    const btnResetElement = document.createElement("button");
          btnResetElement.innerText = "Reset";
          btnResetElement.setAttribute("id", `btn-reset-${name}`);
          btnResetElement.classList.add(
            "bg-red-600",
            "text-white",
            "px-2",
            "py-1",
            "rounded-lg",
            "absolute",
            "left-0",
            "right-0",
            "mx-auto"
          );

          helperReset.add(btnResetElement.id);

          // Gunakan data dari parameter function di sini
          btnResetElement.addEventListener("click", function () {
            const order = siswa.reset.indexOf(btnResetElement.id);
            switch (order) {
              case 0:
                console.log(1);
                siswa.load = 0;
                siswa.total = 0;
                siswa.offset = 0;
                siswa.limit = 10;
                siswa.filterBy = '';
                siswa.keyword = '';
                loadDataSiswa();
                siswa.reset.map((btn) => {
                  let button = document.getElementById(btn);
                  button.click();
                  button.remove();
                })
                helperReset.delete(order, 2);
                break;
              case 1:
                console.log(2);
                siswa.load = 0;
                siswa.total = 0;
                siswa.offset = 0;
                btnResetElement.remove();
                helperReset.delete(order, 1);
                loadDataSiswa();
                break;
            }
            if (typeof callback === 'function'){
                callback();
            }
          });
          container.appendChild(btnResetElement);
  }

  // # Search Input Table
  // ## Search Data
  function searchData() {
    const inputSearchElement = document.getElementById('search-input-table');
    const selectSearchFilterElement = document.getElementById('select-search-filter');
    const filterSearch = selectSearchFilterElement.value;
    const filterBy = siswa.filterBy;
    const keyword = inputSearchElement.value;

    if (keyword !== "") {
      SPP.datas = [];
      if (filterSearch != "" && filterBy != "") {
          console.log('search 1');
          SPP.filterBy = '';
          SPP.filterBy = `${filterSearch} LIKE '%${keyword}%' AND ${filterBy}`;
          console.log(SPP.filterBy);
          loadDataSiswa(() => {
            templateBtnReset('search', 'container-btn-reset-search', () => {
              render('#search-table', templateInputSearch)
            });
          });
          siswa.filterBy = '';
        } else if (filterSearch != "") {
          console.log('search 2');
          siswa.filterBy = `${filterSearch} LIKE '%${keyword}%'`;
          loadDataSiswa(() => {
            templateBtnReset('search', 'container-btn-reset-search', () => {
              render('#search-table', templateInputSearch)
            });
          });
          siswa.filterBy = '';
          console.log(siswa.filterBy);
        } else if (filterBy != '') {
          // Pencarian Tanpa Filter Pencarian, Tapi dengan Group By
          console.log('search 3');
          siswa.filterBy = `(nama_lengkap LIKE '%${keyword}%' OR kelas LIKE '%${keyword}%' OR nama_ayah LIKE '%${keyword}%' OR nama_ibu LIKE '%${keyword}%') AND ${filterBy}`;
          loadDataSiswa(() => {
            templateBtnReset('search', 'container-btn-reset-search', () => {
              render('#search-table', templateInputSearch)
            });
            siswa.filterBy = filterBy;
          });
        } else {
          console.log('search 4');
          // Pencarian Tanpa Filter Pencarian & Tanpa Group By
          siswa.filterBy = `nama_lengkap LIKE '%${keyword}%' OR kelas LIKE '%${keyword}%' OR nama_ayah LIKE '%${keyword}%' OR nama_ibu LIKE '%${keyword}%'`;

          loadDataSiswa(() => {
            templateBtnReset('search', 'container-btn-reset-search', () => {
              render('#search-table', templateInputSearch)
            });
          });
          siswa.keyword = keyword;
        }
    } else {
        Swal.fire({
          title: 'Oops!',
          text: 'Kata kunci pencarian tidak boleh kosong.',
          icon: 'warning',
          confirmButtonText: 'OK',
          confirmButtonColor: '#3085d6',
          backdrop: `
              rgba(0,0,123,0.4)
              left top
              no-repeat
          `
      });
    }
  }

  // ## Filter Data By Limit
  function handleLimitData(element) {
    const limit = parseInt(element.target.value);
    siswa.limit = limit;

    loadDataSiswa(() => {
      templateBtnReset('filter', 'container-btn-reset-groupby', () => {
        render('#container-filter-data-table', templateFilterData)
      });
    });
  }

  // Perbaiki Bagian Ini
  function templateFilterData() {
    let dom = '';
    let filterLimit = '<select id="select-data-limit" style="height:35px;border-radius:5px;font-size:13px;" onchange="handleLimitData(this.value)"><option disabled selected value="">-- Limit Data --</option>';

    // Reset `filter.limits` untuk menghindari duplikat
    let countData = Math.ceil(siswa.total / 10);

    // Mengisi `filter.limits` dan `dom` hanya jika `countData` lebih dari 0
    if (countData > 0) {
        for (let i = 1; i <= countData; i++) {
            const limit = i * 10;
            // Selected Limit
              filterLimit += `<option id="limit-value-${limit}" value="${limit}">${limit} Data</option>`;
        }

    }

    filterLimit += '</select>';

    let filterByGroup = `<select id="select-data-group-by" style="height:35px;width:fit-content;border-radius:5px;font-size:13px;" onchange="handleFilterDataGroupBy(this.value)"> <option disabled selected selected="selected" value="">-- Group By --</option>`;

    if (siswa.listFilterGroupBy.length > 0) {
      siswa.listFilterGroupBy.forEach((group) => {
        let groupName = '';
        let groupKey = '';

          switch (group) {
            case 'L':
                groupName = 'Laki-Laki';
                groupKey = 'jenis_kelamin';
              break;
            case 'P':
                groupName = 'Perempuan';
                groupKey = 'jenis_kelamin';
              break;
            default:
                groupName = group;
                groupKey = 'kelas';
              break;
          }
          filterByGroup += `<option name="${groupKey}" id="${group}" value="${group}">${groupName}</option>`;
        });
    } else {
      filterByGroup += "Loading...";
    }
    filterByGroup += "</select>";

    dom += filterLimit + filterByGroup;
    return dom;
  }

  component('#container-filter-data-table', templateFilterData, {
    events:{
      handleLimitData, handleFilterDataGroupBy, templateBtnReset
    },
    signals:[
      'data-biaya-spp'
    ]
  });

  function handleFilterDataGroupBy(element) {
    siswa.limit = 10;
    siswa.offset = 0;
    siswa.load = 0;
    siswa.total = 0;
    siswa.groupBy = '';
    siswa.datas = [];

    const container = document.getElementById('select-data-group-by');
          container.setAttribute('disabled', true);
    const filterByValue = element.target?.value ?? element;
    const keyFilterBy = document.getElementById(filterByValue).getAttribute('name');

    const keyword = siswa.keyword && `(nama_lengkap LIKE '%${siswa.keyword}%' OR kelas LIKE '%${siswa.keyword}%' OR nama_ayah LIKE '%${siswa.keyword}%' OR nama_ibu LIKE '%${siswa.keyword}%')`;

    const defaultParam = `${keyFilterBy} = '${filterByValue}'`;
    const filterByParamAndValue = keyword != '' ? `${keyword} AND ${defaultParam}` : defaultParam;
    siswa.filterBy = filterByParamAndValue;
    loadDataSiswa(() => {
      templateBtnReset('filter', 'container-btn-reset-groupby', () => {
        render('#container-filter-data-table', templateFilterData);
      });
      siswa.filterBy = keyword != '' ? keyword : defaultParam;
    });
  }

  // Input Search
  function showTooltip() {
    const selectSearchFilterElement = document.getElementById('select-search-filter');
    const tooltip = document.getElementById("tooltip");

    if (selectSearchFilterElement.value == ''){
      tooltip.style.visibility = "visible";
    }
  }

  function hideTooltip() {
    const tooltip = document.getElementById("tooltip");
    tooltip.style.visibility = "hidden";
  }

  function templateInputSearch(){
    const icon = '../assets/icon/icon-search.png';
    let dom = '';

    let select = '<select id="select-search-filter" style="height:35px;border-radius:5px;font-size:13px;"><option disabled selected selected="selected" value="">-- Pilih Filter Pencarian --</option>';

    const headNames = siswa.headers;
    let formatedHeadNames = [];
    headNames.forEach(headName => {
      let nameToUpperCase = headName.charAt(0).toUpperCase() + headName.slice(1);
      let formatedName = nameToUpperCase.replace(/_/g, " ");
      formatedHeadNames.push(formatedName);
    });

    siswa.headers.forEach((header, index) => {
      select += `<option value="${header}">${formatedHeadNames[index]}</option>`;
    });

    select += '</select>';
    dom += select;
    dom += `
    <div class="flex flex-row h-full">
        <div class="relative inline-block">
        <input id="search-input-table"
           type="text"
           placeholder="Masukan Kata Kunci Pencarian"
           class="rounded-l-lg h-full"
           onfocus="showTooltip()"
           onblur="hideTooltip()" autocomplete="off"/>
          <!-- Tooltip -->
         <span id="tooltip" class="invisible text-xs bg-gray-800 text-white text-center p-1.5 rounded absolute top-10 left-0 z-50 whitespace-nowrap">
         Default: <i>Nama Lengkap Siswa, Kelas, Nama Ayah, Nama Ibu</i>
        </span>
      </div>
        <button class="rounded-r-lg bg-blue-900 h-full" onclick="searchData()">
            <img class="p-1" src="${icon}">
        </button>
      </div>
    `;
    return dom;
  }

  component('#search-table', templateInputSearch, {events: {searchData, showTooltip, hideTooltip}, signals: ['data-biaya-spp']});

  // # Table Head
  function templateTableHead() {
    let dom = '<tr class="sticky top-0 bg-[#EDEDED]"><th class="p-2 border text-sm text-nowrap">No</th>';
    const headNames = SPP.headers;
    let formatedHeadNames = [];
    headNames.forEach(headName => {
      let nameToUpperCase = headName.charAt(0).toUpperCase() + headName.slice(1);
      let formatedName = nameToUpperCase.replace(/_/g, " ");
      formatedHeadNames.push(formatedName);
    });

    formatedHeadNames.forEach(name => {
      dom += `
        <th class="p-2 border text-sm text-nowrap">${name}</th>
      `;
    });

    dom += '</tr>';
    return dom;
  }
  component('#table-head', templateTableHead, {signals: ['data-biaya-spp']});

  // # Table Body
  function templateTableData() {
    let dom = '';
    let count = 1;
    if (SPP.datas?.length > 0) {
      SPP.datas.forEach(data => {
            dom += `<tr class="bg-white"><td class="p-2 border text-sm text-nowrap">${count}</td>`;
              for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    dom += `<td class="p-2 border text-sm text-nowrap">${data[key]}</td>`;
                }
              }
            dom += '</tr>';
        count++;
      });
    } else {
      dom += `
          <tr style="background:white;">
            <td colspan="19" class="p-2 border text-sm text-nowrap">${SPP.status}</td>
          </tr>
        `;
    }
    return dom;
  }

  component('#table-body', templateTableData, {signals: ['data-biaya-spp']});

  // Pagination Table
  function loadMore(callback) {
    let tempData = SPP.datas;
    console.log(1, tempData, SPP.offset)
    SPP.offset += SPP.limit;
    // TEST
    SimpleTest(SPP.offset + SPP.limit, SPP.offset + SPP.limit, 'Load More');

    // Hanya kirim request jika load saat ini kurang dari total
    if (SPP.load < SPP.total) {
        loadDataSPP((datas) => {
          tempData.push(...datas.data);
          console.log(2, tempData);
          SPP.datas = [...tempData];
          SPP.load = SPP.datas.length;
        });
        if (SPP.load >= SPP.total) {
            SPP.load = SPP.total;
        }
    } else {
        if (typeof callback === 'function') {
            callback();
        }
        return false;
    }
}


  function templatePagination() {
    if (SPP.load < SPP.total) {
      return `
          <button type="button" class="bg-blue-900 text-white px-2 py-1 rounded-lg h-full" onclick="loadMore()">Load More</button>
          <span class="px-2 py-1" style="background:white; border-radius:5px;"> ${SPP.load} of ${SPP.total} </span>
      `;
    } else {
      return `
        <span class="px-2 py-1" style="background:white; border-radius:5px;"> ${SPP.load} of ${SPP.total} </span>
      `;
    }
  }

  component('#pagination', templatePagination, {signals: ['data-biaya-spp'], events: {loadMore}});

  // Event Load
  // document.addEventListener("DOMContentLoaded", () => {
  //   loadDataOrangTua(() => {
  //     orangtua.load = 10;
  //     orangtua.total = orangtua.datas.length;
  //   });
  // });