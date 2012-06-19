<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints;
/**
 * Index URL, automatic redirect to preferred user locale
 */
$app->get('/', function (Silex\Application $app) {
    return $app['twig']->render('contact.html.twig');

});


/**
 * Sends e-mail and returns a json response
 */
$app->post('/', function (Silex\Application $app) {
    $contactData = array(
        'entitat' => $app['request']->get('entitat'),
        'nom_1'  => $app['request']->get('nom_1'),
        'carrec_1'  => $app['request']->get('carrec_1'),
        'nom_2'  => $app['request']->get('nom_2'),
        'carrec_2'  => $app['request']->get('carrec_2'),
    );

    $collectionConstraint = new Constraints\Collection(array(
        'entitat' => array(
                        new Constraints\NotBlank(array('message' => 'No pots deixar aquest camp en blanc'))
                        ),
        'nom_1' => array(
                        new Constraints\NotBlank(array('message' => 'No pots deixar aquest camp en blanc'))
                        ),
        'carrec_1' => array(),
        'nom_2' => array(),
        'carrec_2' => array()

    ));

    $errors = $app['validator']->validateValue($contactData, $collectionConstraint);

    if (0 === count($errors)) {

        $body = sprintf(<<<EOF
            <ul>
                <li>Entitat: %s</li>
                <li>Nom 1: %s</li>
                <li>Càrrec 1: %s</li>
                <li>Nom 2: %s</li>
                <li>Càrrec 2: %s</li>
            </ul>
EOF
        , $contactData['entitat'],
            $contactData['nom_1'], $contactData['carrec_1'],
            $contactData['nom_2'], $contactData['carrec_2']
        );

        $message = \Swift_Message::newInstance()
            ->setSubject('[CMS El tercer] Missatge rebut')
            ->setFrom($app['mail.from'])
            ->setTo($app['mail.to'])
            ->setBody($body)
                ;

       // $app['mailer']->send($message);

        return $app->json(array('msg' => 'El teu missatge s\'ha enviat correctament'), 200, array('content-type' => 'application/json'));
    } else {
        $jsonerr = array();
        foreach ($errors as $error) {
            $jsonerr[$error->getPropertyPath()] = $error->getMessage();
        }
        return $app->json(array('msg' => 'ERROR', 'errors' => $jsonerr), 400, array('content-type' => 'application/json'));
    }
});

