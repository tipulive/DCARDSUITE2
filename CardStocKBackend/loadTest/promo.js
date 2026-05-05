import http from 'k6/http';

export default function () {

  let token = '962|a1i5jItgxzfVTt5nhyC8J4S6yHnhYmsBTjACmlql';

  let payload = JSON.stringify({
    permKey: "default",
    permV: false,
    productCode: "nyota",
    req_qty: 263,
    safari: false,
    app_vers: "1.0.0"
  });

  let params = {
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'Authorization': `Bearer ${token}`,
    },
  };

  let res = http.post(
    'http://localhost:8000/api/addPromo',
    payload,
    params
  );

  console.log(res.status);
  console.log(res.body);
}
