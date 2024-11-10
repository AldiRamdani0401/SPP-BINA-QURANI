  // Library
  const { component, render } = reef;
  const nosql = new FlyJson();

  const kelas = signal({
    datas: [],
    headers: [],
    load: 10,
    total: 20
  }, 'data-kelas');

  kelas.datas = [
    {
      id: '001',
      kelas: '1A',
      total: 30
    },
    {
      id: '002',
      kelas: '1B',
      total: 30
    },
    {
      id: '003',
      kelas: '1C',
      total: 30
    },
    {
      id: '004',
      kelas: '2A',
      total: 30
    },
    {
      id: '005',
      kelas: '2B',
      total: 30
    },
    {
      id: '006',
      kelas: '2C',
      total: 30
    },
    {
      id: '007',
      kelas: '3A',
      total: 30
    },
    {
      id: '008',
      kelas: '3B',
      total: 30
    },
    {
      id: '009',
      kelas: '3C',
      total: 30
    },
    {
      id: '010',
      kelas: '4A',
      total: 30
    },
    {
      id: '011',
      kelas: '4B',
      total: 30
    },
    {
      id: '012',
      kelas: '4C',
      total: 30
    },
    {
      id: '013',
      kelas: '5A',
      total: 30
    },
    {
      id: '014',
      kelas: '5B',
      total: 30
    },
    {
      id: '015',
      kelas: '5C',
      total: 30
    },
    {
      id: '016',
      kelas: '6A',
      total: 30
    },
    {
      id: '017',
      kelas: '6B',
      total: 30
    },
    {
      id: '018',
      kelas: '6C',
      total: 30
    },
  ];

  kelas.headers = ['Kode Kelas', 'Nama Kelas', 'Total Siswa'];

  // function loadDataKelas(callback) {
  //   fetch('/data-kelas')
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
      siswa.datas = [];
      if (filterSearch != "" && filterBy != "") {
          console.log('search 1');
          siswa.filterBy = '';
          siswa.filterBy = `${filterSearch} LIKE '%${keyword}%' AND ${filterBy}`;
          console.log(siswa.filterBy);
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
      'data-siswa'
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

  component('#search-table', templateInputSearch, {events: {searchData, showTooltip, hideTooltip}, signals: ['data-siswa']});

  // # Table Head
  function templateTableHead() {
    let dom = '<tr class="sticky top-0 bg-[#EDEDED]"><th class="p-2 border text-sm text-nowrap">No</th>';
    const headNames = kelas.headers;
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
  component('#table-head', templateTableHead, {signals: ['data-kelas']});

  // # Table Body
  function templateTableData() {
    let dom = '';
    let count = 1;
    if (kelas.datas?.length > 0) {
      kelas.datas.forEach(data => {
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
            <td colspan="19" class="p-2 border text-sm text-nowrap">${siswa.status}</td>
          </tr>
        `;
    }
    return dom;
  }

  component('#table-body', templateTableData, {signals: ['data-kelas']});

  // Pagination Table
  function loadMore(callback) {
    let tempData = siswa.datas;
    console.log(1, tempData, siswa.offset)
    siswa.offset += siswa.limit;
    // TEST
    SimpleTest(siswa.offset + siswa.limit, siswa.offset + siswa.limit, 'Load More');

    // Hanya kirim request jika load saat ini kurang dari total
    if (siswa.load < siswa.total) {
        loadDataSiswa((datas) => {
          tempData.push(...datas.data);
          console.log(2, tempData);
          siswa.datas = [...tempData];
          siswa.load = siswa.datas.length;
        });
        if (siswa.load >= siswa.total) {
            siswa.load = siswa.total;
        }
    } else {
        if (typeof callback === 'function') {
            callback();
        }
        return false;
    }
}


  function templatePagination() {
    if (kelas.load < kelas.total) {
      return `
          <button type="button" class="bg-blue-900 text-white px-2 py-1 rounded-lg h-full" onclick="loadMore()">Load More</button>
          <span class="px-2 py-1" style="background:white; border-radius:5px;"> ${kelas.load} of ${kelas.total} </span>
      `;
    } else {
      return `
        <span class="px-2 py-1" style="background:white; border-radius:5px;"> ${kelas.load} of ${kelas.total} </span>
      `;
    }
  }

  component('#pagination', templatePagination, {signals: ['data-kelas'], events: {loadMore}});

  // Event Load
  // document.addEventListener("DOMContentLoaded", () => {
  //   loadDataOrangTua(() => {
  //     orangtua.load = 10;
  //     orangtua.total = orangtua.datas.length;
  //   });
  // });