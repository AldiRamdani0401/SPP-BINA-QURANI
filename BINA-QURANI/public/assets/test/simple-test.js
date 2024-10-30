function SimpleTest(insert, expect, label = '') {
  // Menjalankan insert jika itu adalah fungsi
  var result = typeof insert === 'function' ? insert() : insert;
  var label = label === '' ? '' : `(${label})`;

  // Cek apakah expect adalah array
  if (Array.isArray(expect)) {
      expect.forEach((element, index) => {
        // Pastikan result juga adalah array untuk dilakukan perbandingan per elemen
        if (result === element) {
          console.log(
            `%c === TEST PASSED ${label} === \n` + `%c[>] Expected: ${element}\n` + `%c[O] Result: ${result}`,
            'background: green; color:white; font-weight:bold; padding:2px 0;', 'font-weight:600;margin-top:10px;', 'font-weight:600;margin-bottom:10px;'
          );
        } else {
          console.log(
            `%c xxx TEST FAILED ${label} xxx \n` + `%c[>] Expected: ${element}\n` + `%c[X] Result: ${result}`,
            'background: red; color:white; font-weight:bold; padding:2px 0;', 'font-weight:600;margin-top:10px;', 'font-weight:600;margin-bottom:10px;'
          );
        }
      });
  } else {
    // Jika expect bukan array, lakukan perbandingan biasa
    if (result === expect) {
      console.log(
        `%c === TEST PASSED ${label} === \n` + `%c[>] Expected: ${expect}\n` + `%c[O] Result: ${result}`,
        'background: green; color:white; font-weight:bold; padding:2px 0;', 'font-weight:600;margin-top:10px;', 'font-weight:600;margin-bottom:10px;'
      );
    } else {
      console.log(
        `%c xxx TEST FAILED ${label} xxx \n` + `%c[>] Expected: ${expect}\n` + `%c[X] Result: ${result}`,
        'background: red; color:white; font-weight:bold; padding:2px 0;', 'font-weight:600;margin-top:10px;', 'font-weight:600;margin-bottom:10px;'
      );
    }
  }
}
