import 'package:flutter/material.dart';
import 'package:flutter_redux/flutter_redux.dart';
import 'package:flutter_weighter/api/api.dart';
import 'package:flutter_weighter/model/user.dart';
import 'package:flutter_weighter/redux/app_state.dart';
import 'package:flutter_weighter/utility/color_utility.dart';
import 'package:flutter_weighter/utility/translation/app_translations.dart';
import 'package:flutter_weighter/widget/base_sliver_header.dart';
import 'package:flutter_weighter/widget/rounded_button.dart';
import 'package:flutter_weighter/widget/vertical_spacer.dart';
import 'package:flutter_weighter/widget/weight_card.dart';
import 'package:redux/redux.dart';

import 'bloc/add_weight_bloc.dart';
import 'bloc/bloc_provider.dart';

class AddWeightID extends StatefulWidget {
  @override
  _AddWeightState createState() => _AddWeightState();
}

class _AddWeightState extends State<AddWeightID> {
  AddWeightBloc _addWeightBloc;
  final TextEditingController nameController = TextEditingController();
  final TextEditingController nameController2 = TextEditingController();

  @override
  void initState() {
    super.initState();
    _addWeightBloc = AddWeightBloc();
  }

  @override
  Widget build(BuildContext context) {
    return AddWeightBlocProvider(
      bloc: _addWeightBloc,
      child: Scaffold(
        body: BaseSliverHeader(
          title: AppTranslations.of(context).text("add_weight_label"),
          bodyWidget: buildContent(),
        ),
      ),
    );
  }

  Widget buildContent() {
    return StoreConnector<AppState, User>(
        converter: (Store<AppState> store) => store.state.user,
        builder: (BuildContext context, User user) {
          _addWeightBloc.weight = /*user.weight*/ 15.5;
          return Column(
            children: <Widget>[
              buildWeightCard(),
              buildIDCard(),
              //_SelectedWeightText(),
              _UpdateButton(nameController: nameController)
            ],
          );
        });
  }

  buildWeightCard() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 16.0),
      child: TextFormField(
        style: TextStyle(
            color: Color(getColorHexFromStr(TEXT_COLOR_BLACK)),
            fontSize: MediaQuery.of(context).size.shortestSide * 0.05,
            letterSpacing: 1.2),
        decoration: new InputDecoration(
          border: InputBorder.none,
          hintText: AppTranslations.of(context).text("amount_hint"),
          helperStyle: TextStyle(
              color: Color(getColorHexFromStr(TEXT_COLOR_BLACK)),
              fontSize: MediaQuery.of(context).size.shortestSide * 0.03,
              letterSpacing: 0.8),
          errorStyle: TextStyle(
              fontSize: MediaQuery.of(context).size.shortestSide * 0.03,
              letterSpacing: 0.8),
        ),
        keyboardType: TextInputType.number,
        controller: nameController,
      ),
    );
  }

  buildIDCard() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 16.0),
      child: TextFormField(
        style: TextStyle(
            color: Color(getColorHexFromStr(TEXT_COLOR_BLACK)),
            fontSize: MediaQuery.of(context).size.shortestSide * 0.05,
            letterSpacing: 1.2),
        decoration: new InputDecoration(
          border: InputBorder.none,
          hintText: AppTranslations.of(context).text("amount_id_hint"),
          helperStyle: TextStyle(
              color: Color(getColorHexFromStr(TEXT_COLOR_BLACK)),
              fontSize: MediaQuery.of(context).size.shortestSide * 0.03,
              letterSpacing: 0.8),
          errorStyle: TextStyle(
              fontSize: MediaQuery.of(context).size.shortestSide * 0.03,
              letterSpacing: 0.8),
        ),
        keyboardType: TextInputType.number,
        controller: nameController2,
      ),
    );
  }
}

class _TitleText extends StatelessWidget {
  final String lastUpdated;

  _TitleText({@required this.lastUpdated});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(24.0),
      child: Text(
        'Select an amount:',
        style: TextStyle(
            color: Colors.black87,
            fontSize: MediaQuery.of(context).size.shortestSide * 0.04,
            letterSpacing: 0.8),
        softWrap: true,
        textAlign: TextAlign.center,
      ),
    );
  }
}

class _SelectedWeightText extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    final _addWeightBloc = AddWeightBlocProvider.of(context);
    return Padding(
      padding: const EdgeInsets.all(24.0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: <Widget>[
          Text(
            AppTranslations.of(context).text("add_weight_result_label"),
            style: TextStyle(
                color: Colors.black54,
                fontSize: MediaQuery.of(context).size.shortestSide * 0.05,
                letterSpacing: 0),
            softWrap: true,
            textAlign: TextAlign.left,
          ),
          StreamBuilder<double>(
              stream: _addWeightBloc.selectedWeightStream,
              builder: (context, snapshot) {
                int selectedWeight = snapshot.hasData
                    ? snapshot.data.toInt()
                    : _addWeightBloc.weight.toInt();
                return Text(
                  '$selectedWeight ${AppTranslations.of(context).text("kg")}',
                  style: TextStyle(
                      color: Theme.of(context).primaryColor,
                      fontSize: MediaQuery.of(context).size.shortestSide * 0.07,
                      letterSpacing: 0.8),
                  softWrap: true,
                  textAlign: TextAlign.left,
                );
              }),
        ],
      ),
    );
  }
}

class _UpdateButton extends StatelessWidget {
  final TextEditingController nameController;

  _UpdateButton({@required this.nameController});

  @override
  Widget build(BuildContext context) {
    return StreamBuilder<Object>(
        //stream: _addWeightBloc.selectedWeightStream,
        builder: (context, snapshot) {
      return Padding(
        padding: EdgeInsets.symmetric(vertical: 24.0, horizontal: 24.0),
        child: RoundedButton(
          onPressed: () async {
            Map<String, dynamic> data = new Map<String, dynamic>();
            data = {
              'amount': nameController.text,
              'period': "30",
              'interest': '2.5',
            };

            try {
              var res = await CallApi().getData("/loan");
              print('test = ' + res.data);
            } catch (e, stacktrace) {
              print(stacktrace);
            }
          },
          text: AppTranslations.of(context).text("update"),
        ),
      );
    });
  }
}
