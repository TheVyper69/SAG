import 'dart:async';
import 'dart:convert';
import 'package:flutter/services.dart';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'asistencia_user.dart';

// ignore: camel_case_types
class perfil extends StatefulWidget {
  const perfil({super.key});

  @override
  State<perfil> createState() => _perfilState();
}

class Api {
  static Future<List<Asistencia_User>> getData() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    var token2 = prefs.getString('auth_token');

    var headers = {
      'Authorization': 'Bearer $token2',
      'Content-Type': 'application/json',
    };
    final response = await http.get(
        Uri.parse('https://sagapi.coiin.net/public/api/onlyUser'),
        headers: headers);

    if (response.statusCode == 200) {
      List jsonResponse = json.decode(response.body);
      return jsonResponse
          .map((data) => Asistencia_User.fromJson(data))
          .toList();
    } else {
      throw Exception('Failed to load data from API');
    }
  }
}

// ignore: camel_case_types
class _perfilState extends State<perfil> {
  String _name = "";

  String _email = "";

  late Timer _timer;
  int _timeLeft = 28800;
  @override
  void initState() {
    super.initState();
    _loadMyVariable();
    _startTimer();
    _getUser();
  }

  @override
  void dispose() {
    _timer.cancel();
    super.dispose();
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

  void _getUser() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    var token2 = prefs.getString('auth_token');

    var headers = {
      'Authorization': 'Bearer $token2',
      'Content-Type': 'application/json',
    };
    final response = await http.get(
        Uri.parse('https://sagapi.coiin.net/public/api/rolUser'),
        headers: headers);

    if (response.statusCode == 200) {
      var jsonResponse = jsonDecode(response.body);
      var nombre = jsonResponse['nombre'];
      var correo = jsonResponse['email'];

      prefs.setString('nombreU', nombre);
      prefs.setString('correoU', correo);
    }
  }

  Future<void> _loadMyVariable() async {
    final prefs = await SharedPreferences.getInstance();
    setState(() {
      _name = prefs.getString('nombreU') ?? "";

      _email = prefs.getString('correoU') ?? "";
    });
  }

  @override
  Widget build(BuildContext context) {
    SystemChrome.setPreferredOrientations([
      DeviceOrientation.portraitUp,
      DeviceOrientation.portraitDown,
    ]);
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
                  child: Text('Cerrar sesion'),
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
                      title: const Text('Seguro que quieres cerrar sesion'),
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
        backgroundColor: Colors.white,
        extendBody: false,
        extendBodyBehindAppBar: false,
        body: GestureDetector(
            onTap: (() {}),
            child: SingleChildScrollView(
                child: Container(
              width: MediaQuery.of(context).size.width,
              color: Colors.white,
              child: Column(
                children: [
                  const Text(
                    'Mi perfil',
                    style: TextStyle(
                        fontFamily: 'josefin',
                        fontSize: 30,
                        fontWeight: FontWeight.bold),
                  ),
                  ClipOval(
                    child: Image.asset(
                      'assets/a.png',
                      // width: size.width * 0.3,
                    ),
                  ),
                  Center(
                    child: Text(
                      _name,
                      style: const TextStyle(
                          fontFamily: 'josefin',
                          fontSize: 25,
                          fontWeight: FontWeight.bold),
                    ),
                  ),
                  Center(
                    child: Text(
                      _email,
                      style: const TextStyle(
                          fontFamily: 'josefin',
                          fontSize: 25,
                          fontWeight: FontWeight.bold),
                    ),
                  ),
                  const SizedBox(height: 12),
                  const Center(
                    child: Text(
                      'Mis asistencias',
                      style: TextStyle(
                          fontFamily: 'josefin',
                          fontSize: 15,
                          fontWeight: FontWeight.bold),
                    ),
                  ),
                  SingleChildScrollView(
                    child: _tablaAsitencia(),
                  ),
                ],
              ),
            ))));
  }

  Container _tablaAsitencia() {
    // ignore: avoid_unnecessary_containers
    return Container(
      child: SizedBox(
        height: 380,
        child: FutureBuilder<List<Asistencia_User>>(
          future: Api.getData(),
          builder: (context, snapshot) {
            if (snapshot.hasData) {
              return ListView.builder(
                shrinkWrap: true,
                physics: const AlwaysScrollableScrollPhysics(),
                itemCount: snapshot.data!.length,
                itemBuilder: (context, index) {
                  return ListTile(
                    title: Text('Parada: ${snapshot.data![index].parada}'),
                    subtitle:
                        Text('Fecha y hora: ${snapshot.data![index].fecha}'),
                    trailing: Text('Ruta: ${snapshot.data![index].ruta}'),
                  );
                },
              );
            } else if (snapshot.hasError) {}

            return const Center(child: CircularProgressIndicator());
          },
        ),
      ),
    );
  }
}
