<div id="content" class="d-flex flex-column h-100 flex-md-grow-1 px-0 mx-auto"
  style="background:#BBBBBB; max-width:100%;">
  <!-- Banner -->
  <div class="d-flex flex-column flex-md-row px-5 align-items-center" style="background:#769B27;">
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
  <div id="tab-container" class="d-flex pt-3 gap-2 align-items-end px-3" style="background:#576834;">
  </div>
  <!-- Sub Content 2 -->
  <!-- Interactive Table -->
  <div class="d-flex flex-column h-100 justify-content-center" style="width:100%;">
    <div class="d-flex py-2 px-4 gap-2 justify-content-between align-items-center px-3" style="background:#D9D9D9;">
      <!-- Table Configuration -->
      <!-- Search Table -->
      <div class="d-flex justify-content-center gap-3">
        <button>+</button>
        <button>+</button>
        <button>+</button>
      </div>
      <div id="search-table"
        class="d-flex flex-sm-column flex-md-row align-items-center justify-content-center d-none d-sm-flex">
        <input type="text" placeholder="Masukan Kata Kunci Pencarian" style="border-radius:10px 0 0 10px;height:35px;">
        <button
          style="border:none;border-top-right-radius:10px;border-bottom-right-radius:10px;height:35px;background:#161AF5;"><img
            src="<?= base_url(path: 'assets/icon/icon-search.png'); ?>" height="28" width="33"></button>
      </div>
      <div class="d-flex justify-content-center gap-3">
        <button>+ Tambah Data</button>
        <button>- Hapus Data</button>
        <button>+ Edit Data</button>
      </div>
    </div>
    <!-- Table -->
    <div class="container-fluid px-2 py-2" style="background:#BBBBBB;">
      <div class="container p-0 w-100" style="background:#BBBBBB;max-width:1100px;max-height:400px;overflow:auto;">
        <table class="text-center">
          <thead id="table-head">
          </thead>
          <tbody id="table-body">
          </tbody>
        </table>
      </div>
      <div id="pagination" class="d-flex justify-content-center align-items-center py-2 gap-3">
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

  // Data From Database
  const datas = <?php echo json_encode(value: $data); ?>;

  const main = signal({
    datas: [],
    page: 0,
    total: 0,
  });

  var result = nosql.set(datas)
    .where('fullname', 'like', 'Ali')
    .exec();


  // TAB COMPONENT
  const tab = signal({
    labels: ['Semua Data Siswa'],
    selected: []
  }, 'tab-container');

  const defaultTab = 'Semua Data Siswa';
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

  // Data Tab Labels
  let tabLabels = [];
  let selectedTabIndex = null;

  // Get Tab Labels
  function getTabLabels() {
    datas.forEach((data) => {
      tabLabels.push(data.class);
    });

    tabLabels = [...new Set(tabLabels)];
    tabLabels = tabLabels.sort((a, b) => a - b); // ascending
  }

  // Handle Selected Tab
  function handleSelectedTab(element) {
    if (!tabs.value.includes(defaultTab)) {
      tabs.add(defaultTab);
    }

    tabLabels.forEach(labelName => {
      if (!tabs.value.includes(labelName)) {
        tabs.add(labelName);
      }
    });

    let value = element.target.id;
    selectedTabIndex = tabs.value.indexOf(value);
    console.log('selectedTabIndex', selectedTabIndex);
  }

  function templateTab() {
    let dom = '';
    getTabLabels();
    // let result = nosql.set(datas).select('class').exec();

    if (tabs.value.length == 0) {
      dom += `
        <div class="d-flex flex-column justify-content-center align-items-center px-3"
          style="width:fit-content;height:53px;background:#D9D9D9;border-radius:24px 24px 0 0; ">
          <h3 class="text-black m-0" style="font-size:18px;font-weight:500;">${defaultTab}</h3>
        </div>
      `;

      tabLabels.forEach((label) => {
        dom += `
          <div id="${label}" class="d-flex flex-column justify-content-center align-items-center px-3"
            style="width:fit-content;height:53px;background:#6A813A;border-radius:24px 24px 0 0; " onclick="handleSelectedTab(this)">
            <h3 id="${label}" class="text-white m-0" style="font-size:18px;">Kelas ${label}</h3>
          </div>
        `;
      });
    } else {
      tabs.value.forEach((label, index) => {
        if (index == selectedTabIndex) {
          dom += `
            <div id="${label}" class="d-flex flex-column justify-content-center align-items-center px-3"
              style="width:fit-content;height:53px;background:#D9D9D9;border-radius:24px 24px 0 0; ">
              <h3 class="text-black m-0" style="font-size:18px;font-weight:500;">Kelas ${label}</h3>
            </div>
          `;
        } else {
          dom += `
          <div id="${label}" class="d-flex flex-column justify-content-center align-items-center px-3"
            style="width:fit-content;height:53px;background:#6A813A;border-radius:24px 24px 0 0; " onclick="handleSelectedTab(this)">
            <h3 id="${label}" class="text-white m-0" style="font-size:18px;">Kelas ${label}</h3>
          </div>
        `;
        }
      });
    }

    return dom;
  }
  component('#tab-container', templateTab, {signals: ['tab-container'],  events: { handleSelectedTab } });

  // Table Component

  // # Table Head
  function templateTableHead() {
    let dom = '<tr class="sticky-top" style="background:#EDEDED;">';
    dom += '<th class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">No</th>';
    const headNames = Object.keys(datas[0]);
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
  component('#table-head', templateTableHead);

  // # Table Body
  function templateTableData() {
    const baseUrl = "<?= base_url() ?>";
    let dom = '';
    let count = 1;
    main.datas.forEach(data => {
      dom += `
        <tr style="background:white;">
          <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;">${count}</td>
          <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.id}</td>
          <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">${data.fullname}</td>
          <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;"><img class="img-fluid" src="${baseUrl}assets/${data.profile_picture}" alt="photo ${data.fullname}"/></td>
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
    return dom;
  }

  component('#table-body', templateTableData);

  // Pagination Table
  function templatePagination() {
    return `
      <button>Prev</button>
        <span class="px-2 py-1" style="background:white; border-radius:5px;"> ${main.page + 1} of ${main.total} </span>
      <button>Next</button>
    `;
  }

  component('#pagination', templatePagination);

  // Event Load
  document.addEventListener("DOMContentLoaded", () => {
    console.log('Document diload');
    main.datas = datas;
    main.total = datas.length;
  });
</script>