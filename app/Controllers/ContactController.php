<?php


namespace KBS\Controllers;

use KBS\Entities\Contact;
use KBS\Query\Builder;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ContactController extends BaseController
{

    /**
     * Index page for the contact page.
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     * @throws \ReflectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $contact = (new Contact())
                        ->select(['*'])
                        ->get();

        return $this->view->render($response, 'contact/contact.twig', [
            'contact' => $contact
        ]);
    }
}