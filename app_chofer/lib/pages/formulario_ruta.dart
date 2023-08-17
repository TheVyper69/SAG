// ignore_for_file: use_build_context_synchronously

import 'dart:async';
import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:geolocator/geolocator.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:permission_handler/permission_handler.dart';

class Item {
  final String name;
  final String value;

  Item({required this.name, required this.value});

  factory Item.fromJson(Map<String, dynamic> json) {
    return Item(name: json['nombre'], value: json['nombre']);
  }
}

class FormRuta extends StatefulWidget {
  const FormRuta({super.key});

  @override
  State<FormRuta> createState() => _FormRutaState();
}

class _FormRutaState extends State<FormRuta>
    with SingleTickerProviderStateMixin {
  late Timer _timer;
  int _timeLeft = 28800;

  String? selectedStation;
  String? selectedRoute;
  List<Map<String, dynamic>> stations = [];
  List<Map<String, dynamic>> routes = [];

// Consulta los datos de la api

  Future<List<Map<String, dynamic>>> fetchData() async {
    final prefs = await SharedPreferences.getInstance();

    var token3 = prefs.getString('auth_token');
    print(token3);
    var headers = {
      'Authorization': 'Bearer $token3',
      'Content-Type': 'application/json',
    };
    final response = await http.get(
        Uri.parse('https://sagapi.coiin.net/public/api/rutaCollectionEmpresa'),
        headers: headers);
    if (response.statusCode == 200) {
      final jsonResponse = json.decode(response.body);
      // retornar datos
      return jsonResponse['rutas'].cast<Map<String, dynamic>>();
      // Condición si no hubo obtención de datos
    } else {
      throw Exception('Failed to load data');
    }
  }

  @override
  void initState() {
    super.initState();
    // _fetchData();

    _startTimer();
    fetchData().then((jsonResponse) {
      setState(() {
        routes = jsonResponse;
      });
    });
  }

  @override
  void dispose() {
    // _controller.dispose();
    super.dispose();
    _timer.cancel();
  }

  final nombreParada = TextEditingController();
  final paradaAnterior = TextEditingController();
  final tiempo = TextEditingController();

  String _rutaName = "";
  String _tiempoAprox = "";

  @override
  Widget build(BuildContext context) {
    final screenSize = MediaQuery.of(context).size;
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
      body: GestureDetector(
        onTap: () {},
        child: SizedBox(
          width: screenSize.width,
          height: screenSize.height,
          child: Column(
            children: [
              const SizedBox(
                height: 15,
              ),
              Container(
                margin: const EdgeInsets.symmetric(horizontal: 15),
                decoration: BoxDecoration(
                    border: Border.all(color: Colors.grey),
                    borderRadius: BorderRadius.circular(8)),
                child: Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: DropdownButton<String>(
                    isExpanded: true,

                    icon: const Icon(Icons.arrow_drop_down_circle,
                        color: Colors.blue),
                    style: const TextStyle(color: Colors.black),
                    iconSize: 25,
                    borderRadius: BorderRadius.circular(15),
                    elevation: 8,
                    underline: Container(),
                    value: selectedRoute,
                    hint: const Text('Selección de rutas'),
                    onChanged: (value) {
                      // Preparar estado del valor del input
                      setState(() {
                        selectedRoute = value;
                        // Filtrar la lista de estaciones para mostrar solo las estaciones de la ruta seleccionada
                        stations = routes
                            .where((route) =>
                                route['id'].toString() == selectedRoute)
                            .map((route) =>
                                route['paradas'].cast<Map<String, dynamic>>())
                            .toList()[0];
                        // Reiniciar el valor seleccionado de la estacion
                        selectedStation = null;
                      });
                    },
                    // Objetos del dropdown
                    items: routes
                        .map((route) => DropdownMenuItem<String>(
                              value: route['id'].toString(),
                              child: Text(route['nombre']),
                            ))
                        .toList(),
                  ),
                ),
              ),
              const SizedBox(
                height: 10,
              ),
              Container(
                margin: const EdgeInsets.symmetric(horizontal: 15),
                decoration: BoxDecoration(
                    border: Border.all(color: Colors.grey),
                    borderRadius: BorderRadius.circular(8)),
                child: Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: DropdownButton<String>(
                    isExpanded: true,
                    icon: const Icon(Icons.arrow_drop_down_circle,
                        color: Colors.blue),
                    style: const TextStyle(color: Colors.black),
                    iconSize: 25,
                    borderRadius: BorderRadius.circular(15),
                    elevation: 8,
                    underline: Container(),
                    value: selectedStation,
                    hint: Text('Selecciona la estación anterior'),
                    onChanged: (value) {
                      // Preparar estado del valor del input
                      setState(() {
                        selectedStation = value;
                      });
                    },
                    // Objetos del Dropdown
                    items: stations
                        .map((station) => DropdownMenuItem<String>(
                              value: station['id'].toString(),
                              child: Text(station['nombreParada']),
                            ))
                        .toList(),
                  ),
                ),
              ),
              const SizedBox(
                height: 10,
              ),
              _inputEstacion(),
              const SizedBox(
                height: 10,
              ),
              _tiempo(),
              Row(
                children: [
                  Expanded(
                    child: Padding(
                      padding: const EdgeInsets.all(10.0),
                      child: ElevatedButton(
                        style: ElevatedButton.styleFrom(
                            backgroundColor:
                                const Color.fromRGBO(129, 190, 234, 1)),
                        onPressed: () async {
                          requestPermission();
                        },
                        child: const Text("Registrar"),
                      ),
                    ),
                  )
                ],
              ),
              const SizedBox(
                height: 10,
              ),
            ],
          ),
        ),
      ),
    );
  }

  Container _inputEstacion() {
    return Container(
        decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(8),
            border: Border.all(color: Colors.grey)),
        padding: const EdgeInsets.symmetric(horizontal: 40),
        margin: const EdgeInsets.symmetric(horizontal: 15),
        child: TextFormField(
          controller: nombreParada,
          style: const TextStyle(fontSize: 16),
          decoration: const InputDecoration(
              hintText: "Nombre de la estación", border: InputBorder.none),
        ));
  }

  Container _tiempo() {
    return Container(
        decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(8),
            border: Border.all(color: Colors.grey)),
        padding: const EdgeInsets.symmetric(horizontal: 40),
        margin: const EdgeInsets.symmetric(horizontal: 15),
        child: TextFormField(
          controller: tiempo,
          keyboardType: TextInputType.number,
          maxLength: 2,
          inputFormatters: [
            FilteringTextInputFormatter.allow(RegExp(r'[0-9]'))
          ],
          style: const TextStyle(fontSize: 16),
          decoration: const InputDecoration(
              hintText: "Tiempo de llegada (en minutos)",
              border: InputBorder.none),
        ));
  }

  void cerrarPop() {
    showDialog(
        context: context,
        builder: (BuildContext context) {
          return AlertDialog(
            title: const Text('SAG'),
            content: SingleChildScrollView(
              child: ListBody(
                children: const [
                  Text('Se registro exitosamente la primer parada')
                ],
              ),
            ),
          );
        });
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
      Navigator.of(context)
          .pushNamedAndRemoveUntil('/', (Route<dynamic> route) => false);

      await prefs.clear();
    } else {}
  }

  void _startTimer() {
    _timer = Timer.periodic(const Duration(seconds: 1), (timer) {
      setState(() {
        if (_timeLeft > 0) {
          _timeLeft--;
        } else {
          cerrarSesion();
        }
      });
    });
  }

  Future<void> requestPermission() async {
    final PermissionStatus status = await Permission.location.request();
    if (status == PermissionStatus.granted) {
      Position position = await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.high,
      );
      var latitude = position.latitude;
      var longitude = position.longitude;

      var ruta = selectedRoute;
      var estacion = selectedStation;
      if (estacion != null) {
        _rutaName = nombreParada.text;
        var request = http.MultipartRequest('POST',
            Uri.parse('https://sagapi.coiin.net/public/api/paradasRegister'));
        request.fields.addAll({
          'id_ruta': ruta.toString(),
          'nombre': _rutaName,
          'coordenadas_x': latitude.toString(),
          'coordenadas_y': longitude.toString()
        });

        http.StreamedResponse response3 = await request.send();
        if (response3.statusCode == 200) {
          var responseBody3 = await response3.stream.bytesToString();
          var jsonResponse3 = jsonDecode(responseBody3);
          var idParada2 = jsonResponse3['id'];
          _tiempoAprox = tiempo.text;
          var request = http.MultipartRequest('POST',
              Uri.parse('https://sagapi.coiin.net/public/api/registroParada'));
          request.fields.addAll({
            'id_parada': idParada2.toString(),
            'id_parada_anterior': estacion.toString(),
            'tiempo': _tiempoAprox
          });

          http.StreamedResponse response = await request.send();

          if (response.statusCode == 200) {
            showDialog(
                context: context,
                builder: (BuildContext context) {
                  return AlertDialog(
                    title: const Text('SAG'),
                    content: SingleChildScrollView(
                      child: ListBody(
                        children: const [Text('Se registro exitosamente')],
                      ),
                    ),
                  );
                });

            nombreParada.clear();
            tiempo.clear();
            setState(() {
              selectedStation = null;
              selectedRoute = null;
            });
          } else {
            showDialog(
                context: context,
                builder: (BuildContext context) {
                  return AlertDialog(
                    title: const Text('SAG'),
                    content: SingleChildScrollView(
                      child: ListBody(
                        children: const [Text('A ocurrido un error')],
                      ),
                    ),
                  );
                });
          }
        }
      } else {
        showDialog(
            context: context,
            builder: (BuildContext context) {
              return AlertDialog(
                title: const Text('SAG'),
                content: SingleChildScrollView(
                  child: ListBody(
                    children: const [Text('¿Es la primer parada de la ruta?')],
                  ),
                ),
                actions: [
                  ElevatedButton(
                    child: const Text('No'),
                    onPressed: () {
                      // Cerrar la alerta y no hacer nada
                      Navigator.of(context).pop();
                      showDialog(
                          context: context,
                          builder: (BuildContext context) {
                            return AlertDialog(
                              title: const Text('SAG'),
                              content: SingleChildScrollView(
                                child: ListBody(
                                  children: const [
                                    Text(
                                        'Introduzca el nombre de la parada anterior por favor')
                                  ],
                                ),
                              ),
                            );
                          });
                    },
                  ),
                  ElevatedButton(
                    child: const Text('Sí'),
                    onPressed: () async {
                      Navigator.of(context).pop();
                      _rutaName = nombreParada.text;
                      var request = http.MultipartRequest(
                          'POST',
                          Uri.parse(
                              'https://sagapi.coiin.net/public/api/paradasRegister'));
                      request.fields.addAll({
                        'id_ruta': ruta.toString(),
                        'nombre': _rutaName,
                        'coordenadas_x': latitude.toString(),
                        'coordenadas_y': longitude.toString()
                      });

                      http.StreamedResponse response = await request.send();
                      if (response.statusCode == 200) {
                        cerrarPop();

                        nombreParada.clear();
                        tiempo.clear();
                        setState(() {
                          selectedRoute = null;
                        });
                      } else {
                        showDialog(
                            context: context,
                            builder: (BuildContext context) {
                              return AlertDialog(
                                title: const Text('SAG'),
                                content: SingleChildScrollView(
                                  child: ListBody(
                                    children: const [
                                      Text('A ocurrido un error')
                                    ],
                                  ),
                                ),
                              );
                            });
                      }
                    },
                  ),
                ],
              );
            });
      }
    } else if (status == PermissionStatus.denied) {
      // El permiso fue denegado
    } else if (status == PermissionStatus.permanentlyDenied) {
      // El permiso fue denegado permanentemente, solicita permiso en la configuración de la aplicación
    }
  }
}
