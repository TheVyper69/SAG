import 'dart:async';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:geolocator/geolocator.dart';
import 'package:permission_handler/permission_handler.dart';
import 'package:shared_preferences/shared_preferences.dart';

// ignore: camel_case_types
class asistencia extends StatefulWidget {
  const asistencia({super.key});
  @override
  State<asistencia> createState() => _asistenciaState();
}

// ignore: camel_case_types
class _asistenciaState extends State<asistencia> {
  VoidCallback? _onTap;
  bool _isInkWellDisabled = false;

  Future<void> requestPermission() async {
    final PermissionStatus status = await Permission.location.request();
    if (status == PermissionStatus.granted) {}
  }

  void _onDataSent() async {
    requestPermission();
    Position position = await Geolocator.getCurrentPosition(
      desiredAccuracy: LocationAccuracy.high,
    );

    double latitude = position.latitude;
    double longitude = position.longitude;

    String coordx = latitude.toString();
    String coordy = longitude.toString();
    print(longitude);

    String latitudex = coordx.substring(0, 6);
    String longitudey = coordy.substring(0, 8);
    print(longitudey);
    SharedPreferences prefs = await SharedPreferences.getInstance();
    const CircularProgressIndicator(
      color: Colors.white,
    );
    var token2 = prefs.getString('auth_token');
    print(token2);
    var request = http.MultipartRequest('POST',
        Uri.parse('https://sagapi.coiin.net/public/api/compararParada'));
    request.fields
        .addAll({'coordenadas_x': latitudex, 'coordenadas_y': longitudey});
    request.headers.addAll({
      'Authorization': 'Bearer $token2',
    });

    http.StreamedResponse response = await request.send();

    if (response.statusCode == 200) {
      var responseBody = await response.stream.bytesToString();
      var jsonResponse = jsonDecode(responseBody);
      var idRuta = jsonResponse['id'];
      print(response.statusCode);

      print(latitudex);
      print(longitudey);

      print(jsonResponse);

      if (jsonResponse != {}) {
        const CircularProgressIndicator(
          color: Colors.white,
        );

        print(idRuta);
        var request = http.MultipartRequest(
            'POST',
            Uri.parse(
                'https://sagapi.coiin.net/public/api/asistenciaRegister'));
        request.headers.addAll({
          'Authorization': 'Bearer $token2',
        });
        request.fields.addAll({'id_parada': idRuta.toString()});

        http.StreamedResponse response2 = await request.send();

        if (response2.statusCode == 201) {
          // ignore: use_build_context_synchronously
          showDialog(
              context: context,
              builder: (BuildContext context) {
                return AlertDialog(
                  title: const Text('SAG'),
                  content: SingleChildScrollView(
                    child: ListBody(
                      children: const [Text('Asistencia tomada')],
                    ),
                  ),
                );
              });
          setState(() {
            _isInkWellDisabled = true;
            _onTap = null;
          });
          Timer(const Duration(seconds: 600), () {
            setState(() {
              _isInkWellDisabled = false;
              _onTap = () => _onDataSent();
            });
          });
        } else {
          showDialog(
              context: context,
              builder: (BuildContext context) {
                return AlertDialog(
                  title: const Text('SAG'),
                  content: SingleChildScrollView(
                    child: ListBody(
                      children: const [Text('NO ESTAS EN UNA PARADA')],
                    ),
                  ),
                );
              });
        }
      }
    } else {}
    // Si los datos se enviaron con éxito, deshabilita el InkWell por 5 segundos
  }

  @override
  void initState() {
    super.initState();
    _onTap = () => _onDataSent();
  }

  void cerrarSesion() async {
    final prefs = await SharedPreferences.getInstance();

    var token3 = prefs.getString('auth_token');

    var request = http.Request(
        'POST', Uri.parse('https://sagapi.coiin.net/public/api/auth/logout'));
    request.headers.addAll({
      'Authorization': 'Bearer $token3',
    });

    http.StreamedResponse response = await request.send();

    if (response.statusCode == 200) {
      // ignore: use_build_context_synchronously
      Navigator.of(context)
          .pushNamedAndRemoveUntil('/', (Route<dynamic> route) => false);

      await prefs.clear();
    } else {}
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: const Color.fromRGBO(129, 190, 234, 1),
        title: const Text('SAG'),
        automaticallyImplyLeading: false,
        actions: [
          PopupMenuButton(itemBuilder: (BuildContext context) {
            return [
              const PopupMenuItem(
                value: 1,
                child: Text('Cambiar contraseña'),
              ),
              const PopupMenuItem(
                value: 2,
                child: Text('Cerrar sesión'),
              ),
            ];
          }, onSelected: (value) {
            if (value == 1) {
              Navigator.of(context).pushNamed('/contra');
            } else if (value == 2) {
              showDialog(
                context: context,
                builder: (BuildContext context) {
                  return AlertDialog(
                    title: const Text('¿Seguro que quieres cerrar sesión?'),
                    actions: [
                      ElevatedButton(
                        child: const Text('No'),
                        onPressed: () {
                          // Cerrar la alerta y no hacer nada
                          Navigator.of(context).pop();
                        },
                      ),
                      ElevatedButton(
                        child: const Text('Sí'),
                        onPressed: () {
                          cerrarSesion();
                        },
                      ),
                    ],
                  );
                },
              );
            }
          })
        ],
      ),
      body: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Center(
            child: InkWell(
                splashColor: const Color.fromRGBO(129, 190, 234, 1),
                highlightColor: const Color.fromRGBO(129, 190, 234, 1),
                onTap: _isInkWellDisabled
                    ? () => showDialog(
                        context: context,
                        builder: (BuildContext context) {
                          return AlertDialog(
                            title: const Text('SAG'),
                            content: SingleChildScrollView(
                              child: ListBody(
                                children: const [
                                  Text('No puedes volver a tomar asistencia')
                                ],
                              ),
                            ),
                          );
                        })
                    : _onTap,
                child: Container(
                  padding: const EdgeInsets.all(20.0),
                  decoration: BoxDecoration(
                      color: const Color.fromRGBO(129, 190, 234, 1),
                      borderRadius: BorderRadius.circular(100.0)),
                  child: const Icon(
                    Icons.back_hand,
                    color: Colors.white,
                  ),
                )),
          ),
          const SizedBox(
            height: 16,
          ),
          Text(
            'Precione para pasar asistencia',
            style: TextStyle(
              color: Colors.grey[800],
              fontSize: 16.0,
            ),
          )
        ],
      ),
    );
  }
}

class Persona {
  late String name;
  late String lastname;
  late String routename;

  Persona(name, lastname, routename) {
    // ignore: prefer_initializing_formals
    this.name = name;
    // ignore: prefer_initializing_formals
    this.lastname = lastname;
    this.routename = lastname;
  }
}
