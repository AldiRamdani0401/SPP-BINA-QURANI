  // Library
  const { signal, store, component, render } = reef;
  const nosql = new FlyJson();

  const datas = store([], {
    // Add
    add(datas, data) {
      datas.push(data);
    },

    // Remove
    delete(datas, data) {
      let index = datas.indexOf(data);
      if (index < 0) return;
      datas.splice(index, 1);
    }
  });

  function loadDataSiswa(callback) {
    fetch('/data-siswa')
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
      })
      .then(data => {
        main.headers = data[0];
        data[1].forEach((dt) => {
          datas.add(dt);
        });
        if (typeof callback === 'function') {
          callback(); // Panggil callback
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
      .then(data => {
        data[1].forEach((dt) => {
          groupsStore.add(dt);
        });
        // // Memeriksa apakah callback adalah fungsi
        if (typeof callback === 'function') {
          callback(); // Panggil callback
        }
      })
      .catch(error => console.error('Fetch error:', error));
  }


  const main = signal({
    datas: [],
    headers: [],
    filtered_data1:[],
    filtered_data2:[],
    filtered_data3:[],
    load: 10,
    limit: 10,
    total: 0,
    page: 1,
  }, 'table-data');

  // Helper Function Store Data

  function helperFilteredData(data) {
    if (main.filtered_data1.length == 0) {
      console.log(data);
      main.filtered_data1 = data;
      main.datas = [...main.filtered_data1];
      main.load = main.datas.length;
      return;
    } else if (main.filtered_data2.length == 0) {
      main.filtered_data2 = data;
      main.datas = [...main.filtered_data2];
      main.load = main.datas.length;
      return;
    } else {
      main.filtered_data3 = data;
      main.datas = [...main.filtered_data3];
      main.load = main.datas.length;
      return;
    }
  }


  // Groups COMPONENT
  const groups = signal({
    list: [],
    selected: '',
    selectedIndex: 0
  }, 'groups');

  const groupsStore = store([], {
    // Add
    add(groups, group) {
      groups.push(group);
    },

    // Remove
    delete(groups, group) {
      let index = groups.indexOf(group);
      if (index < 0) return;
      groups.splice(index, 1);
    }
  });

  // Get Tab Labels
  function getListGroupBy() {
    let jenisKelamin = nosql.set(datas.value).select(['jenis_kelamin']).exec();
        jenisKelamin = [...new Set(jenisKelamin.map(item => item.jenis_kelamin))].sort((a, b) => a - b);

    let kelas = nosql.set(groupsStore.value).select(['nama_kelas']).exec();
    // kelas = [...new Set(kelas.map(item => item.class))].sort((a, b) => a - b); // Mengambil value dari object class dan mengurutkan secara ascending

    let result = [...jenisKelamin];

    kelas.forEach((data) => {
      result.push(data.nama_kelas);
    });

    result.forEach((data) => {
      groups.list.push(data);
    });
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
        if (main.filtered_data1.includes(...data)) {
          main.filtered_data1 = [];
          if (main.filtered_data2.length > 0){
            main.filtered_data1 = main.filtered_data2;
            main.datas = main.filtered_data2;
            main.total = main.datas.length;
            main.filtered_data2 = [];
          } else {
            main.datas = nosql.set(datas.value).paginate(1, 10).exec();
            main.total = datas.value.length;
          }
          main.load = main.datas.length;
          main.page = 1;

          btnResetElement.remove();
        } else if (main.filtered_data2.includes(...data)) {
          main.filtered_data2 = [];
          main.datas = nosql.set(main.filtered_data1).paginate(1, 10).exec();
          main.load = main.datas.length;
          main.total = main.filtered_data1.length;
          main.page = 1;
          btnResetElement.remove();
        } else if (main.filtered_data3.includes(...data)) {

          let datas = main.filtered_data2.length != 0 ? main.filtered_data2 : main.filtered_data1;
          main.filtered_data3 = [];
          main.datas = nosql.set(datas).paginate(1, 10).exec();
          main.load = main.datas.length;
          main.total = main.filtered_data2.length;
          main.page = 1;
          btnResetElement.remove();
        } else {

          main.filtered_data2 = [];
          main.datas = nosql.set(main.filtered_data1).paginate(1, 10).exec();
          main.load = main.datas.length;
          main.total = main.filtered_data1.length;
          main.page = 1;
          btnResetElement.remove();
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
          result = nosql.set(datas.value).begin()
            .where(filter, 'LIKE', keyword, false)
            .distinct('id').end().exec();
          } else {
            // Pencarian Tanpa Filter & Tanpa Group By
            result = nosql.set(datas.value).begin()
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
  const filter = signal({
    limits: [],
    group_by: null,
  }, 'filter-data');

  // ## Filter Data By Limit
  function handleLimitData(element) {
    const limit = element.target.value;
    main.limit = limit;
    if (main.filtered_data1.length > 0) {
      main.datas = nosql.set(main.filtered_data1).paginate(main.page, limit).exec();
    } else {
      main.datas = nosql.set(datas.value).paginate(main.page, limit).exec();
    }
    main.load = limit;
  }

  function templateFilterData() {
    let dom = '';
    let filterLimit = '<select id="select-data-limit" style="height:35px;border-radius:5px;font-size:13px;" onchange="handleLimitData(this.value)"><option disabled selected value="null">-- Limit Data --</option>';

    // Reset `filter.limits` untuk menghindari duplikat
    filter.limits = [];
    let countData = 0;

    // Menentukan `countData` berdasarkan apakah data yang difilter ada atau tidak
    if (main.filtered_data1.length > 0) {
      if (main.filtered_data1.length >= 10) {
        countData = Math.ceil(main.filtered_data1.length / 10);
      } else {
        countData = 0;
      }
    } else {
        countData = Math.ceil(datas.value.length / 10);
    }

    // Mengisi `filter.limits` dan `dom` hanya jika ada data
    if (countData > 0) {
        for (let i = 1; i <= countData; i++) {
            const limit = i * 10;
            filter.limits.push(limit);
            filterLimit += `<option value="${limit}">${limit} Data</option>`;
        }
    }

    filterLimit += '</select>';

    let filterByGroup = `<select id="select-data-group-by" style="height:35px;width:fit-content;border-radius:5px;font-size:13px;" onchange="handleFilterDataGroupBy(this.value)"> <option disabled selected selected="selected" value="null">-- Group By --</option>`;
    if (groups.list.length > 1) {
        groups.list.forEach((group) => {
          let groupName = group;
          if (groupName == "L") groupName = "Laki-Laki" ;
          if (groupName == "P") groupName = "Perempuan";
          filterByGroup += `<option value="${group}">${groupName}</option>`;
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
      'filter-data'
    ]
  });

  function handleFilterDataGroupBy(element) {
    const container = document.getElementById('select-data-group-by');
          container.setAttribute('disabled', true);
    const filterBy = element.target?.value ?? element;
    let result = null;
      if (main.filtered_data1.length > 0) {
        result = nosql.set(main.filtered_data1).begin()
          .where('jenis_kelamin', 'LIKE', filterBy, false).or()
          .where('kelas', 'LIKE', filterBy, false).end()
          .exec();
      } else {
        result = nosql.set(datas.value).begin()
          .where('jenis_kelamin', 'LIKE', filterBy, false).or()
          .where('kelas', 'LIKE', filterBy, false).end()
          .exec();
        }
        main.total = result.length;
    helperFilteredData(result);
    templateBtnReset(result, 'filter', 'container-btn-reset', refreshTemplateFilterData);
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
    let dom = '<tr class="sticky-top" style="background:#EDEDED;">';
    dom += '<th class="p-2 border text-sm text-nowrap">No</th>';
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
  component('#table-head', templateTableHead, {signals: ['table-data']});

  // # Table Body
  function templateTableData() {
    let dom = '';
    let count = 1;
    if (main.datas.length > 0) {
      main.datas.forEach(data => {
        const jenis_kelamin = data.jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan';
        dom += `
          <tr class="bg-white">
            <td class="p-2 border text-sm text-nowrap">${count}</td>
            <td class="p-2 border text-sm text-nowrap">${data.nomor_induk_siswa}</td>
            <td class="p-2 border text-sm text-nowrap">${data.nama_lengkap}</td>
            <td class="p-2 border text-sm text-nowrap">
              <img class="w-20 rounded" src="../assets/${data.photo_siswa}" alt="photo ${data.nama_lengkap}"/>
            </td>
            <td class="p-2 border text-sm text-nowrap">${data.kelas}</td>
            <td class="p-2 border text-sm text-nowrap">${jenis_kelamin}</td>
            <td class="p-2 border text-sm text-nowrap">${data.tempat_lahir}</td>
            <td class="p-2 border text-sm text-nowrap">${data.tanggal_lahir}</td>
            <td class="p-2 border text-sm text-nowrap">${data.nama_ayah}</td>
            <td class="p-2 border text-sm text-nowrap">${data.nama_ibu}</td>
            <td class="p-2 border text-sm text-nowrap">${data.rt}</td>
            <td class="p-2 border text-sm text-nowrap">${data.rw}</td>
            <td class="p-2 border text-sm text-nowrap">${data.desa}</td>
            <td class="p-2 border text-sm text-nowrap">${data.kecamatan}</td>
            <td class="p-2 border text-sm text-nowrap">${data.kabupaten}</td>
            <td class="p-2 border text-sm text-nowrap">${data.provinsi}</td>
            <td class="p-2 border text-sm text-nowrap">${data.kode_pos}</td>
            <td class="p-2 border text-sm text-nowrap">${data.di_buat}</td>
            <td class="p-2 border text-sm text-nowrap">${data.di_perbarui}</td>
          </tr>
        `;
        count++;
      });
    } else {
      dom += `
          <tr style="background:white;">
            <td colspan="16" class="p-2 border text-sm text-nowrap">Data Not Found</td>
          </tr>
        `;
    }
    return dom;
  }

  component('#table-body', templateTableData, {signals: ['table-data']});

  // Pagination Table
  function loadMore() {
    let nextPage = main.page + 1; // simpan nilai currentPage yang baru
    let result = null;
    if (main.filtered_data1.length == 0) {
      result = nosql.set(datas.value).paginate(nextPage, main.limit).exec();
      console.log('masuk 1', result);
      console.log(nextPage);
    } else {
      result = nosql.set(main.filtered_data1).paginate(nextPage, main.limit).exec();
      console.log('masuk 2', result);
    }

    if (result.length > 0) {
      main.page = nextPage;
      main.datas.push(...result);
    }
    main.load = main.datas.length;
  }

  function templatePagination() {
    if (main.load != main.total) {
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

  component('#pagination', templatePagination, {signals: ['table-data'], events: {loadMore}});

  // Event Load
  document.addEventListener("DOMContentLoaded", () => {
    loadDataSiswa(() => {
      loadDataKelas(() => {
        getListGroupBy();
      });
      main.datas = nosql.set(datas.value).paginate(1, 10).exec();
      main.load = main.datas.length;
      main.total = datas.value.length;
    });
  });