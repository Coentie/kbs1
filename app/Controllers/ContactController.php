<?php


namespace KBS\Controllers;

use KBS\Entities\Contact;
use KBS\Query\Builder;
use KBS\Request\Errors\Error;
use KBS\Request\Validator\Validator;
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
        $contact = $this->getContact();

        return $this->view->render($response, 'contact/contact.twig', [
            'contact' => $contact
        ]);
    }

    /**
     * Edit form for contact.
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
    public function edit(RequestInterface $request, ResponseInterface $response)
    {
        $this->authenticate();

        $contact = $this->getContact();

        return $this->view->render($response, 'contact/edit.twig', [
            'contact' => $contact
        ]);
    }

    /**
     * Updates the contact
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed|\Zend\Diactoros\Response\RedirectResponse
     * @throws \ReflectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function update(RequestInterface $request, ResponseInterface $response)
    {
        $this->authenticate();

        $validator = (new Validator($request))->setRules([
                                                             'straat'      => 'required|max:255',
                                                             'huis_nummer' => 'required|max:12',
                                                             'postcode'    => 'required|max:8',
                                                             'stad'        => 'required|max:100',
                                                             'telefoon'    => 'required|max:13',
                                                             'email'       => 'required|max:100',
                                                         ])
                                              ->validate();

        if ( ! $validator->validationPassed())
        {
            return $this->view->render($response, 'contact/edit.twig', [
                'contact'         => $this->getContact(),
                'errorStraat'     => Error::has('straat') ? Error::get('straat') : null,
                'errorHuisnummer' => Error::has('huis_nummer') ? Error::get('huis_nummer') : null,
                'errorPostcode'   => Error::has('postcode') ? Error::get('postcode') : null,
                'errorStad'       => Error::has('stad') ? Error::get('stad') : null,
                'errorTelefoon'   => Error::has('telefoon') ? Error::get('telefoon') : null,
                'errorEmail'      => Error::has('email') ? Error::get('email') : null,
            ]);
        }

        (new Contact())->insert([
                                    'straat'      => $request->getParsedBody()['straat'],
                                    'huis_nummer' => $request->getParsedBody()['huis_nummer'],
                                    'postcode'    => $request->getParsedBody()['postcode'],
                                    'stad'        => $request->getParsedBody()['stad'],
                                    'telefoon'    => $request->getParsedBody()['telefoon'],
                                    'email'       => $request->getParsedBody()['email'],
                                ], 'replace');

        Error::clear();

        return redirect('/contact');
    }

    /**
     * Gets the contact.
     *
     * @return mixed
     * @throws \ReflectionException
     */
    private function getContact()
    {
        return (new Contact())
            ->select()
            ->first();
    }
}