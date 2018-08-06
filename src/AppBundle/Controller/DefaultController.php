<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
	 * @Template()
     */
    public function indexAction()
    {
        return  [
        ];
    }

	/**
	 * @param Request $request
	 * @return JsonResponse
	 *
	 * @Route("/send/mail")
	 */
    public function sendEmailAction(Request $request)
	{
		// Configuration
		$host 		= $request->get('host');
		$username 	= $request->get('username');
		$password 	= $request->get('password');
		$port 		= $request->get('port');
		$security 	= $request->get('security');

		// Message
		$to 		= $request->get('to');
		//$toName 	= $request->get('toName');
		$from		= $request->get('from');
		//$fromName	= $request->get('fromName');
		$subject	= $request->get('subject');
		$body 		= $request->get('body');


		// Initialise Configuration SwiftMailer without config.yml
		$swift_transport = new \Swift_SmtpTransport($host, $port, $security);
		$swift_transport->setUsername($username);
		$swift_transport->setPassword($password);



		$message = new \Swift_Message();
		$message->setFrom($from);
		$message->setTo($to);
		$message->setBody($body);
		$message->setSubject($subject);

		$mailer = new \Swift_Mailer($swift_transport);
		$mailer->send($message, $failed);

		return new JsonResponse(['error' => $failed], JsonResponse::HTTP_ACCEPTED);
	}

}
