<?php


namespace KBS\Controllers;


use KBS\Entities\Hobby;
use KBS\Request\Errors\Error;
use KBS\Request\Validator\Validator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HobbyController extends BaseController
{

    /**
     * Hobby index method.
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
        $hobbies = (new Hobby())->select()->get();

        return $this->view->render($response, 'hobby/index.twig', [
            'hobbies' => $hobbies,
        ]);
    }

    /**
     * Hobby delete function.
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \ReflectionException
     */
    public function delete(RequestInterface $request, ResponseInterface $response)
    {
        $this->authenticate();

        (new Hobby())->delete()
                     ->where('id', '=', $request->getQueryParams()['id'])
                     ->get();

        $response->getBody()->write((json_encode([
                                                     'status' => 'success'
                                                 ])));

        return $response;
    }

    /**
     * Returns the create form for a hobby.
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function create(RequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render($response, 'hobby/create.twig');
    }

    /**
     * Stores a new hobby.
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
    public function store(RequestInterface $request, ResponseInterface $response)
    {
        $this->authenticate();

        $validator = (new Validator($request))->setRules([
                                                             'name'        => 'required|max:255',
                                                             'description' => 'required',
                                                         ])
                                              ->validate();
        if ( ! $validator->validationPassed())
        {
            return $this->view->render($response, 'hobby/create.twig', [
                'errorName'        => Error::has('name') ? Error::get('name') : null,
                'errorDescription' => Error::has('description') ? Error::get('description') : null,
            ]);
        }

        (new Hobby())->insert([
                                  'name'        => $request->getParsedBody()['name'],
                                  'description' => $request->getParsedBody()['description'],
                              ]);

        Error::clear();

        return $this->view->render($response, 'hobby/index.twig', [
            'success' => 'Succesvol uw hobby opgeslagen!',
        ]);
    }
}