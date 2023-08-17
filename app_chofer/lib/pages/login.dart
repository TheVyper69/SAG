// ignore_for_file: use_build_context_synchronously

import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Flutter Demo',
      theme: ThemeData(
        brightness: Brightness.light,
        primaryColor: Colors.blue,

        textTheme: const TextTheme(
          titleLarge: TextStyle(
              fontSize: 18.0, fontStyle: FontStyle.italic, color: Colors.white),
        ),
        colorScheme: ColorScheme.fromSwatch().copyWith(secondary: Colors.white),

        // This is the theme of your application.
        //
        // Try running your application with "flutter run". You'll see the
        // application has a blue toolbar. Then, without quitting the app, try
        // changing the primarySwatch below to Colors.green and then invoke
        // "hot reload" (press "r" in the console where you ran "flutter run",
        // or simply save your changes to "hot reload" in a Flutter IDE).
        // Notice that the counter didn't reset back to zero; the application
        // is not restarted.
      ),
      home: const MyHomePage(title: 'Flutter Demo Home Page'),
    );
  }
}

class MyHomePage extends StatefulWidget {
  const MyHomePage({super.key, required this.title});

  // This widget is the home page of your application. It is stateful, meaning
  // that it has a State object (defined below) that contains fields that affect
  // how it looks.

  // This class is the configuration for the state. It holds the values (in this
  // case the title) provided by the parent (in this case the App widget) and
  // used by the build method of the State. Fields in a Widget subclass are
  // always marked "final".

  final String title;

  @override
  State<MyHomePage> createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  bool _loading = false;
  bool _showPassword = true;

  final usuario = TextEditingController();
  final password = TextEditingController();

  String user = "";
  String pass = "";

  @override
  Widget build(BuildContext context) {
    final elevatedButton = ElevatedButton.styleFrom(
        padding: const EdgeInsets.symmetric(vertical: 20));
    return Scaffold(
      body: Stack(
        children: <Widget>[
          Container(
            width: double.infinity,
            padding: const EdgeInsets.symmetric(vertical: 100),
            decoration: const BoxDecoration(
                borderRadius: BorderRadius.only(
                    bottomLeft: Radius.circular(20),
                    bottomRight: Radius.circular(20)),
                gradient: LinearGradient(
                    begin: Alignment.topCenter,
                    colors: <Color>[
                      Color.fromARGB(76, 255, 255, 255),
                      Color.fromARGB(255, 26, 136, 214)
                    ])),
            child: Image.asset(
              'assets/SAG2.png',
              // color: Colors.white,
              height: 150,
            ),
          ),
          Transform.translate(
            offset: const Offset(0, 60),
            child: Center(
              child: SingleChildScrollView(
                child: Card(
                  elevation: 2,
                  shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(20)),
                  margin: const EdgeInsets.all(20),
                  child: Padding(
                    padding: const EdgeInsets.symmetric(
                        horizontal: 35, vertical: 20),
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      children: <Widget>[
                        TextFormField(
                          controller: usuario,
                          decoration: const InputDecoration(
                              labelText: "Correo",
                              prefixIcon: Icon(Icons.person)),
                        ),
                        const SizedBox(height: 25),
                        TextFormField(
                          controller: password,
                          decoration: InputDecoration(
                            labelText: "Contraseña",
                            prefixIcon: const Icon(Icons.password),
                            suffixIcon: IconButton(
                              icon: Icon(_showPassword
                                  ? Icons.visibility_off
                                  : Icons.visibility),
                              onPressed: () {
                                setState(() {
                                  _showPassword = !_showPassword;
                                });
                              },
                            ),
                          ),
                          obscureText: _showPassword,
                        ),
                        const SizedBox(height: 35),
                        ElevatedButton(
                            style: elevatedButton,
                            onPressed: () async {
                              _login(context);
                              user = usuario.text;
                              pass = password.text;
                              var request = http.MultipartRequest(
                                  'POST',
                                  Uri.parse(
                                      'https://sagapi.coiin.net/public/api/auth/login'));
                              request.fields
                                  .addAll({'email': user, 'password': pass});
                              http.StreamedResponse response =
                                  await request.send();
                              if (response.statusCode == 200) {
                                var responseBody =
                                    await response.stream.bytesToString();
                                var jsonResponse = jsonDecode(responseBody);
                                var token = jsonResponse['access_token'];
                                SharedPreferences prefs =
                                    await SharedPreferences.getInstance();
                                prefs.setString('auth_token', token);
                                var token2 = prefs.getString('auth_token');

                                var request = http.Request(
                                    'POST',
                                    Uri.parse(
                                        'https://sagapi.coiin.net/public/api/usuarioActivo'));
                                request.headers.addAll({
                                  'Authorization': 'Bearer $token2',
                                });

                                http.StreamedResponse response4 =
                                    await request.send();

                                if (response4.statusCode == 200) {
                                  var request = http.Request(
                                      'GET',
                                      Uri.parse(
                                          'https://sagapi.coiin.net/public/api/rolUser'));
                                  request.headers.addAll({
                                    'Authorization': 'Bearer $token2',
                                  });

                                  http.StreamedResponse response2 =
                                      await request.send();

                                  if (response2.statusCode == 200) {
                                    _error(context);

                                    var responseBody2 =
                                        await response2.stream.bytesToString();
                                    var jsonResponse2 =
                                        jsonDecode(responseBody2);
                                    var rol = jsonResponse2['id_rol'];
                                    if (rol == 4) {
                                      Navigator.of(context).pushNamed('/menu');
                                    } else if (rol == 5) {
                                      Navigator.of(context)
                                          .pushNamed('/checador');
                                    } else {
                                      showDialog(
                                          context: context,
                                          builder: (BuildContext context) {
                                            return AlertDialog(
                                              title: const Text('SAG'),
                                              content: SingleChildScrollView(
                                                child: ListBody(
                                                  children: const [
                                                    Text('Acceso denegado')
                                                  ],
                                                ),
                                              ),
                                            );
                                          });
                                    }
                                  } else {}
                                } else {
                                  _error(context);
                                  showDialog(
                                      context: context,
                                      builder: (BuildContext context) {
                                        return AlertDialog(
                                          title: const Text('SAG'),
                                          content: SingleChildScrollView(
                                            child: ListBody(
                                              children: const [
                                                Text('No estas activo')
                                              ],
                                            ),
                                          ),
                                        );
                                      });
                                }
                              } else {
                                _error(context);
                                showDialog(
                                    context: context,
                                    builder: (BuildContext context) {
                                      return AlertDialog(
                                        title: const Text('SAG'),
                                        content: SingleChildScrollView(
                                          child: ListBody(
                                            children: const [
                                              Text('Verifica tus datos')
                                            ],
                                          ),
                                        ),
                                      );
                                    });
                              }
                            },
                            child: Row(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: <Widget>[
                                Text('Iniciar sesión',
                                    style: Theme.of(context)
                                        .textTheme
                                        .titleLarge!
                                        .copyWith(
                                          color: Theme.of(context)
                                              .colorScheme
                                              .onSecondary,
                                        )),
                                if (_loading)
                                  Container(
                                    height: 20,
                                    width: 20,
                                    margin: const EdgeInsets.only(left: 20),
                                    child: const CircularProgressIndicator(
                                      color: Colors.white,
                                    ),
                                  )
                              ],
                            )),
                        const SizedBox(
                          height: 20,
                        ),
                        GestureDetector(
                          onTap: (() {
                            Navigator.of(context).pushNamed('/correo');
                          }),
                          child: const Text(
                            '¿has olvidado tu contraseña?',
                            style: TextStyle(
                                decoration: TextDecoration.underline,
                                color: Color.fromRGBO(129, 190, 234, 1)),
                          ),
                        )
                      ],
                    ),
                  ),
                ),
              ),
            ),
          )
        ],
      ),
    );
  }

  void _login(BuildContext context) {
    if (!_loading) {
      setState(() {
        _loading = true;
      });
    }
  }

  void _error(BuildContext context) {
    if (_loading) {
      setState(() {
        _loading = false;
      });
    }
  }
}
