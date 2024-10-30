<div id="content" class="d-flex flex-column h-100 flex-md-grow-1 px-0 mx-auto"
  style="background:#BBBBBB; max-width:100%;">
  <!-- Banner -->
  <div class="no-select d-flex flex-column flex-md-row px-5 align-items-center" style="background:#769B27;">
    <div class="d-flex justify-content-center flex-column px-0 px-md-5 gap-3" style="width:100%;">
      <div class="mx-auto py-3">
        <h1 class="title-banner m-0 text-white px-4 py-1" style="font-weight:500;white-space:nowrap;width:fit-content;">
          Master Data - Data Siswa
        </h1>
      </div>
    </div>
  </div>
  <!-- Sub Content 1 -->
  <!-- Tab Section -->
  <div id="tab-container" class="no-select d-flex pt-3 gap-2 align-items-end px-3" style="background:#576834;">
  </div>
  <div class="d-flex py-2 px-4 gap-2 justify-content-between align-items-center px-3" style="background:#D9D9D9;">
    <!-- Table Configuration -->
    <!-- Search Table -->
    <div id="container-filter-data-table-1" class="no-select d-flex justify-content-center gap-3">
    </div>
    <div id="container-filter-data-table-2" class="no-select d-flex justify-content-center gap-3">
    </div>
    <div id="search-table" class="d-flex flex-sm-column flex-md-row align-items-center justify-content-center gap-2 d-none d-sm-flex">
    </div>
    <div class="no-select d-flex justify-content-center gap-3">
      <button>+ Tambah Data</button>
      <button>- Hapus Data</button>
      <button>+ Edit Data</button>
    </div>
  </div>
  <!-- Sub Content 2 -->
  <!-- Interactive Table -->
  <div class="d-flex flex-column h-100" style="width:100%;">
    <!-- Table -->
    <div class="container-fluid px-2 py-2" style="background:#BBBBBB;">
      <div class="container p-0 w-100 h-100" style="background:#BBBBBB;max-width:1100px;max-height:400px;overflow:auto;">
        <table class="text-center h-100">
          <thead id="table-head">
          </thead>
          <tbody id="table-body">
          </tbody>
        </table>
      </div>
      <div id="pagination" class="no-select d-flex justify-content-center align-items-center py-2 gap-3">
      </div>
    </div>
  </div>
</div>

<!-- Get the latest major version -->
<script src="https://cdn.jsdelivr.net/npm/fly-json-odm/dist/flyjson.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/reefjs@13/dist/reef.min.js"></script>
<script>
  // Library
  const { signal, store, component } = reef;
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

  function loadData(callback) {
    fetch('/data-siswa')
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
      })
      .then(data => {
        // console.log('Fetch data:', data);
        main.headers = [...data[0]];
        data[1].forEach((dt) => {
          datas.add(dt);
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
    load: 10,
    total: 0,
    page: 1,
  }, 'table-data');


  // TAB COMPONENT
  const tab = signal({
    labels: ['Semua Data Siswa'],
    selected: 'Semua Data Siswa',
    selectedIndex: 0
  }, 'tab-container');

  // const defaultTab = 'Semua Data Siswa';
  const tabs = store([], {
    // Add
    add(tabs, tab) {
      tabs.push(tab);
    },

    // Remove
    delete(tabs, tab) {
      let index = tabs.indexOf(tab);
      if (index < 0) return;
      tabs.splice(index, 1);
    }
  });

  // Get Tab Labels
  function getTabLabels() {
    let result = nosql.set(datas.value).select(['class']).exec();
    result = [...new Set(result.map(item => item.class))].sort((a, b) => a - b); // Mengambil value dari object class dan mengurutkan secara ascending
    tab.labels.push(...result);
  }

  // Handle Selected Tab
  function handleSelectedTab(element) {
    main.load = 0;
    let value = element.target.id;
    tab.selected = value;
    tab.selectedIndex = tab.labels.indexOf(value);

    if (value == 'Semua Data Siswa') {
      main.filtered_data1 = [];
      main.datas = nosql.set(datas.value).paginate(1, 10).exec();
      main.total = datas.value.length;
      main.load = main.datas.length;
      main.page = 1;
    } else {
      main.filtered_data1 = [];
      var result = nosql.set(datas.value)
        .where('class', '===', value)
        .exec();
      main.filtered_data1 = [...result];
      main.datas = [...main.filtered_data1];
      main.total = main.datas.length;
      main.load = main.datas.length;
    }
  }

  function templateTab() {
    let dom = '';

    if (tab.selected == null) {
      tab.labels.forEach((label, index) => {
        if (index == 0) {
          // Default Selected Tab
          dom += `
            <div id="${label}" class="d-flex flex-column justify-content-center align-items-center px-3"
              style="width:fit-content;height:53px;background:#D9D9D9;border-radius:24px 24px 0 0;cursor:pointer;">
              <h3 class="text-black m-0" style="font-size:18px;font-weight:500;">${label}</h3>
            </div>
          `;
        } else {
          //  Unselected Tab
          dom += `
            <div id="${label}" class="d-flex flex-column justify-content-center align-items-center px-3"
              style="width:fit-content;height:53px;background:#6A813A;border-radius:24px 24px 0 0;cursor:pointer;" onclick="handleSelectedTab(this)">
              <h3 id="${label}" class="text-white m-0" style="font-size:18px;">Kelas ${label}</h3>
            </div>
          `;
        }
      });
    } else {
      tab.labels.forEach((label, index) => {
        if (index == tab.selectedIndex) {
          // Selected Tab
          dom += `
            <div id="${label}" class="d-flex flex-column justify-content-center align-items-center px-3"
              style="width:fit-content;height:53px;background:#D9D9D9;border-radius:24px 24px 0 0;cursor:pointer;">
              <h3 class="text-black m-0" style="font-size:18px;font-weight:bold;">${label == 'Semua Data Siswa' ? label : 'Kelas ' + label }</h3>
            </div>
          `;
        } else {
          //  Unselected Tab
          dom += `
            <div id="${label}" class="d-flex flex-column justify-content-center align-items-center px-3"
              style="width:fit-content;height:53px;background:#6A813A;border-radius:24px 24px 0 0;cursor:pointer;" onclick="handleSelectedTab(this)">
              <h3 id="${label}" class="text-white m-0" style="font-size:18px;">${label == 'Semua Data Siswa' ? label : 'Kelas ' + label }</h3>
            </div>
          `;
        }
      });
    }
    return dom;
  }
  component('#tab-container', templateTab, {signals: ['tab-container'],  events: { handleSelectedTab } });

  // Table Component

  // # Search Input Table
  // ## Search Data
  function searchData() {
    const inputSearchElement = document.getElementById('search-input-table');
    const selectSearchFilterElement = document.getElementById('select-search-filter');
    const filter = selectSearchFilterElement.value;

    let result = null;
    const keyword = inputSearchElement.value;
    if (tab.selected == 'Semua Data Siswa') {
      console.log(1, filter);
      if (filter != 'null' && main.filtered_data1.length == 0) {
        console.log("filter != 'null' && main.filtered_data1.length == 0");
        result = nosql.set(datas.value).begin()
          .where(filter, 'LIKE', keyword, false).end()
          .distinct('fullname').exec();
        main.filtered_data1 = result;
        main.datas = [...main.filtered_data1];
      } else if (filter != 'null' && main.filtered_data1.length > 0) {
        console.log("filter != 'null' && main.filtered_data1.length > 0");
        result = nosql.set(main.filtered_data1).begin()
          .where(filter, 'LIKE', keyword, false).end()
          .distinct('fullname').exec();
        main.filtered_data2 = result;
        main.datas = [...result];
      } else {
        console.log("no filter");
        if (main.filtered_data1.length > 0){
          result = nosql.set(main.filtered_data1).begin()
            .where('fullname', 'LIKE', keyword, false)
            .or().where('class', 'LIKE', keyword, false)
            .or().where('father_name', 'LIKE', keyword, false)
            .or().where('mother_name', 'LIKE', keyword, false)
            .end().distinct('fullname').exec();
          main.datas = [...result];
        } else {
          result = nosql.set(datas.value).begin()
            .where('fullname', 'LIKE', keyword, false)
            .or().where('class', 'LIKE', keyword, false)
            .or().where('father_name', 'LIKE', keyword, false)
            .or().where('mother_name', 'LIKE', keyword, false)
            .end().distinct('fullname').exec();
          main.filtered_data1 = result;
          main.datas = [...main.filtered_data1];
        }
        console.log(result);
      }
    } else {
      if (filter != 'null') {
        result = nosql.set(main.filtered_data1).begin()
          .where(filter, 'LIKE', keyword, false).end()
          .distinct('fullname').exec();
        main.filtered_data2 = result;
        main.datas = [...main.filtered_data2];
      } else {
        result = nosql.set(main.filtered_data1).begin()
          .where('fullname', 'LIKE', keyword, false)
          .or().where('class', 'LIKE', keyword, false)
          .or().where('father_name', 'LIKE', keyword, false)
          .or().where('mother_name', 'LIKE', keyword, false)
          .end().distinct('fullname').exec();
        main.filtered_data2 = result;
        main.datas = [...main.filtered_data2];
      }
    }
    main.total = result.length;
    main.load = result.length;
    templateBtnReset();
  }

  // ## Reset Search Result
  function templateBtnReset(){
    const existingBtnReset = document.getElementById("btn-reset-search");
    if (existingBtnReset) {
        return false;
    }
    const container = document.getElementById("search-table");
    const btnResetElement = document.createElement("button");
          btnResetElement.innerText = "Reset";
          btnResetElement.setAttribute("id", "btn-reset-search");
          btnResetElement.style.backgroundColor = "red";
          btnResetElement.style.color = "white";
          btnResetElement.style.border = "none";
          btnResetElement.style.height = "35px";
          btnResetElement.addEventListener("click", resetSearchResult);
    container.appendChild(btnResetElement);
  }

  function resetSearchResult() {
    const btnResetElement = document.getElementById("btn-reset-search");
    if (tab.selected == "Semua Data Siswa") {
      if (main.filtered_data1.length > 0) {
          console.log('Masuk 1');
          main.datas = nosql.set(main.filtered_data1).paginate(1, 10).exec();
          main.total = main.filtered_data1.length;
          main.filtered_data1 = [];
          main.filtered_data2 = [];
        } else if (main.filtered_data2.length > 0) {
          main.filtered_data2 = [];
          console.log('Masuk 2');
          main.datas = nosql.set(main.filtered_data1).paginate(1, 10).exec();
          main.total = main.datas.length;
        } else {
          main.datas = nosql.set(datas.value).paginate(1, 10).exec();
          main.total = datas.value.length;
          main.filtered_data1 = [];
        }
        main.load = main.datas.length;
        main.page = 1;
    } else {
       console.log('Masuk 3');
       if (main.filtered_data2.length > 0) {
          main.filtered_data2 = [];
          main.datas = nosql.set(main.filtered_data1).paginate(1, 10).exec();
          main.total = main.datas.length;
        } else {
          main.datas = nosql.set(main.filtered_data1).paginate(1, 10).exec();
          main.total = main.datas.length;
        }
      main.load = main.datas.length;
      main.page = 1;
    }
    btnResetElement.remove();
  }

  // Filter Data
  const filter = signal({
    limits: [],
    group_by: null,
  }, 'filter-data');

  // ## Filter Data By Limit
  function handleLimitData(element) {
    const limit = element.target.value;
    main.load = limit;
    main.page = 1;
    if (main.filtered_data1.length > 0) {
      main.datas = nosql.set(main.filtered_data1).paginate(1, limit).exec();
    } else {
      main.datas = nosql.set(datas.value).paginate(1, limit).exec();
    }
  }

  function templateFilterDataByLimit() {
    let dom = '<select id="select-data-limit" style="height:35px;border-radius:5px;font-size:13px;" onchange="handleLimitData(this.value)"><option disabled selected value="null">-- Limit Data --</option>';

    // Reset `filter.limits` untuk menghindari duplikat
    filter.limits = [];
    let countData = 0;

    // Menentukan `countData` berdasarkan apakah data yang difilter ada atau tidak
    if (main.filtered_data1.length > 0) {
      if (main.filtered_data1.length >= 10) {
        countData = Math.ceil(main.filtered_data1.length / 10);
      } else {
        coundData = 0;
      }
    } else {
        countData = Math.ceil(datas.value.length / 10);
    }

    // Mengisi `filter.limits` dan `dom` hanya jika ada data
    if (countData > 0) {
        for (let i = 1; i <= countData; i++) {
            const limit = i * 10;
            filter.limits.push(limit);
            dom += `<option value="${limit}">${limit} Data</option>`;
        }
    }

      dom += '</select>';
      return dom;
  }


  component('#container-filter-data-table-1', templateFilterDataByLimit, {events:{handleLimitData}, signals:['filter-data']});

  // Filter Data Group By
  // ## Filter Data Group By
  function handleFilterDataGroupBy(element) {
    const filterBy = element.target?.value ?? element;
    let result = null;
    if (tab.selected == 'Semua Data Siswa') {
      if (main.filtered_data1.length > 0) {
        result = nosql.set(main.filtered_data1).where('gender', '===', filterBy).exec();
        main.filtered_data2 = main.filtered_data1;
        console.log(1, result);
      } else {
        result = nosql.set(datas.value).where('gender', '===', filterBy).exec();
        main.filtered_data1 = result;
        console.log(2, result);
      }
    } else {
      result = nosql.set(main.filtered_data1).where('gender', '===', filterBy).exec();
      main.filtered_data2 = [...result];
    }

    main.datas = [...result ];
    main.page = 1;
    main.load = main.datas.length;
    main.total = main.datas.length;
    templateBtnResetFilter();
  }

  // ## Reset Search Result
  function templateBtnResetFilter(){
    const existingBtnReset = document.getElementById("btn-reset-result-filter");
    if (existingBtnReset) {
        return false;
    }
    const container = document.getElementById("container-filter-data-table-2");
    const btnResetResultFilter = document.createElement("button");
          btnResetResultFilter.innerText = "Reset";
          btnResetResultFilter.setAttribute("id", "btn-reset-result-filter");
          btnResetResultFilter.style.backgroundColor = "red";
          btnResetResultFilter.style.color = "white";
          btnResetResultFilter.style.border = "none";
          btnResetResultFilter.style.height = "35px";
          btnResetResultFilter.addEventListener("click", resetResultFilterDataByGroup);
    container.appendChild(btnResetResultFilter);
  }

  // ## Reset Filter Result Data By Group
  function resetResultFilterDataByGroup() {
    const btnResetResultFilter = document.getElementById("btn-reset-result-filter");
    if (tab.selected == "Semua Data Siswa") {
      if (main.filtered_data1.length > 0) {
          console.log('Masuk 1');
          main.datas = nosql.set(datas.value).paginate(1, 10).exec();
          main.total = datas.value.length;
        } else {
          console.log('Masuk 2');
          main.datas = nosql.set(datas.value).paginate(1, 10).exec();
          main.total = datas.value.length;
        }
        main.load = main.datas.length;
        main.page = 1;
    } else {
       console.log('Masuk 3');
        main.filtered_data1 = [];
        var result = nosql.set(datas.value)
          .where('class', '===', tab.selected)
          .exec();
        main.filtered_data1 = [...result];
        main.datas = [...main.filtered_data1];
        main.total = main.datas.length;
        main.load = main.datas.length;
    }
    btnResetResultFilter.remove();
    filter.group_by = null;
    refreshTemplateFilterDataGroupBy();
  }

  function refreshTemplateFilterDataGroupBy() {
    const container = document.getElementById('container-filter-data-table-2');
    container.innerHTML = `
      <select style="height:35px;width:fit-content;border-radius:5px;font-size:13px;" onchange="handleFilterDataGroupBy(this.value)">
        <option disabled selected selected="selected" value="null">-- Group By --</option>
        <option value="L">Laki-Laki</option>
        <option value="P">Perempuan</option>
      </select>
    `;
  }

  function templateFilterDataGroupBy() {
    return `
      <select style="height:35px;width:fit-content;border-radius:5px;font-size:13px;" onchange="handleFilterDataGroupBy(this.value)">
        <option disabled selected selected="selected" value="null">-- Group By --</option>
        <option value="L">Laki-Laki</option>
        <option value="P">Perempuan</option>
      </select>
    `;
  }
  component('#container-filter-data-table-2', templateFilterDataGroupBy, {events:{handleFilterDataGroupBy, templateBtnResetFilter, refreshTemplateFilterDataGroupBy}});

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
    return `
      <select id="select-search-filter" style="height:35px;border-radius:5px;font-size:13px;">
        <option disabled selected selected="selected" value="null">-- Pilih Filter Pencarian --</option>
        <option value="fullname">Fullname</option>
        <option value="class">Class</option>
        <option value="father_name">Father Name</option>
        <option value="mother_name">Mother Name</option>
      </select>
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
            Default: <i>Fullname, Class, Father Name, Mother Name</i>
          </span>
      </div>
        <button
          style="border:none;border-top-right-radius:5px;border-bottom-right-radius:5px;height:35px;background:#161AF5;" onclick="searchData()">
            <img src="<?= base_url(path: 'assets/icon/icon-search.png'); ?>" height="28" width="33">
        </button>
      </div>
    `;
  }

  component('#search-table', templateInputSearch, {events: {searchData, showTooltip, hideTooltip}});

  // # Table Head
  function templateTableHead() {
    let dom = '<tr class="sticky-top" style="background:#EDEDED;">';
    dom += '<th class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">No</th>';
    const headNames = main.headers;
    let formatedHeadNames = [];
    headNames.forEach(headName => {
      let nameToUpperCase = headName.charAt(0).toUpperCase() + headName.slice(1);
      let formatedName = nameToUpperCase.replace(/_/g, " ");
      formatedHeadNames.push(formatedName);
    });

    formatedHeadNames.forEach(name => {
      dom += `
        <th class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${name}</th>
      `;
    });

    dom += '</tr>';
    return dom;
  }
  component('#table-head', templateTableHead, {signals: ['table-data']});

  // # Table Body
  function templateTableData() {
    const baseUrl = "<?= base_url() ?>";
    let dom = '';
    let count = 1;
    if (main.datas.length > 0) {
      main.datas.forEach(data => {
        dom += `
          <tr style="background:white;">
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;">${count}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.id}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.fullname}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;"><img height="100" class="rounded" src="${baseUrl}assets/${data.profile_picture}" alt="photo ${data.fullname}"/></td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.email}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.phone}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.class}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.father_id}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.father_name}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.mother_id}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.mother_name}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.address}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.date_of_birth}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.gender}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.created_at}</td>
            <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.updated_at}</td>
          </tr>
        `;
        count++;
      });
    } else {
      dom += `
          <tr style="background:white;">
            <td colspan="16" class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">Data Not Found</td>
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
      result = nosql.set(datas.value).paginate(nextPage, main.load).exec();
    } else if (tab.selected == 'Semua Data Siswa') {
      result = nosql.set(datas.value).paginate(nextPage, main.load).exec();
    } else {
      result = nosql.set(main.filtered_data1).paginate(nextPage, main.load).exec();
    }

    if (result.length > 0) {
      main.page = nextPage;
      main.datas.push(...result);
    }
    main.load = main.datas.length;
  }

  function templatePagination() {
    if ( main.filtered_data1.length == 0 && main.datas.length < datas.value.length && main.load != 0 && main.total != 0 && main.load != main.total) {
      console.log('1');
      return `
          <button type="button" onclick="loadMore()">Load More</button>
          <span class="px-2 py-1" style="background:white; border-radius:5px;"> ${main.load} of ${main.total} </span>
      `;
    } else if (main.load < main.total && main.filtered_data1.length > 0) {
      console.log('2')
      return `
          <button type="button" onclick="loadMore()">Load More</button>
          <span class="px-2 py-1" style="background:white; border-radius:5px;"> ${main.load} of ${main.total} </span>
      `;
    } else {
      console.log('3')
      return `
        <span class="px-2 py-1" style="background:white; border-radius:5px;"> ${main.load} of ${main.total} </span>
      `;
    }
  }

  component('#pagination', templatePagination, {signals: ['table-data'], events: {loadMore}});

  // Event Load
  document.addEventListener("DOMContentLoaded", () => {
    console.log('Document diload');
    loadData(() => {
      getTabLabels();
      main.datas = nosql.set(datas.value).paginate(1, 10).exec();
      main.load = main.datas.length;
      main.total = datas.value.length;
    });
  });
</script>