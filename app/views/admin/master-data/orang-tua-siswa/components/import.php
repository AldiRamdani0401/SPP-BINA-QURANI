<?php
// Load Data Ayah
$stmt = $conn->prepare("SELECT nama_lengkap, nomor_identitas_kependudukan, tempat_lahir, tanggal_lahir, jenis_kelamin, email, nomor_telepon, hubungan, pekerjaan, provinsi, kabupaten, kecamatan, desa, rt, rw, kode_pos, photo  FROM tb_orang_tua_siswa WHERE hubungan = ?");

$ayah = "Ayah";
$stmt->bind_param("s", $ayah);
$stmt->execute();
$result = $stmt->get_result();
$dataAyah = $result->fetch_all(MYSQLI_ASSOC);

// Load Data Ibu
$stmt = $conn->prepare("SELECT nama_lengkap, nomor_identitas_kependudukan, tempat_lahir, tanggal_lahir, jenis_kelamin, email, nomor_telepon, hubungan, pekerjaan, provinsi, kabupaten, kecamatan, desa, rt, rw, kode_pos, photo  FROM tb_orang_tua_siswa WHERE hubungan = ?");

$ibu = "Ibu";
$stmt->bind_param("s", $ibu);
$stmt->execute();
$result = $stmt->get_result();
$dataIbu = $result->fetch_all(MYSQLI_ASSOC);
?>


<!-- Import Data Orang Tua -->
 <div class="flex flex-col items-center gap-4 w-full h-full pt-6 px-10">
  <!-- Card 1 : Input File -->
  <div class="flex flex-col gap-4 py-2 px-4 bg-white w-fit  h-fit rounded-xl shadow-xl">
    <!-- Header -->
    <div class="flex flex-col">
      <div class="flex flex-row items-center">
        <svg
          width="2em"
          height="2em"
          fill="currentColor"
          viewBox="0 0 16 16"
        >
          <path
            fillRule="evenodd"
            d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM3.517 14.841a1.13 1.13 0 0 0 .401.823q.195.162.478.252.284.091.665.091.507 0 .859-.158.354-.158.539-.44.187-.284.187-.656 0-.336-.134-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.566-.21l-.621-.144a1 1 0 0 1-.404-.176.37.37 0 0 1-.144-.299q0-.234.185-.384.188-.152.512-.152.214 0 .37.068a.6.6 0 0 1 .246.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.2-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.439 0-.776.15-.337.149-.527.421-.19.273-.19.639 0 .302.122.524.124.223.352.367.228.143.539.213l.618.144q.31.073.463.193a.39.39 0 0 1 .152.326.5.5 0 0 1-.085.29.56.56 0 0 1-.255.193q-.167.07-.413.07-.175 0-.32-.04a.8.8 0 0 1-.248-.115.58.58 0 0 1-.255-.384zM.806 13.693q0-.373.102-.633a.87.87 0 0 1 .302-.399.8.8 0 0 1 .475-.137q.225 0 .398.097a.7.7 0 0 1 .272.26.85.85 0 0 1 .12.381h.765v-.072a1.33 1.33 0 0 0-.466-.964 1.4 1.4 0 0 0-.489-.272 1.8 1.8 0 0 0-.606-.097q-.534 0-.911.223-.375.222-.572.632-.195.41-.196.979v.498q0 .568.193.976.197.407.572.626.375.217.914.217.439 0 .785-.164t.55-.454a1.27 1.27 0 0 0 .226-.674v-.076h-.764a.8.8 0 0 1-.118.363.7.7 0 0 1-.272.25.9.9 0 0 1-.401.087.85.85 0 0 1-.478-.132.83.83 0 0 1-.299-.392 1.7 1.7 0 0 1-.102-.627zm8.239 2.238h-.953l-1.338-3.999h.917l.896 3.138h.038l.888-3.138h.879z"
          />
        </svg>
        <h1 class="text-2xl text-slate-700 px-2 py-2 font-bold">Import CSV / XLSX : Data Orang Tua</h1>
      </div>
      <hr class="bg-lime-300 py-[1.8px] rounded-full">
    </div>
    <!-- Form Import File -->
     <form id="form-import-file" class="mx-auto overflow-hidden w-[500px]" enctype="multipart/form-data" method="POST" action="/master-data/orang-tua/update"
       class="flex flex-col gap-5 justify-between">
       <input type="hidden" name="_method" value="PUT" />
       <div id="container-input-data-file" class="flex flex-col gap-3">
         <!-- Information -->
         <div class="flex flex-col px-2">
          <h1 class="font-semibold text-lg mb-2">Format File yang Diterima:</h1>
            <ol class="list-decimal list-inside space-y-2 text-sm">
              <li>
                File yang diperbolehkan adalah dengan ekstensi
                <span class="font-medium text-blue-600">.csv</span> atau
                <span class="font-medium text-blue-600">.xlsx</span>.
              </li>
              <li>
                Struktur kolom dalam file harus sesuai dengan format berikut:
                <ul class="list-disc list-inside grid grid-cols-2 mt-1 ml-4 text-gray-700 text-xs">
                  <li>Nama Lengkap</li>
                  <li>Nomor Identitas Kependudukan</li>
                  <li>Jenis Kelamin</li>
                  <li>Tempat Lahir</li>
                  <li>Tanggal Lahir</li>
                  <li>Pekerjaan</li>
                  <li>Hubungan</li>
                  <li>Email</li>
                  <li>Nomor Telepon</li>
                  <li>Provinsi</li>
                  <li>Kabupaten</li>
                  <li>Kecamatan</li>
                  <li>Desa</li>
                  <li>RT</li>
                  <li>RW</li>
                  <li>Kode Pos</li>
                </ul>
              </li>
              <li>
                <span>Contoh format yang benar: <a href="http://localhost:100/files/spreedsheet/_/template-data-orang-tua" class="underline text-xs text-blue-600" download="template-data-orang-tua.xlsx">Download Template</a></span>
                <div class="overflow-auto py-1 w-full">
                  <table class="text-center mt-1 h-fit">
                    <thead class="sticky top-[-2px] shadow-sm">
                        <tr class="bg-blue-100 text-sm font-medium">
                          <td class="border border-slate-700 p-2 text-nowrap">No</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Nama Lengkap</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Nomor Identitas Kependudukan</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Jenis Kelamin</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Tempat Lahir</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Tanggal Lahir</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Pekerjaan</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Hubungan</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Email</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Nomor Telepon</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Provinsi</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Kabupaten</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Kecamatan</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Desa</td>
                          <td class="border border-slate-700 p-2 text-nowrap">RT</td>
                          <td class="border border-slate-700 p-2 text-nowrap">RW</td>
                          <td class="border border-slate-700 p-2 text-nowrap">Kode Pos</td>
                        </tr>
                      </thead>
                    <tbody>
                      <tr class="text-nowrap">
                        <td class="border border-slate-700">1</td>
                        <td class="border border-slate-700">Aldi Ramdani</td>
                        <td class="border border-slate-700">3210022334455661</td>
                        <td class="border border-slate-700">Laki-Laki</td>
                        <td class="border border-slate-700">Karawang</td>
                        <td class="border border-slate-700">1998-01-04</td>
                        <td class="border border-slate-700">Software Architech</td>
                        <td class="border border-slate-700">Ayah</td>
                        <td class="border border-slate-700">aldi@gmail.com</td>
                        <td class="border border-slate-700">0858112233445</td>
                        <td class="border border-slate-700">Jawa Barat</td>
                        <td class="border border-slate-700">Karawang</td>
                        <td class="border border-slate-700">Telagasari</td>
                        <td class="border border-slate-700">Talagasari</td>
                        <td class="border border-slate-700">001</td>
                        <td class="border border-slate-700">002</td>
                        <td class="border border-slate-700">112233</td>
                      </tr>
                      <tr class="text-nowrap">
                        <td class="border border-slate-700">2</td>
                        <td class="border border-slate-700">Hilda Amelia</td>
                        <td class="border border-slate-700">3210022334455662</td>
                        <td class="border border-slate-700">Perempuan</td>
                        <td class="border border-slate-700">Karawang</td>
                        <td class="border border-slate-700">2003-03-24</td>
                        <td class="border border-slate-700">Administration</td>
                        <td class="border border-slate-700">Ibu</td>
                        <td class="border border-slate-700">hilda@gmail.com</td>
                        <td class="border border-slate-700">0858112233445</td>
                        <td class="border border-slate-700">Jawa Barat</td>
                        <td class="border border-slate-700">Karawang</td>
                        <td class="border border-slate-700">Telagasari</td>
                        <td class="border border-slate-700">Talagasari</td>
                        <td class="border border-slate-700">001</td>
                        <td class="border border-slate-700">002</td>
                        <td class="border border-slate-700">112233</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </li>
            </ol>
          </div>
         <label for="input-data-file" id="label-input-data-file" class="flex justify-center bg-gray-50 py-3 border border-slate-200 rounded-sm w-full cursor-pointer">
           <svg
           xmlns="http://www.w3.org/2000/svg"
           viewBox="0 0 24 24"
           width="2.5em"
           height="2.5em"
           >
             <path
               fill="none"
               stroke="currentColor"
               strokeLinecap="round"
               strokeLinejoin="round"
               strokeWidth="2"
               d="M18 9V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h4M9 3v4a1 1 0 0 1-1 1H4m11 6v4m-2-2h4m3 0a5 5 0 1 1-10 0a5 5 0 0 1 10 0"
             ></path>
           </svg>
         </label>
         <input
           type="file"
           name="data-file"
           id="input-data-file"
           class="border rounded-sm"
           accept=".csv, .xlsx"
         />
       </div>
       <!-- Buttons -->
       <div class="flex flex-row gap-5 mt-2 justify-between">
         <button type="button"
           class="bg-red-600 hover:bg-red-400 hover:font-semibold text-white px-10 py-1 text-lg rounded-md" onclick="handleCloseImportFile()">Batal</button>
           <button
             type="reset"
             id="btn-reset-import-file"
             class="hidden bg-yellow-400 hover:bg-yellow-300 hover:font-semibold text-white px-10 py-1 text-lg rounded-md" onclick="handleResetFile()">Reset</button>
           <button
             type="button"
             id="btn-show-result"
             class="hidden bg-blue-600 hover:bg-blue-400 hover:font-semibold text-white px-2 py-1 text-lg rounded-md"
             onclick="handleShowResultImport()"
             >Tampilkan
           </button>
       </div>
     </form>
  </div>
  <!-- Card 2 : Show Result Import File -->
   <div id="container-show-result-import" class="hidden bg-white w-full h-fit xl:h-[80%] rounded-lg shadow-xl">
    <h1 class="bg-blue-600 text-white p-2 text-xl font-semibold rounded-t-lg">Pratinjau Data Baru : Data Orang Tua</h1>
    <div class="gap-4 bg-white w-full h-[90%] rounded-b-lg shadow-xl overflow-auto">
      <table class="text-center h-fit w-full">
        <thead class="sticky top-[-2px] shadow-sm">
            <tr class="bg-blue-100 text-sm font-medium">
              <td class="border p-2 text-nowrap">No</td>
              <td class="border p-2 text-nowrap">Nama Lengkap</td>
              <td class="border p-2 text-nowrap">Nomor Identitas Kependudukan</td>
              <td class="border p-2 text-nowrap">Jenis Kelamin</td>
              <td class="border p-2 text-nowrap">Tempat Lahir</td>
              <td class="border p-2 text-nowrap">Tanggal Lahir</td>
              <td class="border p-2 text-nowrap">Pekerjaan</td>
              <td class="border p-2 text-nowrap">Hubungan</td>
              <td class="border p-2 text-nowrap">Email</td>
              <td class="border p-2 text-nowrap">Nomor Telepon</td>
              <td class="border p-2 text-nowrap">Provinsi</td>
              <td class="border p-2 text-nowrap">Kabupaten</td>
              <td class="border p-2 text-nowrap">Kecamatan</td>
              <td class="border p-2 text-nowrap">Desa</td>
              <td class="border p-2 text-nowrap">RT</td>
              <td class="border p-2 text-nowrap">RW</td>
              <td class="border p-2 text-nowrap">Kode Pos</td>
            </tr>
          </thead>
          <tbody id="table-body-result">
          <!-- RESULT FILE IMPORT -->
          </tbody>
        </table>
    </div>
   </div>
 </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
  // == Datas
  const files = {
    main_datas: []
  }

  // States
  const icon = {
    "active": function() {
              // set label input icon
              const labelElement = document.getElementById("label-input-data-file");
                    labelElement.innerHTML = `
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        width="5em"
                        height="5em"
                      >
                        <g fill="currentColor">
                          <path d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5z"></path>
                          <path
                            fillRule="evenodd"
                            d="M11 7V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2m4.707 5.707a1 1 0 0 0-1.414-1.414L11 14.586l-1.293-1.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0z"
                            clipRule="evenodd"
                          ></path>
                        </g>
                      </svg>
                    `;
    },
    "disable": function() {
              // set label input icon
              const labelElement = document.getElementById("label-input-data-file");
                    labelElement.innerHTML = `
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        width="5em"
                        height="5em"
                        >
                          <path
                            fill="none"
                            stroke="currentColor"
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            strokeWidth="2"
                            d="M18 9V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h4M9 3v4a1 1 0 0 1-1 1H4m11 6v4m-2-2h4m3 0a5 5 0 1 1-10 0a5 5 0 0 1 10 0"
                          ></path>
                        </svg>
                    `;
    }
  };

  // == Handlers

  // *** Handle Input File *** //
  function handleShowResultImport() {
    const btnShowResult = document.getElementById("btn-show-result");
    const containerInputFile = document.getElementById("container-input-data-file");
    const containerShowResultImport = document.getElementById("container-show-result-import");
    if (containerShowResultImport.classList.contains("hidden") && containerInputFile.classList.contains("flex")){
      containerShowResultImport.classList.remove("hidden");
      containerInputFile.classList.add("hidden");
      btnShowResult.innerText="Tutup";
    } else {
      containerShowResultImport.classList.add("hidden");
      containerInputFile.classList.remove("hidden");
      btnShowResult.innerText="Tampilkan";
    }
  }

  // *** Handle Input File *** //
  function handleInputFile(e) {
    const file = e.target.files[0];
    const fileType = file.type;

    if (file) {
      const reader = new FileReader();

      reader.onload = function (event) {
        const fileData = event.target.result;

        // Handle CSV
        if (fileType === "text/csv") {
          console.log("Processing CSV file...");
          const rows = fileData.split("\n");
          const csvData = rows.map((row) => row.split(","));
          files.main_datas = [...csvData];
          console.log("CSV Data:", files.main_datas);
          icon.active();

          renderResultTable();

          const btnShowResult = document.getElementById("btn-show-result");
          btnShowResult.classList.remove("hidden");

          const btnResetImportFile = document.getElementById("btn-reset-import-file");
          btnResetImportFile.classList.remove("hidden");
        }

        // Handle XLSX
        else if (
          fileType ===
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" ||
          file.name.endsWith(".xlsx")
        ) {
          console.log("Processing XLSX file...");
          const workbook = XLSX.read(fileData, { type: "binary" });
          const sheetName = workbook.SheetNames[0]; // Ambil sheet pertama
          const sheetData = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {
            header: 1,
          });
          // Filter data untuk menghilangkan baris kosong
          const filteredData = sheetData.filter(
            (row) => row && row.some((cell) => cell !== null && cell !== undefined && cell !== "")
          );

          files.main_datas = [...filteredData];
          console.log("XLSX Data:", files.main_datas);
          icon.active();
          renderResultTable();

          const btnShowResult = document.getElementById("btn-show-result");
          btnShowResult.classList.remove("hidden");

          const btnResetImportFile = document.getElementById("btn-reset-import-file");
          btnResetImportFile.classList.remove("hidden");
        } else {
          console.error("Unsupported file format");
          const btnResetImportFile = document.getElementById("btn-reset-import-file");
          btnResetImportFile.classList.add("hidden");
        }
      };

      reader.onerror = function () {
        console.error("Error reading file");
      };

      // XLSX needs binary string mode
      if (file.name.endsWith(".xlsx")) {
        reader.readAsBinaryString(file);
      } else {
        reader.readAsText(file);
      }

      // Set Input Disable
      e.target.setAttribute('disabled', 'true');
    } else {
      console.error("Please upload a file");
    }
  }

  // *** Handle Reset File *** //
  function handleResetFile() {
    icon.disable();
    // Container Input Data File Element
    document.getElementById("container-input-data-file").classList.remove('hidden');
    // Input Data File Element
    document.getElementById("input-data-file").removeAttribute('disabled');
    document.getElementById("input-data-file").value = "";
    // Table Body Result
    document.getElementById("table-body-result").innerHTML = "";
    // Container Show Result
    document.getElementById("container-show-result-import").classList.add("hidden");

    files.main_datas = [];
    const btnShowResult = document.getElementById("btn-show-result");
          btnShowResult.innerText = "Tampilkan";
          btnShowResult.classList.add("hidden");

    const btnResetImportFile = document.getElementById("btn-reset-import-file");
          btnResetImportFile.classList.add("hidden");

  }

  // *** Handle Close Import File *** //
  function handleCloseImportFile() {
    const containerImport = document.getElementById("container-modal-import-file");
          containerImport.classList.add("hidden");
          containerImport.classList.remove("absolute");
    handleResetFile();
  }

  // ### COMPONENTS ###
  function renderResultTable() {
    const targetElement = document.getElementById("table-body-result");
    files.main_datas?.map((data, index) => {
      if (index != 0) {
        const row = document.createElement('tr');
        const style = index % 2 == 0 ? 'bg-blue-50' : '';
        row.className = `group text-sm ${style} hover:bg-lime-50`;
        row.innerHTML = `
                <td class="border text-nowrap px-2 group-hover:font-medium">${index}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[0]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[1]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[2]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[3]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[4]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[5]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[6]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[7]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[8]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[9]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[10]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[11]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[12]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[13]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[14]}</td>
                <td class="border text-nowrap px-2 group-hover:font-medium">${data[15]}</td>
              `;
        targetElement.appendChild(row);
      }
    });
  }

  // ### ONLOAD ###
  const inputDataFile = document.getElementById("input-data-file");
  inputDataFile.addEventListener("change", (e) => handleInputFile(e));
  </script>
