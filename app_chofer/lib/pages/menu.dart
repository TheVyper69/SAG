import 'package:curved_navigation_bar/curved_navigation_bar.dart';
import 'package:flutter/material.dart';
import 'package:login/pages/asistencia.dart';
import 'package:login/pages/perfil.dart';
import 'dart:async';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart' as http;

class MyMenuPage extends StatefulWidget {
  const MyMenuPage({super.key, required this.title});

  final String title;

  @override
  State<MyMenuPage> createState() => _MyMenuState();
}

class _MyMenuState extends State<MyMenuPage> {
  // Diálogo de primer inicio de aplicación
  Future<void> _checkIfDialogShown() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    bool dialogShown = prefs.getBool('dialogShown') ?? false;

    if (!dialogShown) {
      showDialog(
        context: context,
        barrierDismissible: false,
        builder: (BuildContext context) {
          return AlertDialog(
            title: Text('¡Bienvenido(a) a SAG!'),
            content: Text(
              'Tu ubicacion va ser utilizada unicamengte para tu registro de asistencias en tus estaciones asignadas y no se comparte con terceros!.',
              textAlign: TextAlign.justify,
              style: TextStyle(fontSize: 14),
            ),
            elevation: 20,
            shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(15.0)),
            actions: [
              ElevatedButton(
                style: ElevatedButton.styleFrom(
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(15), // borde redondeado
                  ),
                ),
                child: Text('Entendido'),
                onPressed: () {
                  Navigator.of(context).pop();
                  _setDialogShown();
                },
              ),
            ],
          );
        },
      );
    }
  }

  // Usando shared preferences para diálogo
  Future<void> _setDialogShown() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.setBool('dialogShown', true);
  }

  // ignore: non_constant_identifier_names
  List Screen = [const asistencia(), const perfil()];

  int _selectedIndex = 0;
  late Timer _timer;
  int _timeLeft = 28800;

  @override
  void initState() {
    _startTimer();
    super.initState();
    _checkIfDialogShown();
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

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        bottomNavigationBar: CurvedNavigationBar(
          index: _selectedIndex,
          backgroundColor: Colors.white,
          color: const Color.fromRGBO(129, 190, 234, 1),
          animationDuration: const Duration(milliseconds: 300),
          items: const [
            Icon(Icons.taxi_alert, color: Colors.white),
            Icon(Icons.person, color: Colors.white),
          ],
          onTap: (index) {
            setState(() {
              _selectedIndex = index;
            });
          },
        ),
        body: Center(
          child: Screen[_selectedIndex],
        ));
  }
}
