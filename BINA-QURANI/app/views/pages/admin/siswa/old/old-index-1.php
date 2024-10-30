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
     <div class="container-fluid px-2 py-2"
       style="background:#BBBBBB;">
       <div class="container p-0 w-100" style="background:#BBBBBB;max-width:1100px;max-height:400px;overflow:auto;">
         <table class="text-center">
           <thead>
             <tr class="sticky-top" style="background:#EDEDED;">
               <th class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;">No</th>
               <?php foreach (array_keys($data[0]) as $key => $value): ?>
                 <th class="p-2" style="border:1px solid #BBBBBB;font-size:16px;"><?= ucfirst(string: $value) ?></th>
               <?php endforeach; ?>
             </tr>
           </thead>
           <tbody>
             <?php foreach ($data as $index => $row): ?>
               <tr style="background:white;">
                 <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;"><?= $index + 1 ?></td>
                 <?php foreach ($row as $value): ?>
                   <td class="p-2" style="border:1px solid #BBBBBB;font-size:16px;text-wrap:nowrap;"><?= htmlspecialchars(string: $value) ?></td>
                 <?php endforeach; ?>
               </tr>
             <?php endforeach; ?>
           </tbody>
         </table>
       </div>
       <div class="d-flex justify-content-center align-items-center py-2 gap-3">
         <button>Next</button>
         <span class="px-2 py-1" style="background:white; border-radius:5px;"> 10 of 20 </span>
         <button>Prev</button>
       </div>
     </div>
   </div>
</div>

<!-- Get the latest major version -->
<script src="https://cdn.jsdelivr.net/npm/fly-json-odm/dist/flyjson.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/reefjs@13/dist/reef.min.js"></script>
<script>
  // Library
  const {signal, component} = reef;
  const nosql = new FlyJson();

  // Data From Database
  const data = <?php echo json_encode(value: $data); ?>;
  console.log(data);

  var result = nosql.set(data)
  .where('fullname', 'like', 'Ali')
  .exec();
  console.log(result);


  function templateTab() {
    return `
      <!-- Tab 1 -->
      <div class="d-flex flex-column justify-content-center align-items-center px-3"
        style="width:fit-content;height:53px;background:#D9D9D9;border-radius:24px 24px 0 0; ">
        <h3 class="text-black m-0" style="font-size:18px;font-weight:500;">Semua Data Siswa</h3>
      </div>
      <div class="d-flex flex-column justify-content-center align-items-center px-3"
        style="width:fit-content;height:53px;background:#6A813A;border-radius:24px 24px 0 0; ">
        <h3 class="text-white m-0" style="font-size:18px;">Kelas I</h3>
      </div>
      <div class="d-flex flex-column justify-content-center align-items-center px-3"
        style="width:fit-content;height:53px;background:#6A813A;border-radius:24px 24px 0 0; ">
        <h3 class="text-white m-0" style="font-size:18px;">Kelas II</h3>
      </div>
    `;
  }

  component('#tab-container', templateTab);

</script>