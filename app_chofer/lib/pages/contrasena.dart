import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:http/http.dart' as http;

void main() => runApp(const Contra());

class Contra extends StatefulWidget {
  const Contra({super.key});

  @override
  State<Contra> createState() => _ContraState();
}

class _ContraState extends State<Contra> {
  bool _loading = false;

  final codigo = TextEditingController();
  final password = TextEditingController();
  final password2 = TextEditingController();
  final elevatedButton = ElevatedButton.styleFrom(
      padding: const EdgeInsets.symmetric(vertical: 20));
  bool _showPassword = true;

  String cod = "";
  String pass = "";
  String pass2 = "";
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
                          keyboardType: TextInputType.number,
                          maxLength: 6,
                          inputFormatters: [
                            FilteringTextInputFormatter.allow(RegExp(r'[0-9]'))
                          ],
                          controller: codigo,
                          decoration: const InputDecoration(
                              labelText: "Ingrese el codigo que recibió",
                              prefixIcon: Icon(Icons.tag)),
                        ),
                        TextFormField(
                          controller: password,
                          decoration: InputDecoration(
                            labelText: "Ingrese su nueva contraseña",
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
                        TextFormField(
                          obscureText: _showPassword,
                          controller: password2,
                          decoration: InputDecoration(
                            labelText: "Verifique su contraseña",
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
                        ),
                        const SizedBox(height: 35),
                        ElevatedButton(
                            style: elevatedButton,
                            onPressed: () async {
                              _enviar(context);
                              cod = codigo.text;
                              pass = password.text;
                              pass2 = password2.text;
                              if (pass == pass2) {
                                var request = http.MultipartRequest(
                                    'POST',
                                    Uri.parse(
                                        'https://sagapi.coiin.net/public/api/cambioPass'));
                                request.fields.addAll({
                                  'pass': pass.toString(),
                                  'pass_confirmation': pass2.toString(),
                                  'cod_val': cod.toString()
                                });

                                http.StreamedResponse response =
                                    await request.send();

                                if (response.statusCode == 200) {
                                  // ignore: use_build_context_synchronously
                                  _error(context);
                                  codigo.clear();
                                  password.clear();
                                  password2.clear();
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
                                                    'La contraseña fue actualizada')
                                              ],
                                            ),
                                          ),
                                          actions: [
                                            ElevatedButton(
                                              child: const Text('OK'),
                                              onPressed: () async {
                                                Navigator.of(context)
                                                    .pushNamed('/');
                                              },
                                            ),
                                          ],
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
                                                Text('Codigo invalido')
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
                                              Text(
                                                  'Las contraseñas no coinciden')
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
                                Text('Cambiar contraseña',
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
