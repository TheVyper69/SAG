// ignore: camel_case_types
class Asistencia_User {
  late String parada;
  late String ruta;
  late String fecha;

  Asistencia_User(
      {required this.parada, required this.ruta, required this.fecha});

  factory Asistencia_User.fromJson(Map<String, dynamic> json) {
    return Asistencia_User(
        parada: json['parada_nombre'],
        ruta: json['ruta_nombre'],
        fecha: json['created_at']);
  }
}
