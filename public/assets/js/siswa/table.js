  // Library
  const { signal, store, component, render } = reef;
  const nosql = new FlyJson();

  const main = signal({
    datas: [],
    headers: [],
    kelas: [],
    listFilterGroupBy: [],
    filtered_data1:[],
    filtered_data2:[],
    orderBy: '',
    filterBy: '',
    load: 0,
    limit: 10,
    total: 0,
    offset: 0,
  }, 'main-table-data');

  function loadDataSiswa(callback) {
    // Menghitung offset berdasarkan halaman
    const offset = main.offset;
    const limit = main.limit;
    console.log('loadDatasiswa: ', main.offset, main.limit)
    // Mengirimkan request menggunakan method POST
    fetch('/data-siswa', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        limit: limit,
        offset: offset,
      })
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
      }
      return response.json();
    })
    .then(datas => {
      // if (main.datas.length > 0) {
      //   console.log(1);

      //   let cleanData = nosql.set(main.datas).distinct('nomor_induk_siswa').exec();
      //   console.log(cleanData);
      //   main.datas = [...cleanData];
      // } else {
      //   console.log(2);
      //   main.datas = [...datas.data];
      // }

      main.datas = [...datas.data];
      main.headers = Object.keys(datas?.data[0]);
      main.load = datas.data.length;
      main.total = datas.total;

      console.log(main.datas);

      if (typeof callback === 'function') {
        callback();
      }
    })
    .catch(error => console.error('Fetch error:', error));
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

  function helperFilteredData(data) {
    console.log('helperFilteredData : ', data);
    if (main.filtered_data1.length == 0) {
      main.filtered_data1 = data;
      main.datas = [...main.filtered_data1];
      main.load = data.length;
      return;
    } else {
      main.filtered_data2= data;
      main.datas = [...main.filtered_data2];
      main.load = data.length;
      return;
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
  function templateBtnReset(data, name, containerId, callback) {
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

          // Gunakan data dari parameter function di sini
          btnResetElement.addEventListener("click", function () {
            main.load = 0;
            main.total = 0;
            main.offset = 10;
            main.limit = 10;
            main.filterBy = '';

            if (main.filtered_data1.includes(...data)) {
                main.filtered_data1 = [];
                main.datas = [];
                loadDataSiswa();
                btnResetElement.remove();
            } else if (main.filtered_data2.includes(...data)) {
                main.filtered_data2 = [];
                main.datas = nosql.set(main.filtered_data1).paginate(1, 10).exec();
                main.load = main.datas.length;
                main.total = main.filtered_data1.length;
                main.offset = 0;
                btnResetElement.remove();
                console.log(2);
            } else {
                main.datas = [];
                main.filtered_data1 = [];
                loadDataSiswa();
                btnResetElement.remove();
                console.log(3);
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
    const filter = selectSearchFilterElement.value;

    let result = null;
    if (inputSearchElement.value != "") {
      const keyword = inputSearchElement.value;
      if (main.filtered_data1.length > 0) {
        if (filter != "null") {
            // Pencarian Dengan Filter, Tanpa Group By
            result = nosql.set(main.filtered_data1).begin()
              .where(filter, 'LIKE', keyword, false)
              .end().exec();
          } else {
            // Pencarian Tanpa Filter & Tanpa Group By
            result = nosql.set(main.filtered_data1).begin()
              .where('nama_lengkap', 'LIKE', keyword, false)
              .or().where('kelas', 'LIKE', keyword, false)
              .or().where('nama_ayah', 'LIKE', keyword, false)
              .or().where('nama_ibu', 'LIKE', keyword, false)
              .end().distinct('id').exec();
          }
      } else if (main.filtered_data2.length > 0) {
        if (filter != "null") {
          // Pencarian Dengan Filter, Tanpa Group By
            result = nosql.set(main.filtered_data2).begin()
              .where(filter, 'LIKE', keyword, false)
              .end().distinct('id').exec();
          } else {
            // Pencarian Tanpa Filter & Tanpa Group By
            result = nosql.set(main.filtered_data2).begin()
              .where('nama_lengkap', 'LIKE', keyword, false)
              .or().where('kelas', 'LIKE', keyword, false)
              .or().where('nama_ayah', 'LIKE', keyword, false)
              .or().where('nama_ibu', 'LIKE', keyword, false)
              .end().distinct('id').exec();
          }
      } else {
        if (filter != "null") {
          // Pencarian Dengan Filter, Tanpa Group By
          result = nosql.set(main.datas).begin()
            .where(filter, 'LIKE', keyword, false)
            .distinct('id').end().exec();
          } else {
            // Pencarian Tanpa Filter & Tanpa Group By
            result = nosql.set(main.datas).begin()
            .where('nama_lengkap', 'LIKE', keyword, false)
            .or().where('kelas', 'LIKE', keyword, false)
            .or().where('nama_ayah', 'LIKE', keyword, false)
            .or().where('nama_ibu', 'LIKE', keyword, false)
            .distinct('id').end().exec();
          }
        }
      main.total = result.length;
      helperFilteredData(result);
      templateBtnReset(result, 'search', 'search-table', refreshTemplateInputSearch);
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

  // Filter Data
  // const filter = signal({
  //   limits: [],
  //   group_by: null,
  // }, 'filter-data');

  // ## Filter Data By Limit
  function handleLimitData(element) {
    main.limit = 0;
    main.offset = 0;
    main.load = 0;
    main.total = 0;
    main.datas = [];

    const limit = parseInt(element.target.value);
    main.limit = limit;

    console.log('handle limit: ', main.limit, main.offset)
    if (main.filtered_data1.length > 0) {
      console.log('malah masuk sinis');

      // main.datas = nosql.set(main.filtered_data1).paginate(main.offset, limit).exec();
    } else {
      loadDataSiswa();
    }
    templateBtnReset(main.datas, 'filter', 'container-btn-reset', refreshTemplateFilterData);
    main.load = limit;
  }

  // Perbaiki Bagian Ini
  function templateFilterData() {
    console.log('template filter-data: ', main.limit, main.offset)
    let dom = '';
    let filterLimit = '<select id="select-data-limit" style="height:35px;border-radius:5px;font-size:13px;" onchange="handleLimitData(this.value)"><option disabled selected value="null">-- Limit Data --</option>';

    // Reset `filter.limits` untuk menghindari duplikat
    let countData = Math.ceil(main.total / 10);

    // Jika data yang difilter ada dan `main.total` lebih dari 10, hitung `countData`
    if (main.filtered_data1.length > 0 && main.total > 10) {
        countData = Math.ceil(main.total / 10);
    }

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
    main.datas = [];
    main.limit = 10;
    main.offset = 0;
    const container = document.getElementById('select-data-group-by');
          container.setAttribute('disabled', true);
    const filterByValue = element.target?.value ?? element;
    const keyFilterBy = document.getElementById(filterByValue).getAttribute('name');

    const orderBy = main.orderBy;
    const limit = main.limit;
    const offset = main.offset;

    const filterByParamAndValue = `${keyFilterBy} = '${filterByValue}'`;
    main.filterBy = filterByParamAndValue;

    // Mengirimkan request menggunakan method POST
    fetch('/data-siswa', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        filterBy: filterByParamAndValue,
        orderBy: orderBy,
        limit: limit,
        offset: offset,
      })
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok: ' + response.statusText);
      }
      return response.json();
    })
    .then(datas => {
      main.offset += limit;
      main.datas.push(...datas.data);
      main.load = datas.data.length;
      main.total = datas.total;

      helperFilteredData(datas.data);
      templateBtnReset(datas.data, 'filter', 'container-btn-reset', refreshTemplateFilterData);

    })
    .catch(error => console.error('Fetch error:', error));
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
          Default: <i>nama_lengkap, Class, Father Name, Mother Name</i>
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
    <div class="d-flex flex-row">
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
            Default: <i>nama_lengkap, Class, Father Name, Mother Name</i>
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

  component('#search-table', templateInputSearch, {events: {searchData, showTooltip, hideTooltip, refreshTemplateInputSearch}});

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
            <td colspan="16" class="p-2 border text-sm text-nowrap">Loading...</td>
          </tr>
        `;
    }
    return dom;
  }

  component('#table-body', templateTableData, {signals: ['main-table-data']});

  // Pagination Table
  function loadMore(callback) {
    let offset = main.offset + main.limit;
    let limit = main.limit;
    const orderBy = main.orderBy || 'nomor_induk_siswa'; // Default ke 'id' jika orderBy tidak didefinisikan
    const filterBy = main.filterBy || null; // Default ke null jika filterBy tidak didefinisikan

    // Pastikan load tidak melebihi total
    const remainingData = main.total - main.load;

    // Jika remainingData lebih kecil dari limit, kita hanya ambil sisa data
    if (remainingData < limit) {
        limit = remainingData;
    }

    // Hanya kirim request jika load saat ini kurang dari total
    if (main.load < main.total && main.offset < main.total) {
        console.log('Loadmore: ', offset, limit);

        // Mengirimkan request menggunakan method POST
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
            if (datas && datas.data) {
                // Push data baru ke dalam main.datas
                main.datas.push(...datas.data);
                main.load += datas.data.length;
                main.offset += limit;

                // Cek apakah load sudah mencapai total
                if (main.load >= main.total) {
                    main.load = main.total; // Set load sama dengan total
                }

                // Jalankan callback jika disediakan
                if (typeof callback === 'function') {
                    callback();
                }
            }
        })
        .catch(error => console.error('Fetch error:', error));
    } else {
        console.log('All data loaded'); // Tambahkan logging untuk kondisi ini
        if (typeof callback === 'function') {
            callback();
        }
        return false;
    }
}


  function templatePagination() {
    if (main.load <= main.total) {
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