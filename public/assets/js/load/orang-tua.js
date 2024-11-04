function loadDataOrangTua() {
  if (orangtua.datas.length == 0){
    return fetch('/data-orang-tua')
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
      })
      .then( data => {
        orangtua.datas = [...data[1]];
      })
      .catch(error => {
        console.error('Fetch error:', error);
        throw error;
      });
  }
}
