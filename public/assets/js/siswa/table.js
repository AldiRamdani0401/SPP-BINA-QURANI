  // Library
  const { signal, store, component, render } = reef;
  const nosql = new FlyJson();

  const main = signal({
    datas: [],
    headers: [],
    kelas: [],
    listFilterGroupBy: [],
    reset: [],
    orderBy: 'nomor_induk_siswa',
    filterBy: null,
    keyword: null,
    load: 0,
    limit: 10,
    total: 0,
    offset: 0,
    status: 'Loading..',
  }, 'main-table-data');

  function loadDataSiswa(callback) {
    const offset = main.offset;
    const limit = main.limit;
    const orderBy = main.orderBy;
    const filterBy = main.filterBy;
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
      main.datas = [...datas.data];
      main.headers = [...Object.keys(datas?.data[0])];
      main.load = datas.data.length;
      main.total = datas.total;

      if (typeof callback === 'function') {
        callback(datas);
      }
    })
    .catch(error => {
      main.load = 0;
      main.total = 0;
      main.status = 'Data Not Found';
    });
  }

  function loadDataKelas(callback) {
    fetch('/data-kelas')
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
      })
      .then(datas => {
        main.kelas = [...datas[1]];
        // Memeriksa apakah callback adalah fungsi
        if (typeof callback === 'function') {
          callback(); // Panggil callback
        }
      })
      .catch(error => console.error('Fetch error:', error));
  }

  // Helper Function Store Data
  const reset = [];
  const helperReset = {
    add(data) {
      main.reset.push(data);
    },

    delete(index, amount) {
      main.reset.splice(index, amount)
    }
  }


  // Get Tab Labels
  function getListGroupBy() {
    let jenisKelamin = nosql.set(main.datas).select(['jenis_kelamin']).exec();
        jenisKelamin = [...new Set(jenisKelamin.map(item => item.jenis_kelamin))].sort((a, b) => a - b);

    let kelas = nosql.set(main.kelas).select(['nama_kelas']).exec();
        kelas = [...new Set(kelas.map(item => item.nama_kelas))].sort((a, b) => a - b); // Ascending

    main.listFilterGroupBy = [...jenisKelamin, ...kelas];
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
            const order = main.reset.indexOf(btnResetElement.id);
            switch (order) {
              case 0:
                main.load = 0;
                main.total = 0;
                main.offset = 0;
                main.limit = 10;
                main.filterBy = null;
                main.keyword = null;
                loadDataSiswa();
                main.reset.map((btn) => {
                  let button = document.getElementById(btn);
                  button.click();
                  button.remove();
                })
                helperReset.delete(order, 2);
                break;
              case 1:
                main.load = 0;
                main.total = 0;
                main.offset = 0;
                btnResetElement.remove();
                helperReset.delete(order, 1);
                if (main.keyword != null){
                  console.log('ada keyword', main.keyword);
                  console.log(main.filterBy);
                }
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
    const filterBy = main.filterBy || null;
    const keyword = inputSearchElement.value;

    if (keyword !== "") {
      main.datas = [];
      if (filterSearch != "null" && filterBy != "null") {
          console.log('search 1');
          main.filterBy = `${filterSearch} = '${keyword}' AND ${filterBy}`;
          loadDataSiswa(() => {
            templateBtnReset('search', 'container-btn-reset-search', refreshTemplateInputSearch);
            main.filterBy = filterBy;
          });
        } else if (filterBy != null) {
          // Pencarian Tanpa Filter Pencarian, Tapi dengan Group By
          console.log('search 2');
          main.filterBy = `(nama_lengkap LIKE '%${keyword}%' OR kelas LIKE '%${keyword}%' OR nama_ayah LIKE '%${keyword}%' OR nama_ibu LIKE '%${keyword}%') AND ${filterBy}`;
          loadDataSiswa(() => {
            templateBtnReset('search', 'container-btn-reset-search', refreshTemplateInputSearch);
            main.filterBy = filterBy;
          });
        } else {
          console.log('search 3');
          // Pencarian Tanpa Filter Pencarian & Tanpa Group By
          main.filterBy = `nama_lengkap LIKE '%${keyword}%' OR kelas LIKE '%${keyword}%' OR nama_ayah LIKE '%${keyword}%' OR nama_ibu LIKE '%${keyword}%'`;

          loadDataSiswa(() => {
            templateBtnReset('search', 'container-btn-reset-search', refreshTemplateInputSearch);
          });
          main.keyword = keyword;
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
    main.limit = limit;

    loadDataSiswa(() => {
      templateBtnReset('filter', 'container-btn-reset-groupby', refreshTemplateFilterData);
    });
  }

  // Perbaiki Bagian Ini
  function templateFilterData() {
    let dom = '';
    let filterLimit = '<select id="select-data-limit" style="height:35px;border-radius:5px;font-size:13px;" onchange="handleLimitData(this.value)"><option disabled selected value="null">-- Limit Data --</option>';

    // Reset `filter.limits` untuk menghindari duplikat
    let countData = Math.ceil(main.total / 10);

    // Mengisi `filter.limits` dan `dom` hanya jika `countData` lebih dari 0
    if (countData > 0) {
        for (let i = 1; i <= countData; i++) {
            const limit = i * 10;
            // Selected Limit
              filterLimit += `<option id="limit-value-${limit}" value="${limit}" ${main.limit == limit ? 'selected' : ''}>${limit} Data</option>`;
        }

    }

    filterLimit += '</select>';

    let filterByGroup = `<select id="select-data-group-by" style="height:35px;width:fit-content;border-radius:5px;font-size:13px;" onchange="handleFilterDataGroupBy(this.value)"> <option disabled selected selected="selected" value="null">-- Group By --</option>`;

    if (main.listFilterGroupBy.length > 0) {
      main.listFilterGroupBy.forEach((group) => {
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
      'main-table-data'
    ]
  });

  function handleFilterDataGroupBy(element) {
    main.limit = 10;
    main.offset = 0;
    main.load = 0;
    main.total = 0;
    main.datas = [];

    const container = document.getElementById('select-data-group-by');
          container.setAttribute('disabled', true);
    const filterByValue = element.target?.value ?? element;
    const keyFilterBy = document.getElementById(filterByValue).getAttribute('name');

    const keyword = main.keyword && `(nama_lengkap LIKE '%${main.keyword}%' OR kelas LIKE '%${main.keyword}%' OR nama_ayah LIKE '%${main.keyword}%' OR nama_ibu LIKE '%${main.keyword}%')`;

    const defaultParam = `${keyFilterBy} = '${filterByValue}'`;
    const filterByParamAndValue = keyword != null ? `${keyword} AND ${defaultParam}` : defaultParam;
    main.filterBy = filterByParamAndValue;
    loadDataSiswa(() => {
      templateBtnReset('filter', 'container-btn-reset-groupby', refreshTemplateFilterData);
      main.filterBy = keyword != null ? keyword : defaultParam;
    });
  }

  function refreshTemplateFilterData() {
   render('#container-filter-data-table', templateFilterData);
  }

  // Input Search
  function showTooltip() {
    const selectSearchFilterElement = document.getElementById('select-search-filter');
    const tooltip = document.getElementById("tooltip");

    if (selectSearchFilterElement.value == 'null'){
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

    let select = '<select id="select-search-filter" style="height:35px;border-radius:5px;font-size:13px;"><option disabled selected selected="selected" value="null">-- Pilih Filter Pencarian --</option>';

    const headNames = main.headers;
    let formatedHeadNames = [];
    headNames.forEach(headName => {
      let nameToUpperCase = headName.charAt(0).toUpperCase() + headName.slice(1);
      let formatedName = nameToUpperCase.replace(/_/g, " ");
      formatedHeadNames.push(formatedName);
    });

    main.headers.forEach((header, index) => {
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
           onblur="hideTooltip()" />
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

  function refreshTemplateInputSearch(){
    const container = document.getElementById('search-table');
    const icon = '../assets/icon/icon-search.png';

    let dom = '';

    let select = '<select id="select-search-filter" style="height:35px;border-radius:5px;font-size:13px;"><option disabled selected selected="selected" value="null">-- Pilih Filter Pencarian --</option>';

    const headNames = main.headers;
    let formatedHeadNames = [];
    headNames.forEach(headName => {
      let nameToUpperCase = headName.charAt(0).toUpperCase() + headName.slice(1);
      let formatedName = nameToUpperCase.replace(/_/g, " ");
      formatedHeadNames.push(formatedName);
    });

    main.headers.forEach((header, index) => {
      select += `<option value="${header}">${formatedHeadNames[index]}</option>`;
    });

    select += '</select>';
    dom += select;
    dom += `
    <div class="flex flex-row">
        <div style="position: relative; display: inline-block;">
        <input id="search-input-table"
           type="text"
           placeholder="Masukan Kata Kunci Pencarian"
           style="border-radius:5px 0 0 5px;height:35px;"
           onfocus="showTooltip()"
           onblur="hideTooltip()" />
          <!-- Tooltip -->
          <span id="tooltip"
            style="visibility: hidden;
                  font-size:12px;
                  background-color: #333;
                  color: #fff;
                  text-align: center;
                  padding: 5px;
                  border-radius: 5px;
                  position: absolute;
                  top: 40px;
                  left: 0;
                  z-index: 2000;
                  white-space: nowrap;">
            Default: <i>Nama Lengkap Siswa, Kelas, Nama Ayah, Nama Ibu</i>
          </span>
      </div>
        <button
          style="border:none;border-top-right-radius:5px;border-bottom-right-radius:5px;height:35px;background:#161AF5;" onclick="searchData()">
            <img src="${icon}" height="28" width="33">
        </button>
      </div>
    `;
    container.innerHTML = dom;
  }

  component('#search-table', templateInputSearch, {events: {searchData, showTooltip, hideTooltip, refreshTemplateInputSearch}, signals: ['main-table-data']});

  // # Table Head
  function templateTableHead() {
    let dom = '<tr class="sticky top-0 bg-[#EDEDED]"><th class="p-2 border text-sm text-nowrap">No</th>';
    const headNames = main.headers;
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
  component('#table-head', templateTableHead, {signals: ['main-table-data']});

  // # Table Body
  function templateTableData() {
    let dom = '';
    let count = 1;
    if (main.datas?.length > 0) {
      main.datas.forEach(data => {
        const jenis_kelamin = data.jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan';
            dom += `<tr class="bg-white"><td class="p-2 border text-sm text-nowrap">${count}</td>`;
              for (var key in data) {
                if (data.hasOwnProperty(key)) {
                  if (key == 'photo_siswa') {
                    dom += `<td class="p-2 border text-sm text-nowrap">
                              <img class="w-20 rounded" src="../assets/${data[key]}" alt="photo ${data.nama_lengkap}"/>
                            </td>`;
                  } else {
                    dom += `<td class="p-2 border text-sm text-nowrap">${data[key]}</td>`;
                  }
                }
              }
            dom += '</tr>';
        count++;
      });
    } else {
      dom += `
          <tr style="background:white;">
            <td colspan="19" class="p-2 border text-sm text-nowrap">${main.status}</td>
          </tr>
        `;
    }
    return dom;
  }

  component('#table-body', templateTableData, {signals: ['main-table-data']});

  // Pagination Table
  function loadMore(callback) {
    let tempData = main.datas;
    console.log(1, tempData, main.offset)
    main.offset += main.limit;
    // TEST
    SimpleTest(main.offset + main.limit, main.offset + main.limit, 'Load More');

    // Hanya kirim request jika load saat ini kurang dari total
    if (main.load < main.total) {
        loadDataSiswa((datas) => {
          tempData.push(...datas.data);
          console.log(2, tempData);
          main.datas = [...tempData];
          main.load = main.datas.length;
        });
        if (main.load >= main.total) {
            main.load = main.total;
        }
    } else {
        if (typeof callback === 'function') {
            callback();
        }
        return false;
    }
}


  function templatePagination() {
    if (main.load < main.total) {
      return `
          <button type="button" class="bg-blue-900 text-white px-2 py-1 rounded-lg h-full" onclick="loadMore()">Load More</button>
          <span class="px-2 py-1" style="background:white; border-radius:5px;"> ${main.load} of ${main.total} </span>
      `;
    } else {
      return `
        <span class="px-2 py-1" style="background:white; border-radius:5px;"> ${main.load} of ${main.total} </span>
      `;
    }
  }

  component('#pagination', templatePagination, {signals: ['main-table-data'], events: {loadMore}});

  // Event Load
  document.addEventListener("DOMContentLoaded", () => {
    loadDataSiswa(() => {
      loadDataKelas(() => {
        getListGroupBy();
      });
      main.load = main.datas.length;
    });
  });