import 'package:flutter/material.dart';
import 'package:flutter_weighter/api/api.dart';
import 'package:flutter_weighter/screens/home/home_page.dart';
import 'package:flutter_weighter/screens/onboarding/bloc/bloc_provider.dart';
import 'package:flutter_weighter/screens/onboarding/widget/onboarding_header_text.dart';
import 'package:flutter_weighter/utility/color_utility.dart';
import 'package:flutter_weighter/utility/constants.dart';
import 'package:flutter_weighter/utility/translation/app_translations.dart';
import 'package:flutter_weighter/widget/rounded_button.dart';
import 'package:rflutter_alert/rflutter_alert.dart';

class NickNameTab extends StatefulWidget {
  // Controllers
  @override
  _NickNameTabState createState() => _NickNameTabState();
}

class _NickNameTabState extends State<NickNameTab> {
  final TextEditingController nameController = TextEditingController();
  final TextEditingController nameControllerPwd = TextEditingController();
  bool _isLoading = false;

  final formKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return buildScrollPage(context);
  }

  Widget buildScrollPage(BuildContext context) {
    return Container(
        margin: EdgeInsets.only(top: MediaQuery.of(context).size.height * 0.2),
        height: MediaQuery.of(context).size.height * 0.7,
        child: buildFormContainer(context));
  }

  Widget buildFormContainer(BuildContext context) {
    return Stack(
      children: <Widget>[buildTitleLabel(context), buildForm(context)],
    );
  }

  buildTitleLabel(BuildContext context) => Positioned(
        left: 0,
        right: 0,
        top: 0,
        child: OnBoardingHeaderText(
            text: AppTranslations.of(context).text("nickname_label")),
      );

  Widget buildForm(BuildContext context) {
    return Positioned(
      left: 0,
      right: 0,
      top: MediaQuery.of(context).size.height * 0.1,
      child: Form(
          key: formKey,
          child: Column(
            children: <Widget>[
              Padding(
                padding: const EdgeInsets.all(8.0),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.start,
                  children: <Widget>[
                    buildTextForm(),
                  ],
                ),
              ),
              Padding(
                padding: const EdgeInsets.all(8.0),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.start,
                  children: <Widget>[
                    buildPasswordForm(),
                    SizedBox(
                      height: MediaQuery.of(context).size.shortestSide * 0.15,
                    ),
                    buildButton()
                  ],
                ),
              ),
            ],
          )),
    );
  }

  Widget buildTextForm() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 16.0),
      child: TextFormField(
        style: TextStyle(
            color: Color(getColorHexFromStr(TEXT_COLOR_BLACK)),
            fontSize: MediaQuery.of(context).size.shortestSide * 0.05,
            letterSpacing: 1.2),
        decoration: new InputDecoration(
          border: InputBorder.none,
          hintText: AppTranslations.of(context).text("nickname_hint"),
          helperText: AppTranslations.of(context).text("nickname_helper"),
          helperStyle: TextStyle(
              color: Color(getColorHexFromStr(TEXT_COLOR_BLACK)),
              fontSize: MediaQuery.of(context).size.shortestSide * 0.03,
              letterSpacing: 0.8),
          errorStyle: TextStyle(
              fontSize: MediaQuery.of(context).size.shortestSide * 0.03,
              letterSpacing: 0.8),
        ),
        keyboardType: TextInputType.emailAddress,
        maxLength: 20,
        controller: nameController,
        validator: (val) => val.length == 0
            ? AppTranslations.of(context).text("nickname_validation_empty")
            : val.length < 2
                ? AppTranslations.of(context)
                    .text("nickname_validation_invalid")
                : null,
      ),
    );
  }

  Widget buildPasswordForm() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 16.0),
      child: TextFormField(
        obscureText: true,
        style: TextStyle(
            color: Color(getColorHexFromStr(TEXT_COLOR_BLACK)),
            fontSize: MediaQuery.of(context).size.shortestSide * 0.05,
            letterSpacing: 1.2),
        decoration: new InputDecoration(
          border: InputBorder.none,
          hintText: AppTranslations.of(context).text("password_hint"),
          helperText: AppTranslations.of(context).text("password_helper"),
          helperStyle: TextStyle(
              color: Color(getColorHexFromStr(TEXT_COLOR_BLACK)),
              fontSize: MediaQuery.of(context).size.shortestSide * 0.03,
              letterSpacing: 0.8),
          errorStyle: TextStyle(
              fontSize: MediaQuery.of(context).size.shortestSide * 0.03,
              letterSpacing: 0.8),
        ),
        keyboardType: TextInputType.text,
        maxLength: 20,
        controller: nameControllerPwd,
        validator: (val) => val.length == 0
            ? AppTranslations.of(context).text("password_validation_empty")
            : val.length < 2
                ? AppTranslations.of(context)
                    .text("password_validation_invalid")
                : null,
      ),
    );
  }

  Widget buildButton() {
    return Padding(
      padding: EdgeInsets.symmetric(vertical: 24.0, horizontal: 24.0),
      child: RoundedButton(
        onPressed: () {
          if (!_isLoading) {
            _login();
          }
        },
        text: AppTranslations.of(context).text("next"),
      ),
    );
  }

  void _login() async {
    setState(() {
      _isLoading = true;
    });

    Map<String, dynamic> data = new Map<String, dynamic>();
    data = {
      'email': /*nameController.text*/ "test@test.com",
      'password': /*nameControllerPwd.text */ "testtest"
    };

    try {
      /*var res = await CallApi().postData(data, "/auth/login");

      if ((res.data)['access_token'] != null &&
          (res.data)['access_token'] != '') {
        CallApi.token = (res.data)['access_token'];*/
      Navigator.push(
          context, new MaterialPageRoute(builder: (context) => HomePage()));
      // }
    } catch (e, stacktrace) {
      print(stacktrace);
      Alert(
        context: context,
        title: "Wrong Email or Password",
        desc: "Please try again !",
        buttons: [
          DialogButton(
              child: Text("Close"),
              onPressed: () {
                Navigator.pop(context);
              },
              gradient: LinearGradient(colors: [
                Color.fromRGBO(116, 116, 191, 1.0),
                Color.fromRGBO(52, 138, 199, 1.0)
              ])),
        ],
      ).show();
    }
    setState(() {
      _isLoading = false;
    });
  }
}
