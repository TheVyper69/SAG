import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;

void main() => runApp(const Correo());

class Correo extends StatefulWidget {
  const Correo({super.key});

  @override
  State<Correo> createState() => _CorreoState();
}

class _CorreoState extends State<Correo> {
  bool _loading = false;

  final usuario = TextEditingController();
  final password = TextEditingController();
  final elevatedButton = ElevatedButton.styleFrom(
      padding: const EdgeInsets.symmetric(vertical: 20));
  String correo = "";
  @override
  Widget build(BuildContext context) {
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
                        const Text(
                          'Recuperar contraseña',
                          style: TextStyle(
                            color: Colors.black,
                            fontFamily: 'josefin',
                            fontSize: 18,
                          ),
                        ),
                        const SizedBox(
                          height: 15,
                        ),
                        TextFormField(
                          controller: usuario,
                          decoration: const InputDecoration(
                              labelText: "Correo",
                              prefixIcon: Icon(Icons.person)),
                        ),
                        const SizedBox(height: 35),
                        ElevatedButton(
                            style: elevatedButton,
                            onPressed: () async {
                              _enviar(context);
                              correo = usuario.text;
                              var request = http.MultipartRequest(
                                  'POST',
                                  Uri.parse(
                                      'https://sagapi.coiin.net/public/api/codigoValidacion'));
                              request.fields
                                  .addAll({'email': correo.toString()});

                              http.StreamedResponse response =
                                  await request.send();

                              if (response.statusCode == 200) {
                                // ignore: use_build_context_synchronously
                                _error(context);

                                // ignore: use_build_context_synchronously
                                Navigator.of(context).pushNamed('/contrasena');
                              } else if (response.statusCode == 401) {
                                // ignore: use_build_context_synchronously
                                _error(context);
                                // ignore: use_build_context_synchronously
                                showDialog(
                                    context: context,
                                    builder: (BuildContext context) {
                                      return AlertDialog(
                                        title: const Text('SAG'),
                                        content: SingleChildScrollView(
                                          child: ListBody(
                                            children: const [
                                              Text(
                                                  'Este correo no esta registrado')
                                            ],
                                          ),
                                        ),
                                      );
                                    });
                              } else {
                                // ignore: use_build_context_synchronously
                                _error(context);
                                // ignore: use_build_context_synchronously
                                showDialog(
                                    context: context,
                                    builder: (BuildContext context) {
                                      return AlertDialog(
                                        title: const Text('SAG'),
                                        content: SingleChildScrollView(
                                          child: ListBody(
                                            children: const [
                                              Text(
                                                  'A OCURRIDO ALGO, PRUEBE EN UNOS MINUTOS')
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
                                Text('Enviar código',
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

  void _enviar(BuildContext context) {
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
