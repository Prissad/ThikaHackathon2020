<?php
return [
    'admin' => [
        ['controller' => 'AdminController', 'method' => 'index'],
        ['controller' => 'AdminController', 'method' => 'store'],
        ['controller' => 'AdminController', 'method' => 'search'],
        ['controller' => 'AdminController', 'method' => 'destroy'],
        ['controller' => 'AdminController', 'method' => 'update'],
        ['controller' => 'AdminController', 'method' => 'show'],

        ['controller' => 'ClasseController', 'method' => 'index'],
        ['controller' => 'ClasseController', 'method' => 'search'],
        ['controller' => 'ClasseController', 'method' => 'store'],
        ['controller' => 'ClasseController', 'method' => 'update'],
        ['controller' => 'ClasseController', 'method' => 'destroy'],
        ['controller' => 'ClasseController', 'method' => 'show'],

        ['controller' => 'SubjectController', 'method' => 'index'],
        ['controller' => 'SubjectController', 'method' => 'search'],
        ['controller' => 'SubjectController', 'method' => 'show'],
        ['controller' => 'SubjectController', 'method' => 'store'],
        ['controller' => 'SubjectController', 'method' => 'destroy'],
        ['controller' => 'SubjectController', 'method' => 'update'],

        ['controller' => 'ClientController', 'method' => 'index'],
        ['controller' => 'ClientController', 'method' => 'search'],
        ['controller' => 'ClientController', 'method' => 'update'],
        ['controller' => 'ClientController', 'method' => 'getSubscribedClients'],
        ['controller' => 'ClientController', 'method' => 'getCountClients'],
        ['controller' => 'ClientController', 'method' => 'getFiftyClients'],
        ['controller' => 'ClientController', 'method' => 'getAllSubscribed'],

        ['controller' => 'FileController', 'method' => 'saveFile'],

        ['controller' => 'TeacherController', 'method' => 'index'],
        ['controller' => 'TeacherController', 'method' => 'store'],
        ['controller' => 'TeacherController', 'method' => 'search'],
        ['controller' => 'TeacherController', 'method' => 'show'],
        ['controller' => 'TeacherController', 'method' => 'destroy'],
        ['controller' => 'TeacherController', 'method' => 'update'],

        ['controller' => 'TeachController', 'method' => 'index'],
        ['controller' => 'TeachController', 'method' => 'store'],
        ['controller' => 'TeachController', 'method' => 'search'],
        ['controller' => 'TeachController', 'method' => 'show'],
        ['controller' => 'TeachController', 'method' => 'destroy'],
        ['controller' => 'TeachController', 'method' => 'update'],
        ['controller' => 'TeachController', 'method' => 'removeAccess'],

        ['controller' => 'SubjectLevel1Controller', 'method' => 'AddSubjectLevel1ToSubject'],
        ['controller' => 'SubjectLevel1Controller', 'method' => 'AddSubjectLevel1ToSubjectLevel1'],

        ['controller' => 'SubjectLevel1Controller', 'method' => 'index'],
        ['controller' => 'SubjectLevel1Controller', 'method' => 'search'],
        ['controller' => 'SubjectLevel1Controller', 'method' => 'store'],
        ['controller' => 'SubjectLevel1Controller', 'method' => 'update'],
        ['controller' => 'SubjectLevel1Controller', 'method' => 'destroy'],
        ['controller' => 'SubjectLevel1Controller', 'method' => 'show'],

        ['controller' => 'VideoController', 'method' => 'index'],
        ['controller' => 'VideoController', 'method' => 'search'],
        ['controller' => 'VideoController', 'method' => 'store'],
        ['controller' => 'VideoController', 'method' => 'update'],
        ['controller' => 'VideoController', 'method' => 'destroy'],
        ['controller' => 'VideoController', 'method' => 'show'],
        ['controller' => 'VideoController', 'method' => 'playVideo'],
        ['controller' => 'VideoController', 'method' => 'associate'],
        ['controller' => 'VideoController', 'method' => 'associateLatest'],

        ['controller' => 'CommentController', 'method' => 'index'],
        ['controller' => 'CommentController', 'method' => 'search'],
        ['controller' => 'CommentController', 'method' => 'store'],
        ['controller' => 'CommentController', 'method' => 'update'],
        ['controller' => 'CommentController', 'method' => 'destroy'],
        ['controller' => 'CommentController', 'method' => 'show'],


        ['controller' => 'FilePDFController', 'method' => 'index'],
        ['controller' => 'FilePDFController', 'method' => 'search'],
        ['controller' => 'FilePDFController', 'method' => 'store'],
        ['controller' => 'FilePDFController', 'method' => 'update'],
        ['controller' => 'FilePDFController', 'method' => 'destroy'],
        ['controller' => 'FilePDFController', 'method' => 'show'],
        ['controller' => 'FilePDFController', 'method' => 'addLiveToClasse'],
        ['controller' => 'FilePDFController', 'method' => 'addFileToVideo'],
        ['controller' => 'FilePDFController', 'method' => 'associate'],
        ['controller' => 'FilePDFController', 'method' => 'associateLatest'],
        ['controller' => 'FilePDFController', 'method' => 'addFileToLatestVideo'],

        ['controller' => 'RatingController', 'method' => 'index'],
        ['controller' => 'RatingController', 'method' => 'search'],
        ['controller' => 'RatingController', 'method' => 'store'],
        ['controller' => 'RatingController', 'method' => 'update'],
        ['controller' => 'RatingController', 'method' => 'destroy'],
        ['controller' => 'RatingController', 'method' => 'show'],

        ['controller' => 'CodeController', 'method' => 'index'],
        ['controller' => 'CodeController', 'method' => 'search'],
        ['controller' => 'CodeController', 'method' => 'store'],
        ['controller' => 'CodeController', 'method' => 'update'],
        ['controller' => 'CodeController', 'method' => 'destroy'],
        ['controller' => 'CodeController', 'method' => 'show'],
        ['controller' => 'CodeController', 'method' => 'verify'],


        ['controller' => 'AuthController', 'method' => 'user']
    ],
    'client' => [

        ['controller' => 'ClientController', 'method' => 'update'],
        ['controller' => 'ClientController', 'method' => 'show'],

        ['controller' => 'ClasseController', 'method' => 'show'],

        ['controller' => 'SubjectController', 'method' => 'show'],

        ['controller' => 'CodeController', 'method' => 'verify'],

        ['controller' => 'VideoController', 'method' => 'index'],
        ['controller' => 'VideoController', 'method' => 'search'],
        ['controller' => 'VideoController', 'method' => 'store'],
        ['controller' => 'VideoController', 'method' => 'update'],
        ['controller' => 'VideoController', 'method' => 'destroy'],
        ['controller' => 'VideoController', 'method' => 'show'],
        ['controller' => 'VideoController', 'method' => 'playVideo'],
        ['controller' => 'VideoController', 'method' => 'associate'],
        ['controller' => 'VideoController', 'method' => 'associateLatest'],

        ['controller' => 'FilePDFController', 'method' => 'show'],
        ['controller' => 'FilePDFController', 'method' => 'search'],

        ['controller' => 'SubjectLevel1Controller', 'method' => 'search'],
        ['controller' => 'SubjectLevel1Controller', 'method' => 'show'],

        ['controller' => 'RatingController', 'method' => 'index'],
        ['controller' => 'RatingController', 'method' => 'search'],
        ['controller' => 'RatingController', 'method' => 'store'],
        ['controller' => 'RatingController', 'method' => 'show'],

        ['controller' => 'CommentController', 'method' => 'index'],
        ['controller' => 'CommentController', 'method' => 'search'],
        ['controller' => 'CommentController', 'method' => 'store'],
        ['controller' => 'CommentController', 'method' => 'show'],
        ['controller' => 'CommentController', 'method' => 'destroy'],
        ['controller' => 'CommentController', 'method' => 'update'],

        ['controller' => 'AuthController', 'method' => 'user']

    ],
    'teacher' => [
        ['controller' => 'teacherController', 'method' => 'show'],
        ['controller' => 'teacherController', 'method' => 'update'],

        ['controller' => 'ClasseController', 'method' => 'show'],

        ['controller' => 'SubjectController', 'method' => 'show'],

        ['controller' => 'VideoController', 'method' => 'index'],
        ['controller' => 'VideoController', 'method' => 'search'],
        ['controller' => 'VideoController', 'method' => 'store'],
        ['controller' => 'VideoController', 'method' => 'update'],
        ['controller' => 'VideoController', 'method' => 'destroy'],
        ['controller' => 'VideoController', 'method' => 'show'],
        ['controller' => 'VideoController', 'method' => 'playVideo'],
        ['controller' => 'VideoController', 'method' => 'associate'],
        ['controller' => 'VideoController', 'method' => 'associateLatest'],

        ['controller' => 'FilePDFController', 'method' => 'show'],
        ['controller' => 'FilePDFController', 'method' => 'search'],

        ['controller' => 'SubjectLevel1Controller', 'method' => 'search'],
        ['controller' => 'SubjectLevel1Controller', 'method' => 'show'],

        ['controller' => 'CommentController', 'method' => 'index'],
        ['controller' => 'CommentController', 'method' => 'search'],
        ['controller' => 'CommentController', 'method' => 'store'],
        ['controller' => 'CommentController', 'method' => 'show'],
        ['controller' => 'CommentController', 'method' => 'destroy'],
        ['controller' => 'CommentController', 'method' => 'update'],


        ['controller' => 'RatingController', 'method' => 'index'],
        ['controller' => 'RatingController', 'method' => 'search'],
        ['controller' => 'RatingController', 'method' => 'store'],
        ['controller' => 'RatingController', 'method' => 'show'],


        ['controller' => 'AuthController', 'method' => 'user']
    ]
];
