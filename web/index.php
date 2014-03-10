<?php

use Core\Application;

use View\Paginator;

use Model\Record;
use Model\RecordMapper;

use Helper\IpGenerator;

use Form\FileUploader;
use Form\Validate\EmailValidator;
use Form\Validate\UrlValidator;
use Form\Validate\RequiredValidator;
use Form\Form;
use Form\Sanitize\CloseHtmlTagSanitizer;
use Form\Sanitize\RemoveHtmlTagSanitizer;

require_once('../SplClassLoader.php');

$app = new Application();

$app->service['db'] = function (){
    return new PDO('mysql:host=localhost;dbname=guestbook;charset=utf8', 'root', '');
};

$app->match('/', function() use ($app){

    $form = new Form(array(
        'enctype' => 'multipart/form-data',
        'action' => '',
        'method' => 'POST'
    ));
    $form->add('name', 'text', true, array(
            'placeholder' => 'Your name',
            'required' => '',
         ), array(), array(
            new RemoveHtmlTagSanitizer(),
         ))
         ->add('email', 'email', true, array(
            'placeholder' => 'Your Email',
            'required' => '',
         ), array(
            new EmailValidator(),
         ))
         ->add('homepage', 'text', false, array(
            'placeholder' => 'Your Homepage',
         ), array(
            new UrlValidator(),
         ))
         ->add('description', 'textarea', true, array(
            'placeholder' => 'Description',
            'required' => '',
         ), array(), array(
            new RemoveHtmlTagSanitizer(),
            new CloseHtmlTagSanitizer(),
         ))
         ->add('file', 'file')
         ->add('submit', 'submit');

    $form->handleRequest($app->request);

    if ($app->request->getMethod() == 'POST' && $form->isValid()) {
        $record = new Record();

        $record->name = $form->getValue('name');
        $record->email = $form->getValue('email');
        $record->description = $form->getValue('description');
        $record->homepage = $form->getValue('homepage');
        $record->when = time();
        $record->ip = $app->request->getClientIp();

        $fileUploader = new FileUploader();
        $record->file = $fileUploader->upload('uploads', 'file', array('gif', 'jpg', 'png', 'jpeg', 'txt'), 1024 * 1024);

        $recordMapper = new RecordMapper($app->service->get('db'));
        $recordMapper->save($record);

        //$app->redirect('/');
    }

    $page = $app->request->get('page', 1);
    $order = $app->request->get('order', 'ASC', $whiteList = array('ASC', 'DESC'));

    $recordMapper = new RecordMapper($app->service->get('db'));
    $records = $recordMapper->find(5, ($page - 1) * 5, $order);

    $context = array(
        'records' => $records,
        'paginator' => new Paginator($recordMapper, $page, 5),
        'form' => $form
    );

    return $context;

}, 'index');

$app->run();