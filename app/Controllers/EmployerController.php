<?php


namespace KBS\Controllers;


use KBS\Entities\Employer;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class EmployerController extends BaseController
{

    /**
     * Returns the index view of employers
     *
     * @param \Psr\Http\Message\RequestInterface  $request
     * @param \Psr\Http\Message\ResponseInterface $reponse
     *
     * @return mixed
     * @throws \ReflectionException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $this->authenticate();

        $employers = (new Employer())
                        ->select()
                        ->get();

        return $this->view->render($response,'employer/index.twig', [
            'employers' => $employers
        ]);
    }

    /**
     * Deletes an employer from the database.
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

        (new Employer())->delete()
                              ->where('id', '=', $request->getQueryParams()['id'])
                              ->get();

        $response->getBody()->write((json_encode([
                                                     'status' => 'success'
                                                 ])));

        return $response;
    }
}