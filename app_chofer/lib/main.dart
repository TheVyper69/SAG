import 'package:flutter/material.dart';
import 'package:login/pages/contra.dart';
import 'package:login/pages/contrasena.dart';
import 'package:login/pages/correo.dart';
import 'package:login/pages/formulario_ruta.dart';
import 'package:login/pages/login.dart';
import 'package:login/pages/menu.dart';

void main() => runApp(const MyApp());

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Material App',
      debugShowCheckedModeBanner: false,
      initialRoute: '/',
      routes: {
        '/': (BuildContext context) => const MyHomePage(
              title: 'home',
            ),
        '/menu': (BuildContext context) => const MyMenuPage(title: 'menu'),
        '/checador': (BuildContext context) => const FormRuta(),
        '/correo': (BuildContext context) => const Correo(),
        '/contrasena': (BuildContext context) => const Contra(),
        '/contra': (BuildContext context) => const Contrasena()
      },
    );
  }
}
