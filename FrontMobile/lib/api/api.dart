import 'dart:convert';

import 'package:dio/dio.dart';

class CallApi {
  Dio dio;
  final String _url =
      /*'http://10.0.2.2:8000/api';*/ /*'http://127.0.0.1:8000/api';*/
      'http://192.168.1.212:8000/api';

  static var token =
      'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOTAzODUyNjRiNDA1Y2RmODkzODQxYzM3ODIyNjM4Mzc3MzdkZDc3NmQyNjJhN2FiNzlhODFkYTdjZTI3M2MyYzYyMzUwZWIxMGI4MTUyMmIiLCJpYXQiOjE1OTU3NTY2NTEsIm5iZiI6MTU5NTc1NjY1MSwiZXhwIjoxNjI3MjkyNjUxLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.HDBRwneD4evDAwz_GqMQXYBgX7DMyT7Ea_IwiOz1h0Ja35N1Vjz4gmhGLJkb5zPrGv3olwOoqslc8QGVc0A8uqOrScIOUtGI8wD3hTH9-0t4h9JOugl6jvIDV7uoCAXW0A2xDPxKtcQPw2yec31jRyLfdVX35PQUCujN7B37jsNZTpUiPVc8ET7Sd6Kz0DRG275q6xaOQO8CAwRsy_upwWSXHnVXr0-4NlINcI5eO9tHZwNTd6BwqyebR7CxGhqmbPHlM7ugktbqyMJhtT-3WYIZrdZuhvwgvgb_vogYSeLhuNdOZ4erzcmh1KO26itXEKQuvsGAk5eSKkJ01aZDKtuuJLsK-DaW-oj3AXRCik_QE-0JOuqhUSbHPYCpx8BhpljryWnQatFkt6BRgAazj4vmf2r7JxZZ-Fsrq7Ufd17q6pzpvfDdLDtXJqQlfpgGZEZhX58JwwcSF0npyhX_sJjq2_qwJM994hwTahFK7YhmjfpWW9i3D7URzhkBm8fXeFi4gkaEi0UTtj4A4tf0cGpePKYu0-c_B7lLGHT0QAHx_VZhnjuRmf5RosxpkthNQFVdmyrcidwu4o7rrjD9OJBL8_oC3LN3UR2WUrfZjWOwbczLXVd2BVeARDD-Zj30V0RAKaqyqlzE3R_zhkiIlgSr1Rm1TvOI8giPDVYFsl4';

  postData(path, data) async {
    var fullUrl = _url + path;
    setHeaders();
    return await dio.post(Uri.encodeFull(fullUrl), data: json.encode(data));
  }

  getData(path) async {
    var fullUrl = _url + path;
    setHeaders();
    return await dio.get(Uri.encodeFull(fullUrl));
  }

  setHeaders() {
    dio = new Dio();
    dio.options.headers['Authorization'] = CallApi.token;
    dio.options.headers['content-Type'] = 'application/json';
    dio.options.headers['accept'] = 'application/json';
  }
}
