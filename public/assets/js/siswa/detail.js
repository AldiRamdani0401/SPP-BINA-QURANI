function loadDetail(container, id) {

  const data = nosql.set(siswa.datas)
              .where('nomor_induk_siswa', '===', id)
              .exec();

  const data_ayah = nosql.set(orangtua.datas)
                    .where('nama_lengkap', '===', data[0].nama_ayah)
                    .exec();

  const data_ibu = nosql.set(orangtua.datas)
                  .where('nama_lengkap', '===', data[0].nama_ibu)
                  .exec();

  let element = `
    <div class="flex justify-center align-middle absolute w-full h-[680px] top-0 bg-black bg-opacity-90 z-10">
      <div class="no-select mt-2 flex flex-col justify-center gap-2 mx-auto p-4 h-fit rounded-lg bg-white" autocomplete="off">
        <div class="col-12">
          <h4 class="font-bold text-xl">Detail Data Siswa</h4>
          <hr>
        </div>
        <div class="flex flex-row gap-1">
          <div class="flex flex-col w-full border rounded-lg py-3">
            <div class="flex flex-row">
              <div class="w-full px-1 text-white border" style="background:green">
                <span class="font-semibold">Data Siswa</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Nama Lengkap Siswa :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data[0].nama_lengkap}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Nomor Induk Siswa :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data[0].nomor_induk_siswa}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Tempat Lahir :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data[0].tempat_lahir}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Tanggal Lahir :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data[0].tanggal_lahir}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Jenis Kelamin :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">`

                if (data[0].jenis_kelamin == 'L') {
                  element += 'Laki-Laki';
                } else {
                  element += 'Perempuan';
                }

                element +=
                `</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Kelas :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data[0].kelas}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 text-white border" style="background:green">
                <span class="font-semibold">Data Ayah</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Nama Ayah :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data_ayah[0].nama_lengkap}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Nomor Telepon Ayah :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data_ayah[0].nomor_telepon}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Email Ayah :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data_ayah[0].email}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 text-white border" style="background:green">
                <span class="font-semibold">Data Ibu</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Nama Ibu :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data_ibu[0].nama_lengkap}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Nomor Telepon Ibu :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data_ibu[0].nomor_telepon}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Email Ibu :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data_ibu[0].email}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Email Ibu :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data_ibu[0].email}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 text-white border" style="background:green">
                <span class="font-semibold">Alamat</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Provinsi :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data[0].provinsi}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Kabupaten / Kota :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data[0].kabupaten}</span>
              </div>
            </div>
            <div class="flex flex-row">
              <div class="w-full px-1 border">
                <span class="font-medium">Kecamatan :</span>
              </div>
              <div class="w-full px-1 border">
                <span class="">${data[0].kecamatan}</span>
              </div>
            </div>
          </div>
          <div class="flex flex-col gap-2 h-fit">
            <div class="flex flex-col justify-center gap-1 p-2 border rounded-md">
              <h6 class="font-semibold ">Photo Siswa</h6>
              <output id="imageOutput" class="align-center" style="height:500px;">
                <img src="../assets/images/default-image.png" class="w-full" id="previewImage">
              </output>
            </div>
          </div>
        </div>
        <div class="flex flex-row justify-between py-1 w-full">
          <div class="flex flex-row gap-5">
            <button type="button" class="bg-blue-800 py-1 px-2 text-white rounded-md hover:bg-blue-600 hover:font-semibold" onclick="cancelForm()">Kembali</button>
            <button type="button" class="bg-yellow-500 py-1 px-2 rounded-md hover:bg-yellow-400 hover:font-semibold" onclick="loadFormEditData(${data[0].nomor_induk_siswa})">Edit Data</button>
          </div>
          <button type="button" class="bg-red-600 py-1 px-2 rounded-md text-white hover:bg-red-500 hover:font-semibold" onclick="cancelForm()">DELETE DATA</button>
        </div>
      </div>
    </div>
  `;

  container.innerHTML= element;

  setTimeout(() => {
    loadImage(data[0].photo_siswa);
    console.log(++urutan);
  }, 1000);
}